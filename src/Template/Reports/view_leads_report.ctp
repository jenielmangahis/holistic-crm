<?php ?>

	<section class="content-header">
	    <h1><?= __('Reports : Leads') ?></h1>
	    <ol class="breadcrumb">
	        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
	        <li><?= $this->Html->link("<i class='fa fa-tags'></i>" . __('Reports'), ['action' => 'index'],['escape' => false]) ?></li>
	        <li class="active"><?= __('Leads') ?></li>
	    </ol>
	</section>

<section class="content">

	<div class="row">

	    <div class="col-md-12">
	      <div class="box box-primary box-solid"> 
	        <div class="box-header with-border">  
	            <div class="user-block"><i class="fa fa-list-alt"></i> <?= __('Results') ?></div>                  
	        </div>     
	        <div class="box-body box-links" style="overflow-x:auto !important; overflow-y:auto !important; height: 580px;">
	            <table id="example_datatable" class="table table-hover table-striped table-scroll-body">
	                <thead class="thead-inverse">
	                    <tr>
	                        <th style="">-</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                        <th style="">Name</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php foreach($leads as $s) { ?>
	                            <tr>
	                                <td><a class="btn btn-info btn-xs" href="#">Edit</a></td>
	                                <td>Ttest</td>  
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>     
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td> 
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>
	                                <td>Ttest</td>                      
	                            </tr>
	                    <?php } ?>
	                </tbody>
	            </table>                               
	        </div>

	      </div>
	    </div>

		</div>
	</div>

</section>
