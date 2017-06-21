<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InterestTypes Controller
 *
 * @property \App\Model\Table\InterestTypesTable $InterestTypes
 */
class InterestTypesController extends AppController
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
        if( isset( $this->request->query['query'] ) ) {
            $query   = $this->request->query['query'];
            $InterestTypes = $this->InterestTypes->find('all')
                ->where( ['InterestTypes.name LIKE' => '%' . $query . '%'] );
        } else {
            $InterestTypes = $this->InterestTypes->find('all');
        }

        $this->set('interestTypes', $this->paginate($InterestTypes));
        $this->set('_serialize', ['interestTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Interest Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $interestType = $this->InterestTypes->get($id, [
            'contain' => ['Leads']
        ]);
        $this->set('interestType', $interestType);
        $this->set('_serialize', ['interestType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $interestType = $this->InterestTypes->newEntity();
        if ($this->request->is('post')) {
            $interestType = $this->InterestTypes->patchEntity($interestType, $this->request->data);
            if ($this->InterestTypes->save($interestType)) {
                $this->Flash->success(__('The interest type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The interest type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('interestType'));
        $this->set('_serialize', ['interestType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Interest Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $interestType = $this->InterestTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $interestType = $this->InterestTypes->patchEntity($interestType, $this->request->data);
            if ($this->InterestTypes->save($interestType)) {
                $this->Flash->success(__('The interest type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The interest type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('interestType'));
        $this->set('_serialize', ['interestType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Interest Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $interestType = $this->InterestTypes->get($id);
        if ($this->InterestTypes->delete($interestType)) {
            $this->Flash->success(__('The interest type has been deleted.'));
        } else {
            $this->Flash->error(__('The interest type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
