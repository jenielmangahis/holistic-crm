<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class GroupsController extends AppController
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
     * ID : CA-02
     *
     * @return void
     */
    public function index()
    {
        $this->unlock_lead_check();
        if( isset($this->request->query['query']) ){
            $query  = $this->request->query['query'];
            $groups = $this->Groups->find('all')
                ->where(['Groups.name LIKE' => '%' . $query . '%'])                                
            ;
        }else{
            $groups = $this->Groups->find('all');
        }      
        
        $this->set('groups', $this->paginate($groups));
        $this->set('_serialize', ['groups']);
    }

    /**
     * View method
     * ID : CA-03
     *
     * @param string|null $id Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('group', $group);
        $this->set('_serialize', ['group']);
    }

    /**
     * Add method
     * ID : CA-04
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->GroupActions = TableRegistry::get('GroupActions');    

        $group = $this->Groups->newEntity();
        $group_action = $this->GroupActions->newEntity();

        if ($this->request->is('post')) {

            //Insert Group
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));
                $action = $this->request->data['save'];

                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }

            } else {
                $this->Flash->error(__('The group could not be saved. Please, try again.'));
            }

            //Insert Group Permission
            /*$post_data['group_id'] = 1;
            $post_data['module']   = 'test';
            $post_data['action']   = 'test123';

            $group_action = $this->GroupActions->patchEntity($group_action, $post_data);
            if ($this->GroupActions->save($group_action)) {

                $action = $this->request->data['save'];

            } else {
                $this->Flash->error(__('The group could not be saved. Please, try again.'));
            }*/
            
        }

        $permision_array = array(
                "View Only"             => "View Only",
                "View and Edit"         => "View and Edit",
                "View, Edit and Delete" => "View, Edit and Delete",
                "No Access"             => "No Access"
            );

        $modules_array = array(
                "dashboard" => "Dashboard",
                "leads" => "Leads",
                "training" => "Training",
                "users" => "Users",
                "allocations" => "Allocations",
                "sources" => "Sources",
                "groups" => "Groups",
                "status" => "Status",
                "lead_type" => "Lead Type",
                "interest_type" => "Interest Type"
            );

        $this->set(compact('group'));
        $this->set('modules_array', $modules_array);
        $this->set('permision_array', $permision_array);
        $this->set('_serialize', ['group','modules_array','modules_array']);
    }

    /**
     * Edit method
     * ID : CA-05
     *
     * @param string|null $id Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }  
            } else {
                $this->Flash->error(__('The group could not be saved. Please, try again.'));
            }
        }

        $permision_array = array(
                "View Only"             => "View Only",
                "View and Edit"         => "View and Edit",
                "View, Edit and Delete" => "View, Edit and Delete",
                "No Access"             => "No Access"
            );

        $modules_array = array(
                "dashboard" => "Dashboard",
                "leads" => "Leads",
                "training" => "Training",
                "users" => "Users",
                "allocations" => "Allocations",
                "sources" => "Sources",
                "groups" => "Groups",
                "status" => "Status",
                "lead_type" => "Lead Type",
                "interest_type" => "Interest Type"
            );

        $this->set(compact('group'));        
        $this->set('modules_array', $modules_array);
        $this->set('permision_array', $permision_array);        
        $this->set('_serialize', ['group','modules_array', 'permision_array']);
    }

    /**
     * Delete method
     * ID : CA-06
     *
     * @param string|null $id Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->Groups->get($id);
        if ($this->Groups->delete($group)) {
            $this->Flash->success(__('The group has been deleted.'));
        } else {
            $this->Flash->error(__('The group could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
