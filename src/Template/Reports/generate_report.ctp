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
	        <div class="box-body box-links" style="overflow-x:auto !important; overflow-y:auto !important; height: 490px;">
	            <table id="example_datatable" class="table table-hover table-striped table-scroll-body">
	                <thead class="thead-inverse">
	                    <tr>
	                        <th style="">Action</th>
	                        <?php foreach($fields as $fkey => $f) { ?>
	                        		<th style=""><?php echo $f; ?></th>
	                        <?php } ?>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php foreach($leads as $s) { ?>
	                            <tr>
	                                <td>
	                                	<?= $this->Html->link("" . __("Edit"), ['controller' => 'leads', 'action' => 'edit/'. $s->id],['escape' => false, 'class' => 'btn btn-info btn-xs', 'target' => '_blank']) ?>
	                                </td>
	                                <?php
	                                foreach( $fields as $key => $value ){  
	                                	if($key == 'source_id') {
	                                ?>
	                                			<td><?php echo $s->source->name; ?></td>  
	                                	<?php }elseif($key == 'status_id') { ?>
	                                			<td><?php echo $s->status->name; ?></td> 
	                                	<?php }elseif($key == 'interest_type_id') { ?>
	                                			<td><?php echo $s->interest_type->name; ?></td> 
	                                	<?php } else { ?>
	                                			<td><?php echo $s->{$key} ?></td>
	                                	<?php } ?>
	                                <?php } ?>
	                                
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
