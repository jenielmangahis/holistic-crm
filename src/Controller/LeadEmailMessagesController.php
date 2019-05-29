<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;

/**
 * LeadEmailMessages Controller
 *
 * @property \App\Model\Table\LeadEmailMessagesTable $LeadEmailMessages
 */
class LeadEmailMessagesController extends AppController
{
    /**
     * initialize method
     *  ID : CA-01
     * 
     */
    public function initialize()
    {
        parent::initialize();
        $nav_selected = ["leads"];
        $this->set('nav_selected', $nav_selected);

        $session   = $this->request->session();    
        $this->user_data = $session->read('User.data');         
        if( isset($this->user_data) ){
            if( $this->user_data->group_id == 1 ){ //Admin
              $this->Auth->allow();
            }
        }         
        
        $this->Auth->allow(['register']);

    }

    /**
     * Index method
     *  ID : CA-02
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Leads']
        ];
        $this->set('leadEmailMessages', $this->paginate($this->LeadEmailMessages));
        $this->set('_serialize', ['leadEmailMessages']);
    }

    /**
     * View method
     *  ID : CA-03
     *
     * @param string|null $id Lead Email Message id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leadEmailMessage = $this->LeadEmailMessages->get($id, [
            'contain' => ['Users', 'Leads']
        ]);
        $this->set('leadEmailMessage', $leadEmailMessage);
        $this->set('_serialize', ['leadEmailMessage']);
    }

    /**
     * Add method
     *  ID : CA-04
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leadEmailMessage = $this->LeadEmailMessages->newEntity();
        if ($this->request->is('post')) {
            $leadEmailMessage = $this->LeadEmailMessages->patchEntity($leadEmailMessage, $this->request->data);
            if ($this->LeadEmailMessages->save($leadEmailMessage)) {
                $this->Flash->success(__('The lead email message has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'add']);
                }                    
            } else {
                $this->Flash->error(__('The lead email message could not be saved. Please, try again.'));
            }
        }
        $users = $this->LeadEmailMessages->Users->find('list', ['limit' => 200]);
        $leads = $this->LeadEmailMessages->Leads->find('list', ['limit' => 200]);
        $this->set(compact('leadEmailMessage', 'users', 'leads'));
        $this->set('_serialize', ['leadEmailMessage']);
    }

    /**
     * Edit method
     *  ID : CA-05
     *
     * @param string|null $id Lead Email Message id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leadEmailMessage = $this->LeadEmailMessages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leadEmailMessage = $this->LeadEmailMessages->patchEntity($leadEmailMessage, $this->request->data);
            if ($this->LeadEmailMessages->save($leadEmailMessage)) {
                $this->Flash->success(__('The lead email message has been saved.'));
                $action = $this->request->data['save'];
                if( $action == 'save' ){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'edit', $id]);
                }         
            } else {
                $this->Flash->error(__('The lead email message could not be saved. Please, try again.'));
            }
        }
        $users = $this->LeadEmailMessages->Users->find('list', ['limit' => 200]);
        $leads = $this->LeadEmailMessages->Leads->find('list', ['limit' => 200]);
        $this->set(compact('leadEmailMessage', 'users', 'leads'));
        $this->set('_serialize', ['leadEmailMessage']);
    }

    /**
     * Delete method
     *  ID : CA-06
     *
     * @param string|null $id Lead Email Message id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leadEmailMessage = $this->LeadEmailMessages->get($id);
        if ($this->LeadEmailMessages->delete($leadEmailMessage)) {
            $this->Flash->success(__('The lead email message has been deleted.'));
        } else {
            $this->Flash->error(__('The lead email message could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Leads List method
     *  ID : CA-07
     *
     * @param string|null $id Lead id.
     * @return \Cake\Network\Response|null Redirects to index.
     */
    public function list($id = null )
    {
        $this->Leads = TableRegistry::get('Leads');

        $lead = $this->Leads->find()
            ->where(['Leads.id' => $id])
            ->first()
        ;

        if( $lead ){
            $leadEmails = $this->LeadEmailMessages->find('all')
                ->contain(['Leads', 'Users'])
                ->where(['LeadEmailMessages.lead_id' => $id])
                ->order(['LeadEmailMessages.date' => 'DESC'])
            ;
            
            $this->set(['lead' => $lead]);
            $this->set('leadEmailMessages', $this->paginate($leadEmails));
        }else{
            $this->Flash->error(__('The lead could not be found'));
            return $this->redirect(['controller' => 'leads', 'action' => 'index']);  
        }
    }

