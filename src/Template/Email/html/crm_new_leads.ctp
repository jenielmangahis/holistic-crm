<p>Hi,</p>
<p>A new lead has been entered into the Holistic CRM. To update any details regarding this lead login here: <a href="http://holisticwebpresencecrm.com">http://holisticwebpresencecrm.com</a></p>
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
<tr>
	<td>Status</td>
	<td>: <?php echo $lead['status']['name']; ?></td>
</tr>
<tr>
	<td>Action</td>
	<td>: <?php echo $lead['lead_action']; ?></td>
</tr>
<tr>
	<td>Source</td>
	<td>: <?php echo $lead['source']['name']; ?></td>
</tr>
<tr>
	<td>Lead Type</td>
	<td>: <?php echo $lead['lead_type']['name']; ?></td>
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
	<td>: <?php echo strip_tags($lead['followup_notes']); ?></td>
</tr>
<tr>
	<td>Followup Action Reminder Date</td>
	<td>: <?php echo date("Y-m-d",strtotime($lead['followup_action_reminder_date'])); ?></td>
</tr>
<tr>
	<td>Followup Action Notes</td>
	<td>: <?php echo strip_tags($lead['followup_action_notes']); ?></td>
</tr>	
<tr>
	<td>Notes</td>
	<td>: <?php echo strip_tags($lead['notes']); ?></td>
</tr>	
</table>

<br/><br/>
<p><a href="https://www.holisticwebpresence.com">Holistic Web Presence LLC</a></p>