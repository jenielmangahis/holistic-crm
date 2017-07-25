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
              $this->Auth->allow();
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
        
      }

      $allocations  = $this->AllocationUsers->find('all')
        ->where(['AllocationUsers.user_id' => $user_data->id])     
        ;      

      if( isset($this->request->query['query']) ){

          $allocationUsers = $this->AllocationUsers->find('all')            
            ->where(['AllocationUsers.user_id' => $user_data->id])            
          ;

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

      }else{

          /*$allocationUsers = $this->AllocationUsers->find('all')
            ->contain(['Allocations' => ['Leads' => ['LastModifiedBy', 'Statuses', 'Sources', 'Allocations']]])
            ->where(['AllocationUsers.user_id' => $user_data->id])            
          ;*/

          $allocationUsers = $this->AllocationUsers->find('all')            
            ->where(['AllocationUsers.user_id' => $user_data->id])            
          ;

          $query = $this->request->query['query'];
          $allocation_ids = array();
          foreach($allocationUsers as $au){
            $allocation_ids[] = $au->allocation_id;
          }          

          $leads = $this->Leads->find('all')
              ->contain(['LastModifiedBy', 'Statuses', 'Sources', 'Allocations'])
              ->where(['Leads.allocation_id IN' => $allocation_ids])
          ;
      }
      
      $this->set('leads', $this->paginate($leads));
      $this->set('_serialize', ['allocations']);
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
        if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          $this->request->data['allocation_date']               = date("Y-m-d", strtotime($this->request->data['allocation_date']));
          $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
          $this->request->data['followup_action_reminder_date'] = date("Y-m-d", strtotime($this->request->data['followup_action_reminder_date']));
        }

        $lead = $this->Leads->newEntity();
        if ($this->request->is('post')) {
            $lead = $this->Leads->patchEntity($lead, $this->request->data);
            if ($this->Leads->save($lead)) {
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
            $lead = $this->Leads->patchEntity($lead, $this->request->data);
            if ($this->Leads->save($lead)) {
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
}
