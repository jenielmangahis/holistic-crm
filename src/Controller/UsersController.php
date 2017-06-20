<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public $helpers = ['NavigationSelector'];

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

        $this->Auth->allow(['request_forgot_password']);
    }

    /**
     * beforeFilter method
     *  ID : CA-02
     * 
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout', 'login']);
    }

    /**
     * Index method
     * ID : CA-03
     * @return void
     */
    public function index()
    {
        if( isset($this->request->query['query']) ){
            $query = $this->request->query['query'];
            $users = $this->Users->find('all')
                ->contain(['Groups'])
                ->where(['Users.firstname LIKE' => '%' . $query . '%'])       
                ->orWhere(['Users.lastname LIKE' => '%' . $query . '%'])       
                ->orWhere(['Users.email LIKE' => '%' . $query . '%'])       
                ->orWhere(['Groups.name LIKE' => '%' . $query . '%'])       
            ;
        }else{
            $users = $this->Users->find('all')
                ->contain(['Groups'])
            ;
        }

        $this->set('users', $this->paginate($users));
        $this->set('_serialize', ['users']);
    }

    /**
     * Dashboard method
     * ID : CA-04
     * @return void
     */
    public function dashboard()
    {   
        $this->set([        
            'page_title' => 'Dashboard'
        ]);
    }   

    /**
     * View method
     * ID : CA-05
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ["Groups"]
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     * ID : CA-06
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {      
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     * ID : CA-07
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $result = $this->Users->save($user);
            if ($result) {
                $this->Flash->success(__('User data has been updated.'));
                if(isset($this->request->data['edit'])) {
                    return $this->redirect(['action' => 'edit', $id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('User data could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);

         $this->set('groups', $this->Users->Groups->find('list', array('fields' => array('name','id') ) ) );
    }

    /**
     * delete method
     * ID : CA-08
     * @return void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        /*if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }*/
        $this->Flash->error(__('Deleting of user is currently disabled.'));
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login
     * ID : CA-09
     * lagin module then redirect to dashboard
     */
    public function login()
    {
        // Change layout
        $this->viewBuilder()->layout("Users/login");    
        
        //if already logged-in, redirect
        if($this->Auth->user()){
            $this->redirect(array('action' => 'index'));      
        }

        if ($this->request->is('post')) {           
            $user = $this->Auth->identify();            
            if ($user) {                       
                $this->Auth->setUser($user);
                
                $u = $this->Users->find()
                    ->where(['Users.id' => $this->Auth->user('id')])
                    ->first()
                ;              
                $session  = $this->request->session();  
                $session->write('User.data', $u);                                               
                $_SESSION['KCEDITOR']['disabled'] = false;
                $_SESSION['KCEDITOR']['uploadURL'] = Router::url('/')."webroot/upload";
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        $this->set('page_title', 'User Login');
    }

    /**
     * logout
     * ID : CA-10
     * logout user and go back to login page
     */
    public function logout()
    {
        session_start();
        session_destroy();
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Ajax Forgot Password
     * ID : CA-11
     * @return json data
     */
    public function request_forgot_password()
    {
        $this->Users = TableRegistry::get('Users');
        $this->viewBuilder()->layout('');        
        
        if ($this->request->is(['patch', 'post', 'put'])) {                
            $data = $this->request->data;        
            $user = $this->Users->find()
                ->where(['Users.email' => $data['email_username']])
                ->first()
            ;

            if($user) {
                $randChar   = rand() . $user->id;                
                $reset_code = md5(uniqid($randChar, true));  

                //Save verification code
                $user->reset_code = $reset_code;
                $this->Users->save($user);

                //Send email notification to customer                
                $edata = [
                    'user_name' => $user->firstname,
                    'reset_code' => $reset_code
                ];

                $recipient = $user->email;                     
                $email_smtp = new Email('cake_smtp');
                $email_smtp->from(['websystem@nixstage.com' => 'WebSystem'])
                    ->template('request_forgot_password')
                    ->emailFormat('html')
                    ->to($recipient)                                                                                                     
                    ->subject('Nixser : Forgot Password')
                    ->viewVars(['edata' => $edata])
                    ->send();

                $json['message'] = "An email has been sent to your e-mail address for confirmation.";
                $json['is_success'] = true;          
            }else{
                $json['message'] = "Invalid form entry";
                $json['is_success'] = false;    
            }
        }else{
            $json['message'] = "Invalid form entry";
            $json['is_success'] = false;
        }
        
        echo json_encode($json);
        exit;
    }
}
