<?php 
    require_once("../include/files.php");

    if(!(isset($ResetAccount) || isset($_POST['change'])))
        header("Location:login.php");


    if(isset($ResetAccount) && $ResetAccount == "true") 
    {
        $login = new Affiliate();
        $login->loadAffiliate($affiliate_id);

    }
    
    
    if(isset($_POST['change']) && $_POST['change'] == 'change')
    {
            
            if(isset($_POST['affiliate_id']) && $_POST['affiliate_id']!='')
            {
               $login = new Affiliate();
                $login->loadAffiliate($affiliate_id);
                
            }

           if(Security::ChangeUserPassword($login->affiliate_id, NULL, $_POST['NewPassword'])) 
            {
                if($login->sendConfirmedRecoveredPassword($login->email))
                header("Location:".AFFILIATEURL . 'login.php?' . $Encrypt->encrypt("Message=The password has been reset successfully.&Success=true"));
            }
       
    }
  
  


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once ("../include/title.php"); ?> 
<script language = "Javascript">
  
function confirmPass() {
        var pass = document.getElementById("NewPassword").value;
        var confPass = document.getElementById("RepeatPassword").value;
        if(pass != confPass) {
            alert('Password did not match. Please confirm your password !');
            document.getElementById("RepeatPassword").focus();
        }
    }
</script>


</head>

<body class="login">


<!-- Header -->
 
        <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="#">
                <h1>Reset password</h1>
                      <header class="major">
                  <?php 
                    if($Message)
                      echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
                  ?>              
                </header>    
                        <div class="full">
                            
                            <div class="col-lg-12">
                               
                                <?php 
                                    if( isset ($Message) && $Message != "" ) 
                                    {
                                        echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
                                    }

                                ?>

                                <input type="hidden" name="affiliate_id" value="<?php echo $affiliate_id; ?>"/>
                                

                                <div>
                                    <input type="password" placeholder="New Password" name="NewPassword" id="NewPassword" class="form-control required" autocomplete="off">
                                </div>
                                <div>
                                    <input type="password" placeholder="Confirm New Password" name="RepeatPassword" id="RepeatPassword" class="form-control required" onBlur="confirmPass();"  autocomplete="off">
                                </div>

                               
                                <div>
                                    <button type="submit" class="btn btn-default submit" name="change" value="change" >Get New Password
                                        &nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            
                        </div>

                        <div class="clearfix"></div>

                          <div class="separator">
                            <p class="change_link">New to site?
                              <a href="#" onclick="myFunction()" class="to_register"> Create Account </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <p class="change_link">Already a member ?
                                  <a href="login.php" class="to_register"> Log in </a>
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
        
    <script>
    function myFunction() {
        window.location.href = "<?=  AFFILIATEURL . 'register.php' ?>";
    }
  </script>

</body>
</html>