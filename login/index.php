<?php 
	require_once("../include/files.php");

	if(isset($_GET['logout']) && $_GET['logout'] == 'true')
	{
		Security::Logout();
		header("Location: index.php");	
	}


	if(isset($_SESSION['admin_id']))
	{
		header('Location:dashboard.php');
		exit();
	}

  
	if( isset($_POST['login']) && $_POST['login'] == 'Login' )   
  {   

   
    if(Security::AuthorizeAdmin($_POST['username'],$_POST['password']))
    {
      header("Location: dashboard.php");
    }
    else
    {
      $Message="Invalid username / Password";
    }

  }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once ("../include/title.php"); ?>
<script language = "Javascript">
  
function Validate()
{

    if (document.login_form.username.value == '') 
    {
        alert('Please fill in your username!');
        return false;
    }
    if (document.login_form.password.value == '') 
    {
       alert('Please fill in your password!');
      return false;
    }

    return true;
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
              <h1>Admin Login Form</h1>
              <header class="major">
					<?php 
						if($Message)
							echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
					?>							
				</header>


              <div>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required="" />
              </div>
              <div>
                <input type="password" name="password"  class="form-control" placeholder="Enter password" required="" />
              </div>
              <div>
                
                <button type="submit" class="btn btn-default submit" name="login" value="Login" onclick="return Validate();">
					Log in
				</button>
               
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                

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



</body>
</html>