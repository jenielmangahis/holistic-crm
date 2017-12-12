<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Sources Controller
 *
 * @property \App\Model\Table\SourcesTable $Sources
 */
class SourcesController extends AppController
{
    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["system_settings"];
        $this->set('nav_selected', $nav_selected);

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');         
        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{                          
                $authorized_modules = array();     
                $rights = $this->default_group_actions['sources'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'edit', 'add'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'edit', 'delete', 'add'];
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
        $this->unlock_lead_check();
        if( isset( $this->request->query['query'] ) ) {

            $query   = $this->request->query['query'];
            $sources = $this->Sources->find('all')                
                ->where( ['Sources.name LIKE' => '%' . $query . '%'] );

        } else {
            $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : 'ASC';
            $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : 'ASC';            

            if( !empty($this->request->query['direction']) && !empty($this->request->query['sort']) ) {
                //$sources_to_sort  = $this->Sources->find('all', ['order' => ['Sources.'.$sort_field => $sort_direction]]);
                $sources_to_sort  = $this->Sources->find('all', ['order' => [$sort_field => $sort_direction]]);
                $sort = 1;
                foreach($sources_to_sort as $skey => $sd) {

                    $a_data = $this->Sources->get($sd->id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->Sources->patchEntity($a_data, $data_sort);
                    if ( !$this->Sources->save($a_data) ) { echo "error unlocking lead"; }                    

                $sort++;
                }
            }

            $sources = $this->Sources->find('all', ['order' => ['Sources.sort' => 'ASC']]);
        }     

        $this->set('sources', $this->paginate($sources));
        $this->set('_serialize', ['sources']);
    }    

    /**
     * View method
     *
     * @param string|null $id Source id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $source = $this->Sources->get($id, [
            'contain' => []
        ]);
        $this->set('source', $source);
        $this->set('_serialize', ['source']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');
        $source = $this->Sources->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;      
            //debug($data);
            $data['emails'] = str_replace(",", ";", $this->request->data['emails']);             
            $source = $this->Sources->patchEntity($source, $data);           
            if ($newSource = $this->Sources->save($source)) {

                //Audit Trail - Start
                $audit_details = "";
                $audit_details .= "Added By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= "( " . $this->user->email . " )";
                $audit_details .= "<br />";
                $audit_details .= 'Source ID: ' . $newSource->id;  
                
                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Added New Source : ' . $source->name;
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = $audit_details;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }
                //Audit Trail - End

                $this->Flash->success(__('The source has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The source could not be saved. Please, try again.'));
            }
        }

        $this->set('enable_tags_input', true);
        $this->set(compact('source'));
        $this->set('_serialize', ['source']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Source id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');
        $source = $this->Sources->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;      
            $data['emails'] = str_replace(",", ";", $this->request->data['emails']);              

            $fields_changes = array();
            foreach ($data as $dkey => $lu) {
              if ($dkey != 'save') {
                if ($source->{$dkey} != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $source->{$dkey};
                    $fields_changes[$dkey]['new'] = $data[$dkey];
                }
              }
            }

            $source = $this->Sources->patchEntity($source, $data);

            if ($this->Sources->save($source)) {

                //Audit Trails - Start
                $audit_details = "";
                $audit_details .= "Updated By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= " (" . $this->user->email . ")";
                $audit_details .= "<br />";
                $audit_details .= 'Source ID: ' . $source->id;
                $audit_details .= "<hr />";
                $audit_details .= "<strong>Changes:</strong>" . "<br />";
                foreach($fields_changes as $fkey => $fd ) {
                  $audit_details .= $fkey . ": '" . $fd['old'] . "' to '" . $fd['new'] . "'";
                  $audit_details .= "<br />";
                }                

                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Updated Source : ' . $source->name;
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = $audit_details;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }
                //Audit Trails - End

                $this->Flash->success(__('The source has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The source could not be saved. Please, try again.'));
            }
        }

        //$allocations = $this->Sources->Allocations->find('list', ['order' => ['Allocations.sort' => 'ASC']]);

        $this->set('enable_tags_input', true);
        $this->set(compact('source'));
        $this->set('_serialize', ['source']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Source id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $source = $this->Sources->get($id);
        if ($this->Sources->delete($source)) {
            $this->Flash->success(__('The source has been deleted.'));
        } else {
            $this->Flash->error(__('The source could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
