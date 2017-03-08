<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}

	

	if(isset($_POST['couponedit']) && $_POST['couponedit'] == 'couponedit')
	{
		
		$coupon = new Coupon();
		$coupon->Name = $_REQUEST['name'];
		$coupon->Code = $_REQUEST['code'];
		$coupon->Type =  $_REQUEST['type'];
		$coupon->Discount =  $_REQUEST['discount'];
		$coupon->Total = 0.00;
		$coupon->DateStart =  $_REQUEST['date_start'];
		$coupon->DateEnd =  $_REQUEST['date_end'];
		$coupon->Status =  $_REQUEST['status'];
		if($coupon->addCoupon())
		{
			header('Location:coupons.php?'.$Encrypt->encrypt("Success=True&Message=Success: You have successfully created new coupon!"));
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
							<div class="clearfix"></div>	
		                    <h2> Add Coupon <small>Manage your coupon here</small></h2>
		                    <div class="pull-right">
						        <button type="submit" form="form-coupon" data-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fa fa-save"></i></button>
						        <a href="coupons.php" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a>
						    </div>
		                    <div class="clearfix"></div>
		                  </div>
	                  <div class="x_content">
	                    <p class="text-muted font-13 m-b-30">
	                       it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
	                    </p>
	                    <div class="clearfix"></div>
	                    <form action="#" method="post" enctype="multipart/form-data" id="form-coupon" class="form-horizontal">
	                    <input type="text" name="couponedit" value="couponedit" id="couponedit" style="display:none;" />
	                    <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-name">Coupon Name</label>
			                <div class="col-sm-10">
			                  <input type="text" name="name" value="<?= $coupon->Name ?>" placeholder="Coupon Name" id="input-name" class="form-control" />
			                </div>
			            </div>
					            
			            <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-name">Code</label>
			                <div class="col-sm-10">
			                  <input type="text" name="code" value="<?= $coupon->Code ?>" placeholder="Code" id="input-code" class="form-control" />
			                </div>
			            </div>

			            
			            <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-name">Discount</label>
			                <div class="col-sm-10">
			                 <input type="text" name="discount" value="<?= $coupon->Discount ?>" placeholder="Discount" id="input-discount" class="form-control" />
			                </div>
			            </div>

			            <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-name">Type</label>
			                <div class="col-sm-10">
			                  <select name="type" id="input-type" class="form-control">
                                        <option value="P" <?= ($coupon->Discount == 'P') ? 'selected="selected"' : '' ?> >Percentage</option>
                                        <option value="F" <?= ($coupon->Discount == 'F') ? 'selected="selected"' : '' ?> >Fixed Amount</option>
                                      </select>
			                </div>
			            </div>

			            <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-date-start">Date Start</label>
			                <fieldset>
	                          <div class="control-group">
	                            <div class="controls">
	                              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
	                                <input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder="Start Date" aria-describedby="inputSuccess2Status" name="date_start" value="<?= $coupon->DateStart ?>">
	                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
	                              </div>
	                            </div>
	                          </div>
	                        </fieldset>
			            </div>
			            <div class="clearfix"></div>

			            <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-name">End Date</label>
			                
			                  	<fieldset>
		                          <div class="control-group">
		                            <div class="controls">
		                              <div class="col-md-12 xdisplay_inputx form-group has-feedback">
		                                <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="End Date" aria-describedby="inputSuccess2Status" name="date_end" value="<?= $coupon->DateEnd ?>">
		                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
		                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
		                              </div>
		                            </div>
		                          </div>
		                        </fieldset>
			                
			            </div>

			            <div class="col-md-10 form-group has-feedback">
			                <label class="col-sm-2 control-label" for="input-name">Status</label>
			                <div class="col-sm-10">
			                 <select name="status" id="input-status" class="form-control">
                                        
                    					<option value="1" <?= ($coupon->Status == '1') ? 'selected="selected"' : '' ?> >Enabled</option>
                                        <option value="2" <?= ($coupon->Status == '2') ? 'selected="selected"' : '' ?> >Disabled</option>
                                      </select>
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

    <script>
      $(document).ready(function() {
      	
        $('#single_cal1').daterangepicker({          
          singleDatePicker: true,
          format: 'YYYY-MM-DD',
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        
        

        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          format: 'YYYY-MM-DD',
          calender_style: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });

        
      });
    </script>
</body>
</html>
