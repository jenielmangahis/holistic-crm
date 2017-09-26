<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Network\Exception\NotFoundException;


/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 */
class ExternalRequestsController extends AppController
{

    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();        
        // Allow full access to this controller
        $this->Auth->allow();
    }
    /**
     * Frontend : Ajax register method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function ajax_register_leads()
    {
      $this->AllocationUsers = TableRegistry::get('AllocationUsers');

      $data = $this->request->query;
      $json['is_success'] = false;      

      if( $data ){
        $lead = $this->Leads->newEntity();

        $lead_action = "";
        if( isset($data['lead-action']) ){
          $lead_action = $data['lead-action'];
        }

        $data_leads = [
          'firstname' => $data['lead-firstname'],
          'surname' => $data['lead-lastname'],
          'email' => $data['lead-email'],
          'phone' => $data['lead-phone'],
          'city' => $data['lead-city'],
          'state' => $data['lead-state'],
          'source_id' => $data['lead-source-id'],
          'lead_action' => $lead_action,
          'status_id' => 2,
          'lead_type_id' => 1,
          'allocation_id' => $data['lead-allocation-id'],
          'allocation_date' => date("Y-m-d"),
          'followup_date' => date("Y-m-d"),
          'followup_action_reminder_date' => date("Y-m-d")
        ];
        $lead = $this->Leads->patchEntity($lead, $data_leads);        
        if ($new_lead = $this->Leads->save($lead)) {

            $allocation_users = $this->AllocationUsers->find('all')
                ->contain(['Users'])
                ->where(['AllocationUsers.allocation_id' => $data['lead-allocation-id']])
            ;

            $users_email = array();
            foreach($allocation_users as $users){            
                $users_email[$users->user->email] = $users->user->email;            
            }

            if( !empty($users_email) ){
              //Send email notification
              $leadData = $this->Leads->get($new_lead->id, [
                  'contain' => ['Statuses', 'Sources', 'Allocations', 'LastModifiedBy','LeadTypes','InterestTypes']
              ]);  
              $email_customer = new Email('default');
              $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                ->template('external_leads_registration')
                ->emailFormat('html')          
                ->bcc($users_email)                                                                                               
                ->subject('New Lead')
                ->viewVars(['new_lead' => $leadData->toArray()])
                ->send();
            }
            
          $json['is_success'] = true;
        } 
      }

      $this->viewBuilder()->layout('');     
      echo json_encode($json);
      exit;
    }   
}
