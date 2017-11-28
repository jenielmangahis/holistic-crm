<?php ?>
<style>
ul.token-input-list-facebook {
    min-height: 33px;
    border-color: #d2d6de;
}
td.field-name{
    width:18%;
}
td.field-chkbox{
    width:2%;
}
</style>
<section class="content-header">
    <h1><?= __('Reports : Leads') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-tags'></i>" . __('Reports'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('Leads') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box " >
                <div class="box-header">

                </div>
                <?= $this->Form->create(null,[                
                  'url' => ['action' => 'generate_report'],
                  'class' => 'form-horizontal',
                  'type' => 'POST'
                ]) ?> 
                <div class="box-body">
                    <?php include_once('_leads_filter.ctp'); ?>
                    <?php include_once('_leads_fields.ctp'); ?>

                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-search"></i> ' . __('Generate Report'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </section>
    </div>
</section>