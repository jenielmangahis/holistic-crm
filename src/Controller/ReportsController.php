<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 */
class ReportsController extends AppController
{

    /**
     * initialize method
     *  ID : CA-01
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

      $option_logical_operators = ['=', '>', '>=', '<', '<=', '!=', 'LIKE', 'NOT LIKE'];
      $fields = ['Lead Name', 'Source', 'Allocation Date', 'Email', 'Phone', 'Address', 'Source URL', 'City', 'State'];
      $this->set([
          'option_logical_operators' => $option_logical_operators,
          'fields' => $fields,
          'optionSources' => $optionSources,
          'load_advance_search_script' => true
      ]);      
    }
}
