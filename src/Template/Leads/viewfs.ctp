<?php ?>
<style>
.form-hdr{
    background-color: #222D32;
    color:#ffff;
    padding: 10px;
}
</style>
<section class="content-header">
    <h1><?= __('View Lead') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Leads'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('View') ?></li>
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
                                echo $this->Form->input('firstname', ['class' => 'form-control', 'id' => 'firstname', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='surname' class='col-sm-2 control-label'>" . __('Surname') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('surname', ['class' => 'form-control', 'id' => 'surname', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='email' class='col-sm-2 control-label'>" . __('Email') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('email', ['class' => 'form-control', 'id' => 'email', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='phone' class='col-sm-2 control-label'>" . __('Phone') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('phone', ['class' => 'form-control', 'id' => 'phone', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='address' class='col-sm-2 control-label'>" . __('Address') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('address', ['class' => 'form-control', 'id' => 'address', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='city' class='col-sm-2 control-label'>" . __('City') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('city', ['class' => 'form-control', 'id' => 'city', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='state' class='col-sm-2 control-label'>" . __('State') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('state', ['class' => 'form-control', 'id' => 'state', 'label' => false, 'readonly' => 'readonly']);                
                            echo " </div></div>";
                            ?>

                            <h3 class="form-hdr">Other Information</h3>
                            <?php
                            echo "
                            <div class='form-group'>
                                <label for='status_id' class='col-sm-2 control-label'>" . __('Status') . "</label>
                                <div class='col-sm-6'>";
                                echo '<input type="text" id="status_id" class="form-control" name="status_id" value="' . $lead->status->name . '" readonly="readonly" />';
                            echo " </div></div>";

                            echo "
                            <div class='form-group'>
                                <label for='lead_action' class='col-sm-2 control-label'>" . __('Action') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('lead_action', ['class' => 'form-control', 'id' => 'lead_action', 'readonly' => 'readonly',  'type' => 'textarea', 'label' => false]);
                            echo " </div></div>"; 

                            echo "
                            <div class='form-group'>
                                <label for='source_id' class='col-sm-2 control-label'>" . __('Source') . "</label>
                                <div class='col-sm-6'>";
                                echo '<input type="text" id="source_id" class="form-control" name="source_id" value="' . $lead->source->name . '" readonly="readonly" />';
                            echo " </div></div>";    

                            echo "
                            <div class='form-group'>
                                <label for='lead_type_id' class='col-sm-2 control-label'>" . __('Lead Type') . "</label>
                                <div class='col-sm-6'>";
                                if(isset($lead->lead_type->name)) { $lead_type_value = $lead->lead_type->name; } else { $lead_type_value = 'NA'; }
                                echo '<input type="text" id="lead_type_id" class="form-control" name="lead_type_id" value="' . $lead_type_value . '" readonly="readonly" />';
                            echo " </div></div>";    

                            echo "
                            <div class='form-group'>
                                <label for='allocation_id' class='col-sm-2 control-label'>" . __('Allocated to') . "</label>
                                <div class='col-sm-6'>";
                                echo '<input type="text" id="allocation_id" class="form-control" name="allocation_id" value="' . $lead->allocation->name . '" readonly="readonly" />';
                            echo " </div></div>";    
                            echo "
                            <div class='form-group'>
                                <label for='allocation_date' class='col-sm-2 control-label'>" . __('Allocation Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('allocation_date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control', 'id' => 'lead-allocation-date', 'readonly' => 'readonly', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='interest_type_id' class='col-sm-2 control-label'>" . __('Interest Type') . "</label>
                                <div class='col-sm-6'>";
                                echo '<input type="text" id="interest_type" class="form-control" name="interest_type" value="' . $lead->interest_type->name . '" readonly="readonly" />';
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='followup_date' class='col-sm-2 control-label'>" . __('Followup Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('lead-followup-date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control', 'id' => '', 'readonly' => 'readonly', 'label' => false]);                
                            echo " </div></div>";    

                            echo "
                            <div class='form-group'>
                                <label for='followup_notes' class='col-sm-2 control-label'>" . __('Followup Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo "<textarea rows='4' cols='79' class='form-control' readonly='readonly'>";
                                echo strip_tags($lead->followup_notes);
                                echo "</textarea>";                                
                            echo " </div></div>";                            
                            
                            echo "
                            <div class='form-group'>
                                <label for='followup_action_reminder_date' class='col-sm-2 control-label'>" . __('Followup Action Reminder Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_action_reminder_date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control', 'id' => '', 'readonly' => 'readonly', 'label' => false]);                
                            echo " </div></div>";  

                            echo "
                            <div class='form-group'>
                                <label for='followup_action_notes' class='col-sm-2 control-label'>" . __('Followup Action Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo "<textarea rows='4' cols='79' class='form-control' readonly='readonly'>";
                                echo strip_tags($lead->followup_action_notes);
                                echo "</textarea>";                                   
                            echo " </div></div>";                                
                            
                            echo "
                            <div class='form-group'>
                                <label for='notes' class='col-sm-2 control-label'>" . __('Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo "<textarea rows='4' cols='79' class='form-control' readonly='readonly'>";
                                echo strip_tags($lead->notes);
                                echo "</textarea>";  
                            echo " </div></div>";    
                                    
                                                ?>
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'from_source/'. $lead->source->id],['class' => 'btn btn-warning', 'escape' => false]) ?>                            
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>