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
                $this->Auth->allow($authorized_modules);
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

      $optionInformation = [
        //1 => "How many leads we've received (total)",
        2 => "How many leads we've received in specific date range",
        3 => "How many leads are currently open/engaged?",
        4 => "How many leads are closed/sold",
        5 => "How many leads are dead/spam?",
        6 => "How many leads came through the website (all source forms)?",
        7 => "How many leads came through a specific form",
        8 => "How many leads came through the telephone"
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
        'sources' => $sources
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
        'report_data' => $report_data['s3']
      ]);
    }

    public function generate_leads_report()
    {
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
                  $excelFields[] = $l->lead_type->name;
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
                'leads' => $leads,
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
                foreach( $data['search'] as $key => $value ){
                  if($key == 'date_created' ){                   
                    //$query_builder[] = ['DATE_FORMAT(Leads.created, "%Y-%m-%d") >=' => $value['value']['from'], 'DATE_FORMAT(Leads.created, "%Y-%m-%d") <=' => $value['value']['to']];
                    if( $value['value']['from'] != '' && $value['value']['to'] != '' ){
                      $query_builder[] = ['Leads.created >=' => $value['value']['from'], 'Leads.created <=' => $value['value']['to']];
                    }
                  }else{
                    $operator    = trim($value['operator']);
                    $query_value = trim($value['value']);
                    if($operator != '' && $query_value != ''){           
                        switch ($key) {
                          case 'source':                                                                    
                            if( $operator == 'LIKE' ){                                
                                $query_builder[] = ['Source.name ' . $operator . " '%" . $query_value . "%'"];
                            }else{
                                $query_builder[] = ['Leads.source_id ' . $operator => $query_value];
                            }                            
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
                    ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
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
                  $excelFields[] = $l->lead_type->name;
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
              $or_query_builder = array();              
              foreach( $data['search'] as $key => $value ){
                if($key == 'date_created' ){                   
                  //$query_builder[] = ['DATE_FORMAT(Leads.created, "%Y-%m-%d") >=' => $value['value']['from'], 'DATE_FORMAT(Leads.created, "%Y-%m-%d") <=' => $value['value']['to']];
                  if( $value['value']['from'] != '' && $value['value']['to'] != '' ){
                    $query_builder[] = ['Leads.created >=' => $value['value']['from'], 'Leads.created <=' => $value['value']['to']];
                  }                   
                }else{
                  $operator    = trim($value['operator']);
                  $query_value = trim($value['value']);
                  if($operator != '' && $query_value != ''){           
                      switch ($key) {
                        
                        case 'source':                                                                    
                          if( $operator == 'LIKE' ){                                
                              $query_builder[] = ['Source.name ' . $operator . " '%" . $query_value . "%'"];
                          }else{
                              $query_builder[] = ['Leads.source_id ' . $operator => $query_value];
                          }                            
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
                  ->contain(['Statuses', 'Sources', 'InterestTypes', 'LeadTypes'])
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

}
