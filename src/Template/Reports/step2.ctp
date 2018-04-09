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
                        <li><span>Step 3 : Fields</span></li>
                        <li><span>Step 4 : Report Type</span></li>
                    </ol>            
                </div>
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'step2'],
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
                                            if( isset($reportData['information']) && $reportData['information'] == $key ){
                                                $selected = 'checked="checked"';
                                                $hidden   = '';
                                            }else{
                                                $hidden = "hidden";
                                            }
                                        ?>
                                        <label><input type="radio" <?= $selected ?> name="information" class="optInformation" value=<?= $key; ?> /> <?= $value; ?></label>
                                        <?php if( $key == 7 ){ ?>   
                                            <div class="grp-form-types <?= $hidden; ?>">
                                                <ul class="list-group">
                                                    <li class="list-group-item col-xs-4" style="border:none;margin:4px;">Select Form Type : </li>
                                                    <?php foreach($optionFormLocations as $flKey => $flValue){ ?>
                                                        <li class="list-group-item col-xs-3" style="border:none;margin:4px;width:20%;">
                                                            <label><input type="checkbox" name="sources[<?= $flKey; ?>]" /> <?= $flValue; ?></label>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php }elseif( $key == 2 ){ ?>
                                            <?php 
                                                $date_from = date("Y-m-d");
                                                $date_to   = date("Y-m-d");
                                                if( isset($reportData['dateRange']['from']) ){
                                                    $date_from = $reportData['dateRange']['from'];
                                                }

                                                if( isset($reportData['dateRange']['to']) ){
                                                    $date_to = $reportData['dateRange']['to'];
                                                }
                                            ?>
                                            <div class="grp-form-date-range <?= $hidden; ?>" style="margin-left:10px;margin-top:16px;">
                                            <div class="col-md-10">
                                                <div class='form-group'>
                                                    <input type="text" name="dateRange[from]" value="<?= $date_from; ?>" placeholder="Date From" class="default-datepicker form-control" />
                                                </div>
                                                <div class='form-group'>
                                                    <input type="text" name="dateRange[to]" value="<?= $date_to; ?>" placeholder="Date To" class="default-datepicker form-control" />
                                                </div>
                                            </div>
                                            </div>
                                        <?php } ?>
                                    </div>                                    
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-2">           
                            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "index"],["class" => "btn btn-success", "escape" => false]) ?>                            
                            <?= $this->Form->button(__('Next') . ' ' . '<i class="fa fa-arrow-right"></i> ',['value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>