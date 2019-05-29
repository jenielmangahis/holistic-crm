<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LeadEmailAttachments Controller
 *
 * @property \App\Model\Table\LeadEmailAttachmentsTable $LeadEmailAttachments
 */
class LeadEmailAttachmentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['LeadEmailMessages']
        ];
        $this->set('leadEmailAttachments', $this->paginate($this->LeadEmailAttachments));
        $this->set('_serialize', ['leadEmailAttachments']);
    }

    /**
     * View method
     *
     * @param string|null $id Lead Email Attachment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leadEmailAttachment = $this->LeadEmailAttachments->get($id, [
            'contain' => ['LeadEmailMessages']
        ]);
        $this->set('leadEmailAttachment', $leadEmailAttachment);
        $this->set('_serialize', ['leadEmailAttachment']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leadEmailAttachment = $this->LeadEmailAttachments->newEntity();
        if ($this->request->is('post')) {
            $leadEmailAttachment = $this->LeadEmailAttachments->patchEntity($leadEmailAttachment, $this->request->data);
            if ($this->LeadEmailAttachments->save($leadEmailAttachment)) {
                $this->Flash->success(__('The lead email attachment has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The lead email attachment could not be saved. Please, try again.'));
            }
        }
        $leadEmailMessages = $this->LeadEmailAttachments->LeadEmailMessages->find('list', ['limit' => 200]);
        $this->set(compact('leadEmailAttachment', 'leadEmailMessages'));
        $this->set('_serialize', ['leadEmailAttachment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead Email Attachment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leadEmailAttachment = $this->LeadEmailAttachments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leadEmailAttachment = $this->LeadEmailAttachments->patchEntity($leadEmailAttachment, $this->request->data);
            if ($this->LeadEmailAttachments->save($leadEmailAttachment)) {
                $this->Flash->success(__('The lead email attachment has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The lead email attachment could not be saved. Please, try again.'));
            }
        }
        $leadEmailMessages = $this->LeadEmailAttachments->LeadEmailMessages->find('list', ['limit' => 200]);
        $this->set(compact('leadEmailAttachment', 'leadEmailMessages'));
        $this->set('_serialize', ['leadEmailAttachment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead Email Attachment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leadEmailAttachment = $this->LeadEmailAttachments->get($id);
        if ($this->LeadEmailAttachments->delete($leadEmailAttachment)) {
            $this->Flash->success(__('The lead email attachment has been deleted.'));
        } else {
            $this->Flash->error(__('The lead email attachment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
