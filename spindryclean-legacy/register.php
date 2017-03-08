<?php 
	require_once("include/files.php");

  if(isset($_POST['signup']) && $_POST['signup'] == 'signup')
  {
        //debugObj($_REQUEST); die(); 
        if(Security::CheckUserExistsByLogin($_POST['Email']))
        {
          
          header('Location:register.php?'.$Encrypt->encrypt("MessageType=Error&Message=Email currently exists within the database. Please choose a different email."));
          exit();
        }
        else
        {
          
          $customer = new Customer();
          $customer->BusinessName = $_POST['BusinessName'];
          $customer->FirstName = $_POST['Fname'];
          $customer->LastName = $_POST['Lname'];
          $customer->Address1 = $_POST['Address'];
          $customer->Address2 = $_POST['Apt'];        
          $customer->CustomerId = uniqid();
          $customer->City = $_POST['City'];
          $customer->Province = $_POST['Province'];
          $customer->Postalcode = $_POST['Postal'];
          $customer->Cellphone = $_POST['Mobile'];
          $customer->Approved = 2;
          $customer->Status = 1;
          $customerId = $customer->addCustomer();

          

          $login = new Login();
          $login->CustomerId = $customerId;
          $login->EmailId = $_POST['Email'];
          
          $Salt = GenerateSALT();
          $login->SALT = $Salt;
          $login->HASH = GenerateHASH($Salt, $_POST['Password']);
          $login->Status = 0;
          $login->addCustomerInfo();

          $login->sendEmailAdmin($customerId);

          
            /*$Encryption = $Encrypt->encrypt('CustomerId=' . $customerId . '&ExpireDate=' . date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))) . '&ActivateAccount=true');
            if($login->sendEmailActivation($customerId,$Encryption))
            {
              header("Location:login.php?".$Encrypt->encrypt("Message=Email sent successfully. An email has been sent to your account with details on activating your account. Please check your email/junk email for your confirmation email."));
            }*/
          
            header("Location:payment.php?".$Encrypt->encrypt("CustomerId=".$customerId));
            exit();
                  
        }     
        
  }

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once ("include/title.php"); ?>
<script type="text/javascript">
    function confirmPass() {
        var pass = document.getElementById("Password").value;
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
              <h1>Registration</h1>
              <header class="major">
					<?php 
						if($Message)
							echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
					?>							
				</header>


              <div class="col-md-12">
                <input name="BusinessName" placeholder="Business/Workplace Name" type="text" class="form-control" required value="<?=  $BusinessName; ?>"/>
              </div>
              <div class="col-md-6">
                <input name="Fname" placeholder="First Name" type="text" class="form-control" required value="<?=  $Fname; ?>"/>
              </div>
              <div class="col-md-6">
                <input name="Lname" placeholder="Last Name" type="text" class="form-control" required value="<?=  $Lname; ?>"/>
              </div>
              <div class="col-md-12">
                <input name="Address" placeholder="Your Pick up/Drop-off Address" type="text" class="form-control" required value="<?=  $Address; ?>"/>
              </div>
              <div class="col-md-6">
                <input name="Apt" placeholder="Apt./Suite" type="text" class="form-control"  value="<?=  $Apt; ?>"/>
              </div>
              <div class="col-md-6">
                <input name="Postal" placeholder="Postal Code" type="text" class="form-control" required value="<?=  $Postal; ?>"/>
              </div>
              <div class="col-md-6">
                <input name="City" placeholder="City" type="text" class="form-control" required/>
              </div>

              <div class="col-md-6">
                <input name="Mobile" placeholder="Mobile Phone" type="text" class="form-control" required/>
              </div>
              <div class="col-md-12">
                <input name="Email" placeholder="Email" type="email" class="form-control" required autocomplete="off" value="<?=  $Email; ?>" />
              </div>
              <div class="col-md-6">
                <input name="Password" id="Password" placeholder="Password" type="password" class="form-control" required autocomplete="off" value="<?=  $Password; ?>" />
              </div>
              <div class="col-md-6">
                <input name="RepeatPassword" id="RepeatPassword" placeholder="Repeat Password" type="password" class="form-control" required onblur="confirmPass()" autocomplete="off"/>
              </div>



              <div>
                <button class="btn btn-success submit"  name="signup" value="signup">Step 2</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
              <p class="change_link">Already a member ?
                  <a href="index.php" class="to_register"> Log in </a>
                </p>
                
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