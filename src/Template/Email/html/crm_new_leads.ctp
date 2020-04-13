<?php 
use Cake\ORM\TableRegistry;
$this->UserLeadFollowupNotes = TableRegistry::get('UserLeadFollowupNotes');
$this->Leads = TableRegistry::get('Leads');
$followupNotes =  $this->UserLeadFollowupNotes->find('all')
	->contain(['Users'])
	->where(['UserLeadFollowupNotes.lead_id' => $lead['id']])
;
$optionsWillToReview = $this->Leads->optionsWillToReview();
?>
<p>Hi,</p>
<p>A new lead has been entered into the Holistic CRM. To update any details regarding this lead login here: <a href="https://www.holisticwebpresencecrm.com/leads/edit/<?= $lead['id']; ?>">http://holisticwebpresencecrm.com</a></p>
<h3 class="form-hdr" style="background-color: #222D32;color:#ffffff;padding: 10px;">Lead Personal Information</h3>
<table>
<tr>
	<td>Name</td>
	<td>: <?php echo $lead['firstname'] . ' ' . $lead['surname']; ?></td>
</tr>
<tr>
	<td>Email</td>
	<td>: <?php echo $lead['email']; ?></td>
</tr>
<tr>
	<td>Phone</td>
	<td>: <?php echo $lead['phone']; ?></td>
</tr>
<tr>
	<td>City / State</td>
	<td>: <?php echo $lead['city'] . ' / ' . $lead['state']; ?></td>
</tr>
<tr>
	<td>Address</td>
	<td>: <?php echo $lead['address']; ?></td>
</tr>	
</table>

<h3 class="form-hdr" style="background-color: #222D32;color:#ffffff;padding: 10px;">Other Information</h3>
<table>
<!-- <tr>
	<td>Attachments</td>
	<td>: 
		<?php 
			/*foreach( $aAttachments as $a ){
				$file = $this->Url->build("/webroot/" . $attachment_folder . '/' . $a,'true');
				echo "<a target='_blank' href='" . $file . "'>Download Attachment - " . $a . "</a><br />";
			}*/
		?>
		<?php 
			/*if( $lead_attachment != '' ){
				$file = $this->Url->build("/webroot/" . $attachment_folder . '/' . $lead_attachment,'true');
				echo "<a target='_blank' href='" . $file . "'>Download Attachment</a>";
			}else{
				echo "No Attachment";
			}*/
		?>
	</td>
</tr> -->
<tr>
	<td>Status</td>
	<td>: <?php echo $lead['status']['name']; ?></td>
</tr>
<tr>
	<td>Action</td>
	<td>: 
		<?php
			$action = str_replace('\"', '"', $lead['lead_action']); 
			$action = str_replace("\'", "'", $action);
			//$action = h($action);
			$action = str_replace("&#039;", "'", $action);
            $action = str_replace("&quot;", '"', $action);
            $action = str_replace("&amp;amp;", '&&', $action);
            $action = str_replace("&amp;", '&', $action);
            $action = $this->Text->autoParagraph($action);
			echo $action; 
		?>
	</td>
</tr>
<tr>
	<td>Source</td>
	<td>: <?php echo $lead['source']['name']; ?></td>
</tr>
<?php if( $source->is_va == 1 ){ ?>
<tr>
	<td>VA Request Form Completed</td>
	<td>: <?php echo date("Y-m-d", strtotime($lead['va_request_form_completed'])); ?></td>
</tr>
<tr>
	<td>VA Deposit Paid</td>
	<td>: <?php echo $options_va[$lead['va_deposit_paid']]; ?></td>
</tr>
<tr>
	<td>VA Name</td>
	<td>: <?php echo $lead['va_name']; ?></td>
</tr>
<tr>
	<td>VA Start Date</td>
	<td>: <?php echo date("Y-m-d", strtotime($lead['va_start_date'])); ?></td>
</tr>
<tr>
	<td>VA Exit Date</td>
	<td>: <?php echo date("Y-m-d", strtotime($lead['va_exit_date'])); ?></td>
</tr>
<?php } ?>
<tr>
	<td>Willing to Review</td>
	<td>: <?php echo $optionsWillToReview[$lead['willing_to_review']]; ?></td>
</tr>
<?php if( $lead['willing_to_review'] == 1 ){ ?>
	<tr>
		<td>Willing to Review Date</td>
		<td>: <?php echo date("d F, Y", strtotime($lead['willing_to_review_date'])); ?></td>
	</tr>
<?php } ?>
<tr>
	<td>URL</td>
	<td>: <?php echo $lead['source_url']; ?></td>
</tr>
<tr>
	<td>Lead Source</td>
	<td>: <?php echo $string_lead_types; ?></td>
</tr>
<tr>
	<td>Allocation Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($lead['allocation_date'])); ?></td>
</tr>	
<tr>
	<td>Interest Type</td>
	<td>: <?php echo $lead['interest_type']['name']; ?></td>
</tr>	
</table>
<h3 class="form-hdr" style="background-color: #222D32;color:#ffffff;padding: 10px;">New Followup Information</h3>
<table>
<tr>
	<td>Followup Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($lead['followup_date'])); ?></td>
</tr>
<tr>
	<td>Followup Notes</td>
	<td>: 
				
		<?php foreach($followupNotes as $fn){ ?>
			<?php $content = str_replace("/webroot/upload/images/", "http://www.holisticwebpresencecrm.com/webroot/upload/images/", $fn->notes); ?>
			<div style="display: block; margin: 0px; padding: 10px;">
				<small>Date Posted : <?= $fn->date_posted->format("Y-m-d H:i:s"); ?></small><br />
				<small>Posted By : <?= $fn->user->firstname . ' ' . $fn->user->lastname; ?></small><br /><hr />
				<?= $content; ?>
			</div>	
		<?php } ?>
		<?php  
			//$content = str_replace("/webroot/upload/images/", "http://www.holisticwebpresencecrm.com/webroot/upload/images/", $lead['followup_notes']);
			//echo $content;
		?>			
	</td>
</tr>
<tr>
	<td>Followup Action Reminder Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($lead['followup_action_reminder_date'])); ?></td>
</tr>
<tr>
	<td>Followup Action Notes</td>
	<td>: 
		<?php 
			$content = str_replace("/webroot/upload/images/", "http://www.holisticwebpresencecrm.com/webroot/upload/images/", $lead['followup_action_notes']);
			echo $content;
		?>			
	</td>
</tr>
<tr>
	<td>Notes</td>
	<td>: 
		<?php 
			$content = str_replace("/webroot/upload/images/", "http://www.holisticwebpresencecrm.com/webroot/upload/images/", $lead['notes']);
			echo $content;
		?>
	</td>
</tr>	
</table>

<br/><br/>
<p><a href="https://www.holisticwebpresence.com">Holistic Web Presence LLC</a></p>