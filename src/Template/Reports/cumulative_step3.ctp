<?php ?>
<style>
.list-group-item{
    margin:10px;    
}
.box-body{
    padding:2px 26px;
}
.date-range-group{
    background-color: #e6e9ed;
    margin:10px;
    padding: 5px;
}
.date-range-label{
    background-color: #3bafda;
    color:#ffffff;
    padding:10px;
    margin:0px;
}
</style>
<section class="content-header">
    <h1><?= __('Reports : Leads') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-tags'></i>" . __('Reports'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('Cumulative: Step 3') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box" >
                <div class="box-header">
                    <ol class="breadcrumb breadcrumb-arrow">
                        <li><a href="#">Step 1 : Sources</a></li>
                        <li><a href="#">Step 2 : Information</a></li>
                        <li class="active"><a href="#">Step 3 : Specify Date and Generate Report</a></li>
                    </ol>           
                </div>
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'generate_cumulative_report'],
                  'class' => 'form-horizontal',
                  'type' => 'POST'                 
                ]) ?> 
                <div class="box-body">
                    <h1>Please specify the date range you wish to generate report</h1>                    
                    <div class="row">
                        <div class="grp-form-date-range" style="margin-left:10px;margin-top:16px;">
                            <div class="col-md-4">
                                <div class='date-range-group'>
                                    <h3 class="date-range-label">Date From</h3>
                                    <div class="inline-datepicker-from"></div>
                                    <input type="hidden" name="date_from" value="" class="form-control date_from" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='date-range-group'>
                                    <h3 class="date-range-label">Date To</h3>
                                    <div class="inline-datepicker-to"></div>
                                    <input type="hidden" name="date_to" value="" class="form-control date_to" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                    <div class='form-group'>                        
                        <select class="form-control" name='report-type' style="width:20%;margin-left:25px;">
                            <option>- Select Report Type -</option>
                            <option>Excel</option>
                            <option>View in other tab</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-2">           
                            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "cumulative_step2"],["class" => "btn btn-success", "escape" => false]) ?>                            
                            <?= $this->Form->button(__('Generate Report'),['value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>