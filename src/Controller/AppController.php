<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = [
        'Acl' => [
            'className' => 'Acl.Acl'
        ]
    ];

    /**
     * Initialization hook method.
     * ID : CA-01
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $session = $this->request->session();    
        $user_data = $session->read('User.data');

        if( $user_data->group_id == 1 || $user_data->group_id == 3 ){
            $loginRedirect = 'dashboard';
        }else{
            $loginRedirect = 'user_dashboard';
        }

        
        if( $user_data->group_id == 1 || $user_data->group_id == 3 ){
            //Configure::write('Session.timeout', '1');
        }        
        
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => [
                'Acl.Actions' => ['actionPath' => 'controllers/']
            ],
            'loginAction' => [
                'plugin' => false,
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'users',
                'action' => $loginRedirect
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login',
                
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => $loginRedirect,
                'prefix' => false
            ],
            'authError' => 'You are not allowed to access this page',
            'flash' => [
                'element' => 'error'
            ]
        ]);  

        $default_group_actions = array();
        $this->GroupActions = TableRegistry::get('GroupActions');    
        $group_actions = $this->GroupActions->find()
            ->where(['GroupActions.group_id' => $user_data->group_id]);

        foreach($group_actions as $gakey => $gadata) {
            $default_group_actions[$gadata->module] = $gadata->action;
        }  

        $this->default_group_actions = $default_group_actions;        
        $this->set([
            'default_group_actions' => $default_group_actions
        ]);
        
        $base_url  = Router::url('/',true);          
        $this->set([
            'base_url' => $base_url,
            'hdr_user_data' => $user_data            
        ]);

        /*$acl_controller = $this->request->params['controller'];
        $acl_view       = $this->request->params['action'];                       
        $setting = $this->Settings->get(1);             
        if( !empty($user_data) ){
            if( $user_data->user->group_id != 1 && $acl_controller != 'Maintenance' && $setting->is_maintenance == 1 ){                            
                if( $acl_controller != "Users" || ($acl_view != 'logout' && $acl_view != 'login') ){
                    return $this->redirect(['controller' => 'maintenance', 'action' => 'index']);
                }
            }
        }else{
            if( $setting->is_maintenance == 1 && $acl_controller != 'Maintenance' ){
                if( $acl_controller != "Users" || ($acl_view != 'logout' && $acl_view != 'login') ){
                    return $this->redirect(['controller' => 'maintenance', 'action' => 'index']);
                }
            }           
        }*/

    }

    /**
     * beforeFilter method
     * ID : CA-02
     * 
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow('login');

        $this->Leads = TableRegistry::get('Leads');   
        $total_leads_followup = $this->Leads->find('all')
            ->where(['Leads.followup_date' => date("Y-m-d")])
            ->count();
        $total_new_leads = $this->Leads->find('all')
            ->where(['DATE_FORMAT(Leads.created,"%Y-%m-%d")' => date("Y-m-d")])
            ->order(['Leads.id' => 'DESC'])
            ->limit(5)
            ->count()
        ;            

        $this->set('total_new_leads', $total_new_leads);
        $this->set('total_leads_followup', $total_leads_followup);
        $this->set('total_notification', $total_new_leads + $total_leads_followup);
    }

    /**
     * isAuthorized method
     * ID : CA-03
     * @return void
     */
    public function isAuthorized($user) {
        // Here is where we should verify the role and give access based on role
         
        return true;
    }

    public function unlock_lead_check() {

        $session     = $this->request->session(); 
        $ulock_leads = $session->read('LeadsLock.data');
        $u           = $session->read('User.data');

        if(isset($ulock_leads)) {
            foreach($ulock_leads as $ul_key => $ul_data) {
                $user_id = $ul_key;
                $lead_id = $ul_data;

                if($user_id == $u->id) {

                    $lead_unlock = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);       

                    $login_user_id                      = $u->id;
                    $data_unlck['is_lock']              = 0;
                    $data_unlck['last_modified_by_id '] = $login_user_id;
                    $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data_unlck);
                    if ( $this->Leads->save($lead_unlock) ) { 
                        //session_start();
                        unset($ulock_leads[$login_user_id]);
                    }

                }

            }

        } 

        $lock_leads = $this->Leads->find('all')
            ->contain(['Statuses', 'Sources', 'Allocations'])
            ->where(['Leads.is_lock ' => 1])
            ->andWhere(['Leads.last_modified_by_id' => $u->id])
          ;        

        if($lock_leads) {     
            foreach($lock_leads as $ll_key => $ll_data) {
                $lock_status           = $ll_data->is_lock;
                $last_modified_user_id = $ll_data->last_modified_by_id;
                $lead_id               = $ll_data->id;
                $login_user_id         = $u->id;

                if($last_modified_user_id == $u->id) {
                    
                    $lead_unlock = $this->Leads->get($lead_id, [ 'contain' => ['LastModifiedBy'] ]);      
                    $data['is_lock']              = 0;
                    $data['last_modified_by_id '] = $login_user_id;
                    $lead_unlock = $this->Leads->patchEntity($lead_unlock, $data);
                    if ( !$this->Leads->save($lead_unlock) ) { echo "error updating lock lead"; exit; }                

                }

            } 

        }
      
    }       
}
