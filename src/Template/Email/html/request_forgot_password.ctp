<div style="width: 100%;height: 73px;padding-left: 0px;padding-top: 10px;">
	<h1 style="width:100%;padding:10px;background-color:#3C8DBC;color:#ffffff;">Holistic Web Presence</h1>		
</div>
<br style="clear:both;"/>
<div style="margin-top:10px;margin-bottom:10px;margin-left:15px;">			
	<p>Hi <b><?php echo $edata['user_name']; ?></b>,</p> 
	<p>Click the link below to reset your password</p>
	<?php $url = $this->Url->build("/reset_password/index/". $edata['reset_code'],'true'); ?>
	<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>
	<br/>
	<br/>
	<p>Thank you and have a great day!</p>		
</div>	