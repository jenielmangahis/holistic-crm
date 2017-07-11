<?php
namespace App\Controller;

use App\Controller\AppController;
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
                ->contain(['Statuses', 'Sources', 'Allocations'])
            ;
        }

        /*$this->paginate = [
            'contain' => ['Statuses', 'Sources', 'Allocations']
        ];*/
        
        $this->set('leads', $this->paginate($leads));
        $this->set('_serialize', ['leads']);
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
            'contain' => ['Statuses', 'Sources', 'Allocations']
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
        $statuses = $this->Leads->Statuses->find('list', ['limit' => 200]);
        $sources  = $this->Leads->Sources->find('list', ['limit' => 200]);
        $allocations = $this->Leads->Allocations->find('list', ['limit' => 200]);
        $interestTypes = $this->Leads->InterestTypes->find('list',['limit' => 200]);
        $this->set(compact('lead', 'statuses', 'sources', 'allocations', 'interestTypes'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(isset($this->request->data['allocation_date']) || isset($this->request->data['followup_date']) || isset($this->request->data['followup_action_reminder_date'])) {
          $this->request->data['allocation_date']               = date("Y-m-d", strtotime($this->request->data['allocation_date']));
          $this->request->data['followup_date']                 = date("Y-m-d", strtotime($this->request->data['followup_date']));
          $this->request->data['followup_action_reminder_date'] = date("Y-m-d", strtotime($this->request->data['followup_action_reminder_date']));
        }
              
        $lead = $this->Leads->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $lead = $this->Leads->patchEntity($lead, $this->request->data);
            if ($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
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
        $this->set(compact('lead', 'statuses', 'sources', 'allocations', 'interestTypes'));
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
}
