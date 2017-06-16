<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Allocations Controller
 *
 * @property \App\Model\Table\AllocationsTable $Allocations
 */
class AllocationsController extends AppController
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
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('allocations', $this->paginate($this->Allocations));
        $this->set('_serialize', ['allocations']);
    }

    /**
     * View method
     *
     * @param string|null $id Allocation id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $allocation = $this->Allocations->get($id, [
            'contain' => []
        ]);
        $this->set('allocation', $allocation);
        $this->set('_serialize', ['allocation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $allocation = $this->Allocations->newEntity();
        if ($this->request->is('post')) {
            $allocation = $this->Allocations->patchEntity($allocation, $this->request->data);
            if ($this->Allocations->save($allocation)) {
                $this->Flash->success(__('The allocation has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The allocation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('allocation'));
        $this->set('_serialize', ['allocation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Allocation id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $allocation = $this->Allocations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $allocation = $this->Allocations->patchEntity($allocation, $this->request->data);
            if ($this->Allocations->save($allocation)) {
                $this->Flash->success(__('The allocation has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The allocation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('allocation'));
        $this->set('_serialize', ['allocation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Allocation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $allocation = $this->Allocations->get($id);
        if ($this->Allocations->delete($allocation)) {
            $this->Flash->success(__('The allocation has been deleted.'));
        } else {
            $this->Flash->error(__('The allocation could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
