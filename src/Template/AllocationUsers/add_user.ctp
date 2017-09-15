<?php ?>
<style>
.form-caption{
    background-color: #3C8DBC;
    color:#ffffff;
    padding: 5px;
}
</style>
<section class="content-header">
    <h1><?= __('Client Add User') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> System Settings</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> Client</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> Users</a></li>        
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
                    <?= $this->Form->create($user,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
                    <fieldset>        
                        <h3 class="form-caption" style="background-color:#374850;">Client : <?php echo $allocation->name; ?></h3>                        
                        <h3 class="form-caption">User Information</h3>
                        <?php
                                    echo "
                                    <div class='form-group'>
                                        <label for='firstname' class='col-sm-2 control-label'>" . __('Firstname') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('firstname', ['class' => 'form-control', 'id' => 'firstname', 'label' => false]);                
                                    echo " </div></div>";    

                                    echo "
                                    <div class='form-group'>
                                        <label for='middlename' class='col-sm-2 control-label'>" . __('Middlename') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('middlename', ['class' => 'form-control', 'id' => 'middlename', 'label' => false]);                
                                    echo " </div></div>";    

                                    echo "
                                    <div class='form-group'>
                                        <label for='lastname' class='col-sm-2 control-label'>" . __('Lastname') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('lastname', ['class' => 'form-control', 'id' => 'lastname', 'label' => false]);                
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='email' class='col-sm-2 control-label'>" . __('Email') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('email', ['class' => 'form-control', 'id' => 'email', 'label' => false]);                
                                    echo " </div></div>";
                        ?>
                        <h3 class="form-caption">Login Details</h3>          
                        <?php                                    
                                    echo "
                                    <div class='form-group'>
                                        <label for='username' class='col-sm-2 control-label'>" . __('Username') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('username', ['class' => 'form-control', 'id' => 'username', 'label' => false]);                
                                    echo " </div></div>";    

                                    echo "
                                    <div class='form-group'>
                                        <label for='password' class='col-sm-2 control-label'>" . __('Password') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('password', ['type' => 'password', 'class' => 'form-control', 'id' => 'password', 'label' => false]);                
                                    echo " </div></div>";    
                                    
                                                ?>
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                            <?= $this->Form->button('<i class="fa fa-edit"></i> ' . __('Save and Continue adding'),['name' => 'save', 'value' => 'edit', 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'user_list', $allocation->id],['class' => 'btn btn-warning', 'escape' => false]) ?>                            
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>