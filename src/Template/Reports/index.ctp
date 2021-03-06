<?php ?>
<style>
.list-group-item{
    margin:10px;
    flex: 1 0 20%; /* explanation below */
    margin: 5px;
    height: 80px;
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
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box">
                <div class="box-header">
                    <ol class="breadcrumb breadcrumb-arrow">
                        <li class="active"><a href="#">Step 1 : Sources</a></li>
                        <li><span>Step 2 : Information</span></li>
                        <li><span>Step 3 : Fields and Generate Report</span></li>                        
                    </ol>            
                </div>
                
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'index'],
                  'class' => 'form-horizontal',
                  'type' => 'POST'                  
                ]) ?> 
                <div style="display: inline-block;width: 76%;">
                    <h1 class="pull-left">Select sources you like a report for</h1>
                    <div class="checkbox pull-right" style="margin-top:37px;padding:10px;border:1px solid #ddd;">
                        <label><input type="checkbox" class="select-all-sources"  />Check All</label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="box-body">
                    <div>
                        <ul class="list-group row">
                            <?php foreach($sources as $s){ ?>
                                <?php 
                                    $checked = '';
                                    if( isset($report_data['sources']) ){
                                        if( array_key_exists($s->id, $report_data['sources']) ){
                                            $checked = 'checked="checked"';
                                        }
                                    }
                                ?>
                                <li class="list-group-item col-xs-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" <?= $checked; ?> name="sources[<?= $s->id; ?>]" class="chk-sources" /> <?= $s->name; ?></label>
                                    </div>                                    
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-2">                            
                            <?= $this->Form->button(__('Next') . ' ' . '<i class="fa fa-arrow-right"></i> ',['value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>