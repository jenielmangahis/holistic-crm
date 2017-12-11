<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 */
class LeadsController extends AppController
{

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

      if( isset($this->request->query['query']) ){
          $query = $this->request->query['query'];
          $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources'])
              ->where(['Leads.firstname LIKE' => '%' . $query . '%'])       
              ->orWhere(['Leads.surname LIKE' => '%' . $query . '%'])       
              ->orWhere(['Leads.email LIKE' => '%' . $query . '%'])       
          ;
      }else{

          $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : '';
          $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : '';
          
          /*if( !empty($this->request->query['direction']) && !empty($this->request->query['sort']) ) {
              $leads_to_sort  = $this->Leads->find('all')
                                  ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                                  ->order([$sort_field => $sort_direction])
                                  ;
              $sort = 1;
              foreach($leads_to_sort as $skey => $sd) {

                  $a_data = $this->Leads->get($sd->id, []);
                  $data_sort['sort'] = $sort;
                  $a_data = $this->Leads->patchEntity($a_data, $data_sort);
                  if ( !$this->Leads->save($a_data) ) { echo "error unlocking lead"; }                    

              $sort++;
              }
          }*/
          
          /*if(!empty($sort_direction) && !empty($sort_field)) {
            $this->paginate = ['order' => ['Leads.sort' => 'ASC']];  
          } else {
            $this->paginate = ['order' => ['Leads.allocation_date' => 'DESC']];
          }*/
          
          
          if( !isset($this->request->query['sort']) ){
            $this->paginate = ['order' => ['Leads.allocation_date' => 'DESC']];
            $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                
            ;
          }else{

            if($sort_field == 'source_id' || $sort_field == 'Leads.source_id') {
              $this->paginate = ['order' => ['Sources.name' => $sort_direction]];
            }
            
            $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                //->order(['Sources.name' => 'ASC'])
            ;  
          }
          
      }


      /*$this->paginate = [
          'contain' => ['Statuses', 'Sources']
      ];*/
        
