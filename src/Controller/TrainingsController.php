<?php
namespace App\Controller;

use App\Controller\AppController; 
use Cake\ORM\TableRegistry; 
use Cake\Filesystem\Folder; 
use Cake\Filesystem\File; 

/**
 * Trainings Controller
 * ID
 * @property \App\Model\Table\TrainingsTable $Trainings
 */
class TrainingsController extends AppController
{
    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["trainings"];
        $this->set('nav_selected', $nav_selected);

        $session    = $this->request->session();    
        $user_data  = $session->read('User.data');      
        $this->user = $user_data;        

        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }else{                           
                $authorized_modules = array();     
                $rights = $this->default_group_actions['training'];                
                switch ($rights) {
                    case 'View Only':
                        $authorized_modules = ['index', 'view', 'users'];
                        break;
                    case 'View and Edit':
                        $authorized_modules = ['index', 'view', 'users', 'add', 'edit'];
                        break;
                    case 'View, Edit and Delete':
                        $authorized_modules = ['index', 'view', 'users', 'add', 'edit', 'delete'];
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
        if( isset($this->request->query['query']) ){
            $query = $this->request->query['query'];
            $training_data = $this->Trainings->find('all')
                ->contain([])
                ->where(['Trainings.title LIKE' => '%' . $query . '%'])       
                ->orWhere(['Trainings.filename LIKE' => '%' . $query . '%'])       
            ;
            $this->set('trainings', $this->paginate($training_data));
        }else{
            $this->set('trainings', $this->paginate($this->Trainings));
        }


        $this->set('_serialize', ['trainings']);
    }

    /**
     * Users method
     *
     * @return void
     */
    public function users()
    {
        if( isset($this->request->query['query']) ){
            $query = $this->request->query['query'];
            $training_data = $this->Trainings->find('all')
                ->contain([])
                ->where(['Trainings.title LIKE' => '%' . $query . '%'])       
                ->orWhere(['Trainings.filename LIKE' => '%' . $query . '%'])       
            ;
            $this->set('trainings', $this->paginate($training_data));
        }else{
            $this->set('trainings', $this->paginate($this->Trainings));
        }

        $this->set('_serialize', ['trainings']);
    }

    /**
     * View method
     *
     * @param string|null $id Training id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $training = $this->Trainings->get($id, [
            'contain' => []
        ]);
        $this->set('training', $training);
        $this->set('_serialize', ['training']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');

        $training = $this->Trainings->newEntity();
        if ($this->request->is('post')) {

            $file = $this->request->data['filename'];           

            if($file['name'] != '' && $file['error'] == 0) {

                $ext  = substr(strtolower(strrchr($file['name'], '.')), 1); 
                $arr_ext        = array('jpg', 'jpeg', 'gif', 'exe');
                $setNewFileName = time() . "_" . rand(000000, 999999);

                if (!in_array($ext, $arr_ext)) { 
                    $directory_name = WWW_ROOT . '/upload/trainings/';
                    if(!is_dir($directory_name)){                                           
                        mkdir($directory_name, 755, true);
                    }          

                    move_uploaded_file($file['tmp_name'], WWW_ROOT . '/upload/trainings/' . $setNewFileName . '.' . $ext);                        
                    chmod(WWW_ROOT . '/upload/trainings/' . $setNewFileName . '.' . $ext, 0755);   

                    $imageFileName = $setNewFileName . '.' . $ext;

                    $request_data['title']       = $this->request->data['title'];  
                    $request_data['filename']    = $imageFileName;  
                    $request_data['anchor_text'] = $this->request->data['anchor_text'];  
                    $request_data['video_url']   = $this->request->data['video_url'];  

                    $training = $this->Trainings->patchEntity($training, $request_data);
                    if ( $newTraining = $this->Trainings->save($training)) {

                        $audit_details = "";
                        $audit_details .= "Added By: " . $this->user->firstname . ' ' . $this->user->lastname;
                        $audit_details .= "( " . $this->user->email . " )";
                        $audit_details .= "<br />";
                        $audit_details .= 'Training ID: ' . $newTraining->id;

                        $audit_data['user_id']      = $this->user->id;
                        $audit_data['action']       = 'Added Training : ' . $newTraining->title;
                        $audit_data['event_status'] = 'Success';
                        $audit_data['details']      = $audit_details;
                        $audit_data['audit_date']   = date("Y-m-d h:i:s");
                        $audit_data['ip_address']   = getRealIPAddress();

                        $auditTrail = $this->AuditTrails->newEntity();
                        $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                        if (!$this->AuditTrails->save($auditTrail)) {
                          echo 'Error updating audit trails'; exit;
                        }

                        $this->Flash->success(__('The training has been saved.'));
                        $action = $this->request->data['save'];
                        if( $action == 'save' ){
                            return $this->redirect(['action' => 'index']);
                        }else{
                            return $this->redirect(['action' => 'add']);
                        }                    
                    } else {
                        $this->Flash->error(__('The training could not be saved. Please, try again.'));
                    }
                    
                } else {
                    $this->Flash->error(__('The training could not be saved. File extension not allowed.'));                
                } 

            }           

        }
        $this->set(compact('training'));
        $this->set('_serialize', ['training']);
    }   

    /**
     * Edit method
     *
     * @param string|null $id Training id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->AuditTrails = TableRegistry::get('AuditTrails');

        $training = $this->Trainings->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $file = $this->request->data['filename'];   

            $ext  = substr(strtolower(strrchr($file['name'], '.')), 1); 
            $arr_ext        = array('jpg', 'jpeg', 'gif', 'exe');
            $setNewFileName = time() . "_" . rand(000000, 999999);        

            $data     = $this->request->data;   
            $fields_changes = array();
            foreach ($data as $dkey => $lu) {
              if ($dkey != 'save') {                
                if ($training->{$dkey} != $data[$dkey]) {
                    $fields_changes[$dkey]['old'] = $training->{$dkey};
                    if( $dkey == 'filename' ){                        
                        $fields_changes[$dkey]['new'] = $setNewFileName . '.' . $ext;
                    }else{
                        $fields_changes[$dkey]['new'] = $data[$dkey];
                    }                       
                }
              }
            }

            if (!in_array($ext, $arr_ext)) { 
                $directory_name = WWW_ROOT . '/upload/trainings/';
                if(!is_dir($directory_name)){                                           
                    mkdir($directory_name, 755, true);
                }          

                move_uploaded_file($file['tmp_name'], WWW_ROOT . '/upload/trainings/' . $setNewFileName . '.' . $ext);                        
                chmod(WWW_ROOT . '/upload/trainings/' . $setNewFileName . '.' . $ext, 0755);   

                $imageFileName = $setNewFileName . '.' . $ext;

                $request_data['title'] = $this->request->data['title'];

                if($file['name'] == '' || $file['error'] == 4) {
                    $request_data['filename'] = $training->filename;  
                } else {
                    $request_data['filename'] = $imageFileName;      
                }

                $request_data['anchor_text'] = $this->request->data['anchor_text'];  
                $request_data['video_url']   = $this->request->data['video_url'];                  
                
                $training = $this->Trainings->patchEntity($training, $request_data);
                if ($this->Trainings->save($training)) {

                    $audit_details = "";
                    $audit_details .= "Updated By: " . $this->user->firstname . ' ' . $this->user->lastname;
                    $audit_details .= " (" . $this->user->email . ")";
                    $audit_details .= "<br />";
                    $audit_details .= 'Training ID: ' . $training->id;
                    $audit_details .= "<hr />";
                    $audit_details .= "<strong>Changes:</strong>" . "<br />";
                    foreach($fields_changes as $fkey => $fd ) {
                      $audit_details .= $fkey . ": '" . $fd['old'] . "' to '" . $fd['new'] . "'";
                      $audit_details .= "<br />";
                    }                  

                    $audit_data['user_id']      = $this->user->id;
                    $audit_data['action']       = 'Updated Training : ' . $training->title;
                    $audit_data['event_status'] = 'Success';
                    $audit_data['details']      = $audit_details;
                    $audit_data['audit_date']   = date("Y-m-d h:i:s");
                    $audit_data['ip_address']   = getRealIPAddress();

                    $auditTrail = $this->AuditTrails->newEntity();
                    $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $audit_data);
                    if (!$this->AuditTrails->save($auditTrail)) {
                      echo 'Error updating audit trails'; exit;
                    }

                    $this->Flash->success(__('The training has been saved.'));
                    $action = $this->request->data['save'];
                    if( $action == 'save' ){
                        return $this->redirect(['action' => 'index']);
                    }else{
                        return $this->redirect(['action' => 'edit', $id]);
                    }         
                } else {
                    $this->Flash->error(__('The training could not be saved. Please, try again.'));
                }
                                
            } else {
                $this->Flash->error(__('The training could not be saved. File extension not allowed.'));                
            } 

        }
        $this->set(compact('training'));
        $this->set('_serialize', ['training']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Training id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $training = $this->Trainings->get($id);
        if ($this->Trainings->delete($training)) {
            $this->Flash->success(__('The training has been deleted.'));
        } else {
            $this->Flash->error(__('The training could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
