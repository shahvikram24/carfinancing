<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	$date = date("Y-m-d");

	if(isset($_POST['submitdate']) && $_POST['submitdate'] == 'submitdate')
	{
		$date = date("Y-m-d", strtotime($_REQUEST['input2']));
		//echo "<br/>date = " . $date . "<br/>";
		$Result = Order::TodayPickup($date);
	}
	else
		$Result = Order::TodayPickup();


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
	                  <div class="col-md-6 col-sm-6 col-xs-6">
		                  <div class="x_title">
		                  	<?php 
								if($Message)
									echo '<h2 style="text-align: left;color:#555;background:#e9ffd9;">'. $Message.'</h2>';
							?>
							<div class="clearfix"></div>	
		                    <h2>Order for pickup <small>Date: <?= $date ?></small></h2>
		                    <div class="clearfix"></div>
		                  </div>
		               </div>
		               <div class="col-lg-6">
		                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="#">
		                    <div class="title_right">
				                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
				                  <div class="input-group">
				                    <input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder=" Pickup Date" aria-describedby="inputSuccess2Status" name="input2">
	                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
				                    <span class="input-group-btn">
				                      <button class="btn btn-default" type="submit" name="submitdate" value="submitdate">Go!</button>
				                    </span>
				                  </div>
				                </div>
				            </div>
				            </form>
		               </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <?php
							
							if($Result->TotalResults>0)
							{
						?>
						<form name="DeleteFrm" method="post" action="#" id="DeleteFrm">
		                    <table id="datatable-buttons" class="table table-striped table-bordered">
		                      <thead>
		                        <tr>
		                          <th>Sr. #</th>
		                          <th>Order&nbsp;Id</th>
		                          <th>Order Placed</th>
		                          <th>Contact</th>
		                          <th>Pickup Date</th>
		                          <th>Instructions</th>
		                          
		                        </tr>
		                      </thead>


		                      <tbody>

		                        <?php

									$count = 1;
				
									for($x = 0; $x < $Result->TotalResults ; $x++)
									{
										$Link = $Encrypt->encrypt("Id=".$Result->Result[$x]['Id']);
										$Contact = 	$Result->Result[$x]['ContactName'] . " <br/>" 
													. $Result->Result[$x]['Address1'] . " " 
													. $Result->Result[$x]['Address2'] . " <br/>" 
													. $Result->Result[$x]['City'] . " " 
													. $Result->Result[$x]['PostalCode'] . " <br/>" 
													. $Result->Result[$x]['Cellphone'] . " <br/>" 
													. $Result->Result[$x]['EmailId'] ;
									?>
										<tr class="">
											<td><?php echo ($x+1) ; ?></td>
											<td><?php echo $Result->Result[$x]['OrderId']; ?></td>
					                        <td><?php echo $Result->Result[$x]['Timestamp']; ?></td>
					                        <td><?php echo $Contact; ?></td>
					                        <td><?php echo $Result->Result[$x]['PickupDate']; ?></td>
					                        <td><?php echo $Result->Result[$x]['Instructions']; ?></td>
											
										</tr>				
									<?php 
									$count++;
									}
									?>
		                        	
		                      </tbody>
		                    </table>
		                    <input type="hidden" name="act" value="action" />
		                </form>
		                <?php } 
		                else{
		                		echo '<p class="text-muted font-13 m-b-30">You have no orders for '. $date .'!</p>';
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

    </script>
    <!-- /Datatables -->

    <script>
      $(document).ready(function() {
      	
        $('#single_cal1').daterangepicker({          
          singleDatePicker: true,
          minDate: moment(),
          isInvalidDate: function(date) { return date.day() == 0 || date.day() == 6; },
          
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
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
