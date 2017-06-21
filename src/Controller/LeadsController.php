<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $this->Auth->allow();
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
        $sources = $this->Leads->Sources->find('list', ['limit' => 200]);
        $allocations = $this->Leads->Allocations->find('list', ['limit' => 200]);
        $this->set(compact('lead', 'statuses', 'sources', 'allocations'));
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
        $this->set(compact('lead', 'statuses', 'sources', 'allocations'));
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
}
