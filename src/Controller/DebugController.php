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
    
    
}
