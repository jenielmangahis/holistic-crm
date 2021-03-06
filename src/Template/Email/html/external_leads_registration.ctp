<?php 
use Cake\View\Helper\TextHelper;
?>
<p>Hi,</p>
<p>A new lead has been entered into the Holistic CRM. To update any details regarding this lead login here: <a href="https://www.holisticwebpresencecrm.com/leads/edit/<?= $new_lead['id']; ?>">http://holisticwebpresencecrm.com</a></p>
<h3 class="form-hdr" style="background-color: #222D32;color:#ffffff;padding: 10px;">Lead Personal Information</h3>
<table>
<tr>
	<td>Name</td>
	<td>: <?php echo $new_lead['firstname'] . ' ' . $new_lead['surname']; ?></td>
</tr>
<tr>
	<td>Email</td>
	<td>: <?php echo $new_lead['email']; ?></td>
</tr>
<tr>
	<td>Phone</td>
	<td>: <?php echo $new_lead['phone']; ?></td>
</tr>
<tr>
	<td>City / State</td>
	<td>: <?php echo $new_lead['city'] . ' / ' . $new_lead['state']; ?></td>
</tr>
<tr>
	<td>Address</td>
	<td>: <?php echo $new_lead['address']; ?></td>
</tr>	
</table>

<h3 class="form-hdr" style="background-color: #222D32;color:#ffffff;padding: 10px;">Other Information</h3>
<table>
<tr>
	<td>Status</td>
	<td>: <?php echo $new_lead['status']['name']; ?></td>
</tr>
<tr>
	<td>Action</td>
	<td>: 
		<?php
			$action = str_replace('\"', '"', $new_lead['lead_action']); 
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
	<td>: <?php echo $new_lead['source']['name']; ?></td>
</tr>
<tr>
	<td>URL</td>
	<td>: <?php echo $new_lead['source_url']; ?></td>
</tr>
<tr>
	<td>Lead Source</td>
	<td>: <?php echo $string_lead_types; ?></td>
</tr>
<tr>
	<td>Allocation Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($new_lead['allocation_date'])); ?></td>
</tr>	
<tr>
	<td>Interest Type</td>
	<td>: <?php echo $new_lead['interest_type']['name']; ?></td>
</tr>	
</table>
<h3 class="form-hdr" style="background-color: #222D32;color:#ffffff;padding: 10px;">New Followup Information</h3>
<table>
<tr>
	<td>Followup Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($new_lead['followup_date'])); ?></td>
</tr>
<tr>
	<td>Followup Notes</td>
	<td>: <?php echo $new_lead['followup_notes']; ?></td>
</tr>
<tr>
	<td>Followup Action Reminder Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($new_lead['followup_action_reminder_date'])); ?></td>
</tr>
<tr>
	<td>Followup Action Notes</td>
	<td>: <?php echo $new_lead['followup_action_notes']; ?></td>
</tr>	
<tr>
	<td>Notes</td>
	<td>: <?php echo $new_lead['notes']; ?></td>
</tr>	
</table>

<br/><br/>
<p><a href="https://www.holisticwebpresence.com">Holistic Web Presence LLC</a></p>