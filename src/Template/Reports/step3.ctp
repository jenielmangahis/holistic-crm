<?php ?>
<style>
.list-group-item{
    margin:10px;
    flex: 1 0 20%; /* explanation below */
    margin: 5px;
    height: 60px;
    overflow: auto;

}
.list-group{

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
                        <li class="active"><a href="#">Step 3 : Fields and Generate Report</a></li>                        
                    </ol>            
                </div>
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'generate_leads_report'],
                  'class' => 'form-horizontal',
                  'type' => 'POST'                 
                ]) ?> 
                <div style="display: inline-block;width: 85%;">
                    <h1 class="pull-left">What information would you like in the report (check all that apply)?</h1>
                    <div class="checkbox pull-right" style="margin-top:37px;padding:10px;border:1px solid #ddd;">
                        <label><input type="checkbox" class="select-all-sources"  />Check All</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="box-body">          
                    <div>
                        <div>
                            <ul class="list-group row">
                                <?php foreach($fields as $key => $value){ ?>
                                    <li class="list-group-item col-sm-2 col-md-2">
                                        <div class="checkbox">
                                            <?php 
                                                $checked = '';
                                                if( array_key_exists($key, $report_data['fields']) ){
                                                    $checked = 'checked="checked"';
                                                }
                                            ?>
                                            <label><input type="checkbox" <?= $checked; ?> name="fields[<?= $key; ?>]" class="chk-sources" /><?= $value; ?></label>
                                        </div>                                    
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <hr />
                    <div class='form-group'>                        
                        <select class="form-control" name='report-type' style="width:20%;margin-left:15px;">
                            <option>- Select Report Type -</option>
                            <option>Excel</option>
                            <option>View in other tab</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-3">           
                            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "step2"],["class" => "btn btn-success", "escape" => false]) ?>                            
                            <?= $this->Form->button(__('Generate Report'),['value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>