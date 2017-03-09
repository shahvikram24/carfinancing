<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	
	
	$Order = new Order();
	if( isset($_POST['submitorder']) && $_POST['submitorder'] == 'submitorder' )   
	{
		
		for($x=0; $x < count($_REQUEST['Id']) ; $x++)
		{
			$Id = '';
			$Id = $Decrypt->decrypt($_REQUEST['Id'][$x]);
			$Order->loadorder($Id);
			$Order->OrderStatus = $Decrypt->decrypt($_POST['OrderStatus'][$x]);
			$Order->UpdateOrder($Id);
		}

		header("Location:collectedorders.php?".$Encrypt->encrypt("Message=Your choice has been successfully selected.&Success=true"));
      		exit();
	}

if(isset($_POST['pay']) && $_POST['pay'] == 'pay')
{
    

    $stripeWSP = new StripeWSP();
    $stripeWSP->retrieveCreateCustomer($_REQUEST['CustomerId']);
    
    		try
	        {
	        	if(isset($_REQUEST['applyType']) && $_REQUEST['applyType'] == 'new')
			    {
			    		$stripeCard = array(
			              'number' => $_POST['txtCreditCardNumber'],
			              'exp_month' => $_POST['drpdwnMonth'],
			              'exp_year' => $_POST['drpdwnYear'],
			              'cvc' => $_POST['txtCreditCardCVS'],
			              'name' => $_POST['txtCreditCardName'],
			          );

			    	$stripeWSP->setCard($stripeCard);
			    }

	          

	          if($stripeWSP->applyCharge($_REQUEST['TotalPrice']))
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
	         header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
	         exit;
	      }

	      catch (Stripe_InvalidRequestError $e) { 
	        // Invalid parameters were supplied to Stripe's API 
	        $body = $e->getJsonBody(); 
	           $err = $body['error']; 
	           header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
	           exit;

	      } 
	      catch (Stripe_AuthenticationError $e) { 
	        // Authentication with Stripe's API failed // (maybe you changed API keys recently)
	        // Invalid parameters were supplied to Stripe's API 
	        $body = $e->getJsonBody(); 
	           $err = $body['error']; 
	           header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
	           exit;
	        } 

	      catch (Stripe_ApiConnectionError $e) { 
	        // Network communication with Stripe failed 
	        // Invalid parameters were supplied to Stripe's API 
	        $body = $e->getJsonBody(); 
	           $err = $body['error']; 
	           header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
	           exit;
	      } 
	      catch (Stripe_Error $e) { 
		      //echo '<pre>'.print_r($e,true).'</pre>';
		      header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=Card error'));
		      exit;
	      }

	      catch (Exception $e) {
	        // Something else happened, completely unrelated to Stripe
	        header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Error&MessageStyle=bg-orange&Message=We apologize. Sorry for the inconvenience. '));
	      exit;
	      }

	      if($stripeSuccess)
	      {       
	         
	          $orders = new InvoiceTransactions();
	          $orders->OrderId = $_REQUEST['OrderId'];
	          $orders->Amount = $_REQUEST['TotalPrice'];
	          $orders->DateAdded = date('Y-m-d H:i:s');
	          $orders->Status = 1;
	          $orders->addTransactions();

	          $Invoice = new Invoice();
	          $Invoice->loadInvoice(' OrderId = '.$_REQUEST['OrderId']);
	          $Invoice->InvoiceStatus=3;
	          $Invoice->updateInvoice();
	      }

	      
	      header("location:collectedorders.php?".$Encrypt->encrypt("Message=Your Payment has been received successfully&Success=true"));
	      exit();

}


