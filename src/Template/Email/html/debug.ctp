<?php 
use Cake\View\Helper\TextHelper;
?>
<p>Hi,</p> 
<p>Someone made an inquiry via our website. Below are the details</p>
<table border="0">
	<tr>
		<td>Name</td>
		</td>: <?php echo $this->Text->autoParagraph($action); ?></tr>
	</tr>
</table>