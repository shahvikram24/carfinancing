<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	
	
	$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
	if( isset($_REQUEST['submitorder']) && $_REQUEST['submitorder'] == 'submitorder' )   
	{
			//echo "<br/> =========== ----1" ;

			

			$delchk = isset($_REQUEST["del"])?$_REQUEST["del"]:"";
			$delreason = isset($_REQUEST["delreason"])?$_REQUEST["delreason"]:"";
			$approvechk = isset($_REQUEST["approve"])?$_REQUEST["approve"]:"";
			
			if($delchk != "")
			{
				for($i=0; $i< count($delchk) ; $i++)
				{	
					if($delchk[$i] > 0 )
						{
							$sql = "update tblorder 
									set Status = 3, 
										RejectReason = '" . $delreason[$i] ."' ,
										OrderStatus = 'Order Rejected' 
										where Id = " . $delchk[$i] ;
							$res = Order::AcceptOrder($sql);
							Login::RejectOrderConfirmation($delchk[$i]);
						}
						else
						{
							$Message = "Invalid Selection.<br><br>";
						}
				}
			}
			
			/////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////


			if($approvechk != "")
			{
				//echo "<br/> =========== ----0" ;
				for($i=0; $i< count($approvechk) ; $i++)
				{	
					//echo "<br/> =========== 1" ;
					if($approvechk[$i] > 0 )
						{
							$sql = "update tblorder 
									set Status = 1 ,
									OrderStatus = 'Order Accepted' 
									where Id = " . $approvechk[$i] ;
							$res = Order::AcceptOrder($sql);
							//echo "<br/> === res = " . $res;
							Login::AcceptOrderConfirmation($approvechk[$i]);
							//echo "<br/> =========== 2" ;
						}
						else
						{
							$Message = "Invalid Selection.<br><br>";
						}
				}
			}

			//debugObj($_REQUEST); die();
			header("Location:orders.php?".$Encrypt->encrypt("Message=Your choice has been successfully selected.&Success=true"));
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
	                    <h2>Order for pickup <small>Accept / Reject It</small></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Order::GetApprovalOrderLsit();
							if($Result->TotalResults>0)
							{
						?>
						<form name="DeleteFrm" method="post" action="#" id="DeleteFrm">
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
		                          <th>Accept Order</th>
		                          <th>Reject Order</th>
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
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
					                        <td><?php echo $Result->Result[$x]['PickupDate']; 
					                        	if($Result->Result[$x]['PickupAfter'] != '')
					                        		{
					                        			echo " <b>Between</b> " 
						                        		. $Result->Result[$x]['PickupAfter'] 
						                        		. " <b>to</b> " 
						                        		. $Result->Result[$x]['PickupBefore']
						                        		; 	
					                        		}
					                        ?></td>

					                        <td><?php echo $Result->Result[$x]['Instructions']; ?></td>
											<td><?php echo $Result->Result[$x]['OrderStatus']; ?></td>
											
											<td><input type="checkbox" id="approve" name="approve[]" value="<?php echo $Result->Result[$x]['Id'];?>" onclick="toggleApprove('<?php echo $count; ?>' )"/></td>
												<td><input type="checkbox" id="delete" name="del[]" value="<?php echo $Result->Result[$x]['Id'];?>"  onclick="toggleDelete('<?php echo $count; ?>' )"/>
												
												<input type="text"  class="form-control" name="delreason[]" value="" disabled/>
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
		                    <input type="hidden" name="act" value="action" />
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
</body>
</html>