?>
<!DOCTYPE html>
<html lang="en">
<?php require_once ("../include/title.php"); ?>  
<body class="nav-md">
    <div class="container body">
      <div class="main_container">

			<!-- Header Wrapper -->
			<?php require_once ("include/header.php"); ?>  
			
			<!-- page content -->
			<div class="right_col" role="main">               
		         <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                  	<?php 
							if($Message)
								echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
						?>
						<div class="clearfix"></div>	
	                    <h2>Orders <small>Manage your orders here</small></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Order::GetApprovedOrderLsit();
							if($Result->TotalResults>0)
							{
						?>
						<form name="DeleteFrm" method="post" action="collectedorders.php" id="DeleteFrm" enctype="multipart/form-data">
		                    <table id="datatable" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Sr. #</th>
		                          <th>Order&nbsp;Id</th>
		                          <th>Order Placed</th>
		                          <th>Contact</th>
		                          <th>Pickup Date</th>
		                          <th>Instructions</th>
		                          <th>Order Status</th>
		                          <th>Order Status</th>
		                         
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
										
										echo '<input type="text" style="display:none;" name="Id[]" value="'. $Encrypt->encrypt($Result->Result[$x]['Id'])  .'" />';
										$Link = $Encrypt->encrypt("Id=".$Result->Result[$x]['Id']);
										$Contact = 	$Result->Result[$x]['ContactName'] . "<br/>" 
													. $Result->Result[$x]['Address1'] . " " 
													. $Result->Result[$x]['Address2'] . "<br/>" 
													. $Result->Result[$x]['City'] . " " 
													. $Result->Result[$x]['PostalCode'] . "<br/>" 
													. $Result->Result[$x]['Cellphone'] . "<br/>" 
													. $Result->Result[$x]['EmailId'] ;
									?>

										<tr class="">
											<td><?php echo ($x+1) ; ?></td>
											<td><?php echo $Result->Result[$x]['OrderId']; ?></td>
					                        <td><?php echo $Result->Result[$x]['Timestamp']; ?></td>
					                        <td><?php echo $Contact; ?></td>
					                        <td><?php echo $Result->Result[$x]['PickupDate']; ?></td>
					                        <td><?php echo $Result->Result[$x]['Instructions']; ?></td>
											<td><?php echo $Result->Result[$x]['OrderStatus']; ?></td>
											<td> <select name="OrderStatus[]" class="form-control" required>
													<option value="<?php echo $Encrypt->encrypt("Order Placed"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Order Placed') echo "selected=selected"; ?> >Order Placed</option>
													<option value="<?php echo $Encrypt->encrypt("Upcoming"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Upcoming') echo "selected=selected"; ?> >Upcoming</option>
													<option value="<?php echo $Encrypt->encrypt("Pick up"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Pick up') echo "selected=selected"; ?> >Pick up</option>
													<option value="<?php echo $Encrypt->encrypt("Order Accepted"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Order Accepted') echo "selected=selected"; ?> >Order Accepted</option>
													<option value="<?php echo $Encrypt->encrypt("Processing"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Processing') echo "selected=selected"; ?> >Processing</option>
													<option value="<?php echo $Encrypt->encrypt("In Transit"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'In Transit') echo "selected=selected"; ?> >In Transit</option>
													<option value="<?php echo $Encrypt->encrypt("Out for Delivery"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Out for Delivery') echo "selected=selected"; ?> >Out for Delivery</option>
													<option value="<?php echo $Encrypt->encrypt("Attempted Delivery"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Attempted Delivery') echo "selected=selected"; ?> >Attempted Delivery</option>
													<option value="<?php echo $Encrypt->encrypt("Delivered"); ?>" <?php if($Result->Result[$x]['OrderStatus'] == 'Delivered') echo "selected=selected"; ?> >Delivered</option>
												 </select>
												 <div class="clearfix"></div>
												 <br/>
												 <?php
												 		if(Invoice::CheckInvoiceExist($Result->Result[$x]['Id']))
												 		{
												 			$FilesResultset = Files::LoadFileInfo($Result->Result[$x]['Id']);

												 			
												 			echo '<a href="'. APPROOT . 'tmp/'. $FilesResultset->Result[0]['FileLocation'] .'" target="_blank" class="btn btn-sm btn-primary">'
												.'View&nbsp;Invoice </a>'; 

														if(InvoiceTransactions::CheckInvoiceTransactionsExist($Result->Result[$x]['Id']))
														{
															echo '<div class="clearfix"></div>';
															echo '<span class="alert-success">Credit card has been charged.</span>';
														}
														else{
															
															$TotalPrice = Invoice::GetTotal($Result->Result[$x]['Id']);
															echo '<a href="#" target="_blank" class="btn btn-sm btn-warning modaledit" data-toggle="modal" data-target=".bs-example-modal-lg" data-loginid="'. $Result->Result[$x]['LoginId'] . '" data-id="'. $Result->Result[$x]['Id']. '"  data-total="'. $TotalPrice. '">'
															.'Charge&nbsp;Invoice </a>'; 
														}
										 		}	
										 		else
										 			echo '<a href="generate-invoice.php?'. $Link .'" class="label label-danger" >Generate&nbsp;Invoice</a>';

												 ?>
												
											</td>
										</tr>				
									<?php 
									$count++;
									}
									?>
		                        	
		                      </tbody>
		                    </table>
		                    <table id="" class="table table-striped table-bordered">
		                    	<tr class="">
									<td colspan="4" align="right">
										<button type="submit" class="btn btn-success" name="submitorder" value="submitorder" onClick="document.getElementById('DeleteFrm').submit(); ">Submit Your Choice</button>
									</td>
								</tr>	
		                    </table>
		                    
		                </form>
		                <?php } 
		                else{
		                		echo '<p class="text-muted font-13 m-b-30">You have no orders today!</p>';
		                	}?>
	                  </div>
	                </div>
	            </div>

			    <div class="clearfix"></div>

		    
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  

			<!-- Datatables -->
    <script>
      $(document).ready(function() {
      	

        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });

      function toggleApprove(check)
		{
			check = parseInt(check) - parseInt("1");
			//alert(check);

			chkvaluer=document.DeleteFrm.elements['del[]'];
			chkvaluedel=document.DeleteFrm.elements['delreason[]'];
			
					
					if(chkvaluer[check].disabled)
					{
						chkvaluer[check].disabled = false;
						
					}	
					else
					{
						chkvaluer[check].disabled = true;
						chkvaluedel[check].disabled = true;
					}	
			
		}

		function toggleDelete(check)
		{
			check = parseInt(check) - parseInt("1");
			//alert(check);

			chkvaluer=document.DeleteFrm.elements['approve[]'];
			chkvaluedel=document.DeleteFrm.elements['delreason[]'];

					if(chkvaluer[check].disabled)
					{
						chkvaluer[check].disabled = false;
						chkvaluedel[check].disabled = true;
					}	
					else
					{
						chkvaluer[check].disabled = true;
						chkvaluedel[check].disabled = false;

					}	
		}

