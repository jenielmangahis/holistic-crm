<?php ?>
<style>
.form-hdr{
    background-color: #222D32;
    color:#ffffff;
    padding: 10px;
}
</style>
<section class="content-header">
    <h1><?= __('Edit Training') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Trainings'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('Edit') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box " >
                <div class="box-header">

                </div>
                <div class="box-body">
                    <?= $this->Form->create($training,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal', 'type' => 'file', 'enctype' => 'multipart/form-data']) ?>                  
                    <fieldset>       
                        <h3 class="form-hdr">Document</h3> 
                        <?php
                            echo "
                                    <div class='form-group'>
                                    <label for='title' class='col-sm-2 control-label'>" . __('Title') . "</label>
                                    <div class='col-sm-6'>";
                            echo $this->Form->input('title', ['class' => 'form-control', 'id' => 'title', 'label' => false]);                
                            echo " </div></div>";    
                                    
                            echo "
                                    <div class='form-group'>
                                    <label for='filename' class='col-sm-2 control-label'>" . __('Filename') . "</label>
                                    <div class='col-sm-6'>";
                            echo $this->Form->input('filename', ['type' => 'file', 'class' => '', 'id' => 'filename', 'label' => false]);                
                            echo " </div></div>";    
                                    
                        ?>
                        <h3 class="form-hdr">Video</h3> 
                        <?php
                            echo "
                                    <div class='form-group'>
                                    <label for='anchor_text' class='col-sm-2 control-label'>" . __('Anchor Text') . "</label>
                                    <div class='col-sm-6'>";
                            echo $this->Form->input('anchor_text', ['class' => 'form-control', 'id' => 'anchor_text', 'label' => false]);                
                            echo " </div></div>";    
                                    
                            echo "
                                    <div class='form-group'>
                                    <label for='video_url' class='col-sm-2 control-label'>" . __('Url') . "</label>
                                    <div class='col-sm-6'>";
                            echo $this->Form->input('video_url', ['type' => 'text', 'class' => 'form-control', 'id' => 'video_url', 'label' => false]);                
                            echo " </div>eg: http://www.test.com</div>";    
                                    
                        ?>                        
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                            <?= $this->Form->button('<i class="fa fa-edit"></i> ' . __('Save and Continue editing'),['name' => 'save', 'value' => 'edit', 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?>                            
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>