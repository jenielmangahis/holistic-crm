<?php ?>
<style>
.form-caption{
    background-color: #3C8DBC;
    color:#ffffff;
    padding: 5px;
}
.allocation-users-list{
    list-style: none;
}
.allocation-users-list li{
    display: inline-block;
    margin:15px;
    padding: 5px;
    border: 1px solid #d2d6de;
    background-color:#ecf0f5;
}
.allocation-users-list li div.checkbox{
    padding:0px;
    min-height: 0;
}
</style>
<section class="content-header">
    <h1><?= __('Allocation Assign Users') ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> System Settings</a></li>
        <li><a href="<?php echo $base_url; ?>"><i class="fa fa-gear"></i> Allocations</a></li>        
        <li class="active"><?= __('Assign Users') ?></li>
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
                    <?= $this->Form->create(null,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
                    <fieldset>        
                        <h3 class="form-caption" style="background-color:#374850;">Allocation : <?php echo $allocation->name; ?></h3>         
                        <?php if( $users ){ ?>               
                            <h3 class="form-caption">Check user to assign in this allocation</h3>
                            <ul class="allocation-users-list">
                            <?php foreach($users as $u){ ?>
                                <li>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="allocation_users[<?php echo $u->id; ?>]" /> <?php echo $u->firstname . ' ' . $u->lastname; ?></label>
                                    </div>
                                </li>
                            <?php } ?>
                            </ul>
                        <?php }else{ ?>
                            <div class="callout callout-warning">
                                <p>No user(s) to assign!</p>
                            </div>
                        <?php } ?>                        
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>                            
                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'user_list', $allocation->id],['class' => 'btn btn-warning', 'escape' => false]) ?>                            
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>