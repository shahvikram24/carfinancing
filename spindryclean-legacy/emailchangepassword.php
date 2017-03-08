<?php 
	require_once("include/files.php");

  if(isset($ResetAccount) && $ResetAccount == "true") 
  {
    $customer = new Customer();
    $customer->loadcustomer( $CustomerId);

  }
  
  if(isset($_POST['change']) && $_POST['change'] == 'change')
  {
    
    if(Security::ChangeUserPassword($_POST['CustomerId'], NULL, $_POST['NewPassword'])) 
    {
      $login = new Login();
      $Result = $login->loadcustomerinfo($_POST['CustomerId']);
      if($login->sendConfirmedRecoveredPassword($Result->EmailId))
      header("Location:index.php?".$Encrypt->encrypt("Message=The password for the username ".$Result->EmailId." has been successfully reset.&Success=false"));
      exit();
    }
    
  }
  


?>
<!DOCTYPE html>
<html lang="en">
<?php require_once ("include/title.php"); ?>
<script type="text/javascript">
    function confirmPass() {
        var pass = document.getElementById("NewPassword").value;
        var confPass = document.getElementById("RepeatPassword").value;
        if(pass != confPass) {
            alert('Password did not match. Please confirm your password !');
            document.getElementById("RepeatPassword").focus();
        }
    }
</script>  
<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="#">
            <input type="hidden" name="CustomerId" value="<?php echo $CustomerId; ?>"/>
              <h1>Change Password</h1>
              <header class="major">
					<?php 
						if($Message)
							echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
					?>							
				</header>


              <div>
                <input type="password" name="NewPassword" id="NewPassword" class="form-control" placeholder="New Password goes here" required="" />
              </div>
              <div>
                <input type="password" name="RepeatPassword" id="RepeatPassword"  class="form-control" placeholder="Confirm New Password goes here" required="" onblur="confirmPass()" autocomplete="off" />
              </div>
              <div>
                
                <button type="submit" class="btn btn-default submit" name="change" value="change">
					Change Password!
				</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#" onclick="myFunction()" class="to_register"> Create Account </a>|| Already a member ?
                  <a href="index.php#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> SPIN</h1>
                  <p>&copy; SPIN. All rights reserved. <br/> Powered By:  
                  		<a href="http://snowballmedia.com" title="Snowball Media" target="_blank">Snowball Media and Advertising</a>
                  </p>
                </div>
              </div>
            </form>
          </section>
        </div>

       
      </div>
    </div>

    <script>
		function myFunction() {
		    window.location.href = "<?=  APPROOT . 'register.php' ?>";
		}
	</script>


</body>
</html>