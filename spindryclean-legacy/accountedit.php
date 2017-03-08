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

	if(isset($_POST['update']) && $_POST['update'] == 'update')
	{
			
				$customer = new Customer();
				$customer->loadcustomer( $_SESSION['customer_id']);
				$customer->FirstName = $_POST['Fname'];
				$customer->LastName = $_POST['Lname'];
				$customer->Address1 = $_POST['Address'];
				$customer->Address2 = $_POST['Apt'];				
				$customer->City = $_POST['City'];
				$customer->Province = $_POST['Province'];
				$customer->Postalcode = $_POST['Postal'];
				$customer->Cellphone = $_POST['Mobile'];
				$customer->Approved = 1;
				$customer->Status = 1;
				$customer->UpdateCustomer($customer->Id);

				header('Location:dashboard.php');

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
		        <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Personal Information <small>Edit information here</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name" name="Fname" value="<?= $customer->FirstName ?>" required >
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name" name="Lname" value="<?= $customer->LastName ?>" required>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Your Pick up/Drop-off Address" name="Address" value="<?= $customer->Address1 ?>" required>
                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Apt./Suite" name="Apt" value="<?= $customer->Address2 ?>">
                        <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Postal Code" name="Postal" value="<?= $customer->Postalcode ?>" required>
                        <span class="fa fa-location-arrow form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess5" placeholder="City" name="City" value="<?= $customer->City ?>" required>
                        <span class="fa fa-home form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess5" placeholder="Mobile Phone" name="Mobile"  value="<?= $customer->Cellphone ?>" required>
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href='dashboard.php' class="btn btn-primary">Cancel</a>
                          <button type="submit" class="btn btn-success" name="update" value="update">Update Information!</button>
                        </div>
                      </div>

                    </form>
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
