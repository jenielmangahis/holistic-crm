<?php ?>
<style>
.form-hdr{
    background-color: #222D32;
    color:#ffff;
    padding: 10px;
}
</style>
<section class="content-header">
    <h1><?= __('Edit Group') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Groups'), ['controller' => 'groups', 'action' => 'dashboard'],['escape' => false]) ?></li>
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
                    <?= $this->Form->create($group,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
                    <fieldset>        
                        <div class="row">
                        <?php
                            echo "
                            <div class='form-group'>
                                <label for='name' class='col-sm-2 control-label'>" . __('Name') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('name', ['class' => 'form-control', 'id' => 'name', 'label' => false]);                
                            echo " </div></div>";    
                        ?>
                        </div>
                        <h3 class="form-hdr">Module Permision</h3>
                        <div class="row">
                            <?php foreach($modules_array as $mkey => $module) { ?>
                                    <div class="col-md-6 form-group">
                                        <div class='form-group'>
                                            <label for="city" class="col-sm-3 control-label"><?php echo ucfirst($module); ?>: </label>
                                            <div class="col-sm-9">
                                                <?php echo $this->Form->input('permision_' . $mkey, array('type'=>'select', 'class' => 'form-control', 'options' => $permision_array, 'default' => $group_action_defauly_array[$mkey], 'label' => false, 'empty' => '')); ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php } ?>
                        </div>                        
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