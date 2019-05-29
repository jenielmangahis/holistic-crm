<section class="content-header">
    <h1><?= __('Add Lead Email Message') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Lead Email Messages'), ['action' => 'index'],['escape' => false]) ?></li>
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
                    <?= $this->Form->create($leadEmailMessage,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
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
                                <label for='lead_id' class='col-sm-2 control-label'>" . __('Lead Id') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('lead_id', ['class' => 'form-control', 'id' => 'lead_id', 'label' => false, 'options' => $leads]);                 
                            echo " </div></div>";    
                            echo "
                            <div class='form-group'>
                                <label for='subject' class='col-sm-2 control-label'>" . __('Subject') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('subject', ['class' => 'form-control', 'id' => 'subject', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='date' class='col-sm-2 control-label'>" . __('Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('date', ['class' => 'form-control', 'id' => 'date', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='content' class='col-sm-2 control-label'>" . __('Content') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('content', ['class' => 'form-control', 'id' => 'content', 'label' => false]);                
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