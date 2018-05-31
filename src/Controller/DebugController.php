<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

require_once(ROOT . DS . 'vendor' . DS . "phpexcel" . DS . "Classes" . DS . "PHPExcel.php");
use PHPExcel;
require_once(ROOT . DS . 'vendor' . DS . "phpexcel" . DS . "Classes" . DS . "PHPExcel" . DS . "Calculation.php");
use Calculation;
require_once(ROOT . DS . 'vendor' . DS . "phpexcel" . DS . "Classes" . DS . "PHPExcel" . DS . "Cell.php");
use Cell;
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

        $id = 131;        
        $leadData = $this->Leads->get($id, [
            'contain' => ['Statuses', 'Sources', 'Allocations', 'LastModifiedBy','LeadTypes','InterestTypes']
        ]); 
        
        $users_email['bryann.revina@gmail.com'] = 'bryann.revina@gmail.com';
        
        $email_customer = new Email('cake_smtp');
        $email_customer->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
          ->template('external_leads_registration')
          ->emailFormat('html')          
          ->bcc($users_email)                                                                                               
          ->subject('New Leads')
          ->viewVars(['lead' => $leadData->toArray()])
          ->send();

        exit;
    }

    public function debugAuditTrailsAdd()
    {
        echo 'Audit Trails Add<hr />';
        $this->AuditTrails = TableRegistry::get('AuditTrails');

        $audit_data['user_id']      = 1; //$this->user->id;
        $audit_data['action']       = 'Update Lead';
        $audit_data['event_status'] = 'Success';
        $audit_data['details']      = 1;
        $audit_data['audit_date']   = date("Y-m-d h:i:s");
        $audit_data['ip_address']   = 222;
        $audit_data['created']      = '';
        $audit_data['modified']     = '';

        echo '<pre>';
        print_r($audit_data);
        echo '</pre>';

        $auditTrail = $this->AuditTrails->newEntity();
        $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
        if (!$this->AuditTrails->save($auditTrail)) {
          echo 'Error updating audit trails';
        }        
        exit;
    }

    public function excelChart()
    {
      define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
      $objPHPExcel = new PHPExcel();
      $objWorksheet = $objPHPExcel->getActiveSheet();
      $objWorksheet->fromArray(
        array(
          array('','Leads'),
          array('Jan',12),
          array('Feb',10)
        )
      );
      $from = array(
          array('',2010,2011),
          array('Q1',12,15)
        );
      //  Set the Labels for each data series we want to plot
      //    Datatype
      //    Cell reference for data
      //    Format Code
      //    Number of datapoints in series
      //    Data values
      //    Data Marker
      $dataseriesLabels = array(
        new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', null, 1)//  2010
        //new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', null, 1), //  2011        
      );      
      //  Set the X-Axis Labels
      //    Datatype
      //    Cell reference for data
      //    Format Code
      //    Number of datapoints in series
      //    Data values
      //    Data Marker
      $xAxisTickValues = array(
        new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$3', null, 1),  //  Q1 to Q4        
      );
      //  Set the Data values for each data series we want to plot
      //    Datatype
      //    Cell reference for data
      //    Format Code
      //    Number of datapoints in series
      //    Data values
      //    Data Marker
      $dataSeriesValues = array(
        new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$3', null, 1)        
      );
      //debug($dataSeriesValues);exit;
      //  Build the dataseries
      $series = new \PHPExcel_Chart_DataSeries(
        \PHPExcel_Chart_DataSeries::TYPE_LINECHART,    // plotType
        \PHPExcel_Chart_DataSeries::GROUPING_STACKED,  // plotGrouping
        range(0, count($dataSeriesValues)-1),     // plotOrder
        $dataseriesLabels,                // plotLabel
        $xAxisTickValues,               // plotCategory
        $dataSeriesValues               // plotValues
      );
      //  Set the series in the plot area
      $plotarea = new \PHPExcel_Chart_PlotArea(null, array($series));
      //  Set the chart legend
      $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_TOPRIGHT, null, false);
      $title = new \PHPExcel_Chart_Title('Test Stacked Line Chart');
      $yAxisLabel = new \PHPExcel_Chart_Title('Value ($k)');
      //  Create the chart
      $chart = new \PHPExcel_Chart(
        'chart1',   // name
        $title,     // title
        $legend,    // legend
        $plotarea,    // plotArea
        true,     // plotVisibleOnly
        0,        // displayBlanksAs
        null,     // xAxisLabel
        $yAxisLabel   // yAxisLabel
      );
      //  Set the position where the chart should appear in the worksheet
      $chart->setTopLeftPosition('A7');
      $chart->setBottomRightPosition('H20');
      //  Add the chart to the worksheet
      $objWorksheet->addChart($chart);
      // Save Excel 2007 file
      echo date('H:i:s') , " Write to Excel2007 format" , EOL;
      $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->setIncludeCharts(TRUE);
      $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
      echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
      // Echo memory peak usage
      echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;
      // Echo done
      echo date('H:i:s') , " Done writing file" , EOL;
      echo 'File has been created in ' , getcwd() , EOL;
      exit;
    }
}
