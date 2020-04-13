<?php ?>
<section class="content-header">
    <h1><?= __('Leads') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= __('Leads') ?></li>
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
                          'url' => ['action' => 'index'],
                          'class' => 'form-inline',
                          'type' => 'GET'
                        ]) ?>                         
                        <div class="input-group input-group-sm">
                            <input class="form-control" name="query" type="text" placeholder="Enter query to search" value="<?= $query; ?>">
                            <span class="input-group-btn">
                                <?= $this->Form->button('<i class="fa fa-search"></i>',['name' => 'search', 'value' => 'search', 'class' => 'btn btn-info btn-flat', 'escape' => false]) ?>                                    
                                <?= $this->Html->link(__('Reset'), ['action' => 'index'],['class' => 'btn btn-success btn-flat', 'escape' => false]) ?>                            
                            </span>
                        </div>                        
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="box-tools" style="top:9px;">  
                        <?php if( $is_admin_user == 1 ){ ?>   
                            <?= $this->Html->link('<i class="fa fa-trash"></i> Delete Selected', '#modal-multiple-delete',['class' => 'btn btn-danger btn-box-tool', 'data-toggle' => 'modal','escape' => false]) ?>
                        <?php } ?>
                        <?php if( $default_group_actions && $default_group_actions['leads'] != 'View Only' ){ ?>
                                    <?= $this->Html->link('<i class="fa fa-plus"></i> Add New', ['action' => 'add'],['class' => 'btn btn-box-tool', 'escape' => false]) ?>
                        <?php } ?>                        
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>                    
                    
                    <div class="box-tools" style="top:9px;">                                                 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>         
                </div>             
                <div class="box-body">   
                    <?= $this->Form->create(null,['url' => ['action' => 'leads_delete_multiple'], 'id' => 'multi-leads', 'data-toggle' => 'validator', 'role' => 'form']) ?>                 
                    <table id="dt-users-list" class="table table-hover table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <?php if( $is_admin_user == 1 ){ ?>
                                <th class="actions"></th>
                                <?php } ?>
                                <th class="actions"></th>
                                <th><?= $this->Paginator->sort('status_id', __("Status") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('source_id', __("Source") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>                                
                                <th><?= $this->Paginator->sort('allocation_date', __("Allocation Date") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('firstname', __("Firstname") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('surname', __("Surname") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('is_lock', __("Is Lock") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('last_modified_by_id', __("Last Modified") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead) { ?>
                            <tr>
                                <?php if( $is_admin_user == 1 ){ ?>
                                    <td style="vertical-align:middle;"><input type="checkbox" name="leads[]" value="<?= $lead->id; ?>" /></td>
                                <?php } ?>
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <?php if( $default_group_actions && $default_group_actions['leads'] == 'View Only' ){ ?>
                                                <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $lead->id],['escape' => false]) ?></li>
                                            <?php }elseif($default_group_actions && $default_group_actions['leads'] == 'View and Edit') { ?>
                                                <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $lead->id],['escape' => false]) ?></li>
                                                <?php if(isset($page)) { ?>
                                                        <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $lead->id . "?page=" . $page],['escape' => false]) ?></li>
                                                <?php } else { ?>
                                                        <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $lead->id],['escape' => false]) ?></li>
                                                <?php } ?>
                                            <?php }elseif($default_group_actions && $default_group_actions['leads'] == 'View, Edit and Delete') { ?>
                                                <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $lead->id],['escape' => false]) ?></li>
                                                <?php if(isset($page)) { ?>
                                                        <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $lead->id . "?page=" . $page],['escape' => false]) ?></li>
                                                <?php } else { ?>
                                                        <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $lead->id],['escape' => false]) ?></li>
                                                <?php } ?>
                                                <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$lead->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                            <?php } ?>

                                            <?php if($is_admin_user == 1 && $lead->is_lock == 1){ ?>
                                                    <li role="presentation"><?= $this->Html->link('<i class="fa fa-unlock"></i> Unlock', '#unlock-modal-'.$lead->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                            <?php } ?>

                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-envelope"></i> Email Messages', ['controller' => 'lead_email_messages', 'action' => 'list_leads', $lead->id],['escape' => false]) ?></li>
                                        </ul>
                                    </div>   

                                    <!-- Delete Modal -->
                                    <div id="modal-<?=$lead->id?>" class="modal fade">
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
                                                <?php if(isset($page)) { ?>
                                                        <?= $this->Html->link('Yes', ['action' => 'delete', $lead->id . '?page='.$page],['class' => 'btn btn-danger', 'escape' => false]) ?>
                                                <?php }else{ ?>
                                                        <?= $this->Html->link('Yes', ['action' => 'delete', $lead->id],['class' => 'btn btn-danger', 'escape' => false]) ?>
                                                <?php } ?>

                                            </div>
                                          </div>
                                        </div>                              
                                    </div>
                                    <!-- Delete Modal End -->

                                    <!-- Unlock Lead Modal -->
                                    <div id="unlock-modal-<?=$lead->id?>" class="modal fade">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p><?= __('Are you sure you want to unlock this lead?') ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-default">No</button>
                                                <?= $this->Form->postLink(
                                                        'Yes',
                                                        ['action' => 'unlock', $lead->id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
                                            </div>
                                          </div>
                                        </div>                              
                                    </div> 
                                    <!-- Unlock Lead Modal End -->
                                                        
                                </td>                                
                                <td><?= $lead->status['name']; ?></td>
                                <td><?= $lead->source['name'] ?></td>                                
                                <td><?= date("d F, Y", strtotime($lead->allocation_date)); ?></td>                          
                                <td><?= sanitizeString($lead->firstname) ?></td>                          
                                <td><?= sanitizeString($lead->surname) ?></td>
                                <td>
                                    <?php if($lead->is_lock == 1){ ?>
                                            <div class="btn btn-warning">Lock by: <strong><?php echo $lead->last_modified_by->username; ?></strong> </div>
                                    <?php }?>
                                </td>
                                <td>
                                        <p>Updated by: <strong><?php echo isset($lead->last_modified_by->username) ? $lead->last_modified_by->username : 'NA'; ?></strong></p>
                                        <p>Date: <?php echo date("d M, Y", strtotime($lead->modified)); ?></p>
                                </td>
                            </tr>
                            <?php } ?>
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
                    <?= $this->Form->end() ?>
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