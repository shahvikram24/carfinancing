<?php 
  require_once("include/files.php");

  $package = new Package();
  $PackageResult = Package::GetPackages();
 
 if(isset($_POST['pay']) && $_POST['pay'] == 'pay')
  {
    //debugObj($_REQUEST); die();

    //$packageId = $Decrypt->decrypt($_REQUEST['packageId']);

    $stripeWSP = new StripeWSP();
    //$stripeWSP->retrieveCreateCustomer($_REQUEST['CustomerId']);

    $stripeCard = array(
              'number' => $_POST['txtCreditCardNumber'],
              'exp_month' => $_POST['drpdwnMonth'],
              'exp_year' => $_POST['drpdwnYear'],
              'cvc' => $_POST['txtCreditCardCVS'],
              'name' => $_POST['txtCreditCardName'],
          );

      try
        {         
          $stripeWSP->retrieveCreateCustomer($_REQUEST['CustomerId'], $stripeCard);
          $stripeSuccess = true;
        }
        
      catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Error&MessageStyle=bg-orange&Message=We apologize. Sorry for the inconvenience. '));     

      exit;
      }

      

      $Login = new Login();
      $Customer = new Customer();

      if($Login->loadcustomerinfobycustomerid($_REQUEST['CustomerId']) && $Customer->loadcustomerCheck($_REQUEST['CustomerId']))
      {

        if($Customer->Approved == 2) {
              
                  try {
                      
                      $Login->Status = 1;
                      $Login->UpdateCustomerInfo($Login->Id);

                      $Customer->Approved = 1;
                      $customer->CardBrand = $_POST['txtCreditCardName'];
                      $customer->CardLastFour = substr($_POST['txtCreditCardNumber'],-4);
                      $Customer->UpdateCustomer($_REQUEST['CustomerId']);
                      $Message = "Thank you to register with SPIN. You are now authorized to login.";
                  }
                  catch(Exception $ex) {}
             
          }
      }
          
      header("location:index.php?".$Encrypt->encrypt("Message=".$Message."&Success=true"));




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
            <input type="hidden" name="CustomerId" value="<?php echo $CustomerId; ?>"/>
              <h1>Payment Area</h1>
              

              <div class="col-md-12">
                <input type="text" name="adnName" class="form-control required" id="" value="" placeholder="Cardholder Name*" required="">
              </div>

                <div class="col-md-12 form-group">
                  <select name="txtCreditCardName" class="form-control required" required>
                    <option value="">-- Card Type --</option>
                    <option value="Visa">Visa</option>
                    <option value="MasterCard">MasterCard</option>                          
                    <option value="American Express">American Express</option>
                    <option value="JCB">JCB</option>                          
                    <option value="Discover">Discover</option>                                                    
                    <option value="Diners Club">Diners Club</option>                                                                              
                  </select>
                </div>
              
              <div class="col-md-12">
                <input type="text" id="txtCreditCardNumber" class="form-control required number" name="txtCreditCardNumber" value="" placeholder="Card Number*" required="">
              </div>
              <div class="col-md-4">
                <input type="text" value="" name="drpdwnMonth" class="form-control required" id="drpdwnMonth" placeholder="MM*" required="">
              </div>
              <div class="col-md-4">
                <input type="text" name="drpdwnYear" value="" id="drpdwnYear" class="form-control required" placeholder="YY*" required="">
              </div>
              <div class="col-md-4">
                <input type="text" name="txtCreditCardCVS" value="" id="txtCreditCardCVS" class="form-control required card-cvc" placeholder="CVC*" required="">  
              </div>
              

              <div>
                <button type="submit" class="btn btn-success submit" name="pay" value="pay" >Register Now</button>
              </div>
              <p class="change_link">You will receive a link to activate your new account via email.</p>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="index.php" class="to_register"> Log in </a>
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