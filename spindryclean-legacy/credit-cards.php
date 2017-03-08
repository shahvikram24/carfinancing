<?php 
	require_once("include/files.php");

	if(!isset($_SESSION['customer_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	
	
	$customer = new Customer();
	$customer->loadcustomer($_SESSION['customer_id']);

	//debugObj($customer);

	if(isset($_POST['update']) && $_POST['update'] == 'update')
  {
      $stripeWSP = new StripeWSP();
      $stripeWSP->retrieveCustomer($_SESSION['customer_id']);

        $customer = new Customer();
        $customer->loadcustomer( $_SESSION['customer_id']);
        $customer->CardBrand = '';
        $customer->CardLastFour = '';
        $customer->UpdateCustomer($customer->Id);

        header('Location:credit-cards.php');
  }

  if(isset($_POST['pay']) && $_POST['pay'] == 'pay')
  {

    $stripeWSP = new StripeWSP();
    

    $stripeCard = array(
              'number' => $_POST['txtCreditCardNumber'],
              'exp_month' => $_POST['drpdwnMonth'],
              'exp_year' => $_POST['drpdwnYear'],
              'cvc' => $_POST['txtCreditCardCVS'],
              'name' => $_POST['txtCreditCardName'],
          );

    

      try
        {         
         	  $stripeWSP->retrieveCreateCustomer($_SESSION['customer_id'], $stripeCard);
              $stripeSuccess = true;
              $customer = new Customer();
              $customer->loadcustomer( $_SESSION['customer_id']);
              $customer->CardBrand = $_POST['txtCreditCardName'];
              $customer->CardLastFour = substr($_POST['txtCreditCardNumber'],-4);
              $customer->UpdateCustomer($customer->Id);

              header('Location:credit-cards.php');
          
        }
        
      catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        header("Location: ".APPROOT.'credit-cards.php?'.$Encrypt->encrypt('Title=Error&MessageStyle=bg-orange&Message=We apologize. Sorry for the inconvenience. '));     

      exit;
      }

  }
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
		        <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Credit Card Information <small>Edit information here</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?php 
                      if($customer->CardBrand == NULL)
                        echo '<label class="control-label col-md-12" for="Card-Brand">NO credit card on file. <a href="#" data-toggle="modal" data-target="#myModal">Add one now</a> </label>';
                      else{
                    ?>
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-6" for="Card-Brand">Card Brand: </label>
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Card Brand" name="CardBrand" value="<?= $customer->CardBrand ?>" disabled >
                        <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-6" for="Visa-Number">Visa Number:</label>
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Card Brand" name="CardLastFour" value="**** **** **** <?= $customer->CardLastFour ?>" disabled >
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success" name="update" value="update">Remove Card</button>
                        </div>
                      </div>

                    </form>
                    <?php } ?>
                  </div>
                </div>

              </div>
              
            </div>	

		    	<div class="clearfix"></div>

		          
          	<!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  

		<script>
      $(document).ready(function() {
      	
        });
    </script>

    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Payment Area</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="#">
            <input type="hidden" name="CustomerId" value="<?php echo $CustomerId; ?>"/>
              
              

              <div class="col-md-12 form-group">
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
              
              <div class="col-md-12 form-group">
                <input type="text" id="txtCreditCardNumber" class="form-control required number" name="txtCreditCardNumber" value="" placeholder="Card Number*" required="">
              </div>
              <div class="col-md-4 form-group">
                <input type="text" value="" name="drpdwnMonth" class="form-control required" id="drpdwnMonth" placeholder="MM*" required="">
              </div>
              <div class="col-md-4 form-group">
                <input type="text" name="drpdwnYear" value="" id="drpdwnYear" class="form-control required" placeholder="YY*" required="">
              </div>
              <div class="col-md-4 form-group">
                <input type="text" name="txtCreditCardCVS" value="" id="txtCreditCardCVS" class="form-control required card-cvc" placeholder="CVC*" required="">  
              </div>
              

              <div>
                <button type="submit" class=" btn btn-success submit" name="pay" value="pay" >Add Payment Method</button>
              </div>
              
                <div class="clearfix"></div>
                
              </div>
            </form>
      </div>
      
    </div>

  </div>
</div>


</body>
</html>
