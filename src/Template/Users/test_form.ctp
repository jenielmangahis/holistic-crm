<script>
var BASE_URL = "<?php echo $base_url; ?>";
</script>

<section class="content-header">
    <h1>
        <?= __("Change Password") ?>
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?= $this->Html->link("About", ['controller' => get_customer_directory().'/about', 'action' => 'index'],['escape' => false]) ?></li>
        <li class="active">Change Password</li>
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
                    <?= $this->Form->create(null,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form']) ?>
                    <fieldset>        
                    <?php
                        echo "<div class='form-group'>";
                            echo "<div class='col-sm-12 form-label'>";
                                echo __("Old Password");
                            echo "</div>";
                            echo "<div class='col-sm-12'>";
                                echo $this->Form->input('old_password', ['class' => 'form-control', 'id' => 'old_password', 'label' => false, 'required', 'type' => 'password',]);
                                echo "<div class='help-block with-errors'></div>";
                            echo "</div>";                
                        echo " </div>";   

                        echo "<div class='form-group'>";
                            echo "<div class='col-sm-12 form-label'>";
                                echo __("New Password");
                            echo "</div>";
                            echo "<div class='col-sm-12'>";
                                echo $this->Form->input('password1', ['class' => 'form-control', 'id' => 'password1', 'label' => false, 'type' => 'password', 'required']);
                                echo "<div class='help-block with-errors'></div>";
                            echo "</div>";                
                        echo " </div>";  

                        echo "<div class='form-group'>";
                            echo "<div class='col-sm-12 form-label'>";
                                echo __("Confirm New Password");
                            echo "</div>";
                            echo "<div class='col-sm-12'>";
                                echo $this->Form->input('password2', ['class' => 'form-control', 'id' => 'password2', 'label' => false, 'type' => 'password', 'required']);
                                echo "<div class='help-block with-errors'></div>";
                            echo "</div>";                
                        echo " </div>";

                        echo "<div class='form-group'>";
                            echo "<div class='col-sm-12 form-label'>";
                                //echo __("Confirm New Password");
                            echo "</div>";
                            echo "<div class='col-sm-12'>";
                                echo '<a class="btn btn-lg btn-primary" id="frm-default-save" href="javascript:void(0);">Save</a>';
                            echo "</div>";                
                        echo " </div>";
                    ?>
                    </fieldset>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>
