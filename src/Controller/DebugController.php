<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class DebugController extends AppController
{
    public $helpers = ['NavigationSelector'];

    /**
     * initialize method    
     * 
     */
    public function initialize()
    {
        parent::initialize();   
         
    }

    /**
     * beforeFilter method     
     * 
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * beforeFilter method     
     * 
     */
    public function afterFilter(Event $event)
    {
        parent::afterFilter($event);
    }

    /**
     * debugFtpGet method     
     * @return void
     */
    public function debugFtpGet()
    {   
        ini_set('max_execution_time', 0);
        $ftp_conn     = ftp_connect(FTP_SERVER) or die("Could not connect to FTP Server");
        $login        = ftp_login($ftp_conn, FTP_USERNAME, FTP_PASSWORD);   
        ftp_pasv($ftp_conn, true);                      
        $upload_dir   = "E:/test";
        $file   = "public_html/i_manager/test/Lighthouse.jpg";        
        $result       = ftp_get($ftp_conn, $upload_dir, $file, FTP_BINARY);
        // close connection
        ftp_close($ftp_conn);                            
        exit;
    }

    /**
     * debugThreaded method     
     * @return void
     */
    public function debugThreaded()
    {   
        $this->VehicleCompartments = TableRegistry::get('VehicleCompartments');
        $data = $this->VehicleCompartments->find('all')
            ->find('threaded')
            ->toArray();
        debug($data);
        $tree = recursiveVehicleCompartments($data);
        echo $tree;
        exit;
        //$data = $this->VehicleCompartments->find('treeList',['spacer' => ''])->toArray();
        debug($data->toArray());exit;
        foreach( $data as $d ){
            debug($d);
        }        
        exit;
    }

    /**
     * debug Leads Allocation Auto Email method     
     * @return void
     */
    public function debugLeadsExternalAutoEmail()
    {   
        $this->AllocationUsers = TableRegistry::get('AllocationUsers');

        $allocation_id = 2;
        $allocation_users = $this->AllocationUsers->find('all')
            ->contain(['Users'])
            ->where(['AllocationUsers.allocation_id' => $allocation_id])
        ;

        $users_email = array();
        
        foreach($allocation_users as $users){            
            $users_email[$users->user->email] = $users->user->email;            
        }        

        $new_lead = [
            'name' => 'Test New Lead',
            'email' => 'test@test.com',
            'phone' => '3435-3453',
            'city_state' => 'City / State'            
        ];

        $email_customer = new Email('default');
        $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
          ->template('external_leads_registration')
          ->emailFormat('html')          
          ->bcc($users_email)                                                                                               
          ->subject('New Leads')
          ->viewVars(['new_lead' => $new_lead])
          ->send();

        exit;
    }

    /**
     * debug Leads Allocation Auto Email method     
     * @return void
     */
    public function debugEmailDefault()
    {
        $this->Leads = TableRegistry::get('Leads');   

        $id = 1;        
        $leadData = $this->Leads->get($id, [
            'contain' => ['Statuses', 'Sources', 'Allocations', 'LastModifiedBy','LeadTypes','InterestTypes']
        ]); 
        
        $users_email['bryan.yobi@gmail.com'] = 'bryan.yobi@gmail.com';
        $email_customer = new Email('default');
        $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
          ->template('external_leads_registration')
          ->emailFormat('html')          
          ->bcc($users_email)                                                                                               
          ->subject('New Leads')
          ->viewVars(['lead' => $leadData->toArray()])
          ->send();

        exit;
    }
}
