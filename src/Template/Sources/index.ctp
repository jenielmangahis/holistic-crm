<?php use Cake\Utility\Inflector; ?>
<?php 
use Cake\ORM\TableRegistry;
$this->SourceUsers = TableRegistry::get('SourceUsers');
$this->Leads = TableRegistry::get('Leads'); 
?>
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
</style>

<section class="content-header">
    <h1><?= __('Sources') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url . 'sources'; ?>"><i class="fa fa-gear"></i> System Settings</a></li>
        <li class="active"><?= __('Sources') ?></li>
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
                    <table id="dt-users-list" class="table table-hover table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <th class="actions"></th>                                
                                <th><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>                                
                                <th><?= __("Users") ?></th>   
                                <th><?= __('Form URL') ?></th>    
                                <th><?= __('Enable CSV Attachment') ?></th>                                                                                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sources as $source) { ?>
                            <tr>
                                <td class="table-actions">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-eye"></i> View', ['action' => 'view', $source->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'edit', $source->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-users"></i> Users', ['controller' => 'source_users', 'action' => 'user_list', $source->id],['escape' => false]) ?></li>
                                            <li role="presentation"><?= $this->Html->link('<i class="fa fa-trash"></i> Delete', '#modal-'.$source->id,['data-toggle' => 'modal','escape' => false]) ?></li>
                                        </ul>
                                    </div>   
                                    <div id="modal-<?=$source->id?>" class="modal fade">
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
                                                        ['action' => 'delete', $source->id],
                                                        ['class' => 'btn btn-danger', 'escape' => false]
                                                    )
                                                ?>
                                            </div>
                                          </div>
                                        </div>                              
                                    </div>                       
                                </td>                                
                                <td><?= $source->name; ?></td>                                                                
                                <td>
                                    <?php        
                                        $sourceUsers = $this->SourceUsers->find('all')
                                            ->contain(['Users'])
                                            ->where(['SourceUsers.source_id' => $source->id])
                                            ->order(['Users.firstname' => 'ASC'])
                                        ;          
                                        if( $sourceUsers->count() > 0 ){
                                            $counter_list = 1;
                                            echo "<ul class='user-allocations'>";
                                            foreach($sourceUsers as $au){                                                    
                                                $add_list_class = '';
                                                $add_icon = '';
                                                if( $counter_list > 1 ){                                                        
                                                    $add_list_class = 'hidden';
                                                    $li_class = 'source-item-' . $source->id;
                                                }else{
                                                    $li_class = 'source-item-' . $source->id . '-1';
                                                    if( $sourceUsers->count() > 1 ){
                                                        $add_icon = "<a href='javascript:void(0);' data-id=" . $source->id . " class='btn btn-default btn-xs btn-show-more-sources'><i class='fa fa-plus'></i> View More</a>";
                                                    }
                                                }
                                                echo "<li class='{$li_class} {$add_list_class}'>" . $au->user->firstname . ' ' . $au->user->lastname . " {$add_icon}</li>";
                                                $counter_list++;
                                            }
                                            echo "</ul>";
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </td>   
                                <td>
                                    <?php 
                                        $leads = $this->Leads->find('all')
                                            ->select(['source_url'])
                                            ->where(['Leads.source_id' => $source->id])
                                            ->group(['Leads.source_url'])
                                        ;
                                        $source_url = array();
                                        foreach($leads as $l){                                            
                                            if( trim($l->source_url) != '' ){
                                                $source_url[] = $l->source_url;
                                            }                                            
                                        }                                        
                                    ?>
                                    <?php if( $source_url ){ ?>
                                    <ul class="source-forms">
                                    <?php foreach($source_url as $value){ ?>
                                        <li><?= $value; ?></li>
                                    <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </td>  
                                <td>
                                    <?php 
                                        if( $source->enable_csv_attachment == 1 ){
                                            echo "<label class='label label-success'>Yes</label>";
                                        }else{
                                            echo "<label class='label label-danger'>No</label>";
                                        }
                                    ?>
                                </td>                     
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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