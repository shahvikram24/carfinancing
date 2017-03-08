<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}

if(!isset($Id))
{
	header("Location: orders.php");
}

if(isset($_POST['genInvoice']) && $_POST['genInvoice'] == 'genInvoice')
{
	$time = strtotime($_REQUEST['date_start']);
	$newformat = date('Y-m-d',$time);
	//echo $newformat;
	//debugObj($_REQUEST); die();
	$Invoice = new Invoice();
	$Invoice->OrderId = $Id;
	$Invoice->CustomerId = $Decrypt->decrypt($_REQUEST['customerid']);
	$Invoice->InvoiceNumber = $_REQUEST['InvoiceNumber'];
	$Invoice->Discount = 0.00;
	$Invoice->TotalPrice = $_REQUEST['totalAftertax'];
	$Invoice->InvoiceStatus = 1;
	$Invoice->DueDate = $newformat;
	$Invoice->Notes = $_REQUEST['notes'];
	$Invoice->Timestamp = date("Y-m-d");
	$Invoice->Status = 1;
	//echo "<br/> ===== 1 ";
	$InvoiceId = $Invoice->addInvoice();

	//echo "<br/> ===== 2 ";
	$InvoiceProducts = new InvoiceProducts();
	$InvoiceProducts->InvoiceId = $InvoiceId;
	
	//echo "<br/> ===== 3 ";
	//ProductCount
	if($_REQUEST['itemName'] != "")
    	$ProductCount = count ($_REQUEST['itemName']) ;

    //echo "<br/> product count =  ". $ProductCount;

	for($x = 0; $x < $ProductCount ; $x++) 
	{
		if( isset($_REQUEST['itemNo'][$x])) 
		{
			$InvoiceProducts->ProductName = $_REQUEST['itemName'][$x];
			$InvoiceProducts->Price = $_REQUEST['price'][$x];
			$InvoiceProducts->Quantity = $_REQUEST['quantity'][$x];
			$InvoiceProducts->Totalprice = $_REQUEST['total'][$x];
			$InvoiceProducts->Status = 1;
			$InvoiceProducts->addInvoiceProducts();
		}
	}

	
		if($InvoiceId)
		{
			header('Location:geninfo.php?'.$Encrypt->encrypt("OrderId=".$Id));
			exit();
		}
		else
		{
			header('Location:generate-invoice.php?'.$Encrypt->encrypt("Success=False&Message=Failure: Something went wrong while creating invoice.!&Id=".$Id));
			exit();
		}	
}

