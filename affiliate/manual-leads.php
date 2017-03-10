<?php 
	require_once("../include/files.php");

	
  if(!isset($_SESSION['affiliate_id']))
  {
      header('Location:login.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
      exit();
  }
	
  if(isset($_POST['Finish']) && $_POST['Finish'] == 'Send Manual Lead')
{

    /*$ContactInfo = new ContactInfo();
    $ContactInfo->FirstName = $_POST['FirstName'];
     $ContactInfo->LastName = $_POST['LastName'];
     $ContactInfo->Email = $_POST['EmailAddress'] ;
     $ContactInfo->Phone1 = $_POST['Phone'];
     $ContactInfo->Created = date('Y-m-d H:i:s');
     $ContactInfo->Notes = $_POST['Notes'];
     $ContactInfo->Notification = 1;
     $ContactInfo->Status = 3;
     $ContactInfoId = $ContactInfo->addContactInfo();

        $affiliateTransaction = new AffiliateTransaction();
        $affiliateTransaction->affiliateid = $_SESSION['affiliate_id'];
        $affiliateTransaction->contactinfoid = $ContactInfoId;
        $affiliateTransaction->description = 1;
        $affiliateTransaction->amount = 0.00;
        $affiliateTransaction->dateadded = date("Y-m-d H:i:s");
        $affiliateTransaction->status = 3;
*/
        $affiliateTransaction->addTransaction();
        header('Location:dashboard.php?' . $Encrypt->encrypt("Message=Lead information has been sent to our team.&Success=true&affiliate_id=".$_SESSION['affiliate_id']));
    exit();

}

	$affiliate = new Affiliate();
  $affiliate->loadAffiliate($_SESSION['affiliate_id']);

	
	
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once ("inc/title.php"); ?>  
<body class="nav-md">
    <div class="container body">
      <div class="main_container">

			<!-- Header Wrapper -->
			<?php require_once ("inc/header.php"); ?>  
			
			<!-- page content -->
			<div class="right_col" role="main">  
            <?php                   
              if( isset ($Message) && $Message != "" ) 
              { 
                  if($Success && $Success == 'true')
                      echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
                  else
                      echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
              }
            ?>             
		        <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Soft Lead Information <small>Enter information here</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name" name="FirstName" value="" required >
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name" name="LastName" value="" required>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Phone Number" name="telephone" value=""  >
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Enter Email Address" name="email" value="" required>
                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true" ></span>
                      </div>

                      



                      <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                        <textarea class="form-control" id="inputSuccess4" placeholder="Provide notes to the admin" name="Notes" rows="4" cols="50"> 
                        </textarea>
                      </div>
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href='dashboard.php' class="btn btn-primary">Cancel</a>
                          <button type="submit" class="btn btn-success" name="Finish" value="Send Manual Lead">Send Manual Lead</button>
                        </div>
                      </div>

                      


                    </form>
                  </div>
                </div>

              </div>
              
            </div>	

		    	<div class="clearfix"></div>

		          
          	<!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("inc/footer.php"); ?>  
</body>
</html>