</script>




    <!-- /Datatables -->
    <form method="post" action="#">
    <div class="modal fade bs-example-modal-lg" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">

	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
	        </button>
	        <h4 class="modal-title" id="myModalLabel">Choose Payment Option</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="row">
	      			<input type="text" style="display:none;" id="OrderId" name="OrderId" value="" />
	      			<input type="text" style="display:none;" id="CustomerId" name="CustomerId" value="" />
	      		
	      		<div class="col-md-6 col-md-offset-3">
	                <input type="text" name="TotalPrice" class="form-control required label-info" id="TotalPrice" value="" placeholder="Total Amount to be charged." required="">
	              </div>
	              <div class="clearfix"></div>
	              <br/>

	      	    <div class="col-md-5">
	            	<input id="applyType" name="applyType" type="radio" value="existing" /> Charge with existing Credit Card
	            </div>
	            <div class="col-md-6">
	            	<input id="applyType" name="applyType" type="radio" value="new" /> Charge with new Credit Card
	            </div>
	          </div>
	        
	        	<div id="newCard" class="newCard">
		          	<h4>Enter your payment</h4>
	                <div class="col-md-4 form-group">
	                  <select name="txtCreditCardName" class="form-control required">
	                    <option value="">-- Card Type --</option>
	                    <option value="Visa">Visa</option>
	                    <option value="MasterCard">MasterCard</option>                          
	                    <option value="American Express">American Express</option>
	                    <option value="JCB">JCB</option>                          
	                    <option value="Discover">Discover</option>                                                    
	                    <option value="Diners Club">Diners Club</option>                                                                              
	                  </select>
	                </div>
	              
	              <div class="col-md-4">
	                <input type="text" name="adnName" class="form-control required" id="" value="" placeholder="Cardholder Name*">
	              </div>

	              <div class="col-md-4">
	                <input type="text" id="txtCreditCardNumber" class="form-control required number" name="txtCreditCardNumber" value="" placeholder="Card Number*">
	              </div>
	              <div class="clearfix"></div>
	              <div class="col-md-4">
	                <input type="text" value="" name="drpdwnMonth" class="form-control required" id="drpdwnMonth" placeholder="MM*">
	              </div>
	              <div class="col-md-4">
	                <input type="text" name="drpdwnYear" value="" id="drpdwnYear" class="form-control required" placeholder="YY*">
	              </div>
	              <div class="col-md-4">
	                <input type="text" name="txtCreditCardCVS" value="" id="txtCreditCardCVS" class="form-control required card-cvc" placeholder="CVC*">  
	              </div>
	              <div class="clearfix"></div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-success submit" name="pay" value="pay" >Pay Now</button>
		      </div>
		    </div> <!-- end of newCard div -->

	    </div>
	  </div>
	</div>
	</form>

	<script>
	$(document).on("click", ".modaledit", function () {
	    var first_name= $(this).data('id');
	    var loginid= $(this).data('loginid');
	    var total= $(this).data('total');
	    
	    $("#bs-example-modal-lg #OrderId").val( first_name );
	    $("#bs-example-modal-lg #CustomerId").val( loginid );
	    $("#bs-example-modal-lg #TotalPrice").val(total );
	});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#newCard").hide();
		     $('input[type="radio"]').click(function(){
		        var checked_option_radio = $('input:radio[name=applyType]:checked').val();
		        
		        if(checked_option_radio===undefined)
		            {
		                alert('Please select any one options!');
		            }else{

		            	if(checked_option_radio === 'new')
		            	 {
		            	 	//alert('Your option - "' +checked_option_radio +'"');
		            	 	 $("#newCard").show();
		            	 	
		            	 }
		            	 else{
		            	 	$("#newCard").hide();
		            	 }
		                 
		            }
		    });
		});
	</script>

</body>
</html>
