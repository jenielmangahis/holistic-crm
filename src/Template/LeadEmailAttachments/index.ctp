
<section class="content-header">
    <h1><?= __('Lead Email Attachments') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= __('Lead Email Attachments') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box " >
                <div class="box-header">
                    <?= $this->Html->link(__('Add New Lead Email Attachment'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                    <h3 class="box-title text-black" ></h3>
                </div>
                <div class="box-body">
                    <table id="dt-users-list" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="actions"><?= __('Actions') ?></th>
                                                <th><?= $this->Paginator->sort('id') ?></th>
                                                <th><?= $this->Paginator->sort('lead_email_message_id') ?></th>
                                                <th><?= $this->Paginator->sort('created') ?></th>
                                                <th><?= $this->Paginator->sort('modified') ?></th>
                                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leadEmailAttachments as $leadEmailAttachment): ?>
                                                        <tr>
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $leadEmailAttachment->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $leadEmailAttachment->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$leadEmailAttachment->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                        </ul>
                                    </div>   
                                    <div id="modal-<?=$leadEmailAttachment->id?>" class="modal fade">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><?= __('Are you sure you want to delete selected entry?') ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-default">No</button>
                                                <?= $this->Form->postLink(
                                                        'Yes',
                                                        ['action' => 'delete', $leadEmailAttachment->id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
                                            </div>
                                          </div>
                                        </div>                              
                                    </div>                       
                                </td>
                                                <td><?= $this->Number->format($leadEmailAttachment->id) ?></td>
                                                <td <?php if( $isKey == 1 ? 'class="tbl-field-id"' : '' ) ?>><?= $leadEmailAttachment->has('lead_email_message') ? $this->Html->link($leadEmailAttachment->lead_email_message->id, ['controller' => 'LeadEmailMessages', 'action' => 'view', $leadEmailAttachment->lead_email_message->id]) : '' ?></td>
                                                <td><?= h($leadEmailAttachment->created) ?></td>
                                                <td><?= h($leadEmailAttachment->modified) ?></td>
                  
                            </tr>
                            <?php ;endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                    <div class="paginator" style="text-align:center;">
                        <ul class="pagination">
                        <?= $this->Paginator->prev('«') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('»') ?>
                        </ul>
                        <p class="hidden"><?= $this->Paginator->counter() ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>