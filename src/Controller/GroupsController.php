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

        $session    = $this->request->session();    
        $user_data  = $session->read('User.data');         
        $this->user = $user_data;

        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{                           
                $authorized_modules = array();     
                $rights = $this->default_group_actions['groups'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'add', 'edit'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'add', 'edit', 'delete'];
                        break;        
                    default:            
                        break;
                }                
                $this->Auth->allow($authorized_modules);
            }
        }  

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
        
        $this->set('user_group', $this->user->group_id);
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
        $group     = $this->Groups->newEntity();
        $post_data = $this->request->data;

        if ($this->request->is('post')) {

            //Insert Group
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));
                $action = $this->request->data['save'];

                $group_id = $group->id;

                /*if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }*/

            } else {
                $this->Flash->error(__('The group could not be saved. Please, try again.'));
            }

            if($group_id > 0) {

                //Insert Group Permission
                $error              = 0;
                $this->GroupActions = TableRegistry::get('GroupActions');    
                $action             = $this->request->data['save'];

                foreach($post_data as $ga_key => $ga_data) {

                    if(strstr($ga_key, "permision_")) {

                        $group_action = $this->GroupActions->newEntity();
                        $group_action->group_id = $group_id;
                        $group_action->module   = str_replace("permision_","", $ga_key);
                        $group_action->action   = $ga_data;

                        if ($this->GroupActions->save($group_action)) {
                            $id = $group_action->id;
                        } else {
                            $error++;   
                        }

                    }

                }

                if($error <= 0) {

                    if( $action == 'save' ){
                        return $this->redirect(['action' => 'index']);
                    }else{
                        return $this->redirect(['action' => 'add']);
                    }                    

                } else {
                    $this->Flash->error(__('The group could not be saved. Please, try again.'));
                }

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
                "allocations" => "Client",
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
        $post_data = $this->request->data;

        if ($this->request->is(['patch', 'post', 'put'])) {

            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));
                $action = $this->request->data['save'];

                /*if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }*/ 

            } else {
                $this->Flash->error(__('The group could not be saved. Please, try again.'));
            }
    
            //Update Group Actions
            $group_id = $id;
            if( $group_id > 0 ) {

                //Insert Group Permission
                $error              = 0;
                $this->GroupActions = TableRegistry::get('GroupActions');    

                foreach($post_data as $ga_key => $ga_data) {

                    if(strstr($ga_key, "permision_")) {

                        $group_action = $this->GroupActions->find()
                            ->where(['GroupActions.group_id' => $group_id])
                            ->andWhere(['GroupActions.module' => str_replace("permision_","", $ga_key)])->first();                    

                        if( isset($group_action->id) ) {

                            $group_action_data['action'] = $ga_data;

                            $group_action = $this->Leads->patchEntity($group_action, $group_action_data);

                            if ($this->GroupActions->save($group_action)) {
                                $id = $group_action->id;
                            } else { $error++; }                        

                        } else {

                            $add_group_action = $this->GroupActions->newEntity();
                            $add_group_action->group_id = $group_id;
                            $add_group_action->module   = str_replace("permision_","", $ga_key);
                            $add_group_action->action   = $ga_data;

                            if ($this->GroupActions->save($add_group_action)) {
                                $id = $add_group_action->id;
                            } else {
                                $error++;   
                            }

                        }

                    }

                }

                if($error <= 0) {

                    if( $action == 'save' ){
                        return $this->redirect(['action' => 'index']);
                    }else{
                        return $this->redirect(['action' => 'edit', $group_id]);
                    }                    

                } else {

                    $this->Flash->error(__('The group could not be saved. Please, try again.'));

                }

            }     
        }   

        $this->GroupActions = TableRegistry::get('GroupActions');    
        $group_actions = $this->GroupActions->find()
            ->where(['GroupActions.group_id' => $id]);

        foreach($group_actions as $gakey => $gadata) {
            $group_action_defauly_array[$gadata->module] = $gadata->action;
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
                "allocations" => "Client",
                "sources" => "Sources",
                "groups" => "Groups",
                "status" => "Status",
                "lead_type" => "Lead Type",
                "interest_type" => "Interest Type"
            );

        $this->set(compact('group'));        
        $this->set('modules_array', $modules_array);
        $this->set('permision_array', $permision_array);        
        $this->set('group_action_defauly_array', $group_action_defauly_array);
        $this->set('_serialize', ['group','modules_array', 'permision_array', 'group_action_defauly_array']);
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
