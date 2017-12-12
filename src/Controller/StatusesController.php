<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Statuses Controller
 *
 * @property \App\Model\Table\StatusesTable $Statuses
 */
class StatusesController extends AppController
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
                $rights = $this->default_group_actions['status'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'add', 'edit', '_update_status_order'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'add', 'edit', 'delete', '_update_status_order'];
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

        $session   = $this->request->session();    
        $user_data = $session->read('User.data'); 

        if( isset( $this->request->query['query'] ) ) {
            $query   = $this->request->query['query'];
            $statuses = $this->Statuses->find('all')
                ->where( ['Statuses.name LIKE' => '%' . $query . '%'] );
        } else {

            $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : 'ASC';
            $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : 'ASC';            

            if( !empty($this->request->query['direction']) && !empty($this->request->query['sort']) ) {
                $statuses_to_sort  = $this->Statuses->find('all', ['order' => ['Statuses.'.$sort_field => $sort_direction]]);
                $sort = 1;
                foreach($statuses_to_sort as $skey => $sd) {

                    $a_data = $this->Statuses->get($sd->id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->Statuses->patchEntity($a_data, $data_sort);
                    if ( !$this->Statuses->save($a_data) ) { echo "error unlocking lead"; }                    

                $sort++;
                }
            }

            $statuses = $this->Statuses->find('all', ['order' => ['Statuses.sort' => 'ASC']]);
        }   

        $this->set('user_data', $user_data);
        if($user_data->group_id == 1) {
            $this->set('statuses', $this->paginate($statuses, ['limit' => 800]));
        } else {
            $this->set('statuses', $this->paginate($statuses));
        }
        $this->set('_serialize', ['statuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Status id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $status = $this->Statuses->get($id, [
            'contain' => []
        ]);
        $this->set('status', $status);
        $this->set('_serialize', ['status']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');
        $status = $this->Statuses->newEntity();
        if ($this->request->is('post')) {
            $status = $this->Statuses->patchEntity($status, $this->request->data);
            if ($this->Statuses->save($status)) {

                //Audit Trail - Start
                $audit_details = "";
                $audit_details .= "Added By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= "( " . $this->user->email . " )";
                $audit_details .= "<br />";
                $audit_details .= 'Status ID: ' . $status->id;  
                
                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Added New Status : ' . $status->name;
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

                $this->Flash->success(__('The status has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The status could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Status id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');
        $status = $this->Statuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $fields_changes = array();
            foreach ($data as $dkey => $lu) {
              if ($dkey != 'save') {
                if ($status->{$dkey} != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $status->{$dkey};
                    $fields_changes[$dkey]['new'] = $data[$dkey];
                }
              }
            }

            $status = $this->Statuses->patchEntity($status, $this->request->data);
            if ($this->Statuses->save($status)) {

                //Audit Trails - Start
                $audit_details = "";
                $audit_details .= "Updated By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= " (" . $this->user->email . ")";
                $audit_details .= "<br />";
                $audit_details .= 'Status ID: ' . $status->id;
                $audit_details .= "<hr />";
                $audit_details .= "<strong>Changes:</strong>" . "<br />";
                foreach($fields_changes as $fkey => $fd ) {
                  $audit_details .= $fkey . ": '" . $fd['old'] . "' to '" . $fd['new'] . "'";
                  $audit_details .= "<br />";
                }                

                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Updated Status : ' . $status->name;
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

                $this->Flash->success(__('The status has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The status could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Status id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Statuses->get($id);
        if ($this->Statuses->delete($status)) {
            $this->Flash->success(__('The status has been deleted.'));
        } else {
            $this->Flash->error(__('The status could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function _update_status_order()
    {
        $this->Statuses = TableRegistry::get('Statuses');   
        $ids = $_POST['ids'];

        if(!empty($ids)) {
            foreach($ids as $sort => $statuses_id) {
                if($statuses_id != '') {
                    $a_data = $this->Statuses->get($statuses_id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->Statuses->patchEntity($a_data, $data_sort);
                    if ( !$this->Statuses->save($a_data) ) { echo "error unlocking lead"; }                    
                }

            }
        }

        exit;
    }    
}
