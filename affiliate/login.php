<?php

    require_once("../include/files.php");
    
if(isset($_SESSION['affiliate_id']))
{
  header("Location: dashboard.php");
}



if( isset($_POST['LostPassword']) && $_POST['LostPassword'] == 'AddIt' )
{  
  if(Security::CheckUserExistsByLogin($_POST['username'], ' AND STATUS IN (1)')) 
    {
      $login = new Affiliate();
      $login->loadAffiliateByCode("email like '".$_POST['username'] . "'");
      $Encryption = $Encrypt->encrypt('affiliate_id=' . $login->affiliate_id . '&ExpireDate=' . date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))) . '&ResetAccount=true');
      
      if($login->sendRecoverPasswordLink($login->email,$Encryption))
      {
        header("Location:".AFFILIATEURL . 'index.php?' . $Encrypt->encrypt("Message=Check your e-mail for the confirmation link.&Success=true"));
        exit();
      }
    }
    else{
      header("Location:".AFFILIATEURL . 'index.php?' . $Encrypt->encrypt("Message=User does not exist.&Success=false"));
        exit();
    }

}


if( isset($_POST['submit']) && $_POST['submit'] == 'Login' )   
{   
  //echo "<br/>===================== 1454 <br/>"; 
  
  if(Security::Authorize($_POST['username'],$_POST['password']))
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
              <h1>Login Form</h1>
              <header class="major">
          <?php 
            if($Message)
              echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
          ?>              
        </header>


              <div>
                <input type="email" name="username" class="form-control" placeholder="Enter email address" required="" />
              </div>
              <div>
                <input type="password" name="password"  class="form-control" placeholder="Enter password" required="" />
              </div>
              <div>
                
                <button type="submit" class="btn btn-default submit" name="submit" value="Login" onclick="return Validate();" > Login</button>

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
                  <h1><i class="fa fa-car"></i> CAR FINANCING</h1>
                  <p>&copy; CAR FINANCING. All rights reserved. <br/> Powered By:  
                      <a href="http://www.vstudiozzz.com" title="Vstudiozzz" target="_blank">Vstudiozzz </a>
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
                <input type="email" class="form-control" required="" id="email" name="username" placeholder="Email address goes here" autocomplete="off"/>
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" name="lost" value="lost">Get New Password</button>
                <input type="hidden" name="LostPassword" value="AddIt" />
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
                  <h1><i class="fa fa-car"></i> CAR FINANCING</h1>
                  <p>&copy; CAR FINANCING. All rights reserved. <br/> Powered By:  
                      <a href="http://www.vstudiozzz.com" title="Vstudiozzz" target="_blank">Vstudiozzz </a>
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
        window.location.href = "<?=  AFFILIATEURL . 'register.php' ?>";
    }
  </script>


</body>
</html>