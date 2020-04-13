<?php ?>
<style>
.form-hdr{
    background-color: #222D32;
    color:#ffffff;
    padding: 10px;
}
.lead-attachments{
     border-collapse:separate;
    border-spacing:0 5px;
}
.lead-type-list{
    list-style: none;
}
.lead-type-list li{
    display: inline-block;
    width: 22%;
}
.col-inline .input{
    display: inline-block;
    width: 40%;
}
.followup-lead-recipient-list{
    margin-left: 10px;
    /*display: inline-block;
    width: 40%;
    */
}
</style>
<section class="content-header">
    <h1><?= __('Add Lead') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Leads'), ['action' => 'index'],['escape' => false]) ?></li>
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
                    <?= $this->Form->create($lead,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
                    <?= $this->Form->hidden('lead_id', ['id' => 'lead_id', 'value' => 0]); ?>
                    <fieldset>        
                        <h3 class="form-hdr">Lead Personal Information</h3>
                        <div class="row">
                        <div class="col-md-8">
                        <?php
                            echo "
                            <div class='form-group'>
                                <label for='firstname' class='col-sm-3 control-label'>" . __('Firstname') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('firstname', ['class' => 'form-control', 'id' => 'firstname', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='surname' class='col-sm-3 control-label'>" . __('Surname') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('surname', ['class' => 'form-control', 'id' => 'surname', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='email' class='col-sm-3 control-label'>" . __('Email') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('email', ['class' => 'form-control', 'id' => 'email', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='phone' class='col-sm-3 control-label'>" . __('Phone') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('phone', ['class' => 'form-control', 'id' => 'phone', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='address' class='col-sm-3 control-label'>" . __('Address') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('address', ['class' => 'form-control', 'id' => 'address', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='city' class='col-sm-3 control-label'>" . __('City') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('city', ['class' => 'form-control', 'id' => 'city', 'label' => false]);                
                            echo " </div></div>";    
                            
                            echo "
                            <div class='form-group'>
                                <label for='state' class='col-sm-3 control-label'>" . __('State') . "</label>
                                <div class='col-sm-9'>";
                                echo $this->Form->input('state', ['class' => 'form-control', 'id' => 'state', 'label' => false]);                
                            echo " </div></div>";
                            ?>
                            </div>
                            <div class="col-md-3">
                                <div class="callout callout-info">
                                    <b>Note:</b>
                                    <ul>
                                        <li>Any field that you have not received information for please enter ‘<b>Not Given</b>’</li>                                        
                                    </ul>                                    
                                </div>
                            </div>
                            </div>
                            <h3 class="form-hdr">Attachments <a class="btn btn-info btn-small pull-right attachment-add-row" href="javascript:void(0);" style="line-height: 0px;"><i class="fa fa-plus"></i></a></h3>
                            <table class="lead-attachments">
                                <tr>
                                    <td style="width:40%;">&nbsp;</td>
                                    <td><input type="file" name="attachments[]" /></td>
                                </tr>
                            </table>
                            <h3 class="form-hdr">Other Information</h3>
                            <?php
                            echo "
                            <div class='form-group'>
                                <label for='cooling_system_repair' class='col-sm-2 control-label'>" . __('Cooling System Service or Repair') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('cooling_system_repair', ['class' => 'form-control', 'id' => 'cooling_system_repair', 'label' => false, 'options' => $options_cooling_repair]);                 
                            echo " </div></div>";
                            echo "
                            <div class='form-group'>
                                <label for='status_id' class='col-sm-2 control-label'>" . __('Status') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('status_id', ['class' => 'form-control', 'id' => 'status_id', 'label' => false, 'options' => $statuses]);                 
                            echo " </div>";
                            ?>
                            <div class='col-md-3'>
                                <div class='callout callout-info'>
                                    <b>
                                        <a href='javascript:void(0);' style='display: none;' id='hide_note'>Hide Note</a>
                                        <a href='javascript:void(0);' id='show_note'>Show Note</a>
                                    </b>
                                    <div id='status_note' style='display: none;'>
                                    <ul>
                                        <?php foreach($status_list as $stat) { ?>
                                                <li><div data-balloon='<?php echo $stat->description; ?>' data-balloon-pos='up'><?php echo $stat->name; ?></div></li>    
                                        <?php } ?>                               
                                    </ul> 
                                    </div>                                   
                                </div>
                            </div>
                            <?php
                            echo "</div>";

                            echo "
                            <div class='form-group'>
                                <label for='lead_action' class='col-sm-2 control-label'>" . __('Action') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('lead_action', ['class' => 'form-control', 'id' => 'lead_action', 'type' => 'textarea', 'label' => false]);
                            echo " </div></div>"; 

                            echo "
                            <div class='form-group'>
                                <label for='source_id' class='col-sm-2 control-label'>" . __('Source') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('source_id', ['class' => 'form-control', 'id' => 'source_id', 'label' => false, 'options' => $sources]);                 
                            echo " </div></div>";
                            ?>
                            <div class="va-group hidden">
                                <?php 
                                    echo "
                                    <div class='form-group'>
                                        <label for='va_request_form_completed' class='col-sm-2 control-label'></label>
                                        <div class='col-sm-6'>";
                                        echo "<h3 class='form-hdr'>VA Information</h3>";         
                                    echo " </div></div>";
                                    echo "
                                    <div class='form-group'>
                                        <label for='va_request_form_completed' class='col-sm-2 control-label'>" . __('VA Request Form Completed') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_request_form_completed', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control allocation-datepicker', 'id' => 'va_request_form_completed', 'label' => false]);                
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='va_deposit_paid' class='col-sm-2 control-label'>" . __('VA Deposit Paid') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_deposit_paid', ['options' => $option_va_deposit_paid, 'class' => 'form-control', 'id' => 'va_deposit_paid', 'label' => false]);
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='va_name' class='col-sm-2 control-label'>" . __('VA Name') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_name', ['class' => 'form-control', 'id' => 'va_name', 'label' => false]);
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='va_start_date' class='col-sm-2 control-label'>" . __('VA Start Date') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_start_date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control allocation-datepicker', 'id' => 'va_start_date', 'label' => false]);
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='va_exit_date' class='col-sm-2 control-label'>" . __('VA Exit Date') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_exit_date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control allocation-datepicker', 'id' => 'va_exit_date', 'label' => false]);
                                    echo " </div></div>";
                                    echo "
                                    <div class='form-group'>
                                        <label for='va_request_form_completed' class='col-sm-2 control-label'></label>
                                        <div class='col-sm-6'>";
                                        echo "<h3 class='form-hdr'>&nbsp;</h3>";         
                                    echo " </div></div>";
                                ?>
                            </div>
                            <?php 
                            echo "
                            <div class='form-group'>
                                <label for='source_url' class='col-sm-2 control-label'>" . __('URL') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('source_url', ['type' => 'text', 'class' => 'form-control', 'id' => 'url', 'label' => false]);                 
                            echo " </div></div>";   

                            echo "
                            <div class='form-group'>
                                <label for='willing_to_review' class='col-sm-2 control-label'>" . __('Willing to Review') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('willing_to_review', ['class' => 'form-control opt-willing-to-review', 'id' => 'willing_to_review', 'label' => false, 'options' => $optionsWillToReview]);                 
                            echo " </div></div>";

                            echo "
                            <div class='grp-willing-review-date hidden'>
                            <div class='form-group'>
                                <label for='willing_to_review_date' class='col-sm-2 control-label'>" . __('Willing to Review Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('willing_to_review_date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control default-datepicker', 'id' => 'willing_to_review_date', 'label' => false]);
                            echo " </div></div></div>"; 

                            echo "
                            <div class='form-group'>
                                <label for='lead_type_id' class='col-sm-2 control-label'>" . __('Lead Source') . "</label>
                                <div class='col-sm-6'>";
                                echo "<ul class='lead-type-list'>";
                                    foreach( $leadTypes as $key => $value ){
                                        echo "<li>";
                                        echo "<div class='checkbox'>";
                                            echo "<label><input type='checkbox' name='leadTypeIds[" . $key . "]' />" . $value . "</label>";
                                        echo "</div>";
                                        echo "</li>";
                                    }
                                echo "</ul>";
                                //echo $this->Form->input('lead_type_id', ['class' => 'form-control', 'id' => 'lead_type_id', 'label' => false, 'options' => $leadTypes]);                 
                            echo " </div></div>";    
                            /*echo "
                            <div class='form-group'>
                                <label for='allocation_date' class='col-sm-2 control-label'>" . __('Allocation Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('allocation_date', ['type' => 'text', 'value' => date("d F, Y"), 'class' => 'form-control allocation-datepicker', 'id' => 'lead-allocation-date', 'label' => false]);                
                            echo " </div></div>"; */   
                            
                            echo "
                            <div class='form-group'>
                                <label for='interest_type_id' class='col-sm-2 control-label'>" . __('Interest Type') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('interest_type_id', ['class' => 'form-control', 'id' => 'interest_type_id', 'label' => false, 'options' => $interestTypes]);                
                            echo " </div></div>";  

                            echo "
                            <div class='form-group'>
                                <label for='followup_notes' class='col-sm-2 control-label'>" . __('Followup Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_notes', ['class' => 'form-control ckeditor', 'id' => 'followup_notes', 'label' => false]);                
                            echo " </div></div>";
                            echo "
                            <div class='form-group'>
                                <label for='user_id' class='col-sm-2 control-label'>" . __('Lead Entered By') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('user_id', ['type' => 'text', 'class' => 'form-control', 'readonly' => 'readonly', 'value' => $user_fullname, 'id' => 'user_id', 'label' => false]);
                            echo " </div></div>";  
                            
                            echo "
                            <div class='form-group'>
                                <label for='followup_date' class='col-sm-2 control-label'>" . __('Followup Date') . "</label>
                                <div class='col-sm-6 col-inline'>";
                                echo $this->Form->input('followup_date', ['type' => 'text','value' => date("d F, Y"),  'class' => 'form-control', 'id' => 'lead-followup-date', 'label' => false]);  
                                echo "<a href='javascript:void(0);' class='btn btn-info followup-lead-recipient-list'><i class='fa fa-envelope'></i></a>";           
                            echo " </div></div>";
                            
                            ?>

                            <div class='form-group'>
                                <label for='followup_date' class='col-sm-2 control-label'></label>
                                <div class='col-sm-6'>
                                    <div class="followup-source-users" style="margin-top: 27px;"></div>
                                </div>
                            </div>

                            <?php
                            echo "<hr />";
                            /*echo "
                            <div class='form-group'>
                                <label for='followup_date' class='col-sm-2 control-label'>" . __('Followup Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_date', ['type' => 'text', 'class' => 'form-control', 'id' => 'lead-followup-date', 'label' => false]);                
                            echo " </div></div>";    

                            echo "
                            <div class='form-group'>
                                <label for='followup_notes' class='col-sm-2 control-label'>" . __('Followup Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_notes', ['class' => 'form-control ckeditor', 'id' => 'followup_notes', 'label' => false]);                
                            echo " </div></div>";                            
                            
                            echo "
                            <div class='form-group'>
                                <label for='followup_action_reminder_date' class='col-sm-2 control-label'>" . __('Followup Action Reminder Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_action_reminder_date', ['type' => 'text', 'class' => 'form-control', 'id' => 'lead-followup-action-reminder-date', 'label' => false]);                
                            echo " </div></div>";  

                            echo "
                            <div class='form-group'>
                                <label for='followup_action_notes' class='col-sm-2 control-label'>" . __('Followup Action Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_action_notes', ['class' => 'form-control ckeditor', 'id' => 'followup_action_notes', 'label' => false]);                
                            echo " </div></div>";                                
                            
                            echo "
                            <div class='form-group'>
                                <label for='notes' class='col-sm-2 control-label'>" . __('Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('notes', ['class' => 'form-control ckeditor', 'id' => 'notes', 'label' => false]);                
                            echo " </div></div>"; */
                        ?>
                        <div class="form-group">
                            <label for='notes' class='col-sm-2 control-label'></label>
                            <div class='col-sm-6' style="padding-left:33px;">
                                <label class='checkbox'><input type="checkbox" name="send_email_notification"> Send email notification to users</label>
                                <label class='checkbox'><input type="checkbox" name="send_secondary_email_notification" id="send_secondary_email_notification"> Send seconday email notification to users</label>
                                <label class='checkbox'><input type="checkbox" name="send_specific_notification" id="send_specific_notification"> Send to specific source users</label>
                                <div class="source-users" style="margin-top: 27px;"></div>
                            </div>
                        </div>
                    </div>                    
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                            <?= $this->Form->button('<i class="fa fa-edit"></i> ' . __('Save and Continue adding'),['name' => 'save', 'value' => 'edit', 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <?php if( empty($source_id) ) { ?>
                                    <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?> 
                            <?php } else { ?>
                                    <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'from_source/'. $source_id],['class' => 'btn btn-warning', 'escape' => false]) ?>    
                            <?php } ?>                                                         
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>            
        </section>
    </div>
</section>