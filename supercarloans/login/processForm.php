<?php

require_once("../include/files.php");
global $DAL, $User, $Encrypt;



// Read the form values
$success = false;
$ContactId = isset( $_POST['ContactId'] ) ?  $_POST['ContactId']  : "";
$mode = isset( $_POST['mode'] ) ?  $_POST['mode']  : "";
$Message = isset( $_POST['message'] ) ? $_POST['message'] : "";

$Contact = new Contact();
$Contact->loadContact($ContactId);


if($mode == 'email')
{
   $SendTo = $Contact->ContactInfoRelation->Email;

  
        //echo $ResultSet->Result[$x]['LoginId'];
        if($SendTo != '')
        {
          $mailObj = new Email($SendTo, "SuperCarLoans", "Message from SuperCarLoans" );
          $mailObj->Content = $Message;
        }
        
             if($mailObj->Send())
                $success = true;
            else 
                $success = false;
       

  
}
// Return an appropriate response to the browser
if ( isset($_GET["ajax"]) ) {
  echo $success ? "success" : "error";
} 
?>


