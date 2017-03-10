<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['affiliate_id']))
  {
      header('Location:login.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
      exit();
  }
	
	$affiliate = new Affiliate();
  $affiliate->loadAffiliate($_SESSION['affiliate_id']);

	if(isset($_POST['change']) && $_POST['change'] == 'change')
  {
    $Result = Security::ChangeUserPassword($_SESSION['affiliate_id'], NULL, $_POST['newpwd']);
        
        if($Result)
        {
            Security::Logout();
            header("Location: login.php?".$Encrypt->encrypt("Success=true&Message=We changed password. Please login again."));
            exit;
        }
        else
        {
             header("Location: change-password.php?".$Encrypt->encrypt("Success=false&Message=Please do not use same password."));
        }
    
  }
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
                    <h2>Change Password <small>Change your existing password here.</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="col-md-12 form-group has-feedback">
                        <input type="password" class="form-control" id="newpwd" placeholder="New Passowrd goes here"  name="newpwd"  required autocomplete="off" >
                        <span class="fa fa-key form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 form-group has-feedback">
                        <input type="password" class="form-control" id="confnewpwd" placeholder="Confirm New Password goes here" name="confnewpwd"  onblur="confirmPass()" autocomplete="off" required >
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
		<?php require_once ("inc/footer.php"); ?>  

    

		<script>
            $("#confnewpwd").blur(function() {
            var pass = document.getElementById("newpwd").value;
            var confPass = document.getElementById("confnewpwd").value;
            if(pass != confPass) {
                alert('Password did not match. Please confirm your password !');
                document.getElementById("newpwd").focus();
            }
        });
    </script>
</body>
</html>
