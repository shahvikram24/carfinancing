<?php 
	require_once("include/files.php");

	if(isset($_GET['logout']) && $_GET['logout'] == 'true')
	{
		Security::Logout();
		header("Location: index.php");	
	}


	if(isset($_SESSION['customer_id']))
	{
		header('Location:dashboard.php');
		exit();
	}

  if(isset($_POST['lost']) && $_POST['lost'] == 'lost')
  {
    if(Security::CheckUserExistsByLogin($_POST['email'], ' AND STATUS IN (0,1)')) 
    {
      $login = new Login();
        $customer = new Customer();

      $customerId = $login->CheckUserByLogin($_POST['email']);
      $login->loadcustomerinfobycustomerid($customerId) ;
      $customer->loadcustomerCheck($customerId);

        $Encryption = $Encrypt->encrypt('CustomerId=' . $customerId . '&ExpireDate=' . date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))) . '&ResetAccount=true');

        if($login->Status==0)
        {
            if($login->sendRecoverPasswordLink($_POST['email'],$Encryption))
            {
              header("Location:index.php?".$Encrypt->encrypt("Message=We now provide service in your area. Further instructions have been sent to your e-mail address. Please check your email/junk email for your confirmation email."));
              exit(); 
            }

        }

      if($login->sendRecoverPasswordLink($_POST['email'],$Encryption))
      {
        header("Location:index.php?".$Encrypt->encrypt("Message=Further instructions have been sent to your e-mail address. Please check your email/junk email for your confirmation email."));
        exit(); 
      } 

    }
    else
    {
      header("Location:index.php?".$Encrypt->encrypt("Message=Email is not registered. Please try another email.&Success=false"));
      exit();
    } 
    
  }
  

	if(isset($_POST['login']) && $_POST['login'] == 'login')
	{
		
		if(Security::Authorize($_POST['email'], $_POST['password'])) 
		{
			header("Location: dashboard.php");	
		}
		else
		{
			$Message = "Invalid Username/Password";
		}
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once ("include/title.php"); ?>  
<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="#">
              <h1>Login Form</h1>
              <header class="major">
					<?php 
						if($Message)
							echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
					?>							
				</header>


              <div>
                <input type="email" name="email" class="form-control" placeholder="Enter email address" required="" />
              </div>
              <div>
                <input type="password" name="password"  class="form-control" placeholder="Enter password" required="" />
              </div>
              <div>
                
                <button type="submit" class="btn btn-default submit" name="login" value="login">
					Log in
				</button>
                <a class="reset_pass" href="#signup"   name="lostpwd" value="lostpwd">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#" onclick="myFunction()" class="to_register"> Create Account </a>
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

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="post" action="#">
              <h1>Recover Password</h1>
              <div>
                <input type="email" class="form-control" placeholder="Username" required="" id="email" name="email" placeholder="Email address goes here" autocomplete="off"/>
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" name="lost" value="lost">Get New Password</button>
              </div>
              <p class="change_link">You will receive a link to create a new password via email.</p>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
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