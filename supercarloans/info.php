<?php
	
	require_once("include/files.php");
	

if(!isset($ContactId))
{
	header("Location: index.php");
}





if(isset($Verify) && $Verify == 'true')
{
	

	
	$Contact = new Contact();
	if($Contact->loadContact($ContactId))
	{
		$Contact->Status=1;
		$Contact->updateContact();

	}
	header("Location:".APPROOT . 'index.php?' . $Encrypt->encrypt('Message='. $Contact->ContactInfoRelation->FirstName.' thank you to verify your email address.&Success=true'));
}



?>
