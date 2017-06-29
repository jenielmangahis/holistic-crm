<p>Hi,</p>
<p>Below are the details of the new leads : </p>
<table>
<tr>
	<td>Name</td>
	<td>:<?php echo $new_lead->firstname . ' ' . $new_lead->lastname; ?></td>
</tr>
<tr>
	<td>Email</td>
	<td>:<?php echo $new_lead->email; ?></td>
</tr>
<tr>
	<td>Phone</td>
	<td>:<?php echo $new_lead->phone; ?></td>
</tr>
<tr>
	<td>Address</td>
	<td>:<?php echo $new_lead->address; ?></td>
</tr>
<tr>
	<td>City / State</td>
	<td>:<?php echo $new_lead->city . ' ' . $new_lead->state; ?></td>
</tr>
</table>

<br/>
<p>Thank you and have a great day!</p>