<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Allocations Controller
 *
 * @property \App\Model\Table\AllocationsTable $Allocations
 */
class AllocationsController extends AppController
{
    public $paginate = ['maxLimit' => 10, 'order' => ['Allocations.sort' => 'ASC']];

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
                $rights = $this->default_group_actions['allocations'];                
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
            $query       = $this->request->query['query'];
            $allocations = $this->Allocations->find('all')
                ->where( ['Allocations.name LIKE' => '%' . $query . '%'] );
        } else {
            $sort_direction = !empty($this->request->query['direction']) ? $this->request->query['direction'] : 'ASC';
            $sort_field     = !empty($this->request->query['sort']) ? $this->request->query['sort'] : 'ASC';

            if( !empty($this->request->query['direction']) && !empty($this->request->query['sort']) ) {
                $allocation_to_sort  = $this->Allocations->find('all', ['order' => ['Allocations.'.$sort_field => $sort_direction]]);
                $sort = 1;
                foreach($allocation_to_sort as $skey => $sd) {

                    $a_data = $this->Allocations->get($sd->id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->Allocations->patchEntity($a_data, $data_sort);
                    if ( !$this->Allocations->save($a_data) ) { echo "error unlocking lead"; }                    

                $sort++;
                }
            }

            $allocations = $this->Allocations->find('all', ['order' => ['Allocations.sort' => 'ASC']]);
        }          

        //$this->set('allocations', $this->paginate($allocations));
        $this->set('user_data', $user_data);
        $this->set('allocations', $allocations);
        $this->set('_serialize', ['allocations']);
    }

    /**
     * View method
     *
     * @param string|null $id Allocation id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $allocation = $this->Allocations->get($id, [
            'contain' => []
        ]);
        $this->set('allocation', $allocation);
        $this->set('_serialize', ['allocation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $allocation = $this->Allocations->newEntity();
        if ($this->request->is('post')) {
            $allocation = $this->Allocations->patchEntity($allocation, $this->request->data);
            if ($this->Allocations->save($allocation)) {
                $this->Flash->success(__('The allocation has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The allocation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('allocation'));
        $this->set('_serialize', ['allocation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Allocation id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $allocation = $this->Allocations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $allocation = $this->Allocations->patchEntity($allocation, $this->request->data);
            if ($this->Allocations->save($allocation)) {
                $this->Flash->success(__('The allocation has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The allocation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('allocation'));
        $this->set('_serialize', ['allocation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Allocation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $allocation = $this->Allocations->get($id);
        if ($this->Allocations->delete($allocation)) {
            $this->Flash->success(__('The allocation has been deleted.'));
        } else {
            $this->Flash->error(__('The allocation could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function _update_order_list()
    {
        $this->Allocations = TableRegistry::get('Allocations');   
        $ids = $_POST['ids'];

        if(!empty($ids)) {
            foreach($ids as $sort => $allocation_id) {

                if($allocation_id != '') {
                    $a_data = $this->Allocations->get($allocation_id, []);
                    $data_sort['sort'] = $sort;
                    $a_data = $this->Allocations->patchEntity($a_data, $data_sort);
                    if ( !$this->Allocations->save($a_data) ) { echo "error unlocking lead"; }                    
                }

            }
        }

        exit;
    }
}
