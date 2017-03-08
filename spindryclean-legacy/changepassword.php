<?php 
	require_once("include/files.php");

	if(!isset($_SESSION['customer_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	
	
	$customer = new Customer();
	$customer->loadcustomer($_SESSION['customer_id']);

	//debugObj($customer);

	if(isset($_POST['change']) && $_POST['change'] == 'change')
  {
    if(Security::ChangeUserPassword($_SESSION['customer_id'], $_POST['OldPassword'], $_POST['NewPassword'])) 
    {
      header('Location: dashboard.php?'.$Encrypt->encrypt("MessageType=Success&Message=Password changed successfully."));
    }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once ("include/title.php"); ?>

<body class="nav-md">
    <div class="container body">
      <div class="main_container">

			<!-- Header Wrapper -->
			<?php require_once ("include/header.php"); ?>  
			
			<!-- page content -->
			<div class="right_col" role="main">               
		        <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Change Password <small>Change your existing password here.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="col-md-12 form-group has-feedback">
                        <input type="password" class="form-control" id="OldPassword" placeholder="Old Passowrd goes here"  name="OldPassword"  required autocomplete="off" >
                        <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 form-group has-feedback">
                        <input type="password" class="form-control" id="NewPassword" placeholder="New Passowrd goes here"  name="NewPassword"  required autocomplete="off" >
                        <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 form-group has-feedback">
                        <input type="password" class="form-control" id="RepeatPassword" placeholder="Confirm New Password goes here" name="RepeatPassword"  onblur="confirmPass()" autocomplete="off" required >
                        <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href='dashboard.php' class="btn btn-primary">Cancel</a>
                          <button type="submit" class="btn btn-success" name="change" value="change">Change Password!</button>
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
		<?php require_once ("include/footer.php"); ?>  

    

		<script>
            $("#RepeatPassword").blur(function() {
            var pass = document.getElementById("NewPassword").value;
            var confPass = document.getElementById("RepeatPassword").value;
            if(pass != confPass) {
                alert('Password did not match. Please confirm your password !');
                document.getElementById("NewPassword").focus();
            }
        });
    </script>
</body>
</html>
