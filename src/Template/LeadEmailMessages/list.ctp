<?php ?>
<section class="content-header">
    <h1><?= __('Lead Email Messages') . " : "  . $lead->firstname . ' ' . $lead->surname ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-users"></i> Leads</a></li>
        <li class="active"><?= __('Email Messages') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box box-primary box-solid">   
                <div class="box-header with-border">  
                    <div class="user-block">   
                        <?= $this->Form->create(null,[                
                          'url' => ['action' => 'list', $lead->id],
                          'class' => 'form-inline',
                          'type' => 'GET'
                        ]) ?>                         
                        <div class="input-group input-group-sm">
                            <input class="form-control" name="query" type="text" placeholder="Enter query to search">
                            <span class="input-group-btn">
                                <?= $this->Form->button('<i class="fa fa-search"></i>',['name' => 'search', 'value' => 'search', 'class' => 'btn btn-info btn-flat', 'escape' => false]) ?>                                    
                                <?= $this->Html->link(__('Reset'), ['action' => 'index'],['class' => 'btn btn-success btn-flat', 'escape' => false]) ?>                            
                            </span>
                        </div>                        
                        <?= $this->Form->end() ?>
                    </div>
                </div>             
                <div class="box-body">          
                    <table id="dt-users-list" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="actions"><?= __('Actions') ?></th>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('user_id', __("Sent By")) ?></th>
                                <th><?= $this->Paginator->sort('lead_id', __("Recipient")) ?></th>
                                <th><?= $this->Paginator->sort('subject') ?></th>
                                <th><?= $this->Paginator->sort('date') ?></th>
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
                                        </ul>
                                    </div>                      
                                </td>
                                <td><?= $this->Number->format($leadEmailMessage->id) ?></td>
                                <td><?= $leadEmailMessage->user->firstname . ' ' . $leadEmailMessage->user->lastname; ?></td>
                                <td><?= $leadEmailMessage->recipient; ?></td>
                                <td><?= h($leadEmailMessage->subject) ?></td>
                                <td><?= $leadEmailMessage->date->format("Y-m-d") ;?></td>
                  
                            </tr>
                            <?php ;endforeach; ?>
                        </tbody>
                    </table>
                    <div id="modal-multiple-delete" class="modal fade">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Multiple Delete Confirmation</h4>
                            </div>
                            <div class="modal-body">
                                <p><?= __('Are you sure you want to delete all selected leads?') ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default">No</button>
                                <a class="btn btn-danger leads-delete-multiple" href="javascript:void(0);">Yes</a>
                            </div>
                          </div>
                        </div>                              
                    </div>
                    <div class="paginator" style="text-align:center;">
                        <ul class="pagination">
                            <?= $this->Paginator->first('FIRST') ?>
                            <?= $this->Paginator->prev('«') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('»') ?>
                            <?= $this->Paginator->last('LAST') ?>
                        </ul>
                        <p class="hidden"><?= $this->Paginator->counter() ?></p>
                    </div>                     
                </div>
            </div>                
        </section>
    </div>
</section>