    /**
     * Send Email method
     *  ID : CA-08
     *
     * @param string|null $id Lead id.
     * @return \Cake\Network\Response|null Redirects to index.
     */
    public function send_email($id = null )
    {
        $this->Leads = TableRegistry::get('Leads');

        $leadEmailMessage = $this->LeadEmailMessages->newEntity();

        $lead = $this->Leads->find()
            ->where(['Leads.id' => $id])
            ->first()
        ;

        if( $lead ){
            $leadEmails = $this->LeadEmailMessages->find('all')
                ->contain(['Leads', 'Users'])
                ->where(['LeadEmailMessages.lead_id' => $id])
                ->order(['LeadEmailMessages.date' => 'DESC'])
            ;

            $this->set(['lead' => $lead, 'leadEmailMessage' => $leadEmailMessage]);
            $this->set('leadEmailMessages', $this->paginate($leadEmails));
        }else{
            $this->Flash->error(__('The lead could not be found'));
            return $this->redirect(['controller' => 'leads', 'action' => 'index']);  
        }
    }

    public function post_send_mail()
    {
        $this->LeadEmailAttachments = TableRegistry::get('LeadEmailAttachments');
        $this->Leads = TableRegistry::get('Leads');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $lead = $this->Leads->find()
                ->where(['Leads.id' => $this->request->data['lead_id']])
                ->first()
            ;

            if( $lead ){
                $data_email = [
                    'user_id' => $this->user_data->id,
                    'lead_id' => $this->request->data['lead_id'],
                    'recipient' => $lead->email,
                    'subject' => $this->request->data['subject'],
                    'date' => date("Y-m-d"),
                    'content' => $this->request->data['content']
                ];
                $leadEmail = $this->LeadEmailMessages->newEntity();
                $leadEmail = $this->LeadEmailMessages->patchEntity($leadEmail, $data_email);
                if( $newEmail = $this->LeadEmailMessages->save($leadEmail) ){
                    $attachments = array();
                    foreach( $this->request->data['attachments'] as $a ){
                        if( $a['name'] != '' && $a['size'] > 0 ){
                            //Upload attachment
                            $attachment = $this->LeadEmailMessages->uploadAttachment($newEmail, $a);
                            $attachments[] = $this->LeadEmailMessages->getAttachmentFolderLocation() . $newEmail->id   . DS . $attachment;

                            //Save attachment
                            $data_attachment = [
                                'lead_email_message_id' => $newEmail->id,
                                'attachment' => $attachment
                            ];

                            $emailAttachment = $this->LeadEmailAttachments->newEntity();
                            $emailAttachment = $this->LeadEmailAttachments->patchEntity($emailAttachment, $data_attachment);
                            $this->LeadEmailAttachments->save($emailAttachment);
                        }
                    }

                    //Send Email
                    $email_smtp = new Email('holistic_mailer_a');
                    $recipient = $lead->email;
                    $subject   = $this->request->data['subject'];
                    $content   = $this->request->data['content'];
                    if( !empty($attachments) ){
                        $email_smtp->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                          ->template('lead_email_message')
                          ->emailFormat('html')
                          ->to($recipient)                                                                                                     
                          ->subject($subject)
                          ->viewVars(['content' => $content, 'lead_id' => $lead->id])
                          ->attachments($attachments)
                        ->send();
                    }else{
                        $email_smtp->from(['websystem@holisticwebpresencecrm.com' => 'Holistic'])
                          ->template('lead_email_message')
                          ->emailFormat('html')
                          ->to($recipient)                                                                                                     
                          ->subject($subject)
                          ->viewVars(['content' => $content, 'lead_id' => $lead->id])
                        ->send();
                    }

                    $this->Flash->success(__('Email was successfully sent.'));

                }else{
                    $this->Flash->error(__('Cannot save entry please try again.'));       
                }
            }else{
                $this->Flash->error(__('The lead could not be found.'));   
            }
        }

        return $this->redirect(['controller' => 'lead_email_messages', 'action' => 'list', $lead->id]);  
    }
}
