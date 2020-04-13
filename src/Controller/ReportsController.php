<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
require_once(ROOT . DS . 'vendor' . DS . "phpexcel" . DS . "Classes" . DS . "PHPExcel.php");
use PHPExcel;
require_once(ROOT . DS . 'vendor' . DS . "phpexcel" . DS . "Classes" . DS . "PHPExcel" . DS . "Calculation.php");
use Calculation;
require_once(ROOT . DS . 'vendor' . DS . "phpexcel" . DS . "Classes" . DS . "PHPExcel" . DS . "Cell.php");
use Cell;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 */
class ReportsController extends AppController
{
  public $paginate = ['maxLimit' => 500,'limit' => 500];

    /**
     * initialize method     
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["reports"];
        $this->set('nav_selected', $nav_selected);

        /*$p = $this->default_group_actions;
        if($p && $p['leads'] != 'No Access' ){
            $this->Auth->allow();
        }*/

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');         
        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{                           
                $authorized_modules = array();     
                $rights = $this->default_group_actions['leads'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view', 'from_source'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'from_source', 'add', 'edit', 'register', 'unlock', 'leads_unlock'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'from_source', 'add', 'edit', 'delete', 'register', 'unlock', 'leads_unlock'];
                        break;        
                    default:            
                        break;
                }                
                //$this->Auth->allow($authorized_modules);
                $this->Auth->allow();
            }
        }         
        $this->user = $user_data;
 
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
      $this->Sources = TableRegistry::get('Sources');
      $this->SourceUsers = TableRegistry::get('SourceUsers');

      $session   = $this->request->session();    
      $user_data = $session->read('User.data');
      $report_data =  $session->read('Report.data');
      /*debug($report_data);
      exit;*/

      if ($this->request->is('post')) {
        $sources = $this->request->data;
        if( !empty($sources) ){
          $report_data['s1'] = $sources;          
          $session->write('Report.data', $report_data);      
          
          return $this->redirect(['action' => 'step2']);
        }else{
          $this->Flash->error(__('Please select source to generate report.'));
        }        
      }

      if( $user_data->group_id == 1 ){
        $sources = $this->Sources->find('all')
          ->order(['Sources.name' => 'ASC'])
        ;        
      }else{
        $source_ids = array();
        $sourceUsers = $this->SourceUsers->find('all')
          ->where(['SourceUsers.user_id' => $user_data->id])
        ;
        foreach( $sourceUsers as $su ){
          $source_ids[$su->source_id] = $su->source_id;
        }

        if( empty($source_ids) ){
          $source_ids[0] = 0;
        }

        $sources = $this->Sources->find('all')
          ->where(['Sources.id IN' => $source_ids])
          ->order(['Sources.name' => 'ASC'])
        ;
      }      

      $this->set([
        'load_reports_js' => true,
        'sources' => $sources,
        'report_data' => $report_data['s1']
      ]);
    }

    /**
     * Report : Step2 method
     *
     * @return void
     */
    public function step2()
    {
      $this->FormLocations = TableRegistry::get('FormLocations');      
      $this->UserAssignedSpecificUsers = TableRegistry::get('UserAssignedSpecificUsers');
      $this->Users = TableRegistry::get('Users');

      $session     = $this->request->session(); 
      $report_data = $session->read('Report.data'); 
      
      if( empty($report_data['s1']) ){        
        $this->Flash->error(__('Please select source to generate report.'));
        return $this->redirect(['action' => 'index']);
      }

      if ($this->request->is('post')) {
        $report_type = $this->request->data;
        if( $report_type['information'] > 0 ){         
          $report_data['s2'] = $report_type;              
          $session->write('Report.data', $report_data);      

          return $this->redirect(['action' => 'step3']);
        }else{
          $this->Flash->error(__('Please select report type.'));
        }        
      }

      $session   = $this->request->session();    
      $user_data = $session->read('User.data');         
      $userAssignedSpecificUsers = $this->UserAssignedSpecificUsers->find()
        ->where(['UserAssignedSpecificUsers.user_id' => $user_data->id])
        ->first()
      ;

      $user_ids = array();
      $userIds  = unserialize($userAssignedSpecificUsers->userids);
      foreach( $userIds as $s ){
        $user_ids[$s] = $s;
      } 

      if( empty($user_ids) ){
        $user_ids[0] = 0;
      }

      $userSpecificUsers = $this->Users->find('all')
        ->where(['Users.id IN' => $user_ids])
      ;

      $optionInformation = [
        //1 => "How many leads we've received (total)",
        2 => "How many leads we've received in specific date range",
        3 => "How many leads are currently open/engaged?",
        4 => "How many leads are closed/sold",
        5 => "How many leads are dead/spam?",
        6 => "How many leads came through the website (all source forms)?",
        7 => "How many leads came through a specific form",
        8 => "How many leads came through the telephone",
        9 => "Assigned leads to Specific Users"
      ];

      $optionFormLocations = array();
      $formLocations = $this->FormLocations->find('all');
      foreach($formLocations as $f){
        $optionFormLocations[$f->id] = $f->name;
      }

      $sources = array();
      foreach( $report_data['s1']['sources'] as $key => $value ){
        $sources[$key] = $key;
      }      

      $this->set([
        'load_reports_js' => true,
        'optionFormLocations' => $optionFormLocations,
        'optionInformation' => $optionInformation,
        'report_data' => $report_data['s2'],
        'sources' => $sources,
        'userSpecificUsers' => $userSpecificUsers
      ]);
    }

    /**
     * Report : Step3 method
     *
     * @return void
     */
    public function step3()
    {

      $session     = $this->request->session(); 
      $report_data = $session->read('Report.data'); 

      if( empty($report_data['s1']) ){        
        $this->Flash->error(__('Please select source to generate report.'));
        return $this->redirect(['action' => 'index']);
      }

      if( empty($report_data['s2']) ){        
        $this->Flash->error(__('Please select report type.'));
        return $this->redirect(['action' => 'step2']);
      }

      $fields = ['firstname' => 'First Name', 'surname' => 'Surname', 'source_id' => 'Source', 'email' => 'Email', 'phone' => 'Phone', 'address' => 'Address', 'status_id' => 'Status', 'city' => 'City', 'state' => 'State' , 'allocation_date' => 'Allocation Date', 'lead_action' => 'Lead Action', 'interest_type_id' => 'Interest Type', 'followup_action_reminder_date' => 'Followup Action Reminder Date', 'followup_notes' => 'Followup Notes', 'notes' => 'Notes', 'lead_type_id' => 'Lead Type', 'source_url' => 'Source URL', 'followup_date' => 'Followup Date', 'followup_action_notes' => 'Followup Action Notes'];

      $this->set([
        'fields' => $fields,
        'load_reports_js' => true,
        'report_data' => $report_data['s3']
      ]);
    }

    public function generate_leads_report()
    {
      $this->LeadLeadTypes = TableRegistry::get('LeadLeadTypes');
      $this->SpecificUserLeads = TableRegistry::get('SpecificUserLeads');

      $session     = $this->request->session(); 
      $report_data = $session->read('Report.data'); 

      if ($this->request->is('post')) {        
        $data = $this->request->data;   
        if( !empty($data['fields']) ){                   
          $report_data['s3'] = $data;          
          $session->write('Report.data', $report_data);      


          //Generate report
          $information = $report_data['s2']['information'];
          $sources     = array();
          foreach( $report_data['s1']['sources'] as $key => $value ){
            $sources[$key] = $key;
          }         
          //Query generator  
          switch ($information) {
            case 2: //How many leads we've received in specific date range   
              $date_from = $report_data['s2']['dateRange']['from'];
              $date_to   = $report_data['s2']['dateRange']['to'];
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to, 'Leads.is_archive' => 'No'])
              ;           
              break;
              
            case 3: //How many leads are currently open/engaged?
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.status_id' => 1, 'Leads.is_archive' => 'No'])
              ;
              break;

            case 4: //How many leads are closed/sold
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.status_id' => 7, 'Leads.is_archive' => 'No'])
              ;
              break;

            case 5: //How many leads are dead/spam?
              $dead_spam_status = [6,11,12,13];
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.status_id IN' => $dead_spam_status, 'Leads.is_archive' => 'No'])
              ;
              break;

            case 6: //How many leads came through the website (all source forms)?            
              $date_from = $report_data['s2']['dateRangeAllForms']['from'];
              $date_to   = $report_data['s2']['dateRangeAllForms']['to'];
              if( isset($report_data['s2']['viewAllDateRangeAllForms']) ){
                $leads = $this->Leads->find('all')
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                  ->where(['Leads.source_id IN' => $sources, 'Leads.lead_type_id' => 1, 'Leads.is_archive' => 'No'])
                ;      
              }else{
                $leads = $this->Leads->find('all')
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                  ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to, 'Leads.lead_type_id' => 1, 'Leads.is_archive' => 'No'])
                ;      
              }              
              break;

            case 7: //How many leads came through a specific form
              $source_urls = array();              
              foreach( $report_data['s2']['formSources'] as $key => $value ){                
                $source_urls[$key] = $key;
              }
              $leads = $this->Leads->find('all')
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                  ->where(['Leads.source_id IN' => $sources, 'Leads.source_url IN' => $source_urls, 'Leads.is_archive' => 'No'])
                ; 
              break;

            case 8: //How many leads came through the telephone        
                $leadTypes = $this->LeadLeadTypes->find('all')
                  ->where(['LeadLeadTypes.lead_type_id' => 2])
                ;
                $leadIds = array();
                foreach( $leadTypes as $lt ){
                  $leadIds[$lt->lead_id] = $lt->lead_id;
                }    
              if( isset($report_data['s2']['viewAllLeadsTelephone']) ){                
                $leads = $this->Leads->find('all')
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                  ->where(['Leads.source_id IN' => $sources, 'Leads.id IN' => $leadIds, 'Leads.is_archive' => 'No'])
                ;  
              }else{
                $date_from = $report_data['s2']['dateRangeLeadsTelephone']['from'];
                $date_to   = $report_data['s2']['dateRangeLeadsTelephone']['to'];
                $leads = $this->Leads->find('all')
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                  ->where(['Leads.source_id IN' => $sources, 'Leads.id IN' => $leadIds, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to, 'Leads.is_archive' => 'No'])
                ;    
              }
              break;
            case 9:
              $user_ids = array();
              foreach( $report_data['s2']['specificUsers'] as $key => $value ){
                $user_ids[$value] = $value;
              }

              if( empty($user_ids) ){
                $user_ids[0] = 0;
              }

              $specificUserLeads = $this->SpecificUserLeads->find('all')
                ->where(['SpecificUserLeads.user_id IN' => $user_ids])
              ;

              $specific_leads_id = array();
              foreach( $specificUserLeads as $sl ){
                $specific_leads_id[$sl->lead_id] = $sl->lead_id;
              }

              if( empty($specific_leads_id) ){
                $specific_leads_id[0] = 0;
              }

              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.id IN' => $specific_leads_id, 'Leads.is_archive' => 'No'])
              ;

              break;
            default:              
              break;
          }

          $fields = $data['fields'];

          if( $data['report-type'] == 'Excel' ){
            $total_fields = count($fields) + 2;
            $eColumns = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 24 => 'Y', 25 => 'Z'];

            $excel_cell_values = array();          
            foreach( $leads as $l ){                
              $excelFields = array();
              foreach( $fields as $key => $value ){              
                if( $key == 'source_id' ){
                  $excelFields[] = $l->source->name;
                }elseif($key == 'status_id') {
                  $excelFields[] = $l->status->name;
                }elseif($key == 'lead_type_id') {
                  $leadLeadTypes = $this->LeadLeadTypes->find('all')
                    ->contain(['LeadTypes'])
                    ->where(['LeadLeadTypes.lead_id' => $l->id])
                  ;
                  $leadTypes = array();
                  foreach($leadLeadTypes as $lt){
                    $leadTypes[$lt->lead_type->name] = $lt->lead_type->name;
                  }
                  $lead_types = implode(",", $leadTypes);
                  $excelFields[] = $lead_types;
                }elseif($key == 'interest_type_id'){
                  $excelFields[] = $l->interest_type->name;
                }else{                
                  $excelFields[] = $l->{$key};
                }              
              }
              $excel_cell_values[] = $excelFields;            
            }

            //generate excel file for attachment
            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Holistic Admin")
               ->setLastModifiedBy("Holistic Admin")
               ->setTitle("Leads Report")
               ->setSubject("Leads Report")
               ->setDescription("Excel file generated for Leads Report")
               ->setKeywords("Leads Report")
               ->setCategory("Lists");
            $objPHPExcel->setActiveSheetIndex(0);

            $borderArray = array(
              'borders' => array(
                'allborders' => array(
                    'style' => 'thick',
                    'color' => array('argb' => 'C3232D')
                 )
              )
            );
            $objPHPExcel->getDefaultStyle()->applyFromArray($borderArray);

            for($col = 'A'; $col !== 'I'; $col++) {
                $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
            }

            $ews = $objPHPExcel->getSheet(0);
            $ews->setTitle('Sheet 1');
            //header
            $ews->setCellValue('A1', 'Date');
            $ews->setCellValue('B1', date("Y-m-d"));

            $ews->setCellValue('A2', '');
            $ews->setCellValue('B2', 'Leads Report');

            $start = 1;
            $end_column;  

            foreach( $fields as $key => $value ){              
              switch ($key) {
                case 'interest_type_id':
                  $key = 'interest type';  
                  break;
                case 'lead_type_id':
                  $key = 'lead type';
                  break;
                case 'source_id':
                  $key = 'source';
                default:                  
                  break;
              }

              $ews->setCellValue($eColumns[$start] . 4, $key);
              $end_column = $eColumns[$start] . 4;
              $start++;
            }          

            $ews->getStyle($eColumns[1] . '4' . ':' . $end_column)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => 'solid',
                        'color' => array('rgb' => 'CDD6DF')
                    )
                )
            );

            $ews->fromArray($excel_cell_values,'','A5');

            $fileName  = time() . "_" . rand(000000, 999999) . ".xls";
            $objWriter  = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('excel\leads\\' . $fileName);          

            $file_path = WWW_ROOT.'excel\leads\\' . $fileName;
            $this->response->file($file_path, array(
                'download' => true,
                'name' => $fileName,
            ));
            return $this->response;
            exit;
          }else{
            $this->set([
                'leads' => $this->Paginate($leads),
                'fields' => $fields,
                'load_reports_js' => false,
                'load_advance_search_script' => false,
                'enable_jscript_datatable', false,
                'enable_content_expander_script', true
            ]); 
          }          
        }else{
          $this->Flash->error(__('Please select fields to display.')); 
        }
      }else{       
        $report_data = $session->read('Report.data');
        //Generate report
        $information = $report_data['s2']['information'];
        $sources     = array();
        foreach( $report_data['s1']['sources'] as $key => $value ){
          $sources[$key] = $key;
        }         
        
        $order = array();
        if( isset($this->request->query['sort']) && isset($this->request->query['direction']) ){
          $order = ['Leads.' . $this->request->query['sort'] => $this->request->query['direction']];
        }

        //Query generator           
        switch ($information) {
          case 2: //How many leads we've received in specific date range   
            $date_from = $report_data['s2']['dateRange']['from'];
            $date_to   = $report_data['s2']['dateRange']['to'];
            $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
              ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to])
            ;           
            break;
            
          case 3: //How many leads are currently open/engaged?
            $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
              ->where(['Leads.source_id IN' => $sources, 'Leads.status_id' => 1])
            ;
            break;

          case 4: //How many leads are closed/sold
            $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
              ->where(['Leads.source_id IN' => $sources, 'Leads.status_id' => 7])
            ;
            break;

          case 5: //How many leads are dead/spam?
            $dead_spam_status = [6,11,12,13];
            $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
              ->where(['Leads.source_id IN' => $sources, 'Leads.status_id IN' => $dead_spam_status])
            ;
            break;

          case 6: //How many leads came through the website (all source forms)?            
            $date_from = $report_data['s2']['dateRangeAllForms']['from'];
            $date_to   = $report_data['s2']['dateRangeAllForms']['to'];
            if( isset($report_data['s2']['viewAllDateRangeAllForms']) ){
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.lead_type_id' => 1])
              ;      
            }else{
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to, 'Leads.lead_type_id' => 1])
              ;      
            }              
            break;

          case 7: //How many leads came through a specific form
            $source_urls = array();              
            foreach( $report_data['s2']['formSources'] as $key => $value ){                
              $source_urls[$key] = $key;
            }
            $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.source_url IN' => $source_urls])
              ; 
            break;

          case 8: //How many leads came through the telephone
            if( isset($report_data['s2']['viewAllLeadsTelephone']) ){
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.lead_type_id' => 2])
              ;  
            }else{
              $date_from = $report_data['s2']['dateRangeLeadsTelephone']['from'];
              $date_to   = $report_data['s2']['dateRangeLeadsTelephone']['to'];
              $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
                ->where(['Leads.source_id IN' => $sources, 'Leads.lead_type_id' => 2, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to])
              ;    
            }
            break;

          default:              
            break;
        }

        $fields = $report_data['s3']['fields'];
        
        if(isset($this->request->query['sort'])){
          $leads->order(['Leads.'. $this->request->query['sort'] => $this->request->query['direction']]);
        }

        $this->set([
            'leads' => $this->Paginate($leads),
            'fields' => $fields,
            'load_reports_js' => false,
            'load_advance_search_script' => false,
            'enable_jscript_datatable', false,
            'enable_content_expander_script', true
        ]); 
      }
    }
   
    /**
     * Leads method
     *
     * @return void
     */
    public function leads()
    { 
      $this->Sources = TableRegistry::get('Sources');
      $this->InterestTypes = TableRegistry::get('InterestTypes');
      $this->Statuses = TableRegistry::get('Statuses');
      $this->LeadTypes = TableRegistry::get('LeadTypes');

      //$sources = $this->Sources->find('all');
      $sources  = $this->Sources->find('all', ['order' => ['Sources.sort' => 'ASC']]);
      $statuses = $this->Statuses->find('all');
      $interestTypes = $this->InterestTypes->find('all')
        ->order(['InterestTypes.sort' => 'ASC'])      
      ;
      $leadTypes = $this->LeadTypes->find('all')
        ->order(['LeadTypes.sort' => 'ASC'])
      ;

      $optionSources = array();
      foreach($sources as $s){
        $optionSources[$s->id] = $s->name;
      }
      

      $optionLeadTypes = array();
      foreach( $leadTypes as $lt ){
        $optionLeadTypes[$lt->id] = $lt->name;
      }

      $optionInterestTypes = array();
      foreach( $interestTypes as $i ){
        $optionInterestTypes[$i->id] = $i->name;
      }

      $optionStatuses = array();
      foreach( $statuses as $s ){
        $optionStatuses[$s->id] = $s->name;
      }

      $option_logical_operators = ['=', '!=', 'LIKE'];
      $fields = ['firstname' => 'First Name', 'surname' => 'Surname', 'source_id' => 'Source', 'email' => 'Email', 'phone' => 'Phone', 'address' => 'Address', 'status_id' => 'Status', 'city' => 'City', 'state' => 'State' , 'allocation_date' => 'Allocation Date', 'lead_action' => 'Lead Action', 'interest_type_id' => 'Interest Type', 'followup_action_reminder_date' => 'Followup Action Reminder Date', 'followup_notes' => 'Followup Notes', 'notes' => 'Notes', 'lead_type_id' => 'Lead Type', 'source_url' => 'Source URL', 'followup_date' => 'Followup Date', 'followup_action_notes' => 'Followup Action Notes'];
      $this->set([
          'option_logical_operators' => $option_logical_operators,
          'fields' => $fields,
          'optionSources' => $optionSources,
          'optionInterestTypes' => $optionInterestTypes,          
          'optionLeadTypes' => $optionLeadTypes,
          'optionStatuses' => $optionStatuses,
          'load_reports_js' => true,
          'load_advance_search_script' => true
      ]);      
    }

    /**
     * Generaate Leads Report method
     *
     * @return void
     */
    public function generate_report()
    { 
      $this->LeadLeadTypes = TableRegistry::get('LeadLeadTypes');
      $data   = $this->request->data; 
      //debug($data); exit;
      if($data['report_type'] == 'excel_download') {
        $query = "";
        $artikel = array();        
        if( isset($this->request->data) ){
            $sql_fields = array();   
            $fields = $data['fields']; 

            foreach($data['fields'] as $key => $value){
              $sql_fields[] = $key;
            }

            if( isset($data['filter-leads-report']) ){
                $query_builder = array();
                $or_query_builder = array();  
                $query_builder[] = ['Leads.is_archive' => 'No'];          
                foreach( $data['search'] as $key => $value ){
                  if($key == 'date_created' ){                   
                    //$query_builder[] = ['DATE_FORMAT(Leads.created, "%Y-%m-%d") >=' => $value['value']['from'], 'DATE_FORMAT(Leads.created, "%Y-%m-%d") <=' => $value['value']['to']];
                    if( $value['value']['from'] != '' && $value['value']['to'] != '' ){
                      $query_builder[] = ['Leads.created >=' => date("Y-m-d",strtotime($value['value']['from'])) . " 00:00:00", 'Leads.created <=' => date("Y-m-d",strtotime($value['value']['to'])) . " 23:59:59"];
                    }
                  }else{
                    $operator    = trim($value['operator']);
                    $query_value = trim($value['value']);
                    if($operator != '' && $query_value != ''){           
                        if( $key == 'allocation_date' ){
                          $query_value = date("Y-m-d", strtotime($query_value));
                        }
                        switch ($key) {
                          case 'source':                                                                    
                            if( $operator == 'LIKE' ){                                
                                $query_builder[] = ['Source.name ' . $operator . " '%" . $query_value . "%'"];
                            }else{
                                $query_builder[] = ['Leads.source_id ' . $operator => $query_value];
                            }                            
                            break;  
                          case 'lead_type_id':                              
                              $leadLeadTypes = $this->LeadLeadTypes->find('all')
                                ->contain(['LeadTypes'])
                                ->where(['LeadLeadTypes.lead_type_id' => $query_value])
                              ;      
                              $leadIds = array();
                              foreach( $leadLeadTypes as $lt ){
                                $leadIds[$lt->lead_id] = $lt->lead_id;
                              }    
                              $query_builder[] = ['Leads.id IN ' => $leadIds];
                              break;                                                                           
                          default:
                            if( $operator == 'LIKE' ){                                
                                $query_builder[] = ['Leads.' . $key . " " . $operator . " '%" . $query_value . "%'"];
                            }else{
                                $query_builder[] = ['Leads.' . $key . " " . $operator => $query_value];
                            }                            
                            break;     
                        }
                    }

                  }                    
                }
                $leads = $this->Leads->find('all')                  
                    ->contain(['Statuses', 'Sources', 'InterestTypes'])
                    ->where($query_builder)                   
                    ->order(['Leads.firstname' => 'ASC'])                                 
                ;
            }else{
              //Select all
              $leads = $this->Leads->find('all')                
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])                
                  ->order(['Leads.firstname' => 'ASC'])                                 
              ;
            }

            //Fields          
            $fields = $data['fields'];
            $total_fields = count($fields) + 2;
            $eColumns = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 24 => 'Y', 25 => 'Z'];

            $excel_cell_values = array();          
            foreach( $leads as $l ){            
              $excelFields = array();
              foreach( $fields as $key => $value ){              
                if( $key == 'source_id' ){
                  $excelFields[] = $l->source->name;
                }elseif($key == 'status_id') {
                  $excelFields[] = $l->status->name;
                }elseif($key == 'lead_type_id') {
                  $leadLeadTypes = $this->LeadLeadTypes->find('all')
                    ->contain(['LeadTypes'])
                    ->where(['LeadLeadTypes.lead_id' => $l->id])
                  ;
                  $leadTypes = array();
                  foreach($leadLeadTypes as $lt){
                    $leadTypes[$lt->lead_type->name] = $lt->lead_type->name;
                  }
                  $lead_types = implode(",", $leadTypes);
                  $excelFields[] = $lead_types;
                }else{                
                  $excelFields[] = $l->{$key};
                }              
              }
              $excel_cell_values[] = $excelFields;            
            }

            //generate excel file for attachment
            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Holistic Admin")
               ->setLastModifiedBy("Holistic Admin")
               ->setTitle("Leads Report")
               ->setSubject("Leads Report")
               ->setDescription("Excel file generated for Leads Report")
               ->setKeywords("Leads Report")
               ->setCategory("Lists");
            $objPHPExcel->setActiveSheetIndex(0);

            $borderArray = array(
              'borders' => array(
                'allborders' => array(
                    'style' => 'thick',
                    'color' => array('argb' => 'C3232D')
                 )
              )
            );
            $objPHPExcel->getDefaultStyle()->applyFromArray($borderArray);

            for($col = 'A'; $col !== 'I'; $col++) {
                $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
            }

            $ews = $objPHPExcel->getSheet(0);
            $ews->setTitle('Sheet 1');
            //header
            $ews->setCellValue('A1', 'Date');
            $ews->setCellValue('B1', date("Y-m-d"));

            $ews->setCellValue('A2', '');
            $ews->setCellValue('B2', 'Leads Report');

            $start = 1;
            $end_column;  
            //debug($eColumns);exit;        
            foreach( $fields as $key => $value ){
              //echo $eColumns[1] . ($start+3) . "<br />";
              $ews->setCellValue($eColumns[$start] . 4, $value);
              $end_column = $eColumns[$start] . 4;
              $start++;
            }          

            $ews->getStyle($eColumns[1] . '4' . ':' . $end_column)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => 'solid',
                        'color' => array('rgb' => 'CDD6DF')
                    )
                )
            );

            $ews->fromArray($excel_cell_values,'','A5');

            $fileName  = time() . "_" . rand(000000, 999999) . ".xlsx";
            $objWriter  = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('excel\leads\\' . $fileName);          

            $file_path = WWW_ROOT.'excel\leads\\' . $fileName;
            $this->response->file($file_path, array(
                'download' => true,
                'name' => $fileName,
            ));
            return $this->response;
            exit;
        }
        exit;
      }elseif($data['report_type'] == 'view_report') {
        $fields = $data['fields'];
        if( isset($this->request->data ) ){
          $query      = "";
          $artikel    = array(); 
          $sql_fields = array();

          foreach($data['fields'] as $key => $value){
            $sql_fields[] = $key;
          }

          if( isset($data['filter-leads-report']) ){
              $query_builder = array();
              $query_builder[] = ['Leads.is_archive' => 'No'];
              $or_query_builder = array();                            
              foreach( $data['search'] as $key => $value ){
                if($key == 'date_created' ){                   
                  //$query_builder[] = ['DATE_FORMAT(Leads.created, "%Y-%m-%d") >=' => $value['value']['from'], 'DATE_FORMAT(Leads.created, "%Y-%m-%d") <=' => $value['value']['to']];
                  if( $value['value']['from'] != '' && $value['value']['to'] != '' ){
                    $query_builder[] = ['Leads.created >=' => date("Y-m-d",strtotime($value['value']['from'])) . " 00:00:00", 'Leads.created <=' => date("Y-m-d",strtotime($value['value']['to'])) . " 23:59:59"];
                  }                                     
                }else{
                  $operator    = trim($value['operator']);
                  $query_value = trim($value['value']);
                  if($operator != '' && $query_value != ''){           
                      if( $key == 'allocation_date' ){
                        $query_value = date("Y-m-d", strtotime($query_value));
                      }
                      switch ($key) {
                        case 'source':                                                                    
                          if( $operator == 'LIKE' ){                                
                              $query_builder[] = ['Source.name ' . $operator . " '%" . $query_value . "%'"];
                          }else{
                              $query_builder[] = ['Leads.source_id ' . $operator => $query_value];
                          }                            
                          break; 
                        case 'lead_type_id':                              
                              $leadLeadTypes = $this->LeadLeadTypes->find('all')
                                ->contain(['LeadTypes'])
                                ->where(['LeadLeadTypes.lead_type_id' => $query_value])
                              ;      
                              $leadIds = array();
                              foreach( $leadLeadTypes as $lt ){
                                $leadIds[$lt->lead_id] = $lt->lead_id;
                              }    
                              $query_builder[] = ['Leads.id IN ' => $leadIds];
                              break;
                        default:
                          if( $operator == 'LIKE' ){                                
                              $query_builder[] = ['Leads.' . $key . " " . $operator . " '%" . $query_value . "%'"];
                          }else{
                              $query_builder[] = ['Leads.' . $key . " " . $operator => $query_value];
                          }                            
                          break;     
                      }
                  }
                }                    
              }
              $leads = $this->Leads->find('all')                  
                  ->contain(['Statuses', 'Sources', 'InterestTypes'])
                  ->where($query_builder)                   
                  ->order(['Leads.firstname' => 'ASC'])                                 
              ;
          }else{
            //Select all
            $leads = $this->Leads->find('all')                
                ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])                
                ->order(['Leads.firstname' => 'ASC'])                                 
            ;
          }
        }

        $this->set([
            'leads' => $leads,
            'fields' => $fields,
            'load_reports_js' => false,
            'load_advance_search_script' => false,
            'enable_jscript_datatable', false,
            'enable_content_expander_script', true
        ]); 
      }
    }

    /**
     * Cumulative method
     *
     * @return void
     */
    public function cumulative()
    {
      $this->Sources = TableRegistry::get('Sources');
      $this->SourceUsers = TableRegistry::get('SourceUsers');

      $session   = $this->request->session();    
      $user_data = $session->read('User.data');
      $report_data =  $session->read('CumulativeReport.data');
      
      if ($this->request->is('post')) {
        $sources = $this->request->data;       
        if( !empty($sources) ){
          $report_data['s1'] = $sources;          
          $session->write('CumulativeReport.data', $report_data);      
          
          return $this->redirect(['action' => 'cumulative_step2']);
        }else{
          $this->Flash->error(__('Please select source to generate report.'));
        }        
      }

      if( $user_data->group_id == 1 ){
        $sources = $this->Sources->find('all')
          ->order(['Sources.name' => 'ASC'])
        ;        
      }else{
        $source_ids = array();
        $sourceUsers = $this->SourceUsers->find('all')
          ->where(['SourceUsers.user_id' => $user_data->id])
        ;
        foreach( $sourceUsers as $su ){
          $source_ids[$su->source_id] = $su->source_id;
        }

        $sources = $this->Sources->find('all')
          ->where(['Sources.id IN' => $source_ids])
          ->order(['Sources.name' => 'ASC'])
        ;
      }      

      $this->set([
        'load_reports_js' => true,
        'sources' => $sources,
        'report_data' => $report_data['s1']
      ]);
    }

    /**
     * Cumulative Step2 method
     *
     * @return void
     */
    public function cumulative_step2()
    {      
      $session     = $this->request->session(); 
      $report_data = $session->read('CumulativeReport.data');

      if( empty($report_data['s1']) ){        
        $this->Flash->error(__('Please select source to generate report.'));
        return $this->redirect(['action' => 'cumulative']);
      }

      if ($this->request->is('post')) {
        $report_type = $this->request->data;
        if( $report_type['information'] > 0 ){         
          $report_data['s2'] = $report_type;                        
          $session->write('CumulativeReport.data', $report_data);      

          return $this->redirect(['action' => 'cumulative_step3']);
        }else{
          $this->Flash->error(__('Please select report type.'));
        }        
      }

      $optionInformation = [        
        1 => "Number of leads per month with chart",
        2 => "Number of leads per week with chart​",
        3 => "Number of leads per day with chart​"        
      ];

      $sources = array();
      foreach( $report_data['s1']['sources'] as $key => $value ){
        $sources[$key] = $key;
      }      

      $this->set([
        'load_reports_js' => true,        
        'optionInformation' => $optionInformation,
        'report_data' => $report_data['s2'],
        'sources' => $sources
      ]);
    }

    /**
     * Cumulative Step3 method
     *
     * @return void
     */
    public function cumulative_step3()
    {

      $session     = $this->request->session(); 
      $report_data = $session->read('CumulativeReport.data');       

      if( empty($report_data['s1']) ){        
        $this->Flash->error(__('Please select source to generate report.'));
        return $this->redirect(['action' => 'cumulative']);
      }

      if( empty($report_data['s2']) ){        
        $this->Flash->error(__('Please select report type.'));
        return $this->redirect(['action' => 'cumulative_step2']);
      }
      
      $this->set([
        'report_data' => $report_data['s3']
      ]);
    }

    /**
     * Generate Cumulative Report method
     *
     * @return download file
     */
    public function generate_cumulative_report()
    {
      define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

      $session     = $this->request->session(); 
      $report_data = $session->read('CumulativeReport.data'); 

      if ($this->request->is('post')) {        
        $data = $this->request->data;   
        
        $report_data['s3'] = $data;   
        $session->write('CumulativeReport.data', $report_data);      

        //Generate report
        $information = $report_data['s2']['information'];
        $sources     = array();
        foreach( $report_data['s1']['sources'] as $key => $value ){
          $sources[$key] = $key;
        } 

        $chart_data   = array(); 
        $chart_labels = array();
        $date_from = $report_data['s3']['date_from'];
        $date_to   = $report_data['s3']['date_to'];
        switch ($information) {
          case 1: //Number of leads per month with chart                                
            $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
              ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date >=' => $date_from, 'Leads.allocation_date <=' => $date_to, 'Leads.is_archive' => 'No'])
            ; 
            
            //Get months covered between 2 dates
            $start    = (new \DateTime($date_from))->modify('first day of this month');
            $end      = (new \DateTime($date_to))->modify('first day of next month');
            $interval = \DateInterval::createFromDateString('1 month');
            $period   = new \DatePeriod($start, $interval, $end);
                       
            foreach ($period as $dt) {
                $start_day = $dt->format("Y-m-01");                
                $last_day  = date("Y-m-t", strtotime($dt->format("Y-m-01")));                
                $leads = $this->Leads->find('all')
                  ->select(['id', 'source_id', 'allocation_date'])    
                  ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date >=' => $start_day, 'Leads.allocation_date <=' => $last_day, 'Leads.is_archive' => 'No'])
                ;   
                $chart_labels[] = '"' . $dt->format("Y-M") . '"';
                $chart_data[]   = $leads->count();                
            }                        
            break;
          case 2: //Number of leads per week with chart​
            $begin = new \DateTime($date_from);
            $end   = new \DateTime($date_to);
            $week  = '';
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
              if( $week != $i->format("W") ){
                $chart_labels[] = '"' . "Week #" . $i->format("W") . '"';
                $week = $i->format("W");
              }
              $leads = $this->Leads->find('all')
                ->select(['id', 'source_id', 'allocation_date'])    
                ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date =' => $i->format("Y-m-d"), 'Leads.is_archive' => 'No'])
              ;                            
              $chart_data[$week] = $chart_data[$week] + $leads->count();
            }            
            break;
          case 3: //Number of leads per day with chart​
              $begin = new \DateTime($date_from);
              $end   = new \DateTime($date_to);

              for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $leads = $this->Leads->find('all')
                  ->select(['id', 'source_id', 'allocation_date'])    
                  ->where(['Leads.source_id IN' => $sources, 'Leads.allocation_date =' => $i->format("Y-m-d"), 'Leads.is_archive' => 'No'])
                ;
                $chart_labels[] = '"' . $i->format("Y-M-d") . '"';
                $chart_data[]   = $leads->count();
              }
            break;
          default:              
            break;
        }        
        if( $report_data['s3']['report-type'] == 'Excel' ){
          $excel_data = array();                    
          $excel_data[0] = ["", "Leads"];
          $start = 0;
          foreach( $chart_data as $key => $c ){
            if( isset($chart_labels[$start]) ){
              $date = str_replace('"',"",$chart_labels[$start]);
              $excel_data[$start+1] = [$date, $c];
            }            
            $start++;
          }

          $total_rows    = 1;
          foreach( $chart_data as $d ){              
              $total_rows++;
          }         
                    
          $objPHPExcel = new PHPExcel();
          $objWorksheet = $objPHPExcel->getActiveSheet();
          $objWorksheet->fromArray($excel_data);                      
          $excel_labels = array();
          $columns = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L'];                  
          
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
            new \PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$' . (count($chart_labels) + 1), null, 5),  //  Q1 to Q4
          );                
          
          //  Set the Data values for each data series we want to plot
          //    Datatype
          //    Cell reference for data
          //    Format Code
          //    Number of datapoints in series
          //    Data values
          //    Data Marker
          $excel_data_series_values = array();
          for( $x = 1; $x < $total_rows; $x++ ){
              $worksheet = "Worksheet!$" . $columns[$x + 1] . "$2:$" . $columns[$x + 1] . "$" . count($chart_labels);              
              $excel_data_series_values[] = new \PHPExcel_Chart_DataSeriesValues('Number', $worksheet, null, 5);
          }       
          $dataSeriesValues = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$' . (count($chart_labels) + 1), null, 1)        
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
          $title = new \PHPExcel_Chart_Title('Accumulated Leads Chart');
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
          $objWorksheet->addChart($chart);
          
          $fileName  = time() . "_" . rand(000000, 999999) . ".xlsx";
          $objWriter  = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->setIncludeCharts(TRUE);
          $objWriter->save('excel\leads\\' . $fileName);   
          $file_path = WWW_ROOT.'excel\leads\\' . $fileName;
            $this->response->file($file_path, array(
                'download' => true,
                'name' => $fileName,
            ));
          return $this->response;   
          exit;
        }else{          
          $this->set([
            'chart_labels' => $chart_labels,
            'chart_data' => $chart_data,
            'load_chart_js' => true
          ]);
        }
      }else{
        $this->Flash->error(__('Cannot generate report'));
        return $this->redirect(['action' => 'cumulative_step3']);
      }
    }

    public function generate_cumulative_chart_excel() {
      
    }
}
