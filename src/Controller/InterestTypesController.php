<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * InterestTypes Controller
 *
 * @property \App\Model\Table\InterestTypesTable $InterestTypes
 */
class InterestTypesController extends AppController
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
                $rights = $this->default_group_actions['interest_type'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'edit', 'add', '_update_interest_type'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'edit', 'delete', 'add', '_update_interest_type'];
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
            $InterestTypes = $this->InterestTypes->find('all')
                ->where( ['InterestTypes.name LIKE' => '%' . $query . '%'] )                
            ;
        } else {

            $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : 'ASC';
            $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : 'ASC';            

            if( !empty($this->request->query['direction']) && !empty($this->request->query['sort']) ) {
                $interest_types_to_sort  = $this->InterestTypes->find('all', ['order' => ['InterestTypes.'.$sort_field => $sort_direction]]);
                $sort = 1;
                foreach($interest_types_to_sort as $skey => $sd) {

                    $a_data = $this->InterestTypes->get($sd->id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->InterestTypes->patchEntity($a_data, $data_sort);
                    if ( !$this->InterestTypes->save($a_data) ) { echo "error unlocking lead"; }                    

                $sort++;
                }
            }

            $InterestTypes = $this->InterestTypes->find('all', ['order' => ['InterestTypes.sort' => 'ASC']]);
        }

        $this->set('user_data', $user_data);
        if($user_data->group_id == 1) {
            $this->set('interestTypes', $this->paginate($InterestTypes, ['limit' => 800]));   
        } else {
            $this->set('interestTypes', $this->paginate($InterestTypes));    
        }
        $this->set('_serialize', ['interestTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Interest Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $interestType = $this->InterestTypes->get($id, [
            'contain' => ['Leads']
        ]);
        $this->set('interestType', $interestType);
        $this->set('_serialize', ['interestType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');

        $interestType = $this->InterestTypes->newEntity();
        if ($this->request->is('post')) {
            $interestType = $this->InterestTypes->patchEntity($interestType, $this->request->data);
            if ($newInterestType = $this->InterestTypes->save($interestType)) {

                $audit_details = "";
                $audit_details .= "Added By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= "( " . $this->user->email . " )";
                $audit_details .= "<br />";
                $audit_details .= 'Interest Type ID: ' . $newInterestType->id;

                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Added Interest Type : ' . $newInterestType->name;
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = $audit_details;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }

                $this->Flash->success(__('The interest type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The interest type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('interestType'));
        $this->set('_serialize', ['interestType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Interest Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');

        $interestType = $this->InterestTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data     = $this->request->data;   
            $fields_changes = array();
            foreach ($data as $dkey => $lu) {
              if ($dkey != 'save') {
                if ($interestType->{$dkey} != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $interestType->{$dkey};
                    $fields_changes[$dkey]['new'] = $data[$dkey];
                }
              }
            }

            $interestType = $this->InterestTypes->patchEntity($interestType, $this->request->data);
            if ($this->InterestTypes->save($interestType)) {

                $audit_details = "";
                $audit_details .= "Updated By: " . $this->user->firstname . ' ' . $this->user->lastname;
                $audit_details .= " (" . $this->user->email . ")";
                $audit_details .= "<br />";
                $audit_details .= 'Interest Type ID: ' . $interestType->id;
                $audit_details .= "<hr />";
                $audit_details .= "<strong>Changes:</strong>" . "<br />";
                foreach($fields_changes as $fkey => $fd ) {
                  $audit_details .= $fkey . ": '" . $fd['old'] . "' to '" . $fd['new'] . "'";
                  $audit_details .= "<br />";
                }                  

                $audit_data['user_id']      = $this->user->id;
                $audit_data['action']       = 'Updated Interest Type : ' . $interestType->name;
                $audit_data['event_status'] = 'Success';
                $audit_data['details']      = $audit_details;
                $audit_data['audit_date']   = date("Y-m-d h:i:s");
                $audit_data['ip_address']   = getRealIPAddress();

                $auditTrail = $this->AuditTrails->newEntity();
                $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                if (!$this->AuditTrails->save($auditTrail)) {
                  echo 'Error updating audit trails'; exit;
                }

                $this->Flash->success(__('The interest type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The interest type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('interestType'));
        $this->set('_serialize', ['interestType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Interest Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $interestType = $this->InterestTypes->get($id);
        if ($this->InterestTypes->delete($interestType)) {
            $this->Flash->success(__('The interest type has been deleted.'));
        } else {
            $this->Flash->error(__('The interest type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function _update_interest_type()
    {
        $this->InterestTypes = TableRegistry::get('InterestTypes');   
        $ids = $_POST['ids'];

        if(!empty($ids)) {
            foreach($ids as $sort => $interest_type_id) {
                if($interest_type_id != '') {
                    $a_data = $this->InterestTypes->get($interest_type_id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->InterestTypes->patchEntity($a_data, $data_sort);
                    if ( !$this->InterestTypes->save($a_data) ) { echo "error unlocking lead"; }                    
                }

            }
        }

        exit;
    }     
}
