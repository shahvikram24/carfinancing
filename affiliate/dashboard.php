<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['affiliate_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	$affiliate_id = $_SESSION['affiliate_id'];
	//$customer = new Customer();
	//$customer->loadcustomer( $_SESSION['affiliate_id']);

	$affiliate = new Affiliate();
    $affiliate->loadAffiliate($_SESSION['affiliate_id']);

	//debugObj($affiliate);
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
			
                         
	          <!-- top tiles -->
	          	  <div class="x_content">

                  <div class="bs-example" data-example-id="simple-jumbotron">
                    <div class="jumbotron">
                      <h1>Hello <?= FormatInitCap(FormatName($affiliate->firstname,$affiliate->lastname)) ?></h1>
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


    				<p>Thank you for choosing Car Financing Affiliate Program!</p>
                    </div>
                  </div>

                </div>
                
		          <div class="row tile_count">
		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Application Received</span>
		              <div class="count"><?= "# ". AffiliateTransaction::Count($affiliate_id, ' description = 1') ?></div>
		            </div>
		            
		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Processing Application</span>
		              <div class="count"><?= "# ". AffiliateTransaction::Count($affiliate_id, ' description = 2') ?></div>
		            </div>
		            
		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Application Withdrawn</span>
		              <div class="count"><?= "# ". AffiliateTransaction::Count($affiliate_id, ' description = 4') ?></div>
		            </div>

		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Deal Not Completed</span>
		              <div class="count"><?= "# ". AffiliateTransaction::Count($affiliate_id, ' description = 5') ?></div>
		            </div>

		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Deal Booked</span>
		              <div class="count"><?= "# ". AffiliateTransaction::Count($affiliate_id, ' description = 6') ?></div>
		            </div>

		            
		          </div>
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("inc/footer.php"); ?>  

		
</body>
</html>
