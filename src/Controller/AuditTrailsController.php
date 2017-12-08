<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AuditTrails Controller
 *
 * @property \App\Model\Table\AuditTrailsTable $AuditTrails
 */
class AuditTrailsController extends AppController
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

        $session = $this->request->session();    
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
        $this->paginate = [
            'contain' => ['Users'],
        ];        
        $this->set('auditTrails', $this->paginate($this->AuditTrails));
        $this->set('_serialize', ['auditTrails']);
    }

    /**
     * View method
     *
     * @param string|null $id Audit Trail id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditTrail = $this->AuditTrails->get($id, [
            'contain' => []
        ]);
        $this->set('auditTrail', $auditTrail);
        $this->set('_serialize', ['auditTrail']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditTrail = $this->AuditTrails->newEntity();
        if ($this->request->is('post')) {
            $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $this->request->data);
            if ($this->AuditTrails->save($auditTrail)) {
                $this->Flash->success(__('The audit trail has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
            }
        }

        $users = $this->AuditTrails->Users->find('list', ['limit' => 200]);
        $this->set(compact('auditTrail', 'users'));
        $this->set('_serialize', ['auditTrail']);
    }   

    /**
     * Edit method
     *
     * @param string|null $id Audit Trail id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditTrail = $this->AuditTrails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $this->request->data);
            if ($this->AuditTrails->save($auditTrail)) {
                $this->Flash->success(__('The audit trail has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('auditTrail'));
        $this->set('_serialize', ['auditTrail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditTrail = $this->AuditTrails->get($id);
        if ($this->AuditTrails->delete($auditTrail)) {
            $this->Flash->success(__('The audit trail has been deleted.'));
        } else {
            $this->Flash->error(__('The audit trail could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getRealIPAddress() {

      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

        $ip=$_SERVER['HTTP_CLIENT_IP'];

      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

      } else {

        $ip=$_SERVER['REMOTE_ADDR'];
        
      }
      return $ip;
    }
}
