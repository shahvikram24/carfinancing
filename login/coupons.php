<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
	if($act == "action")
	{
		
		$IdArray = implode($_REQUEST['selected'],",");
		if(Coupon::archiveCoupon($IdArray))
		{
			header('Location:coupons.php?'.$Encrypt->encrypt("Success=True&Message=Success: You have modified coupons!"));
			exit();
		}
		else
		{
			header('Location:coupons.php?'.$Encrypt->encrypt("Success=False&Message=Failure: Something went wrong!"));
			exit();
		}
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
						        if(isset($Message) && $Message !='')
						        {
						        	if($Success && $Success == 'true')
						        	{
								?> 
									<div class="alert alert-success alert-dismissible fade in" role="alert">
					                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					                    </button>
					                    <strong><?= $Message ?></strong>
					                  </div>

		                  <?
								}  	else {
						   ?>
										<div class="alert alert-success alert-dismissible fade in" role="alert">
					                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					                    </button>
					                    <strong><?= $Message ?></strong>
					                  </div>
							<?php
						        }
						      }
						    ?>
							<div class="clearfix"></div>	
		                    <h2> Coupon List <small>Manage all your promotions here</small></h2>
		                    <div class="pull-right">
		                      <a href="coupons-add.php" data-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fa fa-plus"></i></a>
		                      
		                      <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-coupon').submit() : false;"><i class="fa fa-trash-o"></i></button>
		                      
		                    </div>
		                    <div class="clearfix"></div>
		                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Coupon::GetCouponList();
							if($Result->TotalResults>0)
							{
						?>
						<form name="form-coupon" method="post" action="coupons.php?act=action" id="form-coupon" enctype="multipart/form-data" >
		                    <table id="datatable-buttons" class="table table-hover table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td></th>
		                          <th>Name</th>
		                          <th>Code</th>
		                          <th>Discount</th>		                          
		                          <th>Date Start</th>
		                          <th>Date End</th>
		                          <th>Status</th>
		                          <th>Action</th>
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
									?>

										<tr class="">
											<td><input type="checkbox" name="selected[]" value="<?php echo $Result->Result[$x]['Id']; ?>" /></td>
											<td><?php echo $Result->Result[$x]['Name']; ?></td>
											<td><?php echo $Result->Result[$x]['Code']; ?></td>
											<td><?php 
													if($Result->Result[$x]['Type'] == 'P') 
														echo $Result->Result[$x]['Discount'] . "%"; 
													else
														echo $Result->Result[$x]['Discount']; 
												?>
											</td>
											
											<td><?php echo $Result->Result[$x]['DateStart']; ?></td>
											<td><?php echo $Result->Result[$x]['DateEnd']; ?></td>
											<td>
												<?php 	if($Result->Result[$x]['Status'] ==2)
															echo "Disabled";
														else
															echo "Enabled";
															 ?>
														
											</td>
											<td><a href="<?php echo 'coupons-edit.php?' . $Encrypt->encrypt("CouponId=".$Result->Result[$x]['Id']); ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
										</tr>				
									<?php 
									$count++;
									}
									?>
		                        	
		                      </tbody>
		                    </table>
		                   
		                </form>
		                <?php } 
		                else{
		                		echo '<p class="text-muted font-13 m-b-30">You have no promotions right now!</p>';
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
