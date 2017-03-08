<?php 
	require_once("include/files.php");

	if(!isset($_SESSION['customer_id']))
	{
		header('Location:index.php?'.$Encrypt->encrypt("MessageType=Error&Message=You must sign in to view your account."));
		exit();
	}	

	$customer = new Customer();
	$customer->loadcustomer( $_SESSION['customer_id']);

	//debugObj($customer);
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
	          <!-- top tiles -->
	          	  <div class="x_content">

                  <div class="bs-example" data-example-id="simple-jumbotron">
                    <div class="jumbotron">
                      <h1>Hello <?= ucfirst($customer->FirstName) . " " . ucfirst($customer->LastName) ?></h1>
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


    				<p>Thank you for choosing Spin Dry Clean!</p>
                    </div>
                  </div>

                </div>
                <?php
                		$Amount = CustomerTransactions::GetField('Amount', 'CustomerId', $_SESSION['customer_id']);
                		$OrderQueue = Order::GetField($_SESSION['customer_id']);
                		$TotalOrder = Order::GetTotal($_SESSION['customer_id']);
                		$Support = Support::GetTotal($_SESSION['customer_id']);
                ?>
		          <div class="row tile_count">
		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-money"></i> Balance Remaining</span>
		              <div class="count"><?= "$ ". $Amount ?></div>
		              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
		            </div>
		            
		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-clock-o"></i> Orders in Queue</span>
		              <div class="count"><?=  $OrderQueue ?></div>
		              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
		            </div>
		            
		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Total Orders Placed</span>
		              <div class="count"><?=  $TotalOrder ?></div>
		              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
		            </div>

		            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-clock-o"></i> Support Request</span>
		              <div class="count"><?=  $Support ?></div>
		              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
		            </div>

		           
		          </div>
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("include/footer.php"); ?>  

		
</body>
</html>
