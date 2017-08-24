<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Trainings Controller
 *
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

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');      

        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }elseif( $user_data->group_id == 2 ) { //User
              $this->Auth->allow(['users']);
            }elseif( $user_data->group_id == 3 ) { //Staff
              $this->Auth->allow(['users','register']);
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
                    if ($this->Trainings->save($training)) {
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
        $training = $this->Trainings->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $file = $this->request->data['filename'];           

            
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
