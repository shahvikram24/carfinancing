<?php ob_start();
	require_once("include/files.php");

	if(!isset($_SESSION['customer_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	
	
	$customer = new Customer();
	$customer->loadcustomer($_SESSION['customer_id']);

	
	if(isset($_POST['submitorder']) && $_POST['submitorder'] == 'submitorder')
	{
				//debugObj($_REQUEST); die();
				//echo "<br/> =======1 ========= <br/>";
				//debugObj($customer);
				$order = new Order();
				$order->OrderId = uniqid();
				$order->Instructions = $_POST['Instruction'];
				$order->LoginId = $_SESSION['customer_id'];
				$order->PickupDate = FormatDate($_POST['input2'], 'Y-m-d');
				$order->DropoffDate = FormatDate($_POST['deliverdate'], 'Y-m-d');
				$order->Recurrancefreq = 0;
				$order->PickupAfter = $_POST['PickupAfter'];
				$order->PickupBefore = $_POST['PickupBefore'];
				$order->RecurringOn = 0;
				$order->OrderStatus = 'Order Placed';
				$order->Status = 2;
				$OrderId = $order->addOrder();

				//echo "<br/> =======2 ========= <br/>";
				Login::NewOrder($OrderId);
				header('Location: orderhistory.php');
				exit();
				//echo "<br/> =======3 ========= <br/>";
	}	
ob_end_flush();
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
	          <!-- top tiles -->
	          	  	<div class="row">
		              <div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                	<div class="x_title">
		                    	<h2>Form Design</h2>
		                    	<div class="clearfix"></div>
		                	</div>
		                	<div class="col-md-6">
		                		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="#">
		                			<div class="form-group">
				                        <label class="control-label col-md-6" for="first-name">Select Date for Pickup <span class="required">*</span>
				                        </label>
				                        <div class="col-md-6">
				                          
				                          <input type="hidden" name="deliverdate" value="" id="deliverdate" />
				                          <fieldset>
					                          <div class="control-group">
					                            <div class="controls">
					                              <div class="col-md-11 xdisplay_inputx form-group has-feedback">
					                                <input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder="First Name" aria-describedby="inputSuccess2Status" name="input2">
					                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
					                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
					                              </div>
					                            </div>
					                          </div>
					                        </fieldset>
				                        </div>
				                      </div>

				                      <div class="form-group">
				                        <label class="control-label col-md-6" for="first-name">Pickup Between: <span class="required">*</span>
				                        </label>
				                        <div class="col-md-6">
				                          <input id="PickupAfter" type="text" class="form-control has-feedback-left time" name="PickupAfter"/>
				                          <script>
							                $(function() {
							                    $('#PickupAfter').timepicker({ 'disableTimeRanges': [['12am', '8am'], ['6pm', '11:59pm']] });
							                });
							            </script>
							            <label class="control-label"> AND </label>

							            <input id="PickupBefore" type="text" class="form-control has-feedback-left time" name="PickupBefore"/>
				                          <script>
							                $(function() {
							                    $('#PickupBefore').timepicker({ 'disableTimeRanges': [['12am', '8am'], ['2pm', '11:59pm']] });
							                });
							            </script>

				                        </div>
				                      </div>


				                      <div class="form-group">
				                        <label class="control-label col-md-6" for="first-name">Pick Up Location Instructions <span class="required">*</span>
				                        </label>
				                        <div class="col-md-6">
				                          <input name="Instruction" placeholder="Pick Up Location Instructions" type="text" class="form-control col-md-7 col-xs-12">
				                        </div>
				                      </div>
				                      <div class="ln_solid"></div>
				                      <div class="form-group">
				                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				                          <button type="submit" class="btn btn-success" name="submitorder" value="submitorder">Submit</button>
				                        </div>
				                      </div>

				                </form>
				            </div>
				            <div class="col-md-6">
				            	<div class="form-group">
			                        <span class="control-label col-md-12" for="first-name">
			                        	Your clothing will be picked up from <br/><strong><?= $customer->Address1 ?></strong>, 
													Suite#&nbsp;<strong><?= $customer->Address2 ?></strong>
													<strong><span id="datechange" value=""></span></strong>
			                        </span>
			                    </div>
			                    <div class="clearfix"></div>
			                    <div class="form-group">
			                        <label class="control-label col-md-12" for="first-name">
			                        	Please include detailed instructions on where your bag will be located. Thanks.
			                        </label>
			                    </div>
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
      	
        $('#single_cal1').daterangepicker({          
          singleDatePicker: true,
          minDate: moment(),
          isInvalidDate: function(date) { return date.day() == 0 || date.day() == 6; },
          
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);

        

          var startDate = new Date(start);
			var endDate = "", noOfDaysToAdd = 3, count = 0;
			while(count < noOfDaysToAdd){
			    endDate = new Date(startDate.setDate(startDate.getDate() + 1));
			    if(endDate.getDay() != 0 && endDate.getDay() != 6){
			       count++;
			    }
			}
			var EndDate = endDate.toISOString();
			    document.getElementById("datechange").innerHTML = " and delivered back to you by " +EndDate.substr(0,10);
          		document.getElementById("deliverdate").value = EndDate.substr(0,10);
        });
        
        $('#single_cal1').data('daterangepicker').setStartDate(new Date());


        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        
      });
    </script>
</body>
</html>
