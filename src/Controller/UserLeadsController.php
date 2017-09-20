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
class UserLeadsController extends AppController
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
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'edit', 'add', 'leads_unlock'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'edit', 'delete', 'add', 'leads_unlock'];
                        break;        
                    default:
                        break;
                }                
                $this->Auth->allow($authorized_modules);
            }
        }        

        $this->user = $user_data;
        // Allow full access to this controller
        $this->Auth->allow(['register']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
      $this->paginate = ['order' => ['Leads.allocation_date' => 'DESC']];

      $this->Leads = TableRegistry::get('Leads');
      $this->AllocationUsers = TableRegistry::get('AllocationUsers');

      $session   = $this->request->session();    
      $user_data = $session->read('User.data');         

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

      /*
      $allocations  = $this->AllocationUsers->find('all')
        ->where(['AllocationUsers.user_id' => $user_data->id])     
        ; 
      */   

      if( isset($this->request->query['query']) ){

          $allocationUsers = $this->AllocationUsers->find('all')            
            ->where(['AllocationUsers.user_id' => $user_data->id])            
          ;

          if( $allocationUsers->count() > 0 ) {

            $query = $this->request->query['query'];
            $allocation_ids = array();
            foreach($allocationUsers as $au){
              $allocation_ids[] = $au->allocation_id;
            }
            
            $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'Allocations', 'LastModifiedBy'])
              ->where(['Leads.allocation_id IN' => $allocation_ids])
              ->andwhere([
                            'Leads.firstname LIKE' => '%' . $query . '%',
                            'OR' => [['Leads.surname LIKE' => '%' . $query . '%']],
                            'OR' => [['Leads.email LIKE' => '%' . $query . '%']],
                        ]) 
            ; 
            $this->set('leads', $this->paginate($leads));

          } else {
            $leads = null;
            $this->set('leads', $leads);
          }

      }else{

          /*$allocationUsers = $this->AllocationUsers->find('all')
            ->contain(['Allocations' => ['Leads' => ['LastModifiedBy', 'Statuses', 'Sources', 'Allocations']]])
            ->where(['AllocationUsers.user_id' => $user_data->id])            
          ;*/

          $allocationUsers = $this->AllocationUsers->find('all')            
            ->where(['AllocationUsers.user_id' => $user_data->id])            
          ;       

          if( $allocationUsers->count() > 0 ) {

            $query = $this->request->query['query'];
            $allocation_ids = array();
            foreach($allocationUsers as $au){
              $allocation_ids[] = $au->allocation_id;
            }          

            $leads = $this->Leads->find('all')
                ->contain(['LastModifiedBy', 'Statuses', 'Sources', 'Allocations'])
                ->where(['Leads.allocation_id IN' => $allocation_ids])
            ;
            $this->set('leads', $this->paginate($leads));

          } else {
            $leads = null;
            $this->set('leads', $leads);
          }

      }
      
      $this->set('_serialize', ['']);
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
        $lead = $this->Leads->get($id, [
            'contain' => ['Statuses', 'Sources', 'Allocations', 'LeadTypes', 'InterestTypes', 'LastModifiedBy']
        ]);

        $this->set('lead', $lead);
        $this->set('_serialize', ['lead']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->AllocationUsers = TableRegistry::get('AllocationUsers');

        $p = $this->default_group_actions;
        if( $p && $p['leads'] == 'View Only' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        }      

        if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          $this->request->data['allocation_date']               = date("Y-m-d", strtotime($this->request->data['allocation_date']));
          $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
          $this->request->data['followup_action_reminder_date'] = date("Y-m-d", strtotime($this->request->data['followup_action_reminder_date']));
        }

        $lead = $this->Leads->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $lead = $this->Leads->patchEntity($lead, $data);
            if ($this->Leads->save($lead)) {

                //Send Email notification
                $allocation_users = $this->AllocationUsers->find('all')
                    ->contain(['Users'])
                    ->where(['AllocationUsers.allocation_id' => $data['allocation_id']])
                ;

                $users_email = array();
                foreach($allocation_users as $users){            
                    $users_email[$users->user->email] = $users->user->email;            
                }

                if( !empty($users_email) ){

                  //Send email notification                  
                  $new_lead = [
                      'name' => $data['firstname'] . ' ' . $data['surname'],
                      'email' => $data['email'],
                      'phone' => $data['phone'],
                      'lead_action' => $data['lead_action'],
                      'city_state' => $data['city'] . ' / ' . $data['state']        
                  ];

                  $email_customer = new Email('default');
                  $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                    ->template('crm_new_leads')
                    ->emailFormat('html')          
                    ->bcc($users_email)                                                                                               
                    ->subject('New Lead')
                    ->viewVars(['new_lead' => $new_lead])
                    ->send();
                }

                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }
        }
        $statuses = $this->Leads->Statuses->find('list');
        $sources  = $this->Leads->Sources->find('list');
        $allocations = $this->Leads->Allocations->find('list', ['order' => ['Allocations.sort' => 'ASC']]);
        $interestTypes = $this->Leads->InterestTypes->find('list');
        $leadTypes = $this->Leads->LeadTypes->find('list');
        $this->set(compact('lead', 'statuses', 'sources', 'allocations', 'interestTypes', 'leadTypes'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $redir = null)
    {
        $this->AllocationUsers = TableRegistry::get('AllocationUsers');

        $p = $this->default_group_actions;

        /*if( $p && $p['leads'] != 'View and Edit' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        } */

        $login_user_id = $this->user->id;
        if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          $this->request->data['allocation_date']               = date("Y-m-d", strtotime($this->request->data['allocation_date']));
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
          if ( !$this->Leads->save($lead_lock) ) { echo "error updating lock lead"; exit; }
        } 

        $lead = $this->Leads->get($id, [
            'contain' => ['LastModifiedBy']
        ]);        

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $lead = $this->Leads->patchEntity($lead, $data);
            if ($this->Leads->save($lead)) {

                //Send Email notification
                $allocation_users = $this->AllocationUsers->find('all')
                    ->contain(['Users'])
                    ->where(['AllocationUsers.allocation_id' => $data['allocation_id']])
                ;

                $users_email = array();
                foreach($allocation_users as $users){            
                    $users_email[$users->user->email] = $users->user->email;            
                }

                if( !empty($users_email) ){                                                      
                  $modifiedLead = $this->Leads->get($id, [
                      'contain' => ['Statuses', 'Sources', 'Allocations', 'LastModifiedBy','LeadTypes','InterestTypes']
                  ]); 
                
                  $email_customer = new Email('default');
                  $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                    ->template('crm_modified_leads')
                    ->emailFormat('html')          
                    ->bcc($users_email)                                                                                               
                    ->subject('Updated Lead')
                    ->viewVars(['lead' => $modifiedLead->toArray()])
                    ->send();
                }  

                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){

                    $data['is_lock']              = 0;
                    $data['last_modified_by_id '] = $login_user_id;
                    $lead_lock = $this->Leads->patchEntity($lead_lock, $data);
                    if ( !$this->Leads->save($lead_lock) ) { echo "error updating lock lead"; exit; }

                    if($redir == 'dashboard') {
                      return $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                    } else {
                      return $this->redirect(['action' => 'index']);
                    }
                    
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }
        }
        $statuses = $this->Leads->Statuses->find('list', ['limit' => 200]);
        $sources = $this->Leads->Sources->find('list', ['limit' => 200]);
        $allocations = $this->Leads->Allocations->find('list', ['limit' => 200]);
        $interestTypes = $this->Leads->InterestTypes->find('list',['limit' => 200]);
        $leadTypes = $this->Leads->LeadTypes->find('list',['limit' => 200]);
        $this->set(compact('lead', 'statuses', 'sources', 'allocations', 'interestTypes', 'leadTypes'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $p = $this->default_group_actions;
        if( $p && $p['leads'] != 'View, Edit and Delete' ){
            return $this->redirect(['controller' => 'users', 'action' => 'no_access']);
        } 
              
        $login_user_id = $this->user->id;
        $lead_lock = $this->Leads->get($id, [ 'contain' => ['LastModifiedBy'] ]);         

        if($lead_lock->is_lock && $lead_lock->last_modified_by->id != $this->user->id) {
          $this->Flash->error(__('This lead is being accessed by another user, please try again later.'));
          return $this->redirect(['action' => 'index']);
        }       

        $this->request->allowMethod(['post', 'delete']);
        $lead = $this->Leads->get($id);
        if ($this->Leads->delete($lead)) {
            $this->Flash->success(__('The lead has been deleted.'));
        } else {
            $this->Flash->error(__('The lead could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
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
                $email_customer = new Email('cake_smtp');
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
                        session_start();
                        unset($ulock_leads[$login_user_id]);
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

                if($last_modified_user_id == $u->id) {

                    $lead_unlock = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);      
                    $data['is_lock']              = 0;
                    $data['last_modified_by_id '] = $login_user_id;
                    $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data);
                    if ( !$this->Leads->save($lead_unlock) ) { echo "error updating lock lead"; exit; }                

                }

            } 
        }
      
    }     
}
