<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	$Support = new Support();
	if( isset($_POST['submitstatus']) && $_POST['submitstatus'] == 'submitstatus' )   
	{
		
		for($x=0; $x < count($_REQUEST['Id']) ; $x++)
		{
			$Id = '';
			$Id = $Decrypt->decrypt($_POST['Id'][$x]);
			$Support->loadSupport("Id = ".$Id);
			$Support->SupportStatus = $_POST['SupportStatus'][$x];
			$Support->UpdateSupport();
		}

		
		header("Location:support-tickets.php?".$Encrypt->encrypt("Message=Your choice has been successfully selected.&Success=true"));
      		exit();
	}

	$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";
	if($act == "action")
	{
		
		$IdArray = implode($_REQUEST['selected'],",");
		if(Support::archiveSupport($IdArray))
		{
			header('Location:support-tickets.php?'.$Encrypt->encrypt("Success=True&Message=Success: You have modified support tickets!"));
			exit();
		}
		else
		{
			header('Location:support-tickets.php?'.$Encrypt->encrypt("Success=False&Message=Failure: Something went wrong!"));
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
		                    <h2> Support Tickets List <small>Manage all your support tickets here</small></h2>
		                    <div class="pull-right">
		                      
		                      
		                      <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-coupon').submit() : false;"><i class="fa fa-trash-o"></i></button>
		                      
		                    </div>
		                    <div class="clearfix"></div>
		                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Support::GetSupportList();
							$customer = new Customer();
							if($Result->TotalResults>0)
							{								
								
						?>
						<form name="form-coupon" method="post" action="support-tickets.php?act=action" id="form-coupon" enctype="multipart/form-data" >
		                    <table id="datatable-buttons" class="table table-hover table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td></th>
		                          <th>Member Name</th>
		                          <th>Member Phone Number</th>
		                          <th>Subject</th>
		                          <th>Message</th>
		                          <th>DateAdded</th>
		                          <th>Support Status</th>
		                          <th>Action</th>
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
										echo '<input type="text" style="display:none;" name="Id[]" value="'. $Encrypt->encrypt($Result->Result[$x]['Id'])  .'" />';
									?>
										
										<tr class="">
											<td><input type="checkbox" name="selected[]" value="<?php echo $Result->Result[$x]['Id']; ?>" /></td>
											<td><?= Customer::getName($Result->Result[$x]['CustomerId']); ?></td>
											<td><?= Customer::getPhoneNumber($Result->Result[$x]['CustomerId']); ?></td>
											<td><?php echo $Result->Result[$x]['Subject']; ?></td>
											
											<td><?php echo $Result->Result[$x]['Message']; ?></td>
											<td><?php echo $Result->Result[$x]['DateAdded']; ?></td>
											<td>
												<?php 	if($Result->Result[$x]['SupportStatus'] == 2)
															echo "Closed";
														else
															echo "Open";
															 ?>
														
											</td>
											<td> <select name="SupportStatus[]" class="form-control" required>
													<option value="1" <?php if($Result->Result[$x]['SupportStatus'] == 1) echo "selected=selected"; ?> >Open</option>
													<option value="2" <?php if($Result->Result[$x]['SupportStatus'] == 2) echo "selected=selected"; ?> >Close</option>												
												 </select>
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
										<button type="submit" class="btn btn-success" name="submitstatus" value="submitstatus" >Change Status</button>
									</td>
								</tr>	
		                    </table>
		                </form>
		                <?php } 
		                else{
		                		echo '<p class="text-muted font-13 m-b-30">You have no support tickets right now!</p>';
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

