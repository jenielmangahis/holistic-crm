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
     * Leads method
     *
     * @return void
     */
    public function leads()
    { 
      $this->Sources = TableRegistry::get('Sources');

      $sources = $this->Sources->find('all');
      $optionSources = array();

      foreach($sources as $s){
        $optionSources[$s->id] = $s->name;
      }

      $option_logical_operators = ['=', '!=', 'LIKE'];
      $fields = ['firstname' => 'First Name', 'surname' => 'Surname', 'source_id' => 'Source', 'email' => 'Email', 'phone' => 'Phone', 'address' => 'Adddress', 'lead_action' => 'Lead Action', 'city' => 'City', 'state' => 'State' , 'allocation_date' => 'Allocation Date'];
      $this->set([
          'option_logical_operators' => $option_logical_operators,
          'fields' => $fields,
          'optionSources' => $optionSources,
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
      $query = "";
      $artikel = array();        
      if( isset($this->request->data) ){
          $sql_fields = array();
          $data = $this->request->data;    

          foreach($data['fields'] as $key => $value){
            $sql_fields[] = $key;
          }

          if( isset($data['filter-leads-report']) ){
              $query_builder = array();
              $or_query_builder = array();              
              foreach( $data['search'] as $key => $value ){
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

              $leads = $this->Leads->find('all')                  
                  ->contain(['Statuses', 'Sources'])
                  ->where($query_builder)                   
                  ->order(['Leads.firstname' => 'ASC'])                                 
              ;
          }else{
            //Select all
            $leads = $this->Leads->find('all')                
                ->contain(['Statuses', 'Sources'])                
                ->order(['Leads.firstname' => 'ASC'])                                 
            ;
          }

          //Fields          
          $fields = $data['fields'];
          $total_fields = count($fields) + 2;
          $eColumns = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J'];

          $excel_cell_values = array();          
          foreach( $leads as $l ){            
            $excelFields = array();
            foreach( $fields as $key => $value ){              
              if( $key == 'source_id' ){
                $excelFields[] = $l->source->name;
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

          //debug($leads);exit;
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
    }


}
