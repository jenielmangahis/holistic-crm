<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FormLocations Controller
 *
 * @property \App\Model\Table\FormLocationsTable $FormLocations
 */
class FormLocationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('formLocations', $this->paginate($this->FormLocations));
        $this->set('_serialize', ['formLocations']);
    }

    /**
     * View method
     *
     * @param string|null $id Form Location id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $formLocation = $this->FormLocations->get($id, [
            'contain' => []
        ]);
        $this->set('formLocation', $formLocation);
        $this->set('_serialize', ['formLocation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $formLocation = $this->FormLocations->newEntity();
        if ($this->request->is('post')) {
            $formLocation = $this->FormLocations->patchEntity($formLocation, $this->request->data);
            if ($this->FormLocations->save($formLocation)) {
                $this->Flash->success(__('The form location has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The form location could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formLocation'));
        $this->set('_serialize', ['formLocation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Form Location id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $formLocation = $this->FormLocations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formLocation = $this->FormLocations->patchEntity($formLocation, $this->request->data);
            if ($this->FormLocations->save($formLocation)) {
                $this->Flash->success(__('The form location has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The form location could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('formLocation'));
        $this->set('_serialize', ['formLocation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Form Location id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formLocation = $this->FormLocations->get($id);
        if ($this->FormLocations->delete($formLocation)) {
            $this->Flash->success(__('The form location has been deleted.'));
        } else {
            $this->Flash->error(__('The form location could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
