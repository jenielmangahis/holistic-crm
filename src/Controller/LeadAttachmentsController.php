<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LeadAttachments Controller
 *
 * @property \App\Model\Table\LeadAttachmentsTable $LeadAttachments
 */
class LeadAttachmentsController extends AppController
{
    /**
     * initialize method
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["leads"];
        $this->set('nav_selected', $nav_selected);

        $session   = $this->request->session();    
        $user_data = $session->read('User.data');         
        if( isset($user_data) ){
            if( $user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
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
            'contain' => ['Leads']
        ];
        $this->set('leadAttachments', $this->paginate($this->LeadAttachments));
        $this->set('_serialize', ['leadAttachments']);
    }

    /**
     * View method
     *
     * @param string|null $id Lead Attachment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leadAttachment = $this->LeadAttachments->get($id, [
            'contain' => ['Leads']
        ]);
        $this->set('leadAttachment', $leadAttachment);
        $this->set('_serialize', ['leadAttachment']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leadAttachment = $this->LeadAttachments->newEntity();
        if ($this->request->is('post')) {
            $leadAttachment = $this->LeadAttachments->patchEntity($leadAttachment, $this->request->data);
            if ($this->LeadAttachments->save($leadAttachment)) {
                $this->Flash->success(__('The lead attachment has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The lead attachment could not be saved. Please, try again.'));
            }
        }
        $leads = $this->LeadAttachments->Leads->find('list', ['limit' => 200]);
        $this->set(compact('leadAttachment', 'leads'));
        $this->set('_serialize', ['leadAttachment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead Attachment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leadAttachment = $this->LeadAttachments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leadAttachment = $this->LeadAttachments->patchEntity($leadAttachment, $this->request->data);
            if ($this->LeadAttachments->save($leadAttachment)) {
                $this->Flash->success(__('The lead attachment has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The lead attachment could not be saved. Please, try again.'));
            }
        }
        $leads = $this->LeadAttachments->Leads->find('list', ['limit' => 200]);
        $this->set(compact('leadAttachment', 'leads'));
        $this->set('_serialize', ['leadAttachment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead Attachment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leadAttachment = $this->LeadAttachments->get($id);
        if ($this->LeadAttachments->delete($leadAttachment)) {
            $this->Flash->success(__('The lead attachment has been deleted.'));
        } else {
            $this->Flash->error(__('The lead attachment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Download Attachment method
     *
     * @param string|null $id Lead Attachment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function download_file($id = null)
    {
        $leadAttachment = $this->LeadAttachments->get($id, [
            'contain' => ['Leads']
        ]);
        $file = WWW_ROOT . $this->LeadAttachments->getFolderName() . $leadAttachment->lead_id . DS . $leadAttachment->attachment;
        //echo $file;exit;
        $this->response->file(
            $file, #Check $file['filename'] is full path of your download file
            [
               'download' => true,
               'name' => $leadAttachment->attachment
            ]
        );
        return $this->response;
    }
}
