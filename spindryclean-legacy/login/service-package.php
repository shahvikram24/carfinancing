<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
  {
    header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
    exit();
  } 
	
	

	$package = new Package();
  $PackageResult = Package::GetPackages();

  //debugObj($PackageResult);
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
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Service Packages Tables</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="height:600px;">
                  <div class="x_title">
                    <h2>Service Packages Pricing</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="row">

                      <div class="col-md-12">
                        <?php
                           
                            if($PackageResult->TotalResults>0)
                            {
                              for($x = 0; $x < $PackageResult->TotalResults ; $x++)
                              {
                          ?>
                        <!-- price element -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="pricing ui-ribbon-container">
                            <div class="ui-ribbon-wrapper">
                              <div class="ui-ribbon">
                                <?php echo $PackageResult->Result[$x]['Apps']; ?>% Off
                              </div>
                            </div>
                            <div class="title">
                              <h2><?php echo $PackageResult->Result[$x]['Name']; ?></h2>
                              <h1>$<?php echo $PackageResult->Result[$x]['Price']; ?></h1>
                              <span><?php echo $PackageResult->Result[$x]['Recurring']; ?></span>
                            </div>
                            <div class="x_content">
                              <div class="">
                                <div class="pricing_features">
                                  <ul class="list-unstyled text-left">
                                    <li><i class="fa fa-check text-success"></i> <?php echo $PackageResult->Result[$x]['Description']; ?></li>
                                    <li><i class="fa fa-check text-success"></i> <?php echo $PackageResult->Result[$x]['Apps']; ?>% off all orders inclusive and above <?php echo $PackageResult->Result[$x]['Price']; ?> </li>
                                  </ul>
                                </div>
                              </div>
                              <div class="pricing_footer">
                                <a href="#" class="btn btn-success btn-block" role="button">Modify <span> now!</span></a>
                                <p>
                                 
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- price element -->
                        <?php 
                          }
                        }
                          ?>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  

    

		<script>
            $("#RepeatPassword").blur(function() {
            var pass = document.getElementById("NewPassword").value;
            var confPass = document.getElementById("RepeatPassword").value;
            if(pass != confPass) {
                alert('Password did not match. Please confirm your password !');
                document.getElementById("NewPassword").focus();
            }
        });
    </script>
</body>
</html>
