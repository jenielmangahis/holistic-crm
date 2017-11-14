<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * SourceUsers Controller
 *
 * @property \App\Model\Table\SourceUsersTable $SourceUsers
 */
class SourceUsersController extends AppController
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
        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{           
                $authorized_modules = array();     
                $rights = $this->default_group_actions['sources'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'edit', 'add', 'add_user', 'edit_user', 'assign_user', 'change_password'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'edit', 'add', 'delete', 'add_user', 'edit_user', 'assign_user', 'change_password'];
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
     *
     * @return void
     */
    public function index()
    {
        $this->unlock_lead_check();
        $this->paginate = [
            'contain' => ['Sources', 'Users'],
        ];
        $this->set('sourceUsers', $this->paginate($this->SourceUsers));
        $this->set('_serialize', ['sourceUsers']);
    }

    /**
     * Index method
     *
     * @param string|null $id Allocation id.
     * @return void
     */
    public function user_list( $id = null )
    {
        $source = $this->SourceUsers->Sources->get($id);
        
        $this->paginate = [                        
            'sortWhiteList' => ['Users.firstname']           
        ];

        $sourceUsers = $this->SourceUsers->find('all')
            ->contain(['Sources', 'Users']) 
            ->where(['SourceUsers.source_id' => $id])
            ->order(['Users.firstname' => 'ASC'])           
        ;

        $this->set('source', $source);
        $this->set('sourceUsers', $this->paginate($sourceUsers));
        $this->set('_serialize', ['sourceUsers']);
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
        $sourceUser = $this->SourceUsers->get($id, [
            'contain' => ['Sources', 'Users']
        ]);
        $this->set('sourceUser', $sourceUser);
        $this->set('_serialize', ['sourceUser']);
    }

    /**
     * Add method
     *     
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {      
        $sourceUser = $this->SourceUsers->newEntity();
        if ($this->request->is('post')) {
            $sourceUser = $this->SourceUsers->patchEntity($sourceUser, $this->request->data);
            if ($this->SourceUsers->save($sourceUser)) {
                $this->Flash->success(__('The source user has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The sourceUser user could not be saved. Please, try again.'));
            }
        }
        $sources = $this->SourceUsers->Sources->find('list', ['limit' => 200]);
        $users = $this->SourceUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('sourceUser', 'sources', 'users'));
        $this->set('_serialize', ['sourceUser']);
    }

    /**
     * Add method
     *
     * @param string|null $id Allocation id.
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_user( $id = null )
    {
        $source     = $this->SourceUsers->Sources->get($id);
        $user       = $this->SourceUsers->Users->newEntity();
        $sourceUser = $this->SourceUsers->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['group_id'] = 2;
            $data = $this->request->data;      
            $data['other_email'] = str_replace(",", ";", $this->request->data['other_email']);             
            $user = $this->SourceUsers->Users->patchEntity($user, $data);
            if ( $new_user = $this->SourceUsers->Users->save($user)) {
                $source_user_data = [
                    'source_id' => $source->id,
                    'user_id' => $new_user->id
                ];
                $sourceUser = $this->SourceUsers->patchEntity($sourceUser, $source_user_data);
                if ($this->SourceUsers->save($sourceUser)) {
                    $this->Flash->success(__('The source user has been saved.'));
                    $action = $this->request->data['save'];
                    if( $action == 'save' ){
                        return $this->redirect(['action' => 'user_list', $source->id]);
                    }else{
                        return $this->redirect(['action' => 'add_user', $source->id]);
                    }                    
                } else {
                    $this->Flash->error(__('The source user could not be saved. Please, try again.'));
                }
            }            
        }

        $this->set('enable_tags_input', true);
        $this->set(compact('sourceUser', 'source', 'user'));
        $this->set('_serialize', ['sourceUser']);
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
        $sourceUser = $this->SourceUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sourceUser = $this->SourceUsers->patchEntity($sourceUser, $this->request->data);
            if ($this->SourceUsers->save($sourceUser)) {
                $this->Flash->success(__('The source user has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The source user could not be saved. Please, try again.'));
            }
        }
        $sources = $this->SourceUsers->Sources->find('list', ['limit' => 200]);
        $users   = $this->SourceUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('sourceUser', 'sources', 'users'));
        $this->set('_serialize', ['sourceUser']);
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
        $sourceUsers = $this->SourceUsers->get($id);
        $source  = $this->SourceUsers->Sources->get($sourceUsers->source_id);
        
        /*$user       = $this->SourceUsers->Users->get($sourceUsers->user_id, [
            'contain' => []
        ]);*/

        $this->Users = TableRegistry::get('Users');     
        $user = $this->Users->get($sourceUsers->user_id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;      
            $data['other_email'] = str_replace(",", ";", $this->request->data['other_email']);             
            $user = $this->Users->patchEntity($user, $data);
            $result = $this->Users->save($user);
            if ($result) {
                $this->Flash->success(__('User data has been updated.'));
                if(isset($this->request->data['edit'])) {
                    return $this->redirect(['action' => 'edit_user', $source->id]);
                }else{
                    return $this->redirect(['action' => 'user_list', $source->id]);
                }
            } else {
                $this->Flash->error(__('User data could not be saved. Please, try again.'));
            }
        }

        $this->set('enable_tags_input', true);
        $this->set(compact('user', 'source'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Allocation User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $source_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $source_user = $this->SourceUsers->exists(['id' => $id]);
        if($source_user) {
            
            $sourceUser = $this->SourceUsers->get($id);
            $source_id  = $sourceUser->source_id;
            if ($this->SourceUsers->delete($sourceUser)) {
                $this->Flash->success(__('The source user has been deleted.'));
            } else {
                $this->Flash->error(__('The source user could not be deleted. Please, try again.'));
            }

        } else {
            $this->Flash->error(__('Assigned user not be found. Please try again.'));
        }

        return $this->redirect(['action' => 'user_list', $source_id]);
    }

    /**
     * Assign User method
     *
     * @param string|null $id Allocation id.
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function assign_user( $id = null )
    {
        $source     = $this->SourceUsers->Sources->get($id);        
        $sourceUser = $this->SourceUsers->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $total_added = 0;
            
            foreach( $data['source_users'] as $key => $value ){
                $data_source_users = [
                    'source_id' => $source->id,
                    'user_id' => $key
                ];

                $sourceUser = $this->SourceUsers->newEntity();
                $sourceUser = $this->SourceUsers->patchEntity($sourceUser, $data_source_users);
                if ($this->SourceUsers->save($sourceUser)) {
                    $total_added++;
                }
            }
            $this->Flash->success($total_added . ' Users was successfully assigned to this source.');       
            return $this->redirect(['action' => 'user_list', $source->id]);
        }

        $a_source_users = array();
        $source_user = $this->SourceUsers->find('all')
            ->select(['SourceUsers.user_id'])
            ->where(['SourceUsers.source_id' => $id])            
        ;
        foreach( $source_user as $au ){
            $a_source_users[$au->user_id] = $au->user_id;
        }

        if( !empty($a_source_users) ){
            $users = $this->SourceUsers->Users->find('all')
                //->where(['Users.group_id' => 2, 'Users.id NOT IN' => $a_source_users])
                ->where(['Users.id NOT IN' => $a_source_users])
                ->order(['Users.firstname' => 'ASC'])
                ->toArray()
            ;    
        }else{
            $users = $this->SourceUsers->Users->find('all')
                //->where(['Users.group_id' => 2])
                ->order(['Users.firstname' => 'ASC'])
                ->toArray()
            ;    
        }
        
        $this->set(compact('sourceUser', 'source', 'users'));
        $this->set('_serialize', ['sourceUser']);
    }

    public function change_password( $id = null, $source_id = null )
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
                    return $this->redirect(['controller' => 'source_users', 'action' => 'user_list', $source_id]);
                }else{
                    $this->Flash->error(__('Your password could not be change. Please, try again.'));                    
                }
            }else{
                $this->Flash->error(__('Password does not match!'));                    
            }
        }

        $this->set(['user' => $user, 'source_id' => $source_id]);
    }     
}
