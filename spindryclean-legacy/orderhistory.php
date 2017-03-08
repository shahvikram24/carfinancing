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
	$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
	if($act == "action")
	{
				
				$delchk = isset($_POST["del"])?$_POST["del"]:"";
				

				if($delchk != "")
				{
					foreach($delchk as $id)
					{
						if($id > 0 )
						{
							$sql = "update tblorder set Status = 0 where Id = " . $id ;
							$res = mysql_query($sql);
							
						}
						else
						{
							$msg = "Invalid Order.<br><br>";
						}
						//echo "\n" . $id;
					}
				}

				header('Location: orderhistory.php');
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
		         <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2>Scheduled Order <small>History</small></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Order::GetCustomerOrderLsit($_SESSION['customer_id']);
							//debugObj($Result);
							if($Result->TotalResults>0)
							{
						?>
						<form name="DeleteFrm" method="post" action="orderhistory.php?act=action" id="DeleteFrm">
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Order&nbsp;Id</th>
		                          <th>Pick&nbsp;up&nbsp;Date</th>
		                          <th>Status</th>
		                          <th>Cancel&nbsp;Order</th>
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
									
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
									?>
										<tr class="">
											
											<td><?php echo $Result->Result[$x]['OrderId']; ?></td>
					                        <td>
					                        <?php 
					                        		echo $Result->Result[$x]['PickupDate'] ;

					                        		if($Result->Result[$x]['PickupAfter'] != '')
					                        		{
					                        			echo " <b>Between</b> " 
						                        		. $Result->Result[$x]['PickupAfter'] 
						                        		. " <b>to</b> " 
						                        		. $Result->Result[$x]['PickupBefore']
						                        		; 	
					                        		}
					                        		

												 	if(Invoice::CheckInvoiceExist($Result->Result[$x]['Id']))
												 		{
												 			$FilesResultset = Files::LoadFileInfo($Result->Result[$x]['Id']);

												 			
												 			echo '	<span style="padding-left: 10px;">&nbsp;</span>
												 					<a href="'. APPROOT . 'tmp/'. $FilesResultset->Result[0]['FileLocation'] .'" target="_blank" class="label label-primary">'
												.'View&nbsp;Invoice'; 
												 		}	
					                        ?></td>
											<td><?php echo $Result->Result[$x]['OrderStatus']; ?></td>
											<td><input type="checkbox" id="delete" name="del[]" value="<?php echo $Result->Result[$x]['Id'];?>" /></td>

										</tr>				
									<?php 
									}
									?>
		                        	
		                      </tbody>
		                    </table>
		                    <table id="" class="table table-striped table-bordered">
		                    	<tr class="">
									<td colspan="4" align="right">
										<button type="submit" class="btn btn-success" name="submitorder" value="submitorder">Cancel Selected Order</button>
									</td>
								</tr>	
		                    </table>
		                </form>
		                <?php } 
		                else{
		                		echo '<p class="text-muted font-13 m-b-30">
	                      You haven\'t made any orders yet. You can <a href="onetimepickup.php">SCHEDULE&nbsp;A&nbsp;PICKUP</a> today!
	                    </p>';
		                	}?>
	                  </div>
	                </div>
	            </div>

			    <div class="clearfix"></div>
			    

		    	<div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2>Rejected Order <small>History</small></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = '';
							$Result = Order::GetRejectedOrderLsit($_SESSION['customer_id']);
							if($Result->TotalResults>0)
							{
						?>
						<form name="DeleteFrm" method="post" action="orderhistory.php?act=action" id="DeleteFrm">
		                    <table id="datatable" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Order&nbsp;Id</th>
		                          <th>Pick&nbsp;up&nbsp;Date</th>
		                          <th>Reason</th>
		                          <th>Status</th>
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
									
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
									?>
										<tr class="">
											
											<td><?php echo $Result->Result[$x]['OrderId']; ?></td>
					                        <td><?php echo $Result->Result[$x]['PickupDate']; ?></td>
					                        <td><?php echo $Result->Result[$x]['RejectReason']; ?></td>
											<td><?php echo $Result->Result[$x]['OrderStatus']; ?></td>
										</tr>				
									<?php 
									}
									?>
		                        	
		                      </tbody>
		                    </table>
		                </form>
		                <?php } 
		                else{
		                		echo '<p class="text-muted font-13 m-b-30">
	                      You dont have any rejected orders yet.
	                    </p>';
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
    </script>
    <!-- /Datatables -->
</body>
</html>
