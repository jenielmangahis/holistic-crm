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
      $data = $this->request->query;
      $json['is_success'] = false;      
      if( $data ){
        $lead = $this->Leads->newEntity();
        $data_leads = [
          'firstname' => $data['lead-firstname'],
          'surname' => $data['lead-lastname'],
          'email' => $data['lead-email'],
          'phone' => $data['lead-phone'],
          'city' => $data['lead-city'],
          'state' => $data['lead-state'],
          'source_id' => $data['lead-source-id'],
          'status_id' => 1,
          'lead_type_id' => 1,
          'allocation_id' => $data['lead-allocation-id'],
          'allocation_date' => date("Y-m-d"),
          'followup_date' => date("Y-m-d"),
          'followup_action_reminder_date' => date("Y-m-d")
        ];
        $lead = $this->Leads->patchEntity($lead, $data_leads);        
        if ($new_lead = $this->Leads->save($lead)) {

            //Send email notification to admin
            /*$admin_email = 'bryan.yobi@gmail.com';
            $email_customer = new Email('cake_smtp');
            $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
              ->template('leads_registration')
              ->emailFormat('html')
              ->to($admin_email)                                                                                                     
              ->subject('New Leads')
              ->viewVars(['new_lead' => $new_lead])
              ->send();*/

          $json['is_success'] = true;
        } 
      }

      $this->viewBuilder()->layout('');     
      echo json_encode($json);
      exit;
    }   
}
