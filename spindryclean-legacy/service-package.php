<?php 
	require_once("include/files.php");

	if(!isset($_SESSION['customer_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	
	
	$customer = new Customer();
	$customer->loadcustomer($_SESSION['customer_id']);

	$package = new Package();
  $PackageResult = Package::GetPackages();

  if(isset($_POST['pay']) && $_POST['pay'] == 'pay')
  {
    //debugObj($_REQUEST); die();
    $packageId = $_REQUEST['packageId'];
    $CustomerId = $_SESSION['customer_id'];
    $customerTransaction = new CustomerTransactions();
    $customerTransaction->loadTransactions('CustomerId = '.$CustomerId . ' AND Status = 1');
    $Price = $customerTransaction->Amount;
    $PackagePrice = Package::GetPrice($packageId);
    $TotalCharge = $Price + $PackagePrice;

    $customerTransaction->Status = 0;
    $customerTransaction->UpdateTransactions();


    $stripeWSP = new StripeWSP();
    $stripeWSP->retrieveCreateCustomer($CustomerId );

    $stripeCard = array(
              'number' => $_POST['txtCreditCardNumber'],
              'exp_month' => $_POST['drpdwnMonth'],
              'exp_year' => $_POST['drpdwnYear'],
              'cvc' => $_POST['txtCreditCardCVS'],
              'name' => $_POST['txtCreditCardName'],
          );

   
    try
        {
          $stripeWSP->setCard($stripeCard);

          if($stripeWSP->applyCharge(round($PackagePrice,2)))
          {
              $stripeSuccess = true;
            }
        }
    catch(Stripe_CardError $e) { 
         // Since it's a decline, Stripe_CardError will be caught 
          $body = $e->getJsonBody(); 
         $err = $body['error']; 
         //print('Status is:' . $e->getHttpStatus() . "\n"); 
         //print('Type is:' . $err['type'] . "\n"); print('Code is:' . $err['code'] . "\n"); 
         // param is '' in this case 
         //print('Param is:' . $err['param'] . "\n"); 
         //print('Message is:' . $err['message'] . "\n");
         header("Location: ".APPROOT.'service-package.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
         exit;
      }

      catch (Stripe_InvalidRequestError $e) { 
        // Invalid parameters were supplied to Stripe's API 
        $body = $e->getJsonBody(); 
           $err = $body['error']; 
           header("Location: ".APPROOT.'service-package.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
           exit;

      } 
      catch (Stripe_AuthenticationError $e) { 
        // Authentication with Stripe's API failed // (maybe you changed API keys recently)
        // Invalid parameters were supplied to Stripe's API 
        $body = $e->getJsonBody(); 
           $err = $body['error']; 
           header("Location: ".APPROOT.'service-package.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
           exit;
        } 

      catch (Stripe_ApiConnectionError $e) { 
        // Network communication with Stripe failed 
        // Invalid parameters were supplied to Stripe's API 
        $body = $e->getJsonBody(); 
           $err = $body['error']; 
           header("Location: ".APPROOT.'service-package.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
           exit;
      } 


      catch (Stripe_Error $e) { 
      //echo '<pre>'.print_r($e,true).'</pre>';
      header("Location: ".APPROOT.'service-package.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=Card error'));
      

      exit;
      }

      catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        header("Location: ".APPROOT.'service-package.php?'.$Encrypt->encrypt('Title=Error&MessageStyle=bg-orange&Message=We apologize. Sorry for the inconvenience. '));
      

      exit;
      }

      if($stripeSuccess)
      {       
         
          $orders = new CustomerTransactions();
          $orders->CustomerId= $CustomerId;
          $orders->PackageId = $packageId;
          $orders->Amount = $TotalCharge;
          $orders->DateAdded = date('Y-m-d H:i:s');
          $orders->Status = 1;
          $orders->addTransactions();
          $Message = "Your Payment has been received successfully, Thank you for renewing your account.";
          header("location:dashboard.php?".$Encrypt->encrypt("Message=".$Message."&Success=true"));
          exit();
      }

  }
  //debugObj($PackageResult);
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
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Service Packages Tables</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="height:600px;">
                  <div class="x_title">
                    <h2>Service Packages Pricing</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="row">

                      <div class="col-md-12">
                        <?php
                           
                            if($PackageResult->TotalResults>0)
                            {
                              for($x = 0; $x < $PackageResult->TotalResults ; $x++)
                              {
                          ?>
                        <!-- price element -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="pricing ui-ribbon-container">
                            <div class="ui-ribbon-wrapper">
                              <div class="ui-ribbon">
                                <?php echo $PackageResult->Result[$x]['Apps']; ?>% Off
                              </div>
                            </div>
                            <div class="title">
                              <h2><?php echo $PackageResult->Result[$x]['Name']; ?></h2>
                              <h1>$<?php echo $PackageResult->Result[$x]['Price']; ?></h1>
                              <span><?php echo $PackageResult->Result[$x]['Recurring']; ?></span>
                            </div>
                            <div class="x_content">
                              <div class="">
                                <div class="pricing_features">
                                  <ul class="list-unstyled text-left">
                                    <li><i class="fa fa-check text-success"></i> <?php echo $PackageResult->Result[$x]['Description']; ?></li>
                                    <li><i class="fa fa-check text-success"></i> <?php echo $PackageResult->Result[$x]['Apps']; ?>% off all orders inclusive and above <?php echo $PackageResult->Result[$x]['Price']; ?> </li>
                                  </ul>
                                </div>
                              </div>
                              <div class="pricing_footer">
                                <a href="#" id="modaledit" class="btn btn-success btn-block modaledit"  data-id="<?= $PackageResult->Result[$x]['Id'] ?>" data-toggle="modal" data-target="#exampleModal" >Purchase <span> now!</span></a>
                                <p>
                                 
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- price element -->
                        <?php 
                          }
                        }
                          ?>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

      
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

    <script>
        $(document).on("click", ".modaledit", function () {
            $("#exampleModal #packageId").val( $(this).data('id') );
        });
        </script>


    <form method="post" autocomplete="off" action="#">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Payment Area</h4>
              </div>
              <div class="modal-body">
                
                  <input type="hidden" id="packageId" name="packageId">

                  
                    
                   <div class="form-group">
                    <input type="text" name="adnName" class="form-control required" id="" value="" placeholder="Cardholder Name*" required="">
                  </div>

                <div class="form-group">
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
              
              <div class="form-group">
                <input type="text" id="txtCreditCardNumber" class="form-control required number" name="txtCreditCardNumber" value="" placeholder="Card Number*" required="">
              </div>
              <div class="row">
                <div class="col-md-4">
                  <input type="text" value="" name="drpdwnMonth" class="form-control required" id="drpdwnMonth" placeholder="MM*" required="">
                </div>
                <div class="col-md-4">
                  <input type="text" name="drpdwnYear" value="" id="drpdwnYear" class="form-control required" placeholder="YY*" required="">
                </div>
                <div class="col-md-4">
                  <input type="text" name="txtCreditCardCVS" value="" id="txtCreditCardCVS" class="form-control required card-cvc" placeholder="CVC*" required="">  
                </div>
              </div>

              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="pay" name="pay" value="pay">Pay Now</button>
              </div>
            </div>
          </div>
        </div>
      </form>

</body>
</html>

