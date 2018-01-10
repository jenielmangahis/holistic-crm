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
class ArchivesController extends AppController
{

    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["archives"];
        $this->set('nav_selected', $nav_selected);

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');         
        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }/*else{                           
                $authorized_modules = array();     
                $rights = $this->default_group_actions['archives'];                
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
            }*/
        }         

        $this->user = $user_data;        
    }

    /**
     * Leads archive list method
     *
     * @return void
     */
    public function leads()
    {
      $this->Leads = TableRegistry::get('Leads');

      if( isset($this->request->query['query']) ){
          $query = trim($this->request->query['query']);
          $leads = $this->Leads->find('all')
              ->contain(['Statuses', 'Sources'])
              ->where(['Leads.is_archive' => $this->Leads->isArchive()])
              ->andWhere(['OR' => [
                'Leads.firstname LIKE' => '%' . $query . '%',
                'Leads.surname LIKE' => '%' . $query . '%',
                'Leads.email LIKE' => '%' . $query . '%'
              ]])
          ;
      }else{

          $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : '';
          $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : '';
          
          if( !isset($this->request->query['sort']) ){
            $this->paginate = ['order' => ['Leads.allocation_date' => 'DESC']];
            $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                ->where(['Leads.is_archive' => $this->Leads->isArchive()])
                
            ;
          }else{

            if($sort_field == 'source_id' || $sort_field == 'Leads.source_id') {
              $this->paginate = ['order' => ['Sources.name' => $sort_direction]];
            }
            
            $leads = $this->Leads->find('all')
                ->contain(['Statuses', 'Sources', 'LastModifiedBy'])
                ->where(['Leads.is_archive' => $this->Leads->isArchive()])                
            ;  
          }
          
      }

      $get = $_GET;
      if(isset($get['page'])) {
        $this->set('page', $get['page']);
      }      
        
      $this->set('is_admin_user', $this->user->group_id);
      $this->set('leads', $this->paginate($leads));
      $this->set('_serialize', ['leads', 'is_admin_user', 'page']);
    }

    /**
     * Restore Leads method
     *
     * @return void
     */
    public function restore_leads( $id = null )
    {
      $this->Leads = TableRegistry::get('Leads');

      $this->request->allowMethod(['post']);
      $lead = $this->Leads->get($id);
      $lead->is_archive = $this->Leads->isNotArchive();
      $this->Leads->save($lead);

      $this->Flash->success(__('The lead was successfully restored.'));      
      return $this->redirect(['action' => 'leads']);
    }
}
