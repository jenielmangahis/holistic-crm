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
                'action' => 'dashboard'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login',
                
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Main',
                'action' => 'index',
                'prefix' => false
            ],
            'authError' => 'You must be logged in to view this page.',
            'flash' => [
                'element' => 'error'
            ]
        ]);

        $session = $this->request->session();    
        $user_data = $session->read('User.data');        
        
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
}
