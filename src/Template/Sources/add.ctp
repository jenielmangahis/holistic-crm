<?php ?>
<section class="content-header">
    <h1><?= __('Add Source') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Sources'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('Add') ?></li>
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
                    <?= $this->Form->create($source,['id' => 'frm-default-add', 'type' => 'POST', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
                    <fieldset>        
                        <?php
                            echo "
                            <div class='form-group'>
                                <label for='name' class='col-sm-2 control-label'>" . __('Name') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('name', ['class' => 'form-control', 'id' => 'name', 'label' => false]);                
                            echo " </div></div>";  

                            echo "
                            <div class='form-group'>
                                <label for='emails' class='col-sm-2 control-label'>" . __('Emails') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('emails', ['class' => 'form-control', 'id' => 'tags-emails', 'data-role' => 'tagsinput', 'label' => false, 'default' => ' ']);                
                            echo " </div></div>";
                            echo "
                            <div class='form-group'>
                                <label for='enable_csv_attachment' class='col-sm-2 control-label'>" . __('Enable CSV Attachment') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->select('enable_csv_attachment',["0" => "No", "1" => "Yes"],['class' => 'form-control', 'id' => 'enable_csv_attachment', 'label' => false]); 
                            echo " </div></div>";
                            echo "
                            <div class='form-group'>
                                <label for='enable_secondary_notification' class='col-sm-2 control-label'>" . __('Enable Secondary Email Notifcation') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->select('enable_secondary_notification',["0" => "No", "1" => "Yes"],['class' => 'form-control', 'id' => 'enable_secondary_notification', 'label' => false]); 
                            echo " </div></div>";
                            echo "
                            <div class='form-group'>
                                <label for='is_va' class='col-sm-2 control-label'>" . __('Is VA') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->select('is_va', $options_va , ['class' => 'form-control', 'id' => 'is_va', 'label' => false]); 
                            echo " </div></div>"; 
                        ?>
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                            <?= $this->Form->button('<i class="fa fa-edit"></i> ' . __('Save and Continue adding'),['name' => 'save', 'value' => 'edit', 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?>                            
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>