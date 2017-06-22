<style>
.form-hdr{
    background-color: #222D32;
    color:#ffff;
    padding: 10px;
}
</style>
<section class="content-header">
    <h1><?= __('Edit Lead') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Leads'), ['action' => 'index'],['escape' => false]) ?></li>
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
                    <?= $this->Form->create($lead,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
                    <fieldset>        
                        <h3 class="form-hdr">Lead Personal Information</h3>
                        <?php
                            echo "
                            <div class='form-group'>
                                <label for='firstname' class='col-sm-2 control-label'>" . __('Firstname') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('firstname', ['class' => 'form-control', 'id' => 'firstname', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='surname' class='col-sm-2 control-label'>" . __('Surname') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('surname', ['class' => 'form-control', 'id' => 'surname', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='email' class='col-sm-2 control-label'>" . __('Email') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('email', ['class' => 'form-control', 'id' => 'email', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='phone' class='col-sm-2 control-label'>" . __('Phone') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('phone', ['class' => 'form-control', 'id' => 'phone', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='address' class='col-sm-2 control-label'>" . __('Address') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('address', ['class' => 'form-control', 'id' => 'address', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='city' class='col-sm-2 control-label'>" . __('City') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('city', ['class' => 'form-control', 'id' => 'city', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='state' class='col-sm-2 control-label'>" . __('State') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('state', ['class' => 'form-control', 'id' => 'state', 'label' => false]);                
                            echo " </div></div>";
                            ?>

                            <h3 class="form-hdr">Other Information</h3>
                            <?php
                            echo "
                            <div class='form-group'>
                                <label for='status_id' class='col-sm-2 control-label'>" . __('Status') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('status_id', ['class' => 'form-control', 'id' => 'status_id', 'label' => false, 'options' => $statuses]);                 
                            echo " </div></div>";    
                            echo "
                            <div class='form-group'>
                                <label for='source_id' class='col-sm-2 control-label'>" . __('Source') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('source_id', ['class' => 'form-control', 'id' => 'source_id', 'label' => false, 'options' => $sources]);                 
                            echo " </div></div>";    
                            echo "
                            <div class='form-group'>
                                <label for='allocation_id' class='col-sm-2 control-label'>" . __('Allocation') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('allocation_id', ['class' => 'form-control', 'id' => 'allocation_id', 'label' => false, 'options' => $allocations]);                 
                            echo " </div></div>";    
                            echo "
                            <div class='form-group'>
                                <label for='allocation_date' class='col-sm-2 control-label'>" . __('Allocation Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('allocation_date', ['type' => 'text', 'class' => 'form-control default-datepicker', 'value' => $lead->allocation_date->format("Y-m-d"), 'id' => 'lead-allocation-date', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='interest_type_id' class='col-sm-2 control-label'>" . __('Interest Type') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('interest_type_id', ['class' => 'form-control', 'id' => 'interest_type_id', 'label' => false, 'options' => $interestTypes]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='followup_date' class='col-sm-2 control-label'>" . __('Followup Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_date', ['type' => 'text','value' => $lead->followup_date->format("Y-m-d"),  'class' => 'form-control', 'id' => 'lead-followup-date', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='followup_action_reminder_date' class='col-sm-2 control-label'>" . __('Followup Action Reminder Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_action_reminder_date', ['type' => 'text', 'class' => 'form-control', 'value' => $lead->followup_action_reminder_date->format("Y-m-d"), 'id' => 'lead-followup-action-reminder-date', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='notes' class='col-sm-2 control-label'>" . __('Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('notes', ['class' => 'form-control ckeditor', 'id' => 'notes', 'label' => false]);                
                            echo " </div></div>";    
                                    
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