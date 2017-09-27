<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LeadTypes Controller
 *
 * @property \App\Model\Table\LeadTypesTable $LeadTypes
 */
class LeadTypesController extends AppController
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
                $rights = $this->default_group_actions['lead_type'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'edit', 'add', '_update_lead_type_order'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'edit', 'delete', 'add', '_update_lead_type_order'];
                        break;        
                    default:            
                        break;
                }                
                $this->Auth->allow($authorized_modules);
            }
        }                 

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
            $LeadTypes = $this->LeadTypes->find('all')
                ->where( ['LeadTypes.name LIKE' => '%' . $query . '%'] );
        } else {

            $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : 'ASC';
            $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : 'ASC';            

            if( !empty($this->request->query['direction']) && !empty($this->request->query['sort']) ) {
                $lead_types_to_sort  = $this->LeadTypes->find('all', ['order' => ['LeadTypes.'.$sort_field => $sort_direction]]);
                $sort = 1;
                foreach($lead_types_to_sort as $skey => $sd) {

                    $a_data = $this->LeadTypes->get($sd->id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->LeadTypes->patchEntity($a_data, $data_sort);
                    if ( !$this->LeadTypes->save($a_data) ) { echo "error unlocking lead"; }                    

                $sort++;
                }
            }

            $LeadTypes = $this->LeadTypes->find('all', ['order' => ['LeadTypes.sort' => 'ASC']]);
        } 

        $this->set('user_data', $user_data);

        if($user_data->group_id == 1) {
            $this->set('leadTypes', $this->paginate($LeadTypes, ['limit' => 800]));
        } else {
            $this->set('leadTypes', $this->paginate($LeadTypes));
        }
        $this->set('_serialize', ['leadTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Lead Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leadType = $this->LeadTypes->get($id, [
            'contain' => []
        ]);
        $this->set('leadType', $leadType);
        $this->set('_serialize', ['leadType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leadType = $this->LeadTypes->newEntity();
        if ($this->request->is('post')) {
            $leadType = $this->LeadTypes->patchEntity($leadType, $this->request->data);
            if ($this->LeadTypes->save($leadType)) {
                $this->Flash->success(__('The lead type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The lead type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('leadType'));
        $this->set('_serialize', ['leadType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leadType = $this->LeadTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leadType = $this->LeadTypes->patchEntity($leadType, $this->request->data);
            if ($this->LeadTypes->save($leadType)) {
                $this->Flash->success(__('The lead type has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The lead type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('leadType'));
        $this->set('_serialize', ['leadType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leadType = $this->LeadTypes->get($id);
        if ($this->LeadTypes->delete($leadType)) {
            $this->Flash->success(__('The lead type has been deleted.'));
        } else {
            $this->Flash->error(__('The lead type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function _update_lead_type_order()
    {
        $this->LeadTypes = TableRegistry::get('LeadTypes');   
        $ids = $_POST['ids'];

        if(!empty($ids)) {
            foreach($ids as $sort => $lead_type_id) {
                if($lead_type_id != '') {
                    $a_data = $this->LeadTypes->get($lead_type_id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->LeadTypes->patchEntity($a_data, $data_sort);
                    if ( !$this->LeadTypes->save($a_data) ) { echo "error unlocking lead"; }                    
                }

            }
        }

        exit;
    } 

}
