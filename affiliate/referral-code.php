<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['affiliate_id']))
  {
      header('Location:login.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
      exit();
  }
	
	$affiliate = new Affiliate();
  $affiliate->loadAffiliate($_SESSION['affiliate_id']);

	
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
                    <h2>Referral&nbsp;Code<small>Tracking&nbsp;Link - Works very well with Facebook, Google+ and Twitter</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="#">

                      <div class="form-group">
                        <label class="control-label col-md-6" for="first-name">Your&nbsp;Tracking&nbsp;Code 
                        </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Referral Code" name="code" value="<?= $affiliate->code ?>" readonly>
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-12" for="first-name">You can begin to distribute this link to social media websites such as Twitter and Facebook. Just copy and paste this code to social media websites.
                        </label>
                        <div class="col-md-12">
                          <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Referral Code" name="trackingcode" value="<?= APPROOT .  $affiliate->code ?>" readonly>
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      
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

    

		<script>
            $("#confnewpwd").blur(function() {
            var pass = document.getElementById("newpwd").value;
            var confPass = document.getElementById("confnewpwd").value;
            if(pass != confPass) {
                alert('Password did not match. Please confirm your password !');
                document.getElementById("newpwd").focus();
            }
        });
    </script>
</body>
</html>
