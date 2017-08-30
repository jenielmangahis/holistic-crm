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
            $InterestTypes = $this->InterestTypes->find('all', ['order' => ['InterestTypes.sort' => 'ASC']]);
        }

        $this->set('user_data', $user_data);
        if($user_data->group_id == 1) {
            $this->set('interestTypes', $InterestTypes);
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
        $interestType = $this->InterestTypes->newEntity();
        if ($this->request->is('post')) {
            $interestType = $this->InterestTypes->patchEntity($interestType, $this->request->data);
            if ($this->InterestTypes->save($interestType)) {
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
        $interestType = $this->InterestTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $interestType = $this->InterestTypes->patchEntity($interestType, $this->request->data);
            if ($this->InterestTypes->save($interestType)) {
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
