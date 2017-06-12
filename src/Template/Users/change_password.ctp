<div class="cd-tabs">
  <style type="text/css">
    label
    {
      padding: 10px;
      padding-left: 0px;
      padding-top: 0px;
      }
    .callout-info{
        background-color: #69CFD0;
        color:#ffffff;
        padding: 10px;
        margin-bottom: 20px;
        margin-top:20px;
    }
  </style>
<ul class="cd-tabs-content" style="width: 100%;float: left;">
    <li data-content="tab1" class="selected">
  <!-- second partition -->
  <div class="page-title" align="center">
    <h1 style="font-size: 30px; color: #000"> Change Password</h1>
   
    <br>
    <br>
   
  </div>
  <div class="col-md-12" style="color: #000">
  <!-- form here -->
  <div class="portlet light " style="width:100%; float:left;">
    <div class="portlet-title">
      <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <?= $this->Form->create(null,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>                    
                    <fieldset>                                                 
                        <?php
                                    echo "
                                    <div class='form-group'>
                                        <label for='start_date' class='col-sm-2 control-label'>" . __('Your email') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('email_address', ['value' => $user_data->email, 'readonly' => 'readonly', 'disabled' => 'disabled', 'class' => 'form-control', 'id' => 'email_address', 'required' => 'required', 'type' => 'email', 'label' => false]);                
                                    echo " </div></div>";
                                                           
                                                            echo "
                                    <div class='form-group'>
                                        <label for='password' class='col-sm-2 control-label'>" . __('New Password') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('password', ['value' => "", 'class' => 'form-control', 'id' => 'password', 'required' => 'required', 'label' => false]);                
                                    echo " </div></div>";    
                                    
                                                            echo "
                                    <div class='form-group'>
                                        <label for='repassword' class='col-sm-2 control-label'>" . __('Confirm Password') . "</label>
                                        <div class='col-sm-6'>";
                                        echo $this->Form->input('repassword', ['type' => 'password', 'value' => "", 'class' => 'form-control', 'id' => 'repassword', 'required' => 'required', 'label' => false]);                
                                    echo " </div></div>";
                        ?>
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="action-fixed-bottom">
                                <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Update'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>                                
                                <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back to profile'), ['controller' => 'profile', 'action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
        <!-- END FORM-->
      </div>
    </div>
    <!-- Form Here -->
  </div>
  <!-- second partition ==-->
  </div>
</li>
</ul>
</div>
