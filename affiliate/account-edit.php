<?php 
	require_once("../include/files.php");

	
  if(!isset($_SESSION['affiliate_id']))
  {
      header('Location:login.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
      exit();
  }
	
	$affiliate = new Affiliate();
  $affiliate->loadAffiliate($_SESSION['affiliate_id']);

	//debugObj($affiliate);
  if(isset($_POST['update']) && $_POST['update'] == 'update')
  {

    $affiliate = new Affiliate();
    $affiliate->loadAffiliate($_SESSION['affiliate_id']);

    $affiliate->firstname = $_POST['firstname'];
    $affiliate->lastname = $_POST['lastname'];
    $affiliate->telephone = $_POST['telephone'];
    $affiliate->fax = $_POST['fax'];

    $affiliate->company = $_POST['company'];
    $affiliate->website = $_POST['website'];
    $affiliate->address_1 = $_POST['address_1'];
    $affiliate->address_2 = $_POST['address_2'];
    $affiliate->city = $_POST['city'];
    $affiliate->postcode = $_POST['postcode'];

    $affiliate->payment = 'cheque';
    $affiliate->cheque = $_POST['cheque'];

    $affiliate->UpdateAffiliate();

    header('Location:account-edit.php?' . $Encrypt->encrypt("Message=Affiliate personal information has been updated successfully.&Success=true&affiliate_id=".$_SESSION['affiliate_id']));
    exit();
  }
	
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
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name" name="firstname" value="<?= $affiliate->firstname ?>" required >
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name" name="lastname" value="<?= $affiliate->lastname ?>" required>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Phone Number" name="telephone" value="<?= $affiliate->telephone ?>"  >
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" name="email" value="<?= $affiliate->email ?>" disabled>
                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true" ></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Fax Number" name="fax" value="<?= $affiliate->fax ?>" required >
                        <span class="fa fa-fax form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Business Name" name="company" value="<?= $affiliate->company ?>" required>
                        <span class="fa fa-building-o form-control-feedback right" aria-hidden="true"></span>
                      </div>


                      <div class="col-md-6 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Your Address" name="address_1" value="<?= $affiliate->address_1 ?>" required>
                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess4" placeholder="Apt./Suite" name="address_2" value="<?= $affiliate->address_2 ?>">
                        <span class="fa fa-building form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      
                      

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess5" placeholder="City" name="city" value="<?= $affiliate->city ?>" required>
                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="Postal Code" name="postcode" value="<?= $affiliate->postcode ?>" required>
                        <span class="fa fa-location-arrow form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Website" name="website" value="<?= $affiliate->website ?>" required>
                        <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                      <div class="clearfix"></div>
                      <h2>Payment Information <small>Cheque Payee Name</small></h2>
                      <div class="clearfix"></div>


                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Affiliate Payment Method: Cheque <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Cheque Payee Name" name="website" value="<?= $affiliate->cheque ?>" required>
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
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
		<?php require_once ("inc/footer.php"); ?>  
</body>
</html>
