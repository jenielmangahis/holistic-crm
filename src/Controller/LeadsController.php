<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 */
class LeadsController extends AppController
{
	public $paginate = ['order' => ['Leads.id' => 'DESC']];
    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["leads"];
        $this->set('nav_selected', $nav_selected);

        /*$p = $this->default_group_actions;
        if($p && $p['leads'] != 'No Access' ){
            $this->Auth->allow();
        }*/

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');   
        $this->user_data = $user_data;      
        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{                           
                $authorized_modules = array();     
                $rights = $this->default_group_actions['leads'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view', 'from_source'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'from_source', 'add', 'edit', 'register', 'unlock', 'leads_unlock'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'from_source', 'add', 'edit', 'delete', 'register', 'unlock', 'leads_unlock'];
                        break;        
                    default:            
                        break;
                }                
                $this->Auth->allow($authorized_modules);
            }
        }         
        
        $this->enable_email_sending = true;
        $this->enable_archive_data  = true;
        $this->user = $user_data;
        $this->Auth->allow(['register']);

    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
      if(isset($this->request->query['unlock']) && isset($this->request->query['lead_id']) ) {
        $lead_id = $this->request->query['lead_id'];
        if($this->request->query['unlock'] == 1) {
          $lead_unlock = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);       

          $login_user_id                = $this->user->id;
          $data_unlck['is_lock']              = 0;
          $data_unlck['last_modified_by_id '] = $login_user_id;
          $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data_unlck);
          if ( !$this->Leads->save($lead_unlock) ) { echo "error unlocking lead"; exit; }
          return $this->redirect(['action' => 'index']);
        }
        
      } else {
        /* Unlock if have session */
        //$this->leads_unlock();        
        $this->unlock_lead_check();
      }
      
      $query = '';  
      if( isset($this->request->query['query']) ){
          $query = trim($this->request->query['query']);
          $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                ->where(['Leads.is_archive' => 'No']) 
                ->andWhere(['OR' => [
                    'Leads.firstname LIKE' => '%' . $query . '%',
                    'Leads.surname LIKE' => '%' . $query . '%'
                ]])                                
            ;
      }else{

          $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : '';
          $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : '';
          
          if( $sort_direction != '' && $sort_field != '' ){
          	$sort_field = str_replace("Leads.", "", $sort_field);
          	if( $sort_field == 'source_id' ){
          		$sort = ['Sources.name' => $sort_direction];
          	}else{
          		if( $sort_field == 'allocation_date' ){
          			$sort = ['Leads.allocation_date' => $sort_direction, 'Leads.id' => 'DESC'];
          		}else{
          			$sort = ['Leads.' . $sort_field => $sort_direction];
          		}
          	}

          	$leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                ->where(['Leads.is_archive' => 'No']) 
                ->order($sort)
            ;
          }else{
          	$leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                ->where(['Leads.is_archive' => 'No'])
            ;
          }
      }

      $get = $_GET;
      if(isset($get['page'])) {
        $this->set('page', $get['page']);
      } 

      $this->set(['query' => $query]);
      $this->set('is_admin_user', $this->user->group_id);
      $this->set('leads', $this->paginate($leads));
      $this->set('_serialize', ['leads', 'is_admin_user', 'page']);
    }

    public function from_source($source_id)
    {
      $this->paginate = ['order' => ['Leads.allocation_date' => 'DESC']];
      $this->Sources = TableRegistry::get('Sources');     
      $source        = $this->Sources->get($source_id, ['']);

      if(isset($this->request->query['unlock']) && isset($this->request->query['lead_id']) ) {
        $lead_id = $this->request->query['lead_id'];
        if($this->request->query['unlock'] == 1) {
          $lead_unlock = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);       

          $login_user_id                      = $this->user->id;
          $data_unlck['is_lock']              = 0;
          $data_unlck['last_modified_by_id '] = $login_user_id;
          $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data_unlck);
          if ( !$this->Leads->save($lead_unlock) ) { echo "error unlocking lead"; exit; }
          return $this->redirect(['action' => 'index']);
        }
        
      } else {
        /* Unlock if have session */
        $this->unlock_lead_check();
      }

      if( isset($this->request->query['query']) ){
          $query = $this->request->query['query'];
          $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'Allocations'])
              ->where(['Leads.is_archive' => 'No']) 
              ->AndWhere(['Leads.firstname LIKE' => '%' . $query . '%'])       
              ->orWhere(['Leads.surname LIKE' => '%' . $query . '%'])       
              ->orWhere(['Leads.email LIKE' => '%' . $query . '%'])       
          ;
      }else{
          $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
              ->where(['Leads.source_id ' => $source_id]) 
              ->AndWhere(['Leads.is_archive' => 'No']) 
          ;
      }

      $get         = $_GET;
      if(isset($get['page'])) {
        $this->set('page', $get['page']);
      }        
       
      $this->set('source_id', $source_id);
      $this->set('is_admin_user', $this->user->group_id);
      $this->set('source_name', $source->name);
      $this->set('leads', $this->paginate($leads));
      $this->set('_serialize', ['leads', 'is_admin_user', 'page']);

    }

    /**
     * View method
     *
     * @param string|null $id Lead id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->UserLeadFollowupNotes = TableRegistry::get('UserLeadFollowupNotes');

        $lead = $this->Leads->find()
           ->contain(['Users', 'Statuses', 'Sources', 'LeadTypes', 'InterestTypes', 'LastModifiedBy', 'LeadLeadTypes' => ['LeadTypes']])
           ->where(['Leads.id' => $id])
           ->first()
        ;

        $leadFollowupNotes = $this->UserLeadFollowupNotes->find('all')
          ->contain(['Users'])
          ->where(['UserLeadFollowupNotes.lead_id' => $id])
        ;
        
        $lead = santizeLeadsData($lead);       

        $back_url = Router::url( $this->referer(), true );
        $this->set('back_url', $back_url);
        $this->set('lead', $lead);
        $this->set(['leadFollowupNotes' => $leadFollowupNotes]);
        $this->set('_serialize', ['lead']);
    }

    public function viewfs($id = null, $source_id = null)
    {
        $lead = $this->Leads->find()
           ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
           ->where(['Leads.id' => $id])
           ->first()
        ;       

        $this->set('source_id', $source_id);
        $this->set('lead', $lead);
        $this->set('_serialize', ['lead']);
    }    

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($source_id = '')
    {
        $this->SourceUsers = TableRegistry::get('SourceUsers');        
        $this->Sources     = TableRegistry::get('Sources');
        $this->Statuses    = TableRegistry::get('Statuses');
        $this->AuditTrails = TableRegistry::get('AuditTrails');
        $this->LeadAttachments = TableRegistry::get('LeadAttachments');
        $this->LeadsEmailNotificationHistory = TableRegistry::get('LeadsEmailNotificationHistory');
        $this->SourceSecondaryUsers = TableRegistry::get('SourceSecondaryUsers');
        $this->Users = TableRegistry::get('Users');
        $this->LeadLeadTypes = TableRegistry::get('LeadLeadTypes');
        $this->LeadFollowupEmails = TableRegistry::get('LeadFollowupEmails');
        $this->UserLeadFollowupNotes = TableRegistry::get('UserLeadFollowupNotes');

        $p = $this->default_group_actions;
        if( $p && $p['leads'] == 'View Only' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        } 

        /*if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          //$this->request->data['allocation_date']               = empty($this->request->data['allocation_date']) ? date('Y-m-d') : date("Y-m-d", strtotime($this->request->data['allocation_date']));
          $this->request->data['allocation_date']               = date("Y-m-d");
          $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
          $this->request->data['followup_action_reminder_date'] = date("Y-m-d", strtotime($this->request->data['followup_action_reminder_date']));
        }*/

        $lead = $this->Leads->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['allocation_date']               = date("Y-m-d");
            $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
            $this->request->data['followup_action_reminder_date'] = date("Y-m-d");    
            $this->request->data['lead_type_id'] = 1;
            $followup_notes = $this->request->data['followup_notes'];        
            $this->request->data['followup_notes'] = '';        
            $data = $this->request->data;
            //debug($data);exit;
            $data['user_id'] = $this->user_data->id;
            $options_va = $this->Sources->optionsIsVa();
            
            $source = $this->Sources->get($data['source_id']); 
            if( $source->is_va == $this->Sources->isNotVa() ){
              $data['va_request_form_completed'] = '';
              $data['va_deposit_paid'] = 0;
              $data['va_name'] = '';
              $data['va_start_date'] = '';
              $data['va_exit_date'] = '';
            }else{
              $data['va_request_form_completed'] = date("Y-m-d", strtotime($data['va_request_form_completed']));
              $data['va_start_date'] = date("Y-m-d", strtotime($data['va_start_date']));
              $data['va_exit_date'] = date("Y-m-d", strtotime($data['va_exit_date']));
            }   

            if( $data['willing_to_review'] == 1 ){
              $data['willing_to_review_date'] = date("Y-m-d",strtotime($data['willing_to_review_date']));
            }else{
              $data['willing_to_review_date'] = '';
            }

            $lead = $this->Leads->patchEntity($lead, $data);
            if ($newLead = $this->Leads->save($lead)) {
                //Save lead notes
                if( $followup_notes != '' ){
                  $data_lead_notes = [
                    'lead_id' => $newLead->id,
                    'user_id' => $this->user_data->id,
                    'date_posted' => date("Y-m-d H:i:s"),
                    'notes' => $followup_notes
                  ];
                  $fnotes = $this->UserLeadFollowupNotes->newEntity();
                  $fnotes = $this->UserLeadFollowupNotes->patchEntity($fnotes, $data_lead_notes);
                  $this->UserLeadFollowupNotes->save($fnotes);
                }                  

                //Save followup notification email
                foreach( $data['followup_source_users'] as $key => $value ){
                  $data_followup_email[] = [
                    'lead_id' => $newLead->id,
                    'user_id' => $key,
                    'followup_date' => $data['followup_date'],
                    'is_sent' => 0
                  ];
                }

                if( !empty($data_followup_email) ){
                  $newLeadFollowupEmail    = $this->LeadFollowupEmails->newEntities($data_followup_email);
                  $resultLeadFollowupEmail = $this->LeadFollowupEmails->saveMany($newLeadFollowupEmail);
                }                
                
                //Save Lead Types
                $a_lead_types = array();
                foreach( $data['leadTypeIds'] as $key => $value ){
                  $data_lead_type = [
                    'lead_id' => $newLead->id,
                    'lead_type_id' => $key
                  ];

                  $leadLeadType = $this->LeadLeadTypes->newEntity();
                  $leadLeadType = $this->LeadLeadTypes->patchEntity($leadLeadType, $data_lead_type);
                  $this->LeadLeadTypes->save($leadLeadType);

                  $leadType = $this->Leads->LeadTypes->find()
                    ->where(['LeadTypes.id' => $key])
                    ->first()
                  ;
                  $a_lead_types[] = $leadType->name;
                } 
                $string_lead_types = implode(", ", $a_lead_types);

                foreach( $this->request->data['attachments'] as $a ){
                  if( $a['name'] != '' ){
                    $attachment = $this->LeadAttachments->uploadAttachment($newLead, $a);
                    $data_attachment = [
                      'lead_id' => $newLead->id,
                      'attachment' => $attachment
                    ];
                    $leadAttachment = $this->LeadAttachments->newEntity();
                    $leadAttachment = $this->LeadAttachments->patchEntity($leadAttachment, $data_attachment);
                    $this->LeadAttachments->save($leadAttachment);
                  }
                }
                //if( $this->request->data['lead_attachment']['name'] != '' ){
                  //Save attachement
                  //$newLead->attachment = $this->Leads->uploadAttachment($newLead, $this->request->data['lead_attachment']);
                  //$this->Leads->save($newLead);
                //}

                //Send Email notification
                $source_users = $this->SourceUsers->find('all')
                    ->contain(['Users'])
                    ->where(['SourceUsers.source_id' => $data['source_id']])
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

                //add other emails from sources - start                    
                if( !empty($source->emails) || $source->emails != '' ) {
                  $other_source_email = explode(";", $source->emails);
                  foreach($other_source_email as $oekey => $emr) {

                    if (trim($emr) != '') {
                        $other_email_to_add_sources = $emr; //ltrim($em);
                        $users_email[$other_email_to_add_sources] = $other_email_to_add_sources;  
                    }

                  }
                  
                }                
                //add other emails from sources - end                                

                if( !empty($users_email) ){

                  //Send email notification  
                  if($this->enable_email_sending) {
                    if( isset($data['send_email_notification']) ){
                      $data_lead_email_notification = [
                        'user_id' => $this->user_data->id,
                        'lead_id' => $newLead->id,
                        'email_type' => 1,
                        'date_time' => date("Y-m-d H:i:s")
                      ];

                      $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->newEntity();
                      $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->patchEntity($newLeadEmailNotification, $data_lead_email_notification);
                      $this->LeadsEmailNotificationHistory->save($newLeadEmailNotification);

                      $leadData = $this->Leads->get($newLead->id, [
                          'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                      ]);                           

                      $source_name      = !empty($source->name) ? $source->name : "";
                      $surname          = $leadData->surname != "" ? $leadData->surname : "Not Specified";
                      $lead_client_name = $leadData->firstname . " " . $surname;
                      $subject          = "New Lead - " . $source_name . " - " . $lead_client_name;    
                      /*$attachment       = $leadData->attachment;
                      $attachment_folder = $this->Leads->getFolderName() . $leadData->id;*/ 

                      //Attachments
                      $leadAttachments = $this->LeadAttachments->find('all')
                        ->where(['LeadAttachments.lead_id' => $newLead->id])
                      ;             

                      $aAttachments = array();
                      $eAttachments = array();
                      $attachment_folder = $this->Leads->LeadAttachments->getFolderName() . $newLead->id;
                      foreach($leadAttachments as $a){
                        $aAttachments[] = $a->attachment;
                        $eAttachments[] = WWW_ROOT . $attachment_folder . DS . $a->attachment;
                      }

                      $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                      $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                        ->template('crm_new_leads')
                        ->emailFormat('html')          
                        ->to($users_email)                                                                                               
                        ->subject($subject)
                        ->attachments($eAttachments)
                        ->viewVars(['lead' => $leadData->toArray(), 'aAttachments' => $aAttachments, 'attachment_folder' => $attachment_folder, 'source' => $source, 'options_va' => $options_va, 'string_lead_types' => $string_lead_types])
                        ->send();
                    }
                  }
                }

                /*Specific source users*/
                if( isset($data['send_specific_notification']) ){
                  $data_lead_email_notification = [
                    'user_id' => $this->user_data->id,
                    'lead_id' => $newLead->id,
                    'email_type' => 3, //Specific users
                    'date_time' => date("Y-m-d H:i:s")
                  ];

                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->newEntity();
                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->patchEntity($newLeadEmailNotification, $data_lead_email_notification);
                  $this->LeadsEmailNotificationHistory->save($newLeadEmailNotification);

                  $modifiedLead = $this->Leads->get($newLead->id, [
                      'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                  ]); 

                  $source_name      = !empty($source->name) ? $source->name : "";
                  $surname          = $modifiedLead->surname != "" ? $modifiedLead->surname : "Not Specified";
                  $lead_client_name = $modifiedLead->firstname . " " . $surname;
                  $subject          = "**LEAD NEEDS ATTENTION**";              
                  $old_attachment       = $modifiedLead->attachment;
                  $old_attachment_folder = $this->Leads->getFolderName() . $modifiedLead->id; 

                  //Attachments
                  $leadAttachments = $this->LeadAttachments->find('all')
                    ->where(['LeadAttachments.lead_id' => $lead->id])
                  ;

                  $aAttachments = array();
                  $eAttachments = array();
                  $attachment_folder = $this->Leads->LeadAttachments->getFolderName() . $lead->id;
                  foreach($leadAttachments as $a){
                    $aAttachments[] = $a->attachment;
                    $eAttachments[] = WWW_ROOT . $attachment_folder . DS . $a->attachment;
                  }

                  $specific_users = array();
                  foreach( $data['source_users'] as $key => $value ){
                    $user = $this->Users->find()
                      ->where(['Users.id' => $key])
                      ->first()
                    ;

                    if( $user ){
                      $specific_users[$user->email] = $user->email;
                    }
                  }

                  if( !empty($specific_users) ){
                    $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                    $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                      ->template('crm_modified_leads')
                      ->emailFormat('html')          
                      ->to($specific_users)                                                                                               
                      ->subject($subject)
                      ->attachments($eAttachments)
                      ->viewVars(['lead' => $modifiedLead->toArray(), 'aAttachments' => $aAttachments, 'attachment_folder' => $attachment_folder, 'old_attachment' => $old_attachment, 'old_attachment_folder' => $old_attachment_folder, 'source' => $source, 'options_va' => $options_va, 'string_lead_types' => $string_lead_types])
                      ->send();
                  }
                }

                /*Secondary email*/
                if( isset($data['send_secondary_email_notification']) && $source->enable_secondary_notification == 1 ){
                  $data_lead_email_notification = [
                    'user_id' => $this->user_data->id,
                    'lead_id' => $newLead->id,
                    'email_type' => 2,
                    'date_time' => date("Y-m-d H:i:s")
                  ];

                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->newEntity();
                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->patchEntity($newLeadEmailNotification, $data_lead_email_notification);
                  $this->LeadsEmailNotificationHistory->save($newLeadEmailNotification);

                  $modifiedLead = $this->Leads->get($newLead->id, [
                      'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                  ]); 

                  $source_name      = !empty($source->name) ? $source->name : "";
                  $surname          = $modifiedLead->surname != "" ? $modifiedLead->surname : "Not Specified";
                  $lead_client_name = $modifiedLead->firstname . " " . $surname;
                  $subject          = "**LEAD NEEDS ATTENTION**";              
                  $old_attachment       = $modifiedLead->attachment;
                  $old_attachment_folder = $this->Leads->getFolderName() . $modifiedLead->id; 

                  //Attachments
                  $leadAttachments = $this->LeadAttachments->find('all')
                    ->where(['LeadAttachments.lead_id' => $lead->id])
                  ;

                  $aAttachments = array();
                  $eAttachments = array();
                  $attachment_folder = $this->Leads->LeadAttachments->getFolderName() . $lead->id;
                  foreach($leadAttachments as $a){
                    $aAttachments[] = $a->attachment;
                    $eAttachments[] = WWW_ROOT . $attachment_folder . DS . $a->attachment;
                  }

                  $secondaryRecipients = $this->SourceSecondaryUsers->find('all')
                    ->contain(['Users'])
                    ->where(['SourceSecondaryUsers.source_id' => $source->id])
                  ;

                  $secondary_recipients = array();
                  foreach( $secondaryRecipients as $sr ){
                    $secondary_recipients[$sr->user->email] = $sr->user->email;
                  }

                  if( !empty($secondary_recipients) ){
                    $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                    $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                      ->template('crm_modified_leads')
                      ->emailFormat('html')          
                      ->to($secondary_recipients)                                                                                               
                      ->subject($subject)
                      ->attachments($eAttachments)
                      ->viewVars(['lead' => $modifiedLead->toArray(), 'aAttachments' => $aAttachments, 'attachment_folder' => $attachment_folder, 'old_attachment' => $old_attachment, 'old_attachment_folder' => $old_attachment_folder, 'source' => $source, 'options_va' => $options_va, 'string_lead_types' => $string_lead_types])
                      ->send();
                  }
                }

                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];

                /*
                 * To do: add audit trail here
                 * Add IP Address on saving in audit trails
                */
                $audit_details = "";
                $audit_details .= "Added By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= "( " . $this->user->email . " )";
                $audit_details .= "<br />";
                $audit_details .= "Lead ID: " . $lead->id;

                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Add New Lead';
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = $audit_details;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }
                /*
                 * Audit trail end here
                */

                if( $action == 'save' ){
                    if( empty($source_id) || $source_id == '' ) {
                      return $this->redirect(['action' => 'index']);
                    } else {
                      return $this->redirect(array('controller' => 'leads', 'action' => 'from_source', $source_id));
                    }
                    
                }else{
                    if( empty($source_id) || $source_id == '' ) {
                      return $this->redirect(['action' => 'add']);
                    } else {
                      return $this->redirect(['action' => 'add', $source_id]);
                    }                    
                }                    
            } else {
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }
        }

        $option_va_deposit_paid = $this->Leads->optionVADepositPaid();
        $options_cooling_repair = $this->Leads->optionsCoolingRepair();
        $user_fullname = $this->user_data->firstname . ' ' . $this->user_data->lastname;
        $this->set('source_id', $source_id);
        $status_list = $this->Statuses->find('all', ['order' => ['Statuses.sort' => 'ASC']]);
        $statuses = $this->Leads->Statuses->find('list', ['order' => ['Statuses.sort' => 'ASC']]);
        $sources  = $this->Leads->Sources->find('list', ['order' => ['Sources.sort' => 'ASC']]);        
        $interestTypes = $this->Leads->InterestTypes->find('list', ['order' => ['InterestTypes.sort' => 'ASC']]);
        $leadTypes = $this->Leads->LeadTypes->find('list', ['order' => ['LeadTypes.sort' => 'ASC']]);
        $optionsWillToReview = $this->Leads->optionsWillToReview();
        $this->set(compact('lead', 'statuses', 'sources', 'interestTypes', 'leadTypes','status_list', 'options_cooling_repair', 'option_va_deposit_paid', 'user_fullname', 'optionsWillToReview'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $redir = null, $source_id = null)
    {
        $this->SourceUsers = TableRegistry::get('SourceUsers');
        $this->Sources     = TableRegistry::get('Sources');
        $this->Statuses    = TableRegistry::get('Statuses');
        $this->AuditTrails = TableRegistry::get('AuditTrails');
        $this->LeadAttachments = TableRegistry::get('LeadAttachments');
        $this->Users =  TableRegistry::get('Users');
        $this->LeadsEmailNotificationHistory = TableRegistry::get('LeadsEmailNotificationHistory');
        $this->SourceSecondaryUsers = TableRegistry::get('SourceSecondaryUsers');
        $this->LeadLeadTypes = TableRegistry::get('LeadLeadTypes');
        $this->LeadFollowupEmails = TableRegistry::get('LeadFollowupEmails');
        $this->UserLeadFollowupNotes = TableRegistry::get('UserLeadFollowupNotes');        
        $this->SpecificUserLeads = TableRegistry::get('SpecificUserLeads');

        $p = $this->default_group_actions;
        if( $p && $p['leads'] == 'View Only' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        } 

        $login_user_id = $this->user->id;
        if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          //$this->request->data['allocation_date']               = date("Y-m-d", strtotime($this->request->data['allocation_date']));
          $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
          $this->request->data['followup_action_reminder_date'] = date("Y-m-d", strtotime($this->request->data['followup_action_reminder_date']));
        }

        $lead_lock = $this->Leads->get($id, [ 'contain' => ['LastModifiedBy'] ]);         

        //if($lead_lock->is_lock && $lead_lock->last_modified_by->id != $this->user->id) {
        if($lead_lock->is_lock ) {

          $this->Flash->error(__('This lead is being accessed by another user, please try again later.'));
          if($redir == 'dashboard') {
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
          } else {
            return $this->redirect(['action' => 'index']);
          }

        }elseif($lead_lock->is_lock == 0) {
          $query = $this->Leads->query();
          /*$query->update()
            ->set(['is_lock' => 1, 'last_modified_by_id' => $login_user_id])
            ->where(['id' => $id])
            ->execute();*/

          /*$query->update()
            ->set(['is_lock' => 1])
            ->where(['id' => $id])
            ->execute();

          $session  = $this->request->session();  
          $lck_leads[$login_user_id] = $id;
          $session->write('LeadsLock.data', $lck_leads);    */

          /*$data['is_lock']              = 1;
          $data['last_modified_by_id'] = $login_user_id;
          $lead_lock = $this->Leads->patchEntity($lead_lock, $data);
          if ( !$this->Leads->save($lead_lock) ) { 
            echo "error updating lock lead"; exit; 
          } else {
            $session  = $this->request->session();  
            $lck_leads[$login_user_id] = $id;
            $session->write('LeadsLock.data', $lck_leads);            
          }*/
        } 

        $lead = $this->Leads->get($id, [
            'contain' => ['LastModifiedBy', 'LeadAttachments', 'Users', 'Sources', 'LeadLeadTypes']
        ]); 

        $leadTypeIds = array();
        foreach( $lead->lead_lead_types as $l ){
          $leadTypeIds[$l->lead_type_id] = $l->lead_type_id;
        }  
        $lead = santizeLeadsData($lead);     

        $leadEmailNotificationHistory = $this->LeadsEmailNotificationHistory->find('all')
          ->contain(['Users'])
          ->where(['LeadsEmailNotificationHistory.lead_id' => $lead->id])
        ;
        
        if ($this->request->is(['patch', 'post', 'put'])) {          
            $data = $this->request->data;            
            $this->request->data['user_id'] = $lead->user_id;
            $options_va = $this->Sources->optionsIsVa();            
            $source = $this->Sources->get($data['source_id']); 
            if( $source->is_va == $this->Sources->isNotVa() ){
              $this->request->data['va_request_form_completed'] = '';
              $this->request->data['va_deposit_paid'] = 0;
              $this->request->data['va_name'] = '';
              $this->request->data['va_start_date'] = '';
              $this->request->data['va_exit_date'] = '';
            }else{
              $this->request->data['va_request_form_completed'] = date("Y-m-d", strtotime($this->request->data['va_request_form_completed']));
              $this->request->data['va_start_date'] = date("Y-m-d", strtotime($this->request->data['va_start_date']));
              $this->request->data['va_exit_date'] = date("Y-m-d", strtotime($this->request->data['va_exit_date']));
            }
            $fields_changes = array();
            foreach ($data as $dkey => $lu) {
              if ($dkey != 'save') {
                if ($dkey == "followup_date") {
                  if (date( "Y-m-d", strtotime($lead->{$dkey})) != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $lead->{$dkey};
                    $fields_changes[$dkey]['new'] = $data[$dkey];
                  }
                } elseif ($dkey == "followup_action_reminder_date") {
                  if (date( "Y-m-d", strtotime($lead->{$dkey})) != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $lead->{$dkey};
                    $fields_changes[$dkey]['new'] = $data[$dkey];
                  }
                } else {
                  if ($lead->{$dkey} != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $lead->{$dkey};
                    $fields_changes[$dkey]['new'] = $data[$dkey];
                  }
                }
              }
            }

            $followup_notes = $this->request->data['followup_notes'];
            $this->request->data['followup_notes'] = $lead->followup_notes;
            if( $data['willing_to_review'] == 1 ){
              $this->request->data['willing_to_review_date'] = date("Y-m-d",strtotime($this->request->data['willing_to_review_date']));
            }else{
              $this->request->data['willing_to_review_date'] = '';
            }

            $lead = $this->Leads->patchEntity($lead, $this->request->data);
            $dataChanges = $lead->extract($lead->visibleProperties(), true);
            $is_with_changes = false;
            if( count($dataChanges) == 2 ){                                
                if( $this->request->data['lead_attachment']['name'] != '' ){
                  $is_with_changes = true;
                }                
            }elseif( count($dataChanges) > 2 ){
              $is_with_changes = true;
            }            

            if ($this->Leads->save($lead)) {
                //Update Specific User Leads
                $this->SpecificUserLeads->deleteAll(['lead_id' => $lead->id]);
                $specific_user_leads_bulk_data = array();
                foreach( $data['specificUser'] as $key => $keyId ){
                  $specific_user_leads_bulk_data[] = ['user_id' => $keyId, 'lead_id' => $lead->id];
                }

                if( !empty($specific_user_leads_bulk_data) ){
                  $specificUserLeads = $this->SpecificUserLeads->newEntities($specific_user_leads_bulk_data);
                  $this->SpecificUserLeads->saveMany($specificUserLeads);                    
                }     

                if( $followup_notes != '' ){
                  //Save lead notes
                  $data_lead_notes = [
                    'lead_id' => $lead->id,
                    'user_id' => $this->user_data->id,
                    'date_posted' => date("Y-m-d H:i:s"),
                    'notes' => $followup_notes
                  ];
                  $fnotes = $this->UserLeadFollowupNotes->newEntity();
                  $fnotes = $this->UserLeadFollowupNotes->patchEntity($fnotes, $data_lead_notes);
                  $this->UserLeadFollowupNotes->save($fnotes);
                }        

                //Save followup notification email
                $this->LeadFollowupEmails->deleteAll(['lead_id' => $lead->id]);
                foreach( $data['followup_source_users'] as $key => $value ){
                  $data_followup_email[] = [
                    'lead_id' => $lead->id,
                    'user_id' => $key,
                    'followup_date' => $data['followup_date'],
                    'is_sent' => 0
                  ];
                }
                if( !empty($data_followup_email) ){
                  $newLeadFollowupEmail    = $this->LeadFollowupEmails->newEntities($data_followup_email);
                  $resultLeadFollowupEmail = $this->LeadFollowupEmails->saveMany($newLeadFollowupEmail);  
                }
                
                //Save Lead Types
                $this->Leads->LeadLeadTypes->deleteAll(['lead_id' => $lead->id]);
                $a_lead_types = array();
                foreach( $data['leadTypeIds'] as $key => $value ){
                  $data_lead_type = [
                    'lead_id' => $lead->id,
                    'lead_type_id' => $key
                  ];

                  $leadLeadType = $this->Leads->LeadLeadTypes->newEntity();
                  $leadLeadType = $this->Leads->LeadLeadTypes->patchEntity($leadLeadType, $data_lead_type);
                  $this->Leads->LeadLeadTypes->save($leadLeadType);

                  $leadType = $this->Leads->LeadTypes->find()
                    ->where(['LeadTypes.id' => $key])
                    ->first()
                  ;
                  $a_lead_types[] = $leadType->name;
                } 
                $string_lead_types = implode(", ", $a_lead_types);

                /*if( $this->request->data['lead_attachment']['name'] != '' ){
                  //Save attachement
                  $lead->attachment = $this->Leads->uploadAttachment($lead, $this->request->data['lead_attachment']);
                  $this->Leads->save($lead);
                }*/

                //New Attachments
                $attachmentIds = array();
                foreach( $data['currentAttachments'] as $key => $a ){
                  $attachmentIds[] = $key;
                }

                if( $attachmentIds ){
                  $this->LeadAttachments->deleteAll(['LeadAttachments.lead_id' => $lead->id, 'LeadAttachments.id NOT IN' => $attachmentIds]);
                }

                foreach( $this->request->data['attachments'] as $a ){
                  if( $a['name'] != '' ){
                    $attachment = $this->LeadAttachments->uploadAttachment($lead, $a);
                    $data_attachment = [
                      'lead_id' => $lead->id,
                      'attachment' => $attachment
                    ];
                    $leadAttachment = $this->LeadAttachments->newEntity();
                    $leadAttachment = $this->LeadAttachments->patchEntity($leadAttachment, $data_attachment);
                    $this->LeadAttachments->save($leadAttachment);
                  }
                }
                
                //Send Email notification
                //debug($data);exit;
                $source_users = $this->SourceUsers->find('all')
                    ->contain(['Users'])
                    ->where(['SourceUsers.source_id' => $data['source_id']])
                ;

                $users_email = array();
                foreach($source_users as $users){            
                    $users_email[$users->user->email] = $users->user->email;            
                }

                //Lead specific users
                $leadSpecificUser =  $this->SpecificUserLeads->find('all')
                  ->contain(['Users'])
                  ->where(['SpecificUserLeads.lead_id' => $lead->id])
                ;

                foreach( $leadSpecificUser as $lu ){
                  if( !array_key_exists($lu->user->email, $users_email) ){
                      $users_email[$lu->user->email] = $lu->user->email;    
                  }
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

                //add other emails from sources - start
                if( !empty($source->emails) || $source->emails != '' ) {
                  $other_source_email = explode(";", $source->emails);
                  foreach($other_source_email as $oekey => $emr) {

                    if (trim($emr) != '') {
                        $other_email_to_add_sources = $emr; //ltrim($em);
                        $users_email[$other_email_to_add_sources] = $other_email_to_add_sources;  
                    }

                  }
                  
                }                
                //add other emails from sources - end

                if( !empty($users_email) ){ 

                  if($this->enable_email_sending) {
                    if( isset($data['send_email_notification']) ){

                      $data_lead_email_notification = [
                        'user_id' => $this->user_data->id,
                        'lead_id' => $lead->id,
                        'email_type' => 1,
                        'date_time' => date("Y-m-d H:i:s")
                      ];

                      $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->newEntity();
                      $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->patchEntity($newLeadEmailNotification, $data_lead_email_notification);
                      $this->LeadsEmailNotificationHistory->save($newLeadEmailNotification);

                      $modifiedLead = $this->Leads->get($id, [
                          'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                      ]); 

                      $source_name      = !empty($source->name) ? $source->name : "";
                      $surname          = $modifiedLead->surname != "" ? $modifiedLead->surname : "Not Specified";
                      $lead_client_name = $modifiedLead->firstname . " " . $surname;
                      $subject          = "Updated Lead - " . $source_name . " - " . $lead_client_name;              
                      $old_attachment       = $modifiedLead->attachment;
                      $old_attachment_folder = $this->Leads->getFolderName() . $modifiedLead->id; 

                      //Attachments
                      $leadAttachments = $this->LeadAttachments->find('all')
                        ->where(['LeadAttachments.lead_id' => $lead->id])
                      ;

                      $aAttachments = array();
                      $eAttachments = array();
                      $attachment_folder = $this->Leads->LeadAttachments->getFolderName() . $lead->id;
                      foreach($leadAttachments as $a){
                        $aAttachments[] = $a->attachment;
                        $eAttachments[] = WWW_ROOT . $attachment_folder . DS . $a->attachment;
                      }

                      $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                      $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                        ->template('crm_modified_leads')
                        ->emailFormat('html')          
                        ->to($users_email)                                                                                               
                        ->subject($subject)
                        ->attachments($eAttachments)
                        ->viewVars(['lead' => $modifiedLead->toArray(), 'aAttachments' => $aAttachments, 'attachment_folder' => $attachment_folder, 'old_attachment' => $old_attachment, 'old_attachment_folder' => $old_attachment_folder, 'source' => $source, 'options_va' => $options_va, 'string_lead_types' => $string_lead_types])
                        ->send();
                    }                    
                  }
                }  

                /*Specific source users*/
                if( isset($data['send_specific_notification']) ){
                  $data_lead_email_notification = [
                    'user_id' => $this->user_data->id,
                    'lead_id' => $lead->id,
                    'email_type' => 3, //Specific users
                    'date_time' => date("Y-m-d H:i:s")
                  ];

                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->newEntity();
                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->patchEntity($newLeadEmailNotification, $data_lead_email_notification);
                  $this->LeadsEmailNotificationHistory->save($newLeadEmailNotification);

                  $modifiedLead = $this->Leads->get($lead->id, [
                      'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                  ]); 

                  $source_name      = !empty($source->name) ? $source->name : "";
                  $surname          = $modifiedLead->surname != "" ? $modifiedLead->surname : "Not Specified";
                  $lead_client_name = $modifiedLead->firstname . " " . $surname;
                  $subject          = "**LEAD NEEDS ATTENTION**";              
                  $old_attachment       = $modifiedLead->attachment;
                  $old_attachment_folder = $this->Leads->getFolderName() . $modifiedLead->id; 

                  //Attachments
                  $leadAttachments = $this->LeadAttachments->find('all')
                    ->where(['LeadAttachments.lead_id' => $lead->id])
                  ;

                  $aAttachments = array();
                  $eAttachments = array();
                  $attachment_folder = $this->Leads->LeadAttachments->getFolderName() . $lead->id;
                  foreach($leadAttachments as $a){
                    $aAttachments[] = $a->attachment;
                    $eAttachments[] = WWW_ROOT . $attachment_folder . DS . $a->attachment;
                  }

                  $specific_users = array();
                  foreach( $data['source_users'] as $key => $value ){
                    $user = $this->Users->find()
                      ->where(['Users.id' => $key])
                      ->first()
                    ;

                    if( $user ){
                      $specific_users[$user->email] = $user->email;
                    }
                  }

                  //Lead Specific Users
                  foreach( $leadSpecificUser as $lu ){
                    if( !array_key_exists($lu->user->email, $specific_users) ){
                        $specific_users[$lu->user->email] = $lu->user->email;    
                    }
                  }

                  if( !empty($specific_users) ){
                    $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                    $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                      ->template('crm_modified_leads')
                      ->emailFormat('html')          
                      ->to($specific_users)                                                                                               
                      ->subject($subject)
                      ->attachments($eAttachments)
                      ->viewVars(['lead' => $modifiedLead->toArray(), 'aAttachments' => $aAttachments, 'attachment_folder' => $attachment_folder, 'old_attachment' => $old_attachment, 'old_attachment_folder' => $old_attachment_folder, 'source' => $source, 'options_va' => $options_va, 'string_lead_types' => $string_lead_types])
                      ->send();
                  }
                }

                /*Secondary email*/
                if( isset($data['send_secondary_email_notification']) && $source->enable_secondary_notification == 1 ){
                  $data_lead_email_notification = [
                    'user_id' => $this->user_data->id,
                    'lead_id' => $lead->id,
                    'email_type' => 2,
                    'date_time' => date("Y-m-d H:i:s")
                  ];

                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->newEntity();
                  $newLeadEmailNotification = $this->LeadsEmailNotificationHistory->patchEntity($newLeadEmailNotification, $data_lead_email_notification);
                  $this->LeadsEmailNotificationHistory->save($newLeadEmailNotification);

                  $modifiedLead = $this->Leads->get($id, [
                      'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                  ]); 

                  $source_name      = !empty($source->name) ? $source->name : "";
                  $surname          = $modifiedLead->surname != "" ? $modifiedLead->surname : "Not Specified";
                  $lead_client_name = $modifiedLead->firstname . " " . $surname;
                  $subject          = "**LEAD NEEDS ATTENTION**";              
                  $old_attachment       = $modifiedLead->attachment;
                  $old_attachment_folder = $this->Leads->getFolderName() . $modifiedLead->id; 

                  //Attachments
                  $leadAttachments = $this->LeadAttachments->find('all')
                    ->where(['LeadAttachments.lead_id' => $lead->id])
                  ;

                  $aAttachments = array();
                  $eAttachments = array();
                  $attachment_folder = $this->Leads->LeadAttachments->getFolderName() . $lead->id;
                  foreach($leadAttachments as $a){
                    $aAttachments[] = $a->attachment;
                    $eAttachments[] = WWW_ROOT . $attachment_folder . DS . $a->attachment;
                  }

                  $secondaryRecipients = $this->SourceSecondaryUsers->find('all')
                    ->contain(['Users'])
                    ->where(['SourceSecondaryUsers.source_id' => $source->id])
                  ;

                  $secondary_recipients = array();
                  foreach( $secondaryRecipients as $sr ){
                    $secondary_recipients[$sr->user->email] = $sr->user->email;
                  }

                  if( !empty($secondary_recipients) ){
                    $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                    $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                      ->template('crm_modified_leads')
                      ->emailFormat('html')          
                      ->to($secondary_recipients)                                                                                               
                      ->subject($subject)
                      ->attachments($eAttachments)
                      ->viewVars(['lead' => $modifiedLead->toArray(), 'aAttachments' => $aAttachments, 'attachment_folder' => $attachment_folder, 'old_attachment' => $old_attachment, 'old_attachment_folder' => $old_attachment_folder, 'source' => $source, 'options_va' => $options_va, 'string_lead_types' => $string_lead_types])
                      ->send();
                  }
                }   

                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];

                if( $is_with_changes ){
                  /*
                   * To do: add audit trail here
                   * Add IP Address on saving in audit trails
                  */
                    $audit_details = "";
                    $audit_details .= "Updated By: " . $this->user->firstname . ' ' . $this->user->lastname;
                    $audit_details .= " (" . $this->user->email . ")";
                    $audit_details .= "<br />";
                    $audit_details .= "Lead ID: " . $lead->id;
                    $audit_details .= "<hr />";
                    $audit_details .= "<strong>Changes:</strong>" . "<br />";
                    foreach($fields_changes as $fkey => $fd ) {
                      $audit_details .= $fkey . ": '" . $fd['old'] . "' to '" . $fd['new'] . "'";
                      $audit_details .= "<br />";
                    }

                    $audit_data['user_id']      = $this->user->id;
                    $audit_data['action']       = 'Update Lead';
                    $audit_data['event_status'] = 'Success';
                    $audit_data['details']      = $audit_details;
                    $audit_data['audit_date']   = date("Y-m-d h:i:s");
                    $audit_data['ip_address']   = getRealIPAddress();

                    $auditTrail = $this->AuditTrails->newEntity();
                    $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                    if (!$this->AuditTrails->save($auditTrail)) {
                      echo 'Error updating audit trails'; exit;
                    }

                    //$data['is_lock']              = 0;
                    //$data['last_modified_by_id '] = $login_user_id; 
                    $lead->last_modified_by_id = $login_user_id;
                    $lead->is_lock = 0;
                    $this->Leads->save($lead);                                                        
                  /*
                   * Audit trail end here
                  */
                }
                  

                if( $action == 'save' ){                    
                    if($redir == 'dashboard') {
                      return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                    }elseif($redir == 'from_source'){
                      return $this->redirect(array('controller' => 'leads', 'action' => 'from_source', $source_id));
                    } else {
                      if(isset($_GET['page'])) {                        
                        return $this->redirect(['controller' => 'leads', 'action' => 'index?page='.$_GET['page']]);
                      } else {
                        return $this->redirect(['action' => 'index']);
                      }
                    }
                }else{
                    if($redir == 'from_source'){
                      return $this->redirect(['action' => 'edit', $id, 'from_source', $source_id]);
                    }elseif($redir == 'dashboard') {
                       return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                    } else {
                      return $this->redirect(['action' => 'edit', $id]);  
                    }
                    
                }         
            } else {
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }
        }

        $back_url = Router::url( $this->referer(), true );
        $option_va_deposit_paid = $this->Leads->optionVADepositPaid();
        $options_cooling_repair = $this->Leads->optionsCoolingRepair();
        if( $lead->user_id > 0 ){
          $user_fullname = $lead->user->firstname . ' ' . $lead->user->lastname;
        }else{
          $user_fullname = '';
        }        

        //Lead Specific Users
        $specificUserLeads = $this->SpecificUserLeads->find('all')
          ->where(['SpecificUserLeads.lead_id' => $id])
        ;

        $a_specific_user_leads = array();
        foreach( $specificUserLeads as $ls ){
          $a_specific_user_leads[$ls->user_id] = $ls->user_id;
        }

        $nonAdminUsers = $this->Users->find('all')
          ->where(['Users.group_id <>' => 1])
          ->order(['Users.firstname' => 'ASC'])
        ;

        $this->set('back_url', $back_url);
        $this->set('redir', $redir);
        $this->set('source_id', $source_id);
        $this->set('leadEmailNotificationHistory', $leadEmailNotificationHistory);
        $this->set('nonAdminUsers', $nonAdminUsers);
        $this->set('a_specific_user_leads', $a_specific_user_leads);
        //$this->set('load_source_users', true);
        $statuses = $this->Leads->Statuses->find('list', ['order' => ['Statuses.sort' => 'ASC']]);
        $status_list = $this->Statuses->find('all', ['order' => ['Statuses.sort' => 'ASC']]);
        $sources = $this->Leads->Sources->find('list', ['order' => ['Sources.sort' => 'ASC']]);        
        $interestTypes = $this->Leads->InterestTypes->find('list', ['order' => ['InterestTypes.sort' => 'ASC']]);
        $leadTypes = $this->Leads->LeadTypes->find('list', ['order' => ['LeadTypes.sort' => 'ASC']]);
        $leadFollowupNotes = $this->UserLeadFollowupNotes->find('all')
          ->contain(['Users'])
          ->where(['UserLeadFollowupNotes.lead_id' => $id])
        ;
        $optionsWillToReview = $this->Leads->optionsWillToReview();
        $this->set(compact('lead', 'statuses', 'sources', 'interestTypes', 'leadTypes', 'status_list', 'options_cooling_repair', 'user_fullname', 'option_va_deposit_paid', 'leadTypeIds', 'leadFollowupNotes', 'optionsWillToReview'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $source_id = null, $page = null)
    {
        $p = $this->default_group_actions;
        if( $p && $p['leads'] != 'View, Edit and Delete' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        } 

        $lead_exists = $this->Leads->exists(['id' => $id]);
        if($lead_exists) {

          $login_user_id = $this->user->id;
          $lead_lock = $this->Leads->get($id, [ 'contain' => ['LastModifiedBy'] ]);

          if($lead_lock->is_lock && $lead_lock->last_modified_by->id != $this->user->id) {
            $this->Flash->error(__('This lead is being accessed by another user, please try again later.'));
            return $this->redirect(['action' => 'index']);
          }       

          //$this->request->allowMethod(['post', 'delete']);
          
          if($this->enable_archive_data) {

            $lead = $this->Leads->get($id);     

            $login_user_id                      = $this->user->id;
            $lead_data['last_modified_by_id ']  = $login_user_id;
            $lead_data['is_archive']           = "Yes";
            $lead = $this->Leads->patchEntity($lead, $lead_data);

            if ( !$this->Leads->save($lead) ) { 
              $this->Flash->error(__('The lead could not be archived. Please try again.'));
            } else {
                /*
                 * Audit Trail start here
                */
                $this->AuditTrails = TableRegistry::get('AuditTrails');
                $audit_data['user_id']      = $login_user_id;
                $audit_data['action']       = 'Archived Lead';
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = 'Lead ID: ' . $id;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }
                /*
                 * Audit Trail end here
                */             
                $this->Flash->success(__('The lead has been deleted.'));   
            }

          } else {

            $lead = $this->Leads->get($id);
            if ($this->Leads->delete($lead)) {

                /*
                 * Audit Trail start here
                */
                $this->AuditTrails = TableRegistry::get('AuditTrails');
                $audit_data['user_id']      = $login_user_id;
                $audit_data['action']       = 'Delete Lead';
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = 'Lead ID: ' . $id;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }
                /*
                 * Audit Trail end here
                */              

                $this->Flash->success(__('The lead has been deleted.'));
            } else {
                $this->Flash->error(__('The lead could not be deleted. Please try again.'));
            }

          }

        } else {

          $this->Flash->error(__('The lead could not be found. Please try again.'));

        }

        if( !empty($source_id) ) {
          if(isset($_GET['page']) ) {
            return $this->redirect(['action' => 'from_source/'. $source_id . '?page='.$_GET['page']]);
          }else{
            return $this->redirect(['action' => 'from_source/'. $source_id]);
          }
          
        } else {
          if(isset($_GET['page']) ) {
            return $this->redirect(['action' => 'index?page='.$_GET['page']]);     
          } else {
            return $this->redirect(['action' => 'index']);     
          }
           
        }
        
    }

    /**
     * Frontend : register method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function register()
    {
        $this->viewBuilder()->layout("Front/register");  

        $lead = $this->Leads->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['allocation_date'] = date("Y-m-d");
            $this->request->data['followup_date']   = date("Y-m-d");
            $this->request->data['followup_action_reminder_date'] = date("Y-m-d");
            $lead = $this->Leads->patchEntity($lead, $this->request->data);                
            if ($new_lead = $this->Leads->save($lead)) {

                //Send email notification to admin
                $admin_email = 'bryan.yobi@gmail.com';
                $email_customer = new Email('cake_smtp'); //default or cake_smtp (for testing in local)
                $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                  ->template('leads_registration')
                  ->emailFormat('html')
                  ->to($admin_email)                                                                                                     
                  ->subject('New Leads')
                  ->viewVars(['new_lead' => $new_lead])
                  ->send();

                $this->Flash->success(__('The lead has been saved.'));                
            } else {
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }
            return $this->redirect(['action' => 'register']);
        }
        $statuses = $this->Leads->Statuses->find('list', ['limit' => 200]);
        $sources  = $this->Leads->Sources->find('list', ['limit' => 200]);
        $allocations = $this->Leads->Allocations->find('list', ['limit' => 200]);
        $interestTypes = $this->Leads->InterestTypes->find('list',['limit' => 200]);
        $this->set(compact('lead', 'statuses', 'sources', 'allocations', 'interestTypes'));
        $this->set('_serialize', ['lead']);
    }

    public function unlock($id = null)
    {
      $lead_unlock = $this->Leads->get($id, [ 'contain' => ['LastModifiedBy'] ]);       

      $login_user_id                      = $this->user->id;
      $data_unlck['is_lock']              = 0;
      $data_unlck['last_modified_by_id '] = $login_user_id;
      $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data_unlck);

      if( !$this->Leads->save($lead_unlock) ) {
        echo "error unlocking lead"; exit;
      } else {
        $this->Flash->success(__('The lead has been unlocked.'));
        return $this->redirect(['action' => 'index']);  
      }

    }

    
    public function is_lock()
    {
        $lead = 2;

        $this->set('lead', $lead);
        $this->set('_serialize', ['lead']);      
    }

    public function leads_unlock()
    {
      $session     = $this->request->session(); 
      $ulock_leads = $session->read('LeadsLock.data');
      $u           = $session->read('User.data');
  
      if(isset($ulock_leads)) {
        foreach($ulock_leads as $ul_key => $ul_data) {
          $user_id = $ul_key;
          $lead_id = $ul_data;

          if($user_id == $u->id) {
            $lead_unlock = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);       

            $login_user_id                      = $u->id;
            $data_unlck['is_lock']              = 0;
            $data_unlck['last_modified_by_id '] = $login_user_id;
            $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data_unlck);
            if ( $this->Leads->save($lead_unlock) ) { 
              unset($ulock_leads[$u->id]);
            }

          }

        }

      } else {

        $lock_leads = $this->Leads->find('all')
            ->contain(['Statuses', 'Sources', 'Allocations'])
            ->where(['Leads.is_lock ' => 1])
            ->andWhere(['Leads.last_modified_by_id' => $u->id])
          ;       

        foreach($lock_leads as $ll_key => $ll_data) {
            $lock_status           = $ll_data->is_lock;
            $last_modified_user_id = $ll_data->last_modified_by_id;
            $lead_id               = $ll_data->id;
            $login_user_id         = $u->id;

            if($last_modified_user_id == $u->id) {

                $lead_unlck = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);      
                $data['is_lock']              = 0;
                $data['last_modified_by_id '] = $login_user_id;
                $lead_unlck = $this->Leads->patchEntity($lead_unlck, $data);
                if ( !$this->Leads->save($lead_unlck) ) { echo "error updating lock lead"; exit; }                

            }

        }         
      }
      
    }    

    public function no_access() 
    {
        $this->set(['message' => '']);
    }    

    public function leads_delete_multiple()
    {
      if( $this->user->group_id == 1 ){
        $leadsIds = $this->request->data['leads'];
        if( count($leadsIds) > 0 ){
          $total_deleted = 0;
          foreach( $leadsIds as $id ){
            $lead = $this->Leads->find()
              ->where(['Leads.id' => $id])
              ->first()
            ;

            if ($this->Leads->delete($lead)) {
              $total_deleted++;
            }
          } 
          if( $total_deleted > 0 ){
            $message = __('Selected leads was successfully deleted. Total Deleted : ') . $total_deleted;          
          }else{
            $message = __('0 leads deleted');          
          }
          
          $this->Flash->success($message);
        }else{
          $this->Flash->error(__('Please select leads to delete'));
        }        
      }else{
        $this->Flash->error(__('Cannot perform selected action.'));
      }
      return $this->redirect($this->referer());
    }
}
