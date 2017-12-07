<?php use Cake\Utility\Inflector; ?>
<!--
<style>
.label{
    padding:10px;    
    display: block;
    
    font-size: 12px;
}
.thead-inverse th {
    background-color: #2A80B9;
    color: #fff;
    padding:13px !important;
}
th a{
    color:#ffffff;
}
div.box-body{
    padding: 0px;
}
.box-header.with-border {
    border-bottom: 1px solid #2A80B9;
}
.box-body, .box-header{
    overflow:auto;
}
.fa-sort{
    line-height: 19px;
}
.user-allocations{
    padding: 0px;
}
</style>
-->

<section class="content-header">
    <h1><?= __('Audit Trails') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> System Settings</a></li>
        <li class="active"><?= __('Audit Trails') ?></li>
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
                        <!-- <?= $this->Html->link('<i class="fa fa-plus"></i> Add New', ['action' => 'add'],['class' => 'btn btn-box-tool', 'escape' => false]) ?> -->
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>         
                </div>             
                <div class="box-body">                    
                    <table id="dt-users-list" class="table table-hover table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <th class="actions"><?= __('Actions') ?></th>
                                <th><?= $this->Paginator->sort('user_id', __("User") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('action', __("Action") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('event_status', __("Event Status") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <!-- <th><?= $this->Paginator->sort('details', __("Details") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th> -->
                                <th><?= $this->Paginator->sort('audit_date', __("Date") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th><?= $this->Paginator->sort('ip_address', __("IP Address") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>           
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($auditTrails as $auditTrail): ?>
                            <tr>
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $auditTrail->id],['escape' => false]) ?></li>                                            
                                            <!-- 
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $auditTrail->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$auditTrail->id,['data-toggle' => 'modal','escape' => false]) ?></li> 
                                            -->
                                        </ul>
                                    </div>   
                                    <div id="modal-<?=$auditTrail->id?>" class="modal fade">
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
                                                        ['action' => 'delete', $auditTrail->id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
                                            </div>
                                          </div>
                                        </div>                              
                                    </div>              
                                </td>
                                                <td><?= h($auditTrail->user->firstname . ' ' . $auditTrail->user->lastname) ?></td>
                                                <td><?= h($auditTrail->action) ?></td>
                                                <td><?= h($auditTrail->event_status) ?></td>
                                                <!-- <td><?= $this->Number->format($auditTrail->details) ?></td> -->
                                                <td><?= h($auditTrail->audit_date) ?></td>
                                                <td><?= h($auditTrail->ip_address) ?></td>
                                                                                          
                            </tr>
                            <?php endforeach; ?>
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