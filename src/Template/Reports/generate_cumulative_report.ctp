<?php ?>

	<section class="content-header">
	    <h1><?= __('Reports : Cumulative') ?></h1>
	    <ol class="breadcrumb">
	        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
	        <li><?= $this->Html->link("<i class='fa fa-tags'></i>" . __('Reports'), ['action' => 'index'],['escape' => false]) ?></li>
	        <li class="active"><?= __('Cumulative') ?></li>
	    </ol>
	</section>

<section class="content">
	<div class="row">
	    <div class="col-md-12">
	      <div class="box box-primary box-solid"> 
	        <div class="box-header with-border">  
	            <div class="user-block"><i class="fa fa-list-alt"></i> <?= __('Results') ?><?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "cumulative_step3"],["class" => "btn btn-success pull-right", "escape" => false]) ?></div>                  
	        </div>     
	        <div class="box-body box-links" style="">
	        	<div class="chart">
	            	<canvas id="barChart" style="height:auto;"></canvas>
	            </div>
	        </div>
	      </div>
	    </div>		
	</div>
</section>
