<section class="content-header">
    <h1><?= __('Add Audit Trail') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Audit Trails'), ['action' => 'index'],['escape' => false]) ?></li>
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
                    <?= $this->Form->create($auditTrail,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
                    <fieldset>        
                        <?php
                                                            echo "
                                    <div class='form-group'>
                                        <label for='user_id' class='col-sm-2 control-label'>" . __('User Id') . "</label>
                                        <div class='col-sm-6'>";
                                         echo $this->Form->input('user_id', ['class' => 'form-control', 'id' => 'user_id', 'label' => false, 'options' => $users]);                 
                                    echo " </div></div>";    
                                                            echo "
                                    <div class='form-group'>
                                        <label for='action' class='col-sm-2 control-label'>" . __('Action') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('action', ['class' => 'form-control', 'id' => 'action', 'label' => false]);                
                                    echo " </div></div>";    
                                    
                                                            echo "
                                    <div class='form-group'>
                                        <label for='event_status' class='col-sm-2 control-label'>" . __('Event Status') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('event_status', ['class' => 'form-control', 'id' => 'event_status', 'label' => false]);                
                                    echo " </div></div>";    
                                    
                                                            echo "
                                    <div class='form-group'>
                                        <label for='details' class='col-sm-2 control-label'>" . __('Details') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('details', ['class' => 'form-control', 'id' => 'details', 'label' => false]);                
                                    echo " </div></div>";    
                                    
                                                            echo "
                                    <div class='form-group'>
                                        <label for='audit_date' class='col-sm-2 control-label'>" . __('Audit Date') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('audit_date', ['class' => 'form-control', 'id' => 'audit_date', 'label' => false]);                
                                    echo " </div></div>";    
                                    
                                                            echo "
                                    <div class='form-group'>
                                        <label for='ip_address' class='col-sm-2 control-label'>" . __('Ip Address') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('ip_address', ['class' => 'form-control', 'id' => 'ip_address', 'label' => false]);                
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