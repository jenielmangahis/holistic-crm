<?php use Cake\ORM\TableRegistry; ?>
<?php $this->Leads = TableRegistry::get('Leads'); ?>
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
    <h1><?= __('Reports : Cumulative') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-tags'></i>" . __('Reports'), ['action' => 'cumulative'],['escape' => false]) ?></li>
        <li class="active"><?= __('Cumulative: Step 2') ?></li>
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
                        <li class="active"><a href="#">Step 2 : Information</a></li>
                        <li><span>Step 3 : Specify Date and Generate Report</span></li>
                    </ol>            
                </div>
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'cumulative_step2'],
                  'class' => 'form-horizontal',
                  'type' => 'POST'                  
                ]) ?> 
                <div class="box-body">
                    <h1>What information would you like to know?</h1>                    
                    <div>
                        <ul class="list-group row">
                            <?php foreach($optionInformation as $key => $value){ ?>
                                <li class="list-group-item col-xs-5">
                                    <div class="checkbox">
                                        <?php 
                                            $selected = '';
                                            if( isset($report_data['information']) && $report_data['information'] == $key ){
                                                $selected = 'checked="checked"';
                                                $hidden   = '';
                                            }else{
                                                $hidden = "hidden";
                                            }
                                        ?>
                                        <label><input type="radio" <?= $selected ?> name="information" class="optInformation" value=<?= $key; ?> /> <?= $value; ?></label>
                                    </div>                                    
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-2">           
                            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "cumulative"],["class" => "btn btn-success", "escape" => false]) ?>                            
                            <?= $this->Form->button(__('Next') . ' ' . '<i class="fa fa-arrow-right"></i> ',['value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>