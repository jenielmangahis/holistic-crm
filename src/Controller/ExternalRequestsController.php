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
      $this->SourceUsers = TableRegistry::get('SourceUsers');
      $this->Sources     = TableRegistry::get('Sources');     

      $data = $this->request->query;
      $json['is_success'] = false;      

      if( $data ){
        $lead = $this->Leads->newEntity();

        $lead_action = "";
        if( isset($data['lead-action']) ){
          $lead_action = $data['lead-action'];
        }

        $source_url = "";
        if( isset($data['lead-url']) ){
          $source_url = $data['lead-url'];
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
          'source_url' => $source_url,
          'interest_type_id' => 6,          
          'allocation_date' => date("Y-m-d"),
          'followup_date' => date("Y-m-d"),
          'followup_action_reminder_date' => date("Y-m-d")
        ];
        $lead = $this->Leads->patchEntity($lead, $data_leads);        
        if ($new_lead = $this->Leads->save($lead)) {
            //Save Lead Types
            $data_lead_type = [
              'lead_id' => $new_lead->id,
              'lead_type_id' => 1
            ];

            $leadLeadType = $this->Leads->LeadLeadTypes->newEntity();
            $leadLeadType = $this->Leads->LeadLeadTypes->patchEntity($leadLeadType, $data_lead_type);
            $this->Leads->LeadLeadTypes->save($leadLeadType);

            $leadType = $this->Leads->LeadTypes->find()
              ->where(['LeadTypes.id' => 1])
              ->first()
            ;
            $string_lead_types = $leadType->name;
            
            $source_users = $this->SourceUsers->find('all')
                ->contain(['Users'])
                ->where(['SourceUsers.source_id' => $data['lead-source-id']])
            ;

            $users_email = array();
            foreach($source_users as $users){            
                $users_email[$users->user->email] = $users->user->email;            
            }    

            //add other emails to be sent - start
            foreach($source_users as $users){            
                $other_email_to_explode = $users->user->other_email;

                if( !empty($other_email_to_explode) || $other_email_to_explode != '' ) {

                  $other_email = explode(";", $other_email_to_explode);

                  foreach($other_email as $oekey => $em) {

                    if (trim($em) != '') {
                        $other_email_to_add = $em; //ltrim($em);
                        $users_email[$other_email_to_add] = $other_email_to_add;  
                    }

                  }
                  
                }
            }    
            //add other emails to be sent - end                   

            if( !empty($users_email) ){
              //Send email notification
              $leadData = $this->Leads->get($new_lead->id, [
                  'contain' => ['Statuses', 'Sources', 'LeadTypes','InterestTypes']
              ]);
              $leadData = santizeLeadsData($leadData);

              $source           = $this->Sources->get($data['lead-source-id']); 
              $source_name      = !empty($source->name) ? $source->name : "";
              $surname          = $leadData->surname != "" ? $leadData->surname : "Not Specified";
              $lead_client_name = $leadData->firstname . " " . $surname;
              $subject          = "New Lead - " . $source_name . " - " . $lead_client_name; 

              $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
              $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                ->template('external_leads_registration')
                ->emailFormat('html')          
                ->cc($users_email)                                                                                               
                ->subject($subject)
                ->viewVars(['new_lead' => $leadData->toArray(), 'string_lead_types' => $string_lead_types])
                ->send();
            }
            
          $json['is_success'] = true;
        } 
      }

      $this->viewBuilder()->layout('');     
      echo json_encode($json);
      exit;
    } 

    /**
     * Frontend : Post register method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function ajax_post_register_leads()
    {
      $this->SourceUsers = TableRegistry::get('SourceUsers');
      $this->Sources     = TableRegistry::get('Sources');           

      $data = $this->request->data;
      $json['is_success'] = false;      

      if( $data ){
        $lead = $this->Leads->newEntity();

        $lead_action = "";
        if( isset($data['lead-action']) ){
          $lead_action = $data['lead-action'];
        }

        $source_url = "";
        if( isset($data['lead-url']) ){
          $source_url = $data['lead-url'];
        }

        $address = "";
        if( isset($data['lead-address']) ){
          $address = $data['lead-address'];
        }

        $cooling_repair = 0;
        if( isset($data['lead-service-repair']) && $data['lead-service-repair'] == 1 ){
          $cooling_repair = $data['lead-service-repair'];
          //$source_id = 77;
          $source_id = $this->Sources->sourceToCooling($data['lead-source-id']);
          $interest_type_id = 5;
        }else{
          $source_id = $data['lead-source-id'];
          $interest_type_id = 6;
        }

        $data_leads = [
          'firstname' => $data['lead-firstname'],
          'surname' => $data['lead-lastname'],
          'cooling_system_repair' => $cooling_repair,
          'email' => $data['lead-email'],
          'phone' => $data['lead-phone'],
          'address' => $address,
          'city' => $data['lead-city'],
          'state' => $data['lead-state'],
          'source_id' => $source_id,
          'lead_action' => $lead_action,
          'status_id' => 2,
          'lead_type_id' => 1,
          'source_url' => $source_url,
          'interest_type_id' => $interest_type_id,          
          'allocation_date' => date("Y-m-d"),
          'followup_date' => date("Y-m-d"),
          'followup_action_reminder_date' => date("Y-m-d")
        ];
        $lead = $this->Leads->patchEntity($lead, $data_leads);        
        if ($new_lead = $this->Leads->save($lead)) {
            $data_lead_type = ['lead_id' => $new_lead->id, 'lead_type_id' => 1];
            $leadLeadType   = $this->Leads->LeadLeadTypes->newEntity();
            $leadLeadType   = $this->Leads->LeadLeadTypes->patchEntity($leadLeadType, $data_lead_type);
            $this->Leads->LeadLeadTypes->save($leadLeadType);
            
            $enable_attach_csv = false;

            $source = $this->Sources->find()
              ->where(['Sources.id' => $data['lead-source-id']])
              ->first()
            ;

            if( $source ){
              if( $source->enable_csv_attachment == 1 ){
                $enable_attach_csv = true;
              }
            }

            $source_users = $this->SourceUsers->find('all')
                ->contain(['Users'])
                ->where(['SourceUsers.source_id' => $source_id])
            ;

            $users_email = array();
            foreach($source_users as $users){            
                $users_email[$users->user->email] = $users->user->email;            
            }    

            //add other emails to be sent - start
              foreach($source_users as $users){            
                  $other_email_to_explode = $users->user->other_email;

                  if( !empty($other_email_to_explode) || $other_email_to_explode != '' ) {

                    $other_email = explode(";", $other_email_to_explode);

                    foreach($other_email as $oekey => $em) {

                      if (trim($em) != '') {
                          $other_email_to_add = $em; //ltrim($em);
                          $users_email[$other_email_to_add] = $other_email_to_add;  
                      }

                    }
                    
                  }
              }    
            //add other emails to be sent - end                   

            if( !empty($users_email) ){
              //Send email notification
              $leadData = $this->Leads->get($new_lead->id, [
                  'contain' => ['Statuses', 'Sources', 'LeadTypes','InterestTypes']
              ]);  
              
              $leadData = santizeLeadsData($leadData);
              $source           = $this->Sources->get($source_id); 
              $source_name      = !empty($source->name) ? $source->name : "";
              $surname          = $leadData->surname != "" ? $leadData->surname : "Not Specified";
              $lead_client_name = $leadData->firstname . " " . $surname;
              $subject          = "New Lead - " . $source_name . " - " . $lead_client_name; 

              $email_customer = new Email('default');

              if( $enable_attach_csv ){
                $csv_content = ['id,firstname,lastname,email,phone', $new_lead->id . ',' . $new_lead->firstname . ',' . $new_lead->surname . ',' . $new_lead->email . ',' . $new_lead->phone];
                $filename = 'lead.csv';
                $file_path = ROOT . DS . 'webroot' . DS . 'csv'  . DS . $filename; 
                $file = fopen($file_path,"w");
                foreach ($csv_content as $line){
                  fputcsv($file,explode(',',$line));
                }
                fclose($file);

                $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                  ->template('external_leads_registration')
                  ->emailFormat('html')          
                  ->cc($users_email)                                                                                               
                  ->subject($subject)
                  ->viewVars(['new_lead' => $leadData->toArray()])
                  ->attachments([
                      $filename => [
                          'file' => $file_path,
                          'mimetype' => $fileatt_type,
                          'contentId' => 'my-unique-id'
                      ]
                  ])
                  ->send();
              }else{
                $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                  ->template('external_leads_registration')
                  ->emailFormat('html')          
                  ->cc($users_email)                                                                                               
                  ->subject($subject)
                  ->viewVars(['new_lead' => $leadData->toArray()])
                  ->send();
              }
              
              
              //$email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
              
            }
            
          $json['is_success'] = true;
        } 
      }

      $this->viewBuilder()->layout('');     
      echo json_encode($json);
      exit;
    }
}
