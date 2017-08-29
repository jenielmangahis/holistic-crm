<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * AllocationUsers Controller
 *
 * @property \App\Model\Table\AllocationUsersTable $AllocationUsers
 */
class AllocationUsersController extends AppController
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
        $p = $this->default_group_actions;

        if($p && $p['users'] != 'No Access' ){
            $this->Auth->allow();
        }        

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');         

        /*if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }
        }*/
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->unlock_lead_check();
        $this->paginate = [
            'contain' => ['Allocations', 'Users'],
        ];
        $this->set('allocationUsers', $this->paginate($this->AllocationUsers));
        $this->set('_serialize', ['allocationUsers']);
    }

    /**
     * Index method
     *
     * @param string|null $id Allocation id.
     * @return void
     */
    public function user_list( $id = null )
    {
        $allocation = $this->AllocationUsers->Allocations->get($id);
        $this->paginate = [
            'contain' => ['Allocations', 'Users'],
            'conditions' => ['AllocationUsers.allocation_id' => $id]
        ];
        $this->set('allocation', $allocation);
        $this->set('allocationUsers', $this->paginate($this->AllocationUsers));
        $this->set('_serialize', ['allocationUsers']);
    }

    /**
     * View method
     *
     * @param string|null $id Allocation User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $allocationUser = $this->AllocationUsers->get($id, [
            'contain' => ['Allocations', 'Users']
        ]);
        $this->set('allocationUser', $allocationUser);
        $this->set('_serialize', ['allocationUser']);
    }

    /**
     * Add method
     *     
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {      
        $allocationUser = $this->AllocationUsers->newEntity();
        if ($this->request->is('post')) {
            $allocationUser = $this->AllocationUsers->patchEntity($allocationUser, $this->request->data);
            if ($this->AllocationUsers->save($allocationUser)) {
                $this->Flash->success(__('The allocation user has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The allocation user could not be saved. Please, try again.'));
            }
        }
        $allocations = $this->AllocationUsers->Allocations->find('list', ['limit' => 200]);
        $users = $this->AllocationUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('allocationUser', 'allocations', 'users'));
        $this->set('_serialize', ['allocationUser']);
    }

    /**
     * Add method
     *
     * @param string|null $id Allocation id.
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_user( $id = null )
    {
        $allocation     = $this->AllocationUsers->Allocations->get($id);
        $user           = $this->AllocationUsers->Users->newEntity();
        $allocationUser = $this->AllocationUsers->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['group_id'] = 2;
            $user = $this->AllocationUsers->Users->patchEntity($user, $this->request->data);
            if ( $new_user = $this->AllocationUsers->Users->save($user)) {
                $allocation_user_data = [
                    'allocation_id' => $allocation->id,
                    'user_id' => $new_user->id
                ];
                $allocationUser = $this->AllocationUsers->patchEntity($allocationUser, $allocation_user_data);
                if ($this->AllocationUsers->save($allocationUser)) {
                    $this->Flash->success(__('The allocation user has been saved.'));
                    $action = $this->request->data['save'];
                    if( $action == 'save' ){
                        return $this->redirect(['action' => 'user_list', $allocation->id]);
                    }else{
                        return $this->redirect(['action' => 'add_user', $allocation->id]);
                    }                    
                } else {
                    $this->Flash->error(__('The allocation user could not be saved. Please, try again.'));
                }
            }            
        }
        $this->set(compact('allocationUser', 'allocation', 'user'));
        $this->set('_serialize', ['allocationUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Allocation User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $allocationUser = $this->AllocationUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $allocationUser = $this->AllocationUsers->patchEntity($allocationUser, $this->request->data);
            if ($this->AllocationUsers->save($allocationUser)) {
                $this->Flash->success(__('The allocation user has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The allocation user could not be saved. Please, try again.'));
            }
        }
        $allocations = $this->AllocationUsers->Allocations->find('list', ['limit' => 200]);
        $users = $this->AllocationUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('allocationUser', 'allocations', 'users'));
        $this->set('_serialize', ['allocationUser']);
    }

    /**
     * Edit User method
     * ID : CA-07
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_user($id = null)
    {        
        $allocationUsers = $this->AllocationUsers->get($id);
        $allocation = $this->AllocationUsers->Allocations->get($allocationUsers->allocation_id);
        $user       = $this->AllocationUsers->Users->get($allocationUsers->user_id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $result = $this->Users->save($user);
            if ($result) {
                $this->Flash->success(__('User data has been updated.'));
                if(isset($this->request->data['edit'])) {
                    return $this->redirect(['action' => 'edit_user', $allocation->id]);
                }else{
                    return $this->redirect(['action' => 'user_list', $allocation->id]);
                }
            } else {
                $this->Flash->error(__('User data could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user', 'allocation'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Allocation User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $allocationUser = $this->AllocationUsers->get($id);
        $allocation_id  = $allocationUser->allocation_id;
        if ($this->AllocationUsers->delete($allocationUser)) {
            $this->Flash->success(__('The allocation user has been deleted.'));
        } else {
            $this->Flash->error(__('The allocation user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'user_list', $allocation_id]);
    }

    /**
     * Assign User method
     *
     * @param string|null $id Allocation id.
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function assign_user( $id = null )
    {
        $allocation     = $this->AllocationUsers->Allocations->get($id);        
        $allocationUser = $this->AllocationUsers->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $total_added = 0;
            
            foreach( $data['allocation_users'] as $key => $value ){
                $data_allocation_users = [
                    'allocation_id' => $allocation->id,
                    'user_id' => $key
                ];

                $allocationUser = $this->AllocationUsers->newEntity();
                $allocationUser = $this->AllocationUsers->patchEntity($allocationUser, $data_allocation_users);
                if ($this->AllocationUsers->save($allocationUser)) {
                    $total_added++;
                }
            }
            $this->Flash->success($total_added . ' Users was successfully assigned to this allocation.');       
            return $this->redirect(['action' => 'user_list', $allocation->id]);
        }

        $a_allocation_users = array();
        $allocation_user = $this->AllocationUsers->find('all')
            ->select(['AllocationUsers.user_id'])
            ->where(['AllocationUsers.allocation_id' => $id])            
        ;
        foreach( $allocation_user as $au ){
            $a_allocation_users[$au->user_id] = $au->user_id;
        }

        if( !empty($a_allocation_users) ){
            $users = $this->AllocationUsers->Users->find('all')
                //->where(['Users.group_id' => 2, 'Users.id NOT IN' => $a_allocation_users])
                ->where(['Users.id NOT IN' => $a_allocation_users])
                ->toArray()
            ;    
        }else{
            $users = $this->AllocationUsers->Users->find('all')
                //->where(['Users.group_id' => 2])
                ->toArray()
            ;    
        }
        
        $this->set(compact('allocationUser', 'allocation', 'users'));
        $this->set('_serialize', ['allocationUser']);
    }

    public function change_password( $id = null, $allocation_id = null )
    {      
        $this->Users = TableRegistry::get('Users');

        $user = $this->Users->get($id);  

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            if( $data['password'] == $data['repassword'] ){

                $user->password = $data['password'];                
                
                if( $this->Users->save($user) ){

                    //Send email
                    /*$edata = [
                        'user_name' => $user->firstname,
                        'password' => $data['password']                        
                    ];
                    $recipient = $user->email;                     
                    $email_smtp = new Email('cake_smtp');
                    $email_smtp->from(['websystem@holistic.com' => 'WebSystem'])
                        ->template('change_password')
                        ->emailFormat('html')
                        ->to($recipient)                                                                                                     
                        ->subject('Holistic : Change Password')
                        ->viewVars(['edata' => $edata])
                        ->send();*/

                    $this->Flash->success(__('Your password has been changed.'));
                    return $this->redirect(['controller' => 'allocation_users', 'action' => 'user_list', $allocation_id]);
                }else{
                    $this->Flash->error(__('Your password could not be change. Please, try again.'));                    
                }
            }else{
                $this->Flash->error(__('Password does not match!'));                    
            }
        }

        $this->set(['user' => $user]);
    }     
}
