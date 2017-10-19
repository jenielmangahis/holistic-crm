<?php ?>
<section class="content-header">
    <h1><?= __('Leads') ?> from <?php echo ucfirst($source_name); ?></h1>
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
                            <input class="form-control" name="query" type="text" placeholder="Enter query to search">
                            <span class="input-group-btn">
                                <?= $this->Form->button('<i class="fa fa-search"></i>',['name' => 'search', 'value' => 'search', 'class' => 'btn btn-info btn-flat', 'escape' => false]) ?>                                    
                                <?= $this->Html->link(__('Reset'), ['action' => 'index'],['class' => 'btn btn-success btn-flat', 'escape' => false]) ?>                            
                            </span>
                        </div>                        
                        <?= $this->Form->end() ?>
                    </div>

                    <div class="box-tools" style="top:9px;">                         
                        <?= $this->Html->link('<i class="fa fa-plus"></i> Add New', ['action' => 'add', $source_id],['class' => 'btn btn-box-tool', 'escape' => false]) ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>                    
                    
                    <div class="box-tools" style="top:9px;">                                                 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>         
                </div>             
                <div class="box-body">                    
                    <table id="dt-users-list" class="table table-hover table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <th class="actions"></th>
                                <th><?= $this->Paginator->sort('status_id', __("Status") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <!-- <th><?= $this->Paginator->sort('source_id', __("Source") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th> -->
                                <th><?= $this->Paginator->sort('allocation_date', __("Allocation Date") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('modified', __("Last Modified") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('firstname', __("Firstname") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('surname', __("Surname") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('is_lock', __("Is Lock") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead) { ?>
                            <tr>
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'viewfs', $lead->id, $source_id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $lead->id, 'from_source', $source_id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$lead->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                            <?php if($is_admin_user == 1 && $lead->is_lock == 1){ ?>
                                                    <li role="presentation"><?= $this->Html->link('<i class="fa fa-unlock"></i> Unlock', '#unlock-modal-'.$lead->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                            <?php } ?>
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
                                                <?= $this->Form->postLink(
                                                        'Yes',
                                                        ['action' => 'delete', $lead->id, $source_id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
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
                                <!-- <td><?= $lead->source['name'] ?></td> -->
                                <td><?= date("d F, Y", strtotime($lead->allocation_date)); ?></td>
                                <td><?= date("d F, Y", strtotime($lead->modified)); ?></td>
                                <td><?= $lead->firstname ?></td>
                                <td><?= $lead->surname ?></td>
                                <td>
                                    <?php if($lead->is_lock == 1){ ?>
                                            <div class="btn btn-warning">Lock by: <strong><?php echo $lead->last_modified_by->username; ?></strong> </div>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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