      $this->set('is_admin_user', $this->user->group_id);
      $this->set('leads', $this->paginate($leads));
      $this->set('_serialize', ['leads', 'is_admin_user']);
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
              ->where(['Leads.firstname LIKE' => '%' . $query . '%'])       
              ->orWhere(['Leads.surname LIKE' => '%' . $query . '%'])       
              ->orWhere(['Leads.email LIKE' => '%' . $query . '%'])       
          ;
      }else{
          $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
              ->where(['Leads.source_id ' => $source_id]) 
          ;
      }
       
      $this->set('source_id', $source_id);
      $this->set('is_admin_user', $this->user->group_id);
      $this->set('source_name', $source->name);
      $this->set('leads', $this->paginate($leads));
      $this->set('_serialize', ['leads', 'is_admin_user']);

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
        $lead = $this->Leads->find()
           ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
           ->where(['Leads.id' => $id])
           ->first()
        ;       

        $this->set('lead', $lead);
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

        $p = $this->default_group_actions;
        if( $p && $p['leads'] == 'View Only' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        } 

        if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          $this->request->data['allocation_date']               = empty($this->request->data['allocation_date']) ? date('Y-m-d') : date("Y-m-d", strtotime($this->request->data['allocation_date']));
          $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
          $this->request->data['followup_action_reminder_date'] = date("Y-m-d", strtotime($this->request->data['followup_action_reminder_date']));
        }

        $lead = $this->Leads->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->data;
           
            $lead = $this->Leads->patchEntity($lead, $data);
            if ($newLead = $this->Leads->save($lead)) {

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
                $source = $this->Sources->get($data['source_id']);        
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
                      $leadData = $this->Leads->get($newLead->id, [
                          'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                      ]);                           

                      $source_name      = !empty($source->name) ? $source->name : "";
                      $surname          = $leadData->surname != "" ? $leadData->surname : "Not Specified";
                      $lead_client_name = $leadData->firstname . " " . $surname;
                      $subject          = "New Lead - " . $source_name . " - " . $lead_client_name;                     

                      $email_customer = new Email('default'); //default or cake_smtp (for testing in local)
                      $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                        ->template('crm_new_leads')
                        ->emailFormat('html')          
                        ->to($users_email)                                                                                               
                        ->subject($subject)
                        ->viewVars(['lead' => $leadData->toArray()])
                        ->send();
                    }
                  }
                }

                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];
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

        $this->set('source_id', $source_id);
        $statuses = $this->Leads->Statuses->find('list', ['order' => ['Statuses.sort' => 'ASC']]);
        $sources  = $this->Leads->Sources->find('list', ['order' => ['Sources.sort' => 'ASC']]);        
        $interestTypes = $this->Leads->InterestTypes->find('list', ['order' => ['InterestTypes.sort' => 'ASC']]);
        $leadTypes = $this->Leads->LeadTypes->find('list', ['order' => ['LeadTypes.sort' => 'ASC']]);
        $this->set(compact('lead', 'statuses', 'sources', 'interestTypes', 'leadTypes'));
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
        $this->AuditTrails = TableRegistry::get('AuditTrails');

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

        if($lead_lock->is_lock && $lead_lock->last_modified_by->id != $this->user->id) {

          $this->Flash->error(__('This lead is being accessed by another user, please try again later.'));
          if($redir == 'dashboard') {
            return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
          } else {
            return $this->redirect(['action' => 'index']);
          }

        }elseif($lead_lock->is_lock == 0) {
          $data['is_lock']              = 1;
          $data['last_modified_by_id'] = $login_user_id;
          $lead_lock = $this->Leads->patchEntity($lead_lock, $data);
          if ( !$this->Leads->save($lead_lock) ) { 
            echo "error updating lock lead"; exit; 
          } else {
            $session  = $this->request->session();  
            $lck_leads[$login_user_id] = $id;
            $session->write('LeadsLock.data', $lck_leads);            
          }
        } 

        $lead = $this->Leads->get($id, [
            'contain' => ['LastModifiedBy']
        ]);        

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $lead = $this->Leads->patchEntity($lead, $this->request->data);
            if ($this->Leads->save($lead)) {
                
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
                $source = $this->Sources->get($data['source_id']);        
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
                      $modifiedLead = $this->Leads->get($id, [
                          'contain' => ['Statuses', 'Sources', 'LastModifiedBy','LeadTypes','InterestTypes']
                      ]); 

                      $source_name      = !empty($source->name) ? $source->name : "";
                      $surname          = $modifiedLead->surname != "" ? $modifiedLead->surname : "Not Specified";
                      $lead_client_name = $modifiedLead->firstname . " " . $surname;
                      $subject          = "Updated Lead - " . $source_name . " - " . $lead_client_name;              
                    
                      $email_customer = new Email('default'); //default or cake_smtp (for testing in local)
                      $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                        ->template('crm_modified_leads')
                        ->emailFormat('html')          
                        ->to($users_email)                                                                                               
                        ->subject($subject)
                        ->viewVars(['lead' => $modifiedLead->toArray()])
                        ->send();
                    }                    
                  }

                }     

                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){

                    $data['is_lock']              = 0;
                    $data['last_modified_by_id '] = $login_user_id;
                    $lead_lock = $this->Leads->patchEntity($lead_lock, $data);
                    if ( !$this->Leads->save($lead_lock) ) { echo "error updating lock lead"; exit; }

                    /*
                     * To do: add audit trail here
                     * Add IP Address on saving in audit trails
                    */
                    $audit_data['user_id']      = $this->user->id;
                    $audit_data['action']       = 'Update Lead';
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
                     * Audit trail end here
                    */

                    if($redir == 'dashboard') {
                      return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                    }elseif($redir == 'from_source'){
                      return $this->redirect(array('controller' => 'leads', 'action' => 'from_source', $source_id));
                    } else {
                      return $this->redirect(['action' => 'index']);
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

        $this->set('redir', $redir);
        $this->set('source_id', $source_id);
        $statuses = $this->Leads->Statuses->find('list', ['order' => ['Statuses.sort' => 'ASC']]);
        $sources = $this->Leads->Sources->find('list', ['order' => ['Sources.sort' => 'ASC']]);        
        $interestTypes = $this->Leads->InterestTypes->find('list', ['order' => ['InterestTypes.sort' => 'ASC']]);
        $leadTypes = $this->Leads->LeadTypes->find('list', ['order' => ['LeadTypes.sort' => 'ASC']]);
        $this->set(compact('lead', 'statuses', 'sources', 'interestTypes', 'leadTypes'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $source_id = null)
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

          $this->request->allowMethod(['post', 'delete']);
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
              $audit_data['ip_address']   = $this->getRealIPAddress();

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

        } else {

          $this->Flash->error(__('The lead could not be found. Please try again.'));

        }

        if( !empty($source_id) ) {
          return $this->redirect(['action' => 'from_source/'. $source_id]);
        } else {
          return $this->redirect(['action' => 'index']);      
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
                $email_customer = new Email('default'); //default or cake_smtp (for testing in local)
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
}
