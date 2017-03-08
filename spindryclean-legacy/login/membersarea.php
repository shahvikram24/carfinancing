<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
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
	                    <h2>Members Area <small>Manage your members here</small></h2>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							$Result = Customer::GetCustomerList();
							if($Result->TotalResults>0)
							{
						?>
						<form name="DeleteFrm" method="post" action="members.php?act=action" id="DeleteFrm">
		                    <table id="datatable" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Sr. #</th>
		                          <th>Email</th>
		                          <th>First Name</th>
		                          <th>Last Name</th>
		                          <th>Address 1</th>
		                          <th>Address 2</th>
		                          <th>Cellphone</th>
		                          <th>Postal Code</th>
		                          <th>Reject Member</th>
		                         
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
									?>

										<tr class="">
											<td><?php echo ($x+1) ; ?></td>
											<td><?php echo $Result->Result[$x]['EmailId']; ?></td>
											<td><?php echo $Result->Result[$x]['FirstName']; ?></td>
					                        <td><?php echo $Result->Result[$x]['LastName']; ?></td>
											<td><?php echo $Result->Result[$x]['Address1']; ?></td>
											<td><?php echo $Result->Result[$x]['Address2']; ?></td>
											<td><?php echo $Result->Result[$x]['Cellphone']; ?></td>
											<td><?php echo $Result->Result[$x]['Postalcode']; ?></td>
											<td><input type="checkbox" id="delete" name="del[]" value="<?php echo $Result->Result[$x]['Id'];?>"  /></td>
											<td>&nbsp;</td>
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
		                		echo '<p class="text-muted font-13 m-b-30">You have no members to choice from!</p>';
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
