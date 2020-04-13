<?php use Cake\ORM\TableRegistry; ?>
<?php $this->LeadLeadTypes = TableRegistry::get('LeadLeadTypes'); ?>
<style>
th{
	background-color: #374850;
	color:#ffffff;
}
th a{
	color:#ffffff;
}
th{
	border-bottom: 1px solid #ffffff !important;
}
td{
	border:1px solid #d1e0e0;
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
	<div class="row">
	    <div class="col-md-12">
	      <div class="box box-primary box-solid"> 
	        <div class="box-header with-border">  
	            <div class="user-block"><i class="fa fa-list-alt"></i> <?= __('Results') ?><?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'),["action" => "step3"],["class" => "btn btn-success pull-right", "escape" => false]) ?></div>                  
	        </div>     
	        <div class="box-body box-links" style="overflow-x:auto !important; overflow-y:auto !important; height: 490px;">
	            <table class="table table-hover table-striped table-scroll-body">
	                <thead class="thead-inverse">
	                    <?php $total_cols = count($fields);?>
	                	<tr>
	                		<th colspan="<?= $total_cols + 2; ?>">Total Leads : <?= $leads->count(); ?></th>
	                	</tr>
	                    <tr>
	                        <th class="actions">Action</th>
	                        <th>#</th>
	                        <?php foreach($fields as $fkey => $f) { ?>
	                        		<th style=""><?= $this->Paginator->sort($fkey, $fkey . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
	                        <?php } ?>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $count_leads = 1; foreach($leads as $s) { ?>
	                            <tr>
	                                <td class="table-actions">
	                                	<?= $this->Html->link("<i class='fa fa-pencil'></i> " . __("Edit"), ['controller' => 'leads', 'action' => 'edit/'. $s->id],['escape' => false, 'class' => 'btn btn-info', 'target' => '_blank']) ?>
	                                </td>
	                                <td style="width:1%;"><?= $count_leads; ?></td>
	                                <?php
	                                foreach( $fields as $key => $value ){  
	                                	if($key == 'source_id') {
	                                ?>
	                                			<td><?php echo $s->source->name; ?></td>  
	                                	<?php }elseif($key == 'status_id') { ?>
	                                			<td><?php echo $s->status->name; ?></td> 
	                                	<?php }elseif($key == 'interest_type_id') { ?>
	                                			<td><?php echo $s->interest_type->name; ?></td> 
	                                	<?php }elseif($key == 'lead_type_id') { ?>
	                                			<td>
	                                				<?php 
	                                					$leadLeadTypes = $this->LeadLeadTypes->find('all')
	                                						->contain(['LeadTypes'])
	                                						->where(['LeadLeadTypes.lead_id' => $s->id])
	                                					;

	                                					$leadTypes = array();
	                                					foreach($leadLeadTypes as $lt){
	                                						$leadTypes[$lt->lead_type->name] = $lt->lead_type->name;
	                                					}

	                                					echo implode(",", $leadTypes);
	                                				?>
	                                			</td> 
	                                	<?php }elseif($key == 'lead_action') { ?>
	                                			<td>
												  	<div style="width:350px;"><?php echo substr($s->lead_action,0,100); ?></div>
												  	<?php if (strlen($s->lead_action) > 100) { ?>
														  	<div style="width:350px !important;" id="lead_action_<?php echo $s->id; ?>" class="collapse">
														    	<?php echo substr($s->lead_action,100); ?>
														  	</div>
														  	<a href="javascript:void(0);" data-toggle="collapse" data-target="#lead_action_<?php echo $s->id; ?>">View More</a>
												  	<?php } ?>
	                                			</td>
	                                	<?php }elseif($key == 'followup_notes') { ?>
	                                			<td>
												  	<div style="width:350px;"><?php echo substr($s->followup_notes,0,100); ?></div>
												  	<?php if (strlen($s->followup_notes) > 100) { ?>
														  	<div style="width:350px !important;" id="followup_notes_<?php echo $s->id; ?>" class="collapse">
														    	<?php echo substr($s->followup_notes,100); ?>
														  	</div>
														  	<a href="javascript:void(0);" data-toggle="collapse" data-target="#followup_notes_<?php echo $s->id; ?>">View More</a>
												  	<?php } ?>
	                                			</td>
	                                	<?php }elseif($key == 'notes') { ?>
	                                			<td>
												  	<div style="width:350px;"><?php echo substr($s->notes,0,100); ?></div>
												  	<?php if (strlen($s->notes) > 100) { ?>
														  	<div style="width:350px !important;" id="notes_<?php echo $s->id; ?>" class="collapse">
														    	<?php echo substr($s->notes,100); ?>
														  	</div>
														  	<a href="javascript:void(0);" data-toggle="collapse" data-target="#notes_<?php echo $s->id; ?>">View More</a>
												  	<?php } ?>
	                                			</td>
	                                	<?php }elseif($key == 'address') { ?>
	                                			<td>
												  	<div style="width:150px;"><?php echo substr($s->address,0,100); ?></div>
												  	<?php if (strlen($s->address) > 100) { ?>
														  	<div style="width:150px !important;" id="address_<?php echo $s->id; ?>" class="collapse">
														    	<?php echo substr($s->address,100); ?>
														  	</div>
														  	<a href="javascript:void(0);" data-toggle="collapse" data-target="#address_<?php echo $s->id; ?>">View More</a>
												  	<?php } ?>
	                                			</td>
	                                	<?php } else { ?>
	                                			<td><?php echo $s->{$key} ?></td>
	                                	<?php } ?>
	                                <?php } ?>
	                                
	                            </tr>
	                    <?php $count_leads++;} ?>
	                </tbody>
	            </table>         

	        </div>

	      </div>

	    </div>

		</div>
	</div>
</section>