$Order = new Order();
$Order->loadorder($Id);

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
							<div class="clearfix"></div>	
		                    <h2> Invoice <small>Create New Invoice Here</small></h2>
		                    <div class="pull-right">
						        <button type="submit" name="genInvoice" value="genInvoice" form="form-coupon" data-toggle="tooltip" title="Generate Invoice" class="btn btn-primary"><i class="fa fa-save"></i></button>
						        <a href="collectedorders.php" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a>
						    </div>
		                    <div class="clearfix"></div>
		                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <div class="clearfix"></div>
	                    <form action="#" method="post" enctype="multipart/form-data" id="form-coupon" class="form-horizontal">
	                    <input type="text" name="orderid" value="<?php echo $Encrypt->encrypt($Order->Id); ?>" id="orderid" style="display:none;" />
	                    <input type="text" name="customerid" value="<?php echo $Encrypt->encrypt($Order->LoginId); ?>" id="customerid" style="display:none;" />
	                    
	                    <div class='row'>
      		
			      		<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
			      			<div class="col-md-10 form-group has-feedback">
				                <label class="col-sm-3 control-label" for="input-date-start">Invoice Number</label>
				                <fieldset>
		                          <div class="control-group">
		                            <div class="controls">
		                              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
		                                <input type="text" class="form-control" id="InvoiceNumber" placeholder="Invoice No" name="InvoiceNumber" required>
		                              </div>
		                            </div>
		                          </div>
		                        </fieldset>
				            </div>
				            <div class="clearfix"></div>

							<div class="col-md-10 form-group has-feedback">
				                <label class="col-sm-3 control-label" for="input-date-start">Due Date</label>
				                <fieldset>
		                          <div class="control-group">
		                            <div class="controls">
		                              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
		                                <input type="text" class="form-control has-feedback-left" id="invoiceDate" placeholder="Due Date" aria-describedby="inputSuccess2Status" name="date_start" value="">
		                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
		                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
		                              </div>
		                            </div>
		                          </div>
		                        </fieldset>
				            </div>
				            <div class="clearfix"></div>

				            

				            <div class="col-md-10 form-group has-feedback">
				                <label class="col-sm-3 control-label" for="input-date-start">Amount Due</label>
				                <fieldset>
		                          <div class="control-group">
		                            <div class="controls">
		                              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
		                              	
		                              	<span class="fa fa-usd form-control-feedback left" aria-hidden="true"></span>
		                                <input type="text" class="form-control amountDue has-feedback-left" id="amountDueTop" placeholder="Amount Due" readonly>
		                              </div>
		                            </div>
		                          </div>
		                        </fieldset>
				            </div>
				            <div class="clearfix"></div>
							
			      		</div>
			      	</div>
			      	<h2>&nbsp;</h2>
			      	<div class='row'>
			      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			      			<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
										<th width="15%">Sr. #</th>
										<th width="38%">Item Name</th>
										<th width="15%">Price</th>
										<th width="15%">Quantity</th>
										<th width="15%">Total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input class="case" type="checkbox"/></td>
										<td><input type="text" data-type="productCode" name="itemNo[]" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off" readonly></td>
										<td><input type="text" data-type="ProductName" name="itemName[]" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off" required></td>
										<td><input type="text" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;" required></td>
										<td><input type="text" name="quantity[]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;" required></td>
										<td><input type="text" name="total[]" id="total_1" class="form-control totalLinePrice" autocomplete="off" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;" required ></td>
									</tr>
								</tbody>
							</table>
			      		</div>
			      	</div>
			      	<div class='row'>
			      		<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
			      			<button class="btn btn-danger delete" type="button">- Delete</button>
			      			<button class="btn btn-success addmore" type="button">+ Add More</button>
			      		</div>
			      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			      			<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
			      				<h2>Notes: </h2>
						      	<div class='row'>
						      		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						      			<div class="form-group">
											<textarea class="form-control" rows='5' name="notes" id="notes" placeholder="Your Notes"></textarea>
										</div>
						      		</div>
						      	</div>   
			      			</div>
			      			<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
			      				<div class='col-xs-12 col-sm-offset-4 col-md-offset-4 col-lg-offset-4 col-sm-5 col-md-5 col-lg-5'>
							
								<div class="form-group">
									<label>Subtotal: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control" id="subTotal" placeholder="Subtotal" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;">
									</div>
								</div>

								<input type="text" class="form-control" id="tax" placeholder="Tax" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;" value="5" readonly style="display:none;">

								<div class="form-group">
									<label>Tax Amount: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control" id="taxAmount" placeholder="Tax" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;">
										
									</div>
								</div>
								<div class="form-group">
									<label>Total Amount: &nbsp;</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control" id="totalAftertax" name="totalAftertax" placeholder="Total" onkeypress="return parseFloat(event);" ondrop="return false;" onpaste="return false;">
									</div>
								</div>
							
								</div>
					      	
			      			</div>
			      		</div>
			      		
					      	

		                </form>
	                  </div>
	                </div>
	                


	            </div>
	            		

		              
			    <div class="clearfix"></div>

		    
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  
		<script src="js/jquery.min.js"></script>
	    <script src="js/jquery-ui.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/bootstrap-datepicker.js"></script>
	    <script src="js/auto.js"></script>
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

    
</body>
</html>
