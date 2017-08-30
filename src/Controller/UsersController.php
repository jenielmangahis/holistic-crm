<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;
use Cake\Mailer\Email;
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

        $session = $this->request->session();    
        $user_data = $session->read('User.data');         

        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{                          
                $authorized_modules = array();     
                $rights = $this->default_group_actions['users'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view', 'dashboard', 'user_dashboard'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'edit', 'add', 'change_password', 'request_forgot_password', 'dashboard', 'user_dashboard'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'edit', 'delete', 'add', 'change_password', 'request_forgot_password', 'dashboard', 'user_dashboard'];
                        break;        
                    default:        
                        $this->Auth->allow(['user_dashboard','login','logout']);    
                        break;
                }                
                $this->Auth->allow($authorized_modules);
            }
        } 

        $this->user = $user_data;
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
        $this->unlock_lead_check();
        if( isset($this->request->query['query']) ){
            $query = $this->request->query['query'];
            $users = $this->Users->find('all')
                ->contain(['Groups','AllocationUsers' => ['Allocations']])
                ->where(['Users.firstname LIKE' => '%' . $query . '%'])       
                ->orWhere(['Users.lastname LIKE' => '%' . $query . '%'])       
                ->orWhere(['Users.email LIKE' => '%' . $query . '%'])       
                ->orWhere(['Groups.name LIKE' => '%' . $query . '%'])       
            ;
        }else{
            $users = $this->Users->find('all')
                ->contain(['Groups','AllocationUsers' => ['Allocations']])
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
        $session   = $this->request->session();    
        $user_data = $session->read('User.data');         

        $p = $this->default_group_actions;
        if($p && $p['dashboard'] == 'No Access' ){
            return $this->redirect(['action' => 'no_access']);
        } 
                  
        $this->unlock_lead_check();
        $this->Leads    = TableRegistry::get('Leads');        
        $this->Sources  = TableRegistry::get('Sources');        
        $this->Statuses = TableRegistry::get('Statuses');        
        $leads      = $this->Leads->find('all');
        $users      = $this->Users->find('all');
        $sources    = $this->Sources->find('all');   
        $statuses   = $this->Statuses->find('all');   

        $total_leads = $leads->count();
        $total_users = $users->count();        
        $total_leads_followup = $this->Leads->find('all')
            ->where(['Leads.followup_date' => date("Y-m-d")])
            ->count()
        ;

        $new_leads = $this->Leads->find('all')        
            ->contain(['LastModifiedBy'])        
            ->where(['DATE_FORMAT(Leads.created,"%Y-%m-%d")' => date("Y-m-d")])
            ->order(['Leads.id' => 'DESC'])            
        ;

        $followup_leads_today = $this->Leads->find('all')
            ->contain(['LastModifiedBy'])
            ->where(['DATE_FORMAT(Leads.followup_date,"%Y-%m-%d")' => date("Y-m-d")])
            ->order(['Leads.id' => 'DESC'])
        ;

        $nav_selected = ["dashboard"];

        $this->set('nav_selected', $nav_selected);        
        $this->set('page_title','Dashboard');
        $this->set('total_users', $total_users);
        $this->set('total_leads', $total_leads);
        $this->set('total_leads_followup', $total_leads_followup);
        $this->set('new_leads', $new_leads);
        $this->set('sources', $sources);
        $this->set('statuses', $statuses);
        $this->set('lead_registry', $this->Leads);
        $this->set('followup_leads_today', $followup_leads_today);
        $this->set('_serialize', ['total_users','total_leads']);

    }   

    /**
     * Dashboard method     
     * @return void
     */
    public function user_dashboard()
    {  
        $p = $this->default_group_actions;
        if($p && $p['dashboard'] == 'No Access' ){
            return $this->redirect(['action' => 'no_access']);
        }        

        $this->unlock_lead_check(); 
        $this->Leads = TableRegistry::get('Leads');   
        $this->AllocationUsers = TableRegistry::get('AllocationUsers'); 

        $session = $this->request->session();    
        $user_data = $session->read('User.data');

        $allocationLeads = $this->AllocationUsers->find('all')
            ->contain(['Allocations' => ['Leads' => ['LastModifiedBy', 'Statuses', 'Sources', 'Allocations']]])
            ->where(['AllocationUsers.user_id' => $user_data->id])
        ;

        $count_leads = 0;
        foreach ($allocationLeads as $allocationUser) {
            foreach( $allocationUser->allocation->leads as $lead ){
                if(isset($lead->id) && $lead->id > 0 ) {
                    $count_leads++;
                }
            }
        }

        $total_leads = $count_leads; //$allocationLeads->count();
        $new_leads   = array();
        $followup_leads_today = array();
        $total_leads_followup = 0;
        foreach( $allocationLeads as $al ){
            foreach( $al->allocation->leads as $l  ){                
                if( date("Y-m-d",strtotime($l->followup_date)) == date("Y-m-d") ){
                    $total_leads_followup++;
                    $followup_leads_today[] = $l;
                }

                if( date("Y-m-d",strtotime($l->created)) == date("Y-m-d") ){
                    $new_leads[] = $l;
                }
            }               
        }

        $nav_selected = ["dashboard"];

        $this->set('nav_selected', $nav_selected);        
        $this->set('page_title','Dashboard');        
        $this->set('total_leads', $total_leads);
        $this->set('total_leads_followup', $total_leads_followup);
        $this->set('new_leads', $new_leads);
        $this->set('followup_leads_today', $followup_leads_today);
        $this->set('_serialize', ['total_users','total_leads']);

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

        $this->set('user_group', $this->user->group_id);
        if($this->user->group_id == 1) {
            $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        } else {
            $groups = $this->Users->Groups->find('list')
                ->where(['Groups.id !=' => 1]);
        }
        
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

        if($this->user->group_id == 1) {
            $this->set('groups', $this->Users->Groups->find('list', array('fields' => array('name','id') ) ) );
        } else {
            $groups = $this->Users->Groups->find('list')
                ->where(['Groups.id !=' => 1]);

            $this->set('groups', $groups);
        }


        
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
                if( $u->group_id == 1 ){
                    return $this->redirect(['action' => 'dashboard']);
                }else{
                    return $this->redirect(['action' => 'user_dashboard']);
                }                
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
                $email_smtp->from(['websystem@holistic.com' => 'WebSystem'])
                    ->template('request_forgot_password')
                    ->emailFormat('html')
                    ->to($recipient)                                                                                                     
                    ->subject('Holistic : Forgot Password')
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

    public function change_password($id = null)
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
                    return $this->redirect(['controller' => 'users', 'action' => 'index']);
                }else{
                    $this->Flash->error(__('Your password could not be change. Please, try again.'));                    
                }
            }else{
                $this->Flash->error(__('Password does not match!'));                    
            }
        }

        $this->set(['user' => $user]);
    }    

    public function no_access() {
        $this->set(['message' => '']);
    }
}
