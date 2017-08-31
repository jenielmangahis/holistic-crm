<?php ?>
<style>
.link_box_cntr{
    padding-bottom: 2px;
}
</style>
<section class="content-header">
    <h1><?= __('Trainings') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= __('Trainings') ?></li>
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
                                <th style="width:80%;"><?= $this->Paginator->sort('title') ?></th>                                
                                <th class="actions">&nbsp;</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trainings as $training): ?>
                            <tr>                                
                                <td>
                                    <?php //h($training->title) ?>
                                    <p><strong>File:</strong> <?= h($training->title) ?></p>
                                    <?php if($training->anchor_text && $training->video_url) { ?>
                                            <p><strong>Video:</strong> <?= h($training->anchor_text) ?></p>
                                    <?php } ?>                                
                                </td>
                                <td>
                                    <!--<a target="_blank" class="btn btn-info" href="upload/trainings/<?php echo $training->filename; ?>">Open File</a>-->
                                    <div class="link_box_cntr"><a target="_blank" class="btn btn-sm btn-info" href="<?php echo $this->Url->build("/"); ?>upload/trainings/<?php echo $training->filename; ?>">Open File</a></div>
                                    <?php if($training->anchor_text && $training->video_url) { ?>
                                            <div class="link_box_cntr"><a target="_blank" class="btn btn-sm btn-info" href="<?php echo $training->video_url; ?>">Watch Video</a></div>
                                    <?php } ?>                                    
                                </td>
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