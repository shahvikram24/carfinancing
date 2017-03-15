<?php 
	require_once("../include/files.php");

	$DealerId = $_SESSION['DealerId'];
  //$customer = new Customer();
  //$customer->loadcustomer( $_SESSION['affiliate_id']);

  if(isset($_POST['update']) && $_POST['update'] == 'update')
  {
    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);
    $dealership->DealershipName = FormatInitCap($_POST['DealershipName']); 
    $dealership->Address = $_POST['Address']; 
    $dealership->Phone = $_POST['Phone']; 
    $dealership->Fax = $_POST['Fax']; 
    $dealership->updateDealershipInfo();
    header('Location:account-edit.php?' . $Encrypt->encrypt("Message=Personal information has been updated successfully.&Success=true&DealerId=".$DealerId));
    exit();
  }


    $dealership = new dealership();
    $dealership->loadDealershipInfo($DealerId);

    $login = new Login();
    $login->loadcustomerinfo($DealerId);

    //$dealership->DealershipName;
	



?>

<!DOCTYPE html>
<html lang="en">
<?php require_once ("inc/title.php"); ?>  
<body class="nav-md">
    <div class="container body">
      <div class="main_container">

			<!-- Header Wrapper -->
			<?php require_once ("inc/header.php"); ?>  
			
			<!-- page content -->
			<div class="right_col" role="main">  
            <?php                   
              if( isset ($Message) && $Message != "" ) 
              { 
                  if($Success && $Success == 'true')
                      echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
                  else
                      echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
              }
            ?>
            <form class="form-horizontal form-label-left input_mask" method="post" action="#">
		        <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Personal Information <small>Edit information here</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Contact Name</label>
                            <input name="ContactName" id="ContactName" type="text" value="<?= $dealership->ContactName ?>" readonly class="form-control">
                          </div>

                          <div class="form-group">
                            <label>Email Address</label>
                            <input name="Email" id="Email" type="text" value="<?= $login->EmailId ?>"  class="form-control" readonly >
                          </div>

                          <div class="form-group">
                            <label>Fax Number</label>
                            <input name="Fax" id="Fax" type="text" value="<?= $dealership->Fax ?>" class="form-control" placeholder="Enter Fax Number" data-inputmask="'mask' : '1-999-999-9999'">
                          </div>

                          <div class="form-group">
                            <label>Dealership Name</label>
                            <input name="DealershipName" id="DealershipName" type="text" value="<?= $dealership->DealershipName ?>" class="form-control" placeholder="Enter Working Dealership Name">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Dealership Address</label>
                            <input name="Address" id="Address" type="text" value="<?= $dealership->Address ?>" required class="form-control" placeholder="Enter Working Dealership Address">
                          </div>
                          <div class="form-group">
                            <label>Phone Number</label>
                            <input name="Phone" id="Phone" type="text" value="<?= $dealership->Phone ?>" required class="form-control" placeholder="Phone number to contact" data-inputmask="'mask' : '(999) 999-9999'">
                          </div>

                          <div class="form-group">
                            <label>AMVIC Licence No.</label>
                            <input name="LicenceNo" id="LicenceNo" type="text" value="<?= $dealership->LicenceNo ?>" readonly class="form-control" placeholder="AMVIC Registeration Number" data-inputmask="'mask' : 'a999999'">
                          </div>

                          <div class="form-group">
                            <label>Leads Package</label>
                            <input type="text" class="form-control" id="DealershipPlan" name="DealershipPlan" readonly value="<?php echo Package::GetName($dealership->DealershipPlan) .  ' - ' .  Package::GetApps($dealership->DealershipPlan) . ' Leads ';  ?>">
                          </div>

                      </div>
                      
                      
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href='dashboard.php' class="btn btn-primary">Cancel</a>
                          <button type="submit" class="btn btn-success" name="update" value="update">Update Information!</button>
                        </div>
                      </div>

                  </div>
                </div>

              </div>
              
            </div>	
            </form>

		    	<div class="clearfix"></div>

		          
          	<!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("inc/footer.php"); ?>  
     <!-- input_mask -->
          <script>
            $(document).ready(function() {
              $(":input").inputmask();
            });
          </script>
          <!-- /input mask -->

</body>
</html>
