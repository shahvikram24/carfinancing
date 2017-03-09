<?php 
	require_once("../include/files.php");

	if(!isset($_SESSION['admin_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	
	//debugObj($customer);
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
	          <!-- top tiles -->
	          	  <div class="x_content">

                  <div class="bs-example" data-example-id="simple-jumbotron">
                    <div class="jumbotron">
                      <h1>Hello Admin,</h1>
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


    				<p>to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                  </div>

                </div>
                <?php
							$OrderResult = Order::GetApprovalOrderLsit();
							$MembersResult = Customer::GetPendingCustomerLsit();
							$ProductResult = Products::GetProductsList();
							$SupportResult = Support::GetSupportList();
				?>
                  
		          <div class="row tile_count">
		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		            	<a href="orders.php">
			              <span class="count_top"><i class="fa fa-money"></i> New Orders</span>
			              <div class="count">		              
			              	<?= ($OrderResult->TotalResults) ? $OrderResult->TotalResults : "0" ?>
			              </div>
			              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
		            	</a>
		            </div>
		            
		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
			            <a href="members.php">
			              <span class="count_top"><i class="fa fa-clock-o"></i> New Customers</span>
			              <div class="count"><?= ($MembersResult->TotalResults) ? $MembersResult->TotalResults : "0" ?></div>
			              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
			            </a>
		            </div>
		            
		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		            	<a href="products.php">
			              <span class="count_top"><i class="fa fa-user"></i> Total Products</span>
			              <div class="count"><?= ($ProductResult->TotalResults) ? $ProductResult->TotalResults : "0" ?></div>
			              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
			            </a>
		            </div>

		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		            	<a href="support-tickets.php">
			              <span class="count_top"><i class="fa fa-comments-o"></i> Support Tickets</span>
			              <div class="count"><?= ($SupportResult->TotalResults) ? $SupportResult->TotalResults : "0" ?></div>
			              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
			            </a>
		            </div>
		            
		            
		          </div>

		          <?php
							$SignupsCount = Customer::getCustomerCount(date('F'));
							$OrderCount = Order::getOrderCount(date('F'));
							$SupportCount = Support::getSupportCount(date('F'));
				?>

		          <div class="row top_tiles">
		          <h2>Transaction Summary <small>Progress Statistics - <?= date('F') ?> Month</small></h2>
		          <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                <div class="tile-stats">
	                  <div class="icon"><i class="fa user"></i></div>
	                  <div class="count"><?= ($SignupsCount) ? $SignupsCount : "0" ?></div>
	                  <h3>New Members sign ups</h3>
	                  <p>Total number of members who signed up this month.</p>
	                </div>
	              </div>

	              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                <div class="tile-stats">
	                  <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
	                  <div class="count"><?= ($OrderCount) ? $OrderCount : "0" ?></div>
	                  <h3>Total Number of Orders</h3>
	                  <p>Total number of orders received for pickup.</p>
	                </div>
	              </div>
	              
	              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                <div class="tile-stats">
	                  <div class="icon"><i class="fa fa-money"></i></div>
	                  <div class="count">179</div>
	                  <h3>Weekly Revenue</h3>
	                  <p>Lorem ipsum psdea itgum rixt.</p>
	                </div>
	              </div>

	              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                <div class="tile-stats">
	                  <div class="icon"><i class="fa fa-comments-o"></i></div>
	                  <div class="count"><?= ($SupportCount) ? $SupportCount : "0" ?></div>
	                  <h3>Support Tickets</h3>
	                  <p>Total number of support tickets received this month.</p>
	                </div>
	              </div>
	            </div>
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  

		
</body>
</html>
