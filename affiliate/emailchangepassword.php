<?php 
    require_once("../include/files.php");

    if(!(isset($ResetAccount) || isset($_POST['change'])))
        header("Location:index.php");


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
                header("Location:".AFFILIATEURL . 'index.php?' . $Encrypt->encrypt("Message=The password has been reset successfully.&Success=true"));
            }
       
    }
  
  


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once("inc/title.php"); ?>
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

<body>


<!-- Header -->
    <div class="content-section-a">

        <div class="container">

            <div class="contact-form" id="contact-form">
                <form name="login_form" method="post">
                    
                        <div class="full">
                            
                            <div class="col-lg-12">
                                <legend>Enter your new password below.</legend>

                                <?php 
                                    if( isset ($Message) && $Message != "" ) 
                                    {
                                        echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
                                    }

                                ?>

                                <input type="hidden" name="affiliate_id" value="<?php echo $affiliate_id; ?>"/>
                                

                                <div class="form-group">
                                    <input type="password" placeholder="New Password" name="NewPassword" id="NewPassword" class="form-control required" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="password" placeholder="Confirm New Password" name="RepeatPassword" id="RepeatPassword" class="form-control required" onBlur="confirmPass();"  autocomplete="off">
                                </div>

                               
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-success" name="change" value="change" >Get New Password
                                        &nbsp;<i class="fa fa-chevron-circle-right"></i></button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>
</html>