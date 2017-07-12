<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LeadTypes Controller
 *
 * @property \App\Model\Table\LeadTypesTable $LeadTypes
 */
class LeadTypesController extends AppController
{
    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["system_settings"];
        $this->set('nav_selected', $nav_selected);

        // Allow full access to this controller
        //$this->Auth->allow();
    }     

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if( isset( $this->request->query['query'] ) ) {
            $query   = $this->request->query['query'];
            $LeadTypes = $this->LeadTypes->find('all')
                ->where( ['LeadTypes.name LIKE' => '%' . $query . '%'] );
        } else {
            $LeadTypes = $this->LeadTypes->find('all');
        } 

        $this->set('leadTypes', $this->paginate($LeadTypes));
        $this->set('_serialize', ['leadTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Lead Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leadType = $this->LeadTypes->get($id, [
            'contain' => []
        ]);
        $this->set('leadType', $leadType);
        $this->set('_serialize', ['leadType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leadType = $this->LeadTypes->newEntity();
        if ($this->request->is('post')) {
            $leadType = $this->LeadTypes->patchEntity($leadType, $this->request->data);
            if ($this->LeadTypes->save($leadType)) {
                $this->Flash->success(__('The lead type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The lead type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('leadType'));
        $this->set('_serialize', ['leadType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leadType = $this->LeadTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leadType = $this->LeadTypes->patchEntity($leadType, $this->request->data);
            if ($this->LeadTypes->save($leadType)) {
                $this->Flash->success(__('The lead type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The lead type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('leadType'));
        $this->set('_serialize', ['leadType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leadType = $this->LeadTypes->get($id);
        if ($this->LeadTypes->delete($leadType)) {
            $this->Flash->success(__('The lead type has been deleted.'));
        } else {
            $this->Flash->error(__('The lead type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
