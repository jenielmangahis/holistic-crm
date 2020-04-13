<?php 
use Cake\ORM\TableRegistry;
$this->Leads = TableRegistry::get('Leads');
$this->LeadAttachments = TableRegistry::get('LeadAttachments');
?>
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
.table-email-notif-history thead tr, .table-email-notif-history tbody tr{
    font-size: 12px;
}
.table-email-notif-history thead th{
    background-color: #222D32;
    color:#ffffff;
}
.table-email-notif-history tbody tr{
    background-color: #666;
    color:#ffffff;
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
.followup-notes-bubble{
    display: block;
    padding: 10px;
    border-radius: 10px;
    margin: 0px 0px;
    background-color: #0074D9;
    color: #ffffff;
}
.specific-source-users{
    list-style: none;
    margin: 5px;
    padding: 0px;
}
.specific-source-users li{
    display: inline-block;
    width: 24%;
    font-size: 16px;
    padding: 0 10px;
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
                    <?= $this->Form->create($lead,['id' => 'frm-default-add', 'type' => 'post', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
                    <?= $this->Form->hidden('lead_id', ['id' => 'lead_id', 'value' => $lead->id]); ?>
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
                            <h3 class="form-hdr">Attachments <button value='edit' class="btn btn-small btn-success pull-right" style="line-height: 0px;margin-left:5px;"><i class="fa fa-save"></i> Save</button><a class="btn btn-info btn-small pull-right attachment-add-row" href="javascript:void(0);" style="line-height: 0px;"><i class="fa fa-plus"></i></a></h3>
                            <?php if( count($lead->lead_attachments) > 0){ ?>
                                <table class="current-lead-attachments">
                                    <?php foreach($lead->lead_attachments as $a){ ?>
                                        <tr>
                                            <td style="padding:10px;">
                                                <input type="hidden" name="currentAttachments[<?= $a->id; ?>]" value="<?= $a->id; ?>" />
                                                <?php
                                                    $file = $this->Url->build("/webroot/" . $this->LeadAttachments->getFolderName() . $lead->id . '/' . $a->attachment);
                                                    echo $this->Html->link('<i class="fa fa-file"></i> Download - ' . $a->attachment, ['controller' => 'lead_attachments', 'action' => 'download_file/', $a->id],['class' => 'btn btn-info', 'escape' => false]);
                                                    //echo "<a class='btn btn-info' target='_blank' href='" . $file . "' >View Attachement - " . $a->attachment . "</a>";
                                                ?>
                                            </td>
                                            <td><a class='btn btn-danger current-attachment-delete-row' href='javascript:void(0);'><i class='fa fa-trash'></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php }else{ echo "<div class='alert alert-warning'>No Attachment</div>"; } ?>
                            
                            <hr />
                            <table class="lead-attachments">
                                <tr>
                                    <td style="width:40%;">&nbsp;</td>
                                    <td><input type="file" name="attachments[]" /></td>
                                </tr>
                            </table>
                            <h3 class="form-hdr">
                                Apply to Specific Users - Optional
                                <a class="btn btn-info pull-right" data-toggle="collapse" href="#specificUsersContainer" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" style="line-height: 0px;"><i class="fa fa-arrow-circle-down"></i></a>
                            </h3>

                            <div class="collapse multi-collapse" id="specificUsersContainer">                                
                              <div class="card card-body">
                                <ul class="specific-source-users">
                                    <?php foreach( $nonAdminUsers as $u ){ ?>
                                        <li>
                                            <div class='checkbox'>
                                                <label>
                                                    <?php 
                                                        $specific_is_checked = '';
                                                        if( array_key_exists($u->id, $a_specific_user_leads) ){
                                                            $specific_is_checked = 'checked="checked"';
                                                        }
                                                    ?>
                                                    <input type='checkbox' <?php echo $specific_is_checked; ?> name='specificUser[<?php echo $u->id; ?>]' value="<?php echo $u->id; ?>" /><?php echo $u->firstname . ' ' . $u->lastname; ?>
                                                </label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                              </div>
                            </div>                            
                            <h3 class="form-hdr">Other Information</h3>
                            <?php
                            echo "
                            <div class='form-group'>
                                <label for='lead_attachment' class='col-sm-2 control-label'>" . __('Old Attachment') . "</label>
                                <div class='col-sm-6'>";
                                if( $lead->attachment != '' ){
                                    $file = $this->Url->build("/webroot/" . $this->Leads->getFolderName() . $lead->id . '/' . $lead->attachment);
                                    echo "<a class='btn btn-info' target='_blank' href='" . $file . "' >View Attachement</a>";
                                }else{ 
                                    echo "<div class='alert alert-warning'>No Attachment</div>";
                                }
                            echo "</div></div>";

                            echo "
                            <div class='form-group'>
                                <label for='status_id' class='col-sm-2 control-label'>" . __('Date Lead Entered') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('lead_entered', ['value' => date("d F, Y", strtotime($lead->created)), 'class' => 'form-control', 'readonly' => 'readonly', 'disabled' => 'disabled', 'label' => false]);                 
                            echo " </div></div>";
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
                            /*$action = str_replace('&#039;', "'", $lead->lead_action); 
                            $action = str_replace('\"', '"', $action); 
                            $action = str_replace("\'", "'", $action);
                            $action = h($action);
                            $action = str_replace("&quot;", '"', $action);
                            $action = str_replace("&amp;amp;", '&&', $action);
                            $action = str_replace("&amp;", '&', $action);
                            //$action = sanitizeString($action);
                            $action = str_replace("&gt;", ">", $action);*/

                            echo "
                            <div class='form-group'>
                                <label for='lead_action' class='col-sm-2 control-label'>" . __('Action') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('lead_action', ['value' => str_replace('\"', "", $lead->lead_action), 'escape' => false, 'class' => 'form-control', 'id' => 'lead_action', 'type' => 'textarea', 'label' => 
                                false]);
                            echo " </div>";
                            ?> 

                            <div class='col-md-3'>
                                <div class='callout callout-info'>
                                    <b>
                                        <a href='javascript:void(0);' style='display: none;' id='hide_enotif_history'>Hide Email Notification History</a>
                                        <a href='javascript:void(0);' id='show_enotif_history'>Show Email Notification History</a>
                                    </b>
                                    <div id='email_notif_history' style='display: none;'>
                                    <br />
                                    <table class="table table-default table-email-notif-history">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>User</th>
                                                <th>Date Sent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($leadEmailNotificationHistory as $ah){ ?>
                                                <tr>
                                                    <td><?= $ah->user->firstname . ' ' . $ah->user->lastname; ?></td>
                                                    <td><?= $ah->date_time->format("Y-m-d H:i:s"); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    </div>                                   
                                </div>
                            </div>

                            <?php
                            echo "</div>";
                            echo "
                            <div class='form-group'>
                                <label for='source_id' class='col-sm-2 control-label'>" . __('Source') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('source_id', ['class' => 'form-control', 'id' => 'source_id', 'label' => false, 'options' => $sources]);                 
                            echo " </div></div>";
                            ?>
                            <?php 
                                if( $lead->source->is_va == 1 ){
                                    $is_hidden = '';
                                }else{
                                    $is_hidden = 'hidden';
                                }
                            ?>
                            <div class="va-group <?= $is_hidden; ?>">
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
                                        echo $this->Form->input('va_request_form_completed', ['type' => 'text', 'value' => date("d F, Y", strtotime($lead->va_request_form_completed)), 'class' => 'form-control allocation-datepicker', 'id' => 'va_request_form_completed', 'label' => false]);                
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
                                        echo $this->Form->input('va_name', ['class' => 'form-control', 'id' => 'va_name', 'value' => $lead->va_name, 'label' => false]);
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='va_start_date' class='col-sm-2 control-label'>" . __('VA Start Date') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_start_date', ['type' => 'text', 'value' => date("d F, Y", strtotime($lead->va_start_date)), 'class' => 'form-control allocation-datepicker', 'id' => 'va_start_date', 'label' => false]);
                                    echo " </div></div>";

                                    echo "
                                    <div class='form-group'>
                                        <label for='va_exit_date' class='col-sm-2 control-label'>" . __('VA Exit Date') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('va_exit_date', ['type' => 'text', 'value' => date("d F, Y", strtotime($lead->va_exit_date)), 'class' => 'form-control allocation-datepicker', 'id' => 'va_exit_date', 'label' => false]);
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

                            $class_willing_review = "";                            
                            if( $lead['willing_to_review'] != 1 ){
                                $class_willing_review = "hidden";
                                $date_review = date("d F, Y");
                            }else{
                                $date_review = date("d F, Y",strtotime($lead['willing_to_review_date']));
                            }

                            echo "
                            <div class='grp-willing-review-date " . $class_willing_review . "'>
                            <div class='form-group'>
                                <label for='willing_to_review_date' class='col-sm-2 control-label'>" . __('Willing to Review Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('willing_to_review_date', ['type' => 'text', 'value' => $date_review, 'class' => 'form-control default-datepicker', 'id' => 'willing_to_review_date', 'label' => false]);
                            echo " </div></div></div>"; 
                            echo "
                            <div class='form-group'>
                                <label for='lead_type_id' class='col-sm-2 control-label'>" . __('Lead Source') . "</label>
                                <div class='col-sm-6'>";
                                echo "<ul class='lead-type-list'>";
                                    foreach( $leadTypes as $key => $value ){
                                        $is_checked = '';
                                        if( array_key_exists($key, $leadTypeIds) ){
                                            $is_checked = 'checked="checked"';
                                        }
                                        echo "<li>";
                                        echo "<div class='checkbox'>";
                                            echo "<label><input type='checkbox' " . $is_checked . " name='leadTypeIds[" . $key . "]' />" . $value . "</label>";
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
                                echo $this->Form->input('allocation_date', ['type' => 'text', 'class' => 'form-control allocation-datepicker', 'value' => $lead->allocation_date->format("d F, Y"), 'id' => 'lead-allocation-date', 'label' => false]);                
                            echo " </div></div>"; */   
                            
                            echo "
                            <div class='form-group'>
                                <label for='interest_type_id' class='col-sm-2 control-label'>" . __('Interest Type') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('interest_type_id', ['class' => 'form-control', 'id' => 'interest_type_id', 'label' => false, 'options' => $interestTypes]);                
                            echo " </div></div>";    
                            ?>
                            <div class="lead-followup-notes">
                                <div class='form-group'>
                                    <label class='col-sm-2 control-label'></label>
                                    <div class="col-sm-6">
                                        <table class="table">
                                            <tbody>
                                                <?php if($lead->followup_notes != ''){ ?>
                                                <tr>
                                                    <td>
                                                        <div class="followup-notes-bubble"> 
                                                            <small><i class="fa fa-user"></i> Posted By : <?= $lead->user->firstname . ' ' . $lead->user->lastname; ?></small><br />
                                                            <small><i class="fa fa-calendar"></i> Date Posted : <?= $lead->created->format("Y-m-d H:i:s"); ?></small><br />
                                                            <hr />                                                           
                                                            <?= $lead->followup_notes; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            <?php foreach($leadFollowupNotes as $lf){ ?>
                                                <tr>
                                                    <td>
                                                        <div class="followup-notes-bubble">
                                                            <small><i class="fa fa-user"></i> Posted By : <?= $lf->user->firstname . ' ' . $lf->user->lastname; ?></small><br />
                                                            <small><i class="fa fa-calendar"></i> Date Posted : <?= $lf->date_posted->format("Y-m-d H:i:s"); ?></small><br />
                                                            <hr />
                                                            <?= $lf->notes; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                                
                            </div>
                            <?php
                            echo "
                            <div class='form-group'>
                                <label for='followup_notes' class='col-sm-2 control-label'>" . __('Add Followup Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_notes', ['value' => '', 'class' => 'form-control ckeditor', 'id' => 'followup_notes', 'label' => false]);                
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
                                echo $this->Form->input('followup_date', ['type' => 'text','value' => $lead->followup_date->format("d F, Y"),  'class' => 'form-control', 'id' => 'lead-followup-date', 'label' => false]);  
                                echo "<a href='javascript:void(0);' class='btn btn-info followup-lead-recipient-list'><i class='fa fa-envelope'></i></a>";           
                            echo " </div></div>";
                            ?>
                            <div class='form-group'>
                                <label for='followup_date' class='col-sm-2 control-label'>Followup Notes</label>
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
                                echo $this->Form->input('followup_date', ['type' => 'text','value' => $lead->followup_date->format("d F, Y"),  'class' => 'form-control', 'id' => 'lead-followup-date', 'label' => false]);                
                            echo " </div></div>";    

                            echo "
                            <div class='form-group'>
                                <label for='followup_notes' class='col-sm-2 control-label'>" . __('Followup Notes') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_notes', ['class' => 'form-control ckeditor', 'id' => 'followup_notes', 'label' => false]);                
                            echo " </div></div>";                             
                            
                            if( $lead->followup_action_reminder_date == '12/31/69' ){
                                $followup_action_reminder_date = '';
                            }else{
                                $followup_action_reminder_date = $lead->followup_action_reminder_date->format("d F, Y");
                            }

                            echo "
                            <div class='form-group'>
                                <label for='followup_action_reminder_date' class='col-sm-2 control-label'>" . __('Followup Action Reminder Date') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('followup_action_reminder_date', ['type' => 'text', 'class' => 'form-control', 'value' => $followup_action_reminder_date, 'id' => 'lead-followup-action-reminder-date', 'label' => false]);                
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
                            echo " </div></div>";*/    
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
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                            <?= $this->Form->button('<i class="fa fa-edit"></i> ' . __('Save and Continue editing'),['name' => 'save', 'value' => 'edit', 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <?php if( empty($source_id) ) { ?>
                                    <?php if($redir == 'dashboard') { ?>
                                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['controller' => 'users', 'action' => 'dashboard'],['class' => 'btn btn-warning', 'escape' => false]) ?>
                                    <?php }else { ?>
                                            <a href="<?= $back_url; ?>" class="btn btn-warning"><i class="fa fa-angle-left"> </i> Back To list</a>                                            
                                    <?php } ?>
                                    
                            <?php } else { ?>
                                    <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'from_source/'. $source_id],['class' => 'btn btn-warning', 'escape' => false]) ?>    
                            <?php } ?>                      
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>

<script>

</script>