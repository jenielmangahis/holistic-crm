
<section class="content-header">
    <h1><?= __('Lead Email Messages') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= __('Lead Email Messages') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box " >
                <div class="box-header">
                    <?= $this->Html->link(__('Add New Lead Email Message'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                    <h3 class="box-title text-black" ></h3>
                </div>
                <div class="box-body">
                    <table id="dt-users-list" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="actions"><?= __('Actions') ?></th>
                                                <th><?= $this->Paginator->sort('id') ?></th>
                                                <th><?= $this->Paginator->sort('user_id') ?></th>
                                                <th><?= $this->Paginator->sort('lead_id') ?></th>
                                                <th><?= $this->Paginator->sort('subject') ?></th>
                                                <th><?= $this->Paginator->sort('date') ?></th>
                                                <th><?= $this->Paginator->sort('created') ?></th>
                                                <th><?= $this->Paginator->sort('modified') ?></th>
                                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leadEmailMessages as $leadEmailMessage): ?>
                                                        <tr>
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $leadEmailMessage->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $leadEmailMessage->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$leadEmailMessage->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                        </ul>
                                    </div>   
                                    <div id="modal-<?=$leadEmailMessage->id?>" class="modal fade">
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
                                                        ['action' => 'delete', $leadEmailMessage->id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
                                            </div>
                                          </div>
                                        </div>                              
                                    </div>                       
                                </td>
                                                <td><?= $this->Number->format($leadEmailMessage->id) ?></td>
                                                <td <?php if( $isKey == 1 ? 'class="tbl-field-id"' : '' ) ?>><?= $leadEmailMessage->has('user') ? $this->Html->link($leadEmailMessage->user->id, ['controller' => 'Users', 'action' => 'view', $leadEmailMessage->user->id]) : '' ?></td>
                                                <td <?php if( $isKey == 1 ? 'class="tbl-field-id"' : '' ) ?>><?= $leadEmailMessage->has('lead') ? $this->Html->link($leadEmailMessage->lead->id, ['controller' => 'Leads', 'action' => 'view', $leadEmailMessage->lead->id]) : '' ?></td>
                                                <td><?= h($leadEmailMessage->subject) ?></td>
                                                <td><?= h($leadEmailMessage->date) ?></td>
                                                <td><?= h($leadEmailMessage->created) ?></td>
                                                <td><?= h($leadEmailMessage->modified) ?></td>
                  
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