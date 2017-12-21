<?php use Cake\Utility\Inflector; ?>
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
.sort_table_statuses tr {
    cursor: pointer;
}
</style>

<section class="content-header">
    <h1><?= __('Status Options') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> System Settings</a></li>
        <li class="active"><?= __('Status Options') ?></li>
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
                        <?= $this->Html->link('<i class="fa fa-plus"></i> Add New', ['action' => 'add'],['class' => 'btn btn-box-tool', 'escape' => false]) ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div> 
                                        
                    <div class="box-tools" style="top:9px;">                                                 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
                    </div>         
                </div>             
                <div class="box-body">      
                    <?php if($user_data->group_id == 1) { ?>
                            <table id="dt-users-list" class="table table-hover sort_table_statuses">
                    <?php }else{ ?>              
                            <table id="dt-users-list" class="table table-hover table-striped">
                    <?php } ?>
                    
                        <thead class="thead-inverse">
                            <tr>
                                <th class="actions"></th>                                
                                <th ><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th ><?= $this->Paginator->sort('description', __("Description") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                                <th style="width:15%;"><?= $this->Paginator->sort('created', __("Created") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($statuses as $status) { ?>
                            <tr id="<?php echo $status->id; ?>">
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $status->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $status->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$status->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                        </ul>
                                    </div>   
                                    <div id="modal-<?=$status->id?>" class="modal fade">
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
                                                        ['action' => 'delete', $status->id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
                                            </div>
                                          </div>
                                        </div>                              
                                    </div>                       
                                </td>                            
                                <?php if($user_data->group_id == 1) { ?>
                                        <?php $drag_drop_message = 'Drag and drop to sort.'; ?>
                                <?php } else { ?>
                                        <?php $drag_drop_message = ''; ?>
                                <?php } ?>                                    
                                <td title="<?php echo $drag_drop_message; ?>"><?= $status->name; ?></td>
                                <td title="<?php echo $drag_drop_message; ?>"><?= $status->description; ?></td>
                                <td title="<?php echo $drag_drop_message; ?>"><?= $status->created ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if($user_data->group_id != 1) { ?>
                            <div class="paginator" style="text-align:center;">
                                <ul class="pagination">
                                <?= $this->Paginator->prev('«') ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next('»') ?>
                                </ul>
                                <p class="hidden"><?= $this->Paginator->counter() ?></p>
                            </div>
                    <?php } ?>
                </div>
            </div>

        </section>
    </div>
</section>