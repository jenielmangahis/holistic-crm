<?php ?>
<style>
.list-group-item{
    margin:10px;
}
.box-body{
    padding:2px 26px;
}
</style>
<section class="content-header">
    <h1><?= __('Reports : Leads') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-tags'></i>" . __('Reports'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('Leads: Step 1') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box" >
                <div class="box-header">
                    <ol class="breadcrumb breadcrumb-arrow">
                        <li class="active"><a href="#">Step 1 : Sources</a></li>
                        <li class="active"><a href="#">Step 2 : Information</a></li>
                        <li class="active"><a href="#">Step 3 : Fields</a></li>
                        <li><span>Step 4 : Report Type</span></li>
                    </ol>            
                </div>
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'step2'],
                  'class' => 'form-horizontal',
                  'type' => 'POST'                  
                ]) ?> 
                <div class="box-body">
                    <h1>What information would you like in the report (check all that apply)?</h1>                    
                    <div>
                        <div>
                            <ul class="list-group row">
                                <?php foreach($fields as $key => $value){ ?>
                                    <li class="list-group-item col-xs-2">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="fields[<?= $key; ?>]" /><?= $value; ?></label>
                                        </div>                                    
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-2">           
                            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "step2"],["class" => "btn btn-success", "escape" => false]) ?>                            
                            <?= $this->Form->button(__('Generate') . ' ' . '<i class="fa fa-arrow-right"></i> ',['value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>