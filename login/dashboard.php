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

                    </div>
                  </div>

                </div>
                
                 <div class="row tile_count">
		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Un-Assigned Leads</span>
		              <div class="count">#</div>
		            </div>
		            
		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Assigned Leads</span>
		              <div class="count">#</div>
		            </div>
		            
		            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
		              <span class="count_top"><i class="fa fa-user"></i> Total Email Lead Users</span>
		              <div class="count">#</div>
		            </div>

		            

		            
		          </div>
          <!-- /top tiles -->
	    	</div>

		<!-- Footer Wrapper -->
		<?php require_once ("inc/footer.php"); ?>  

		
</body>
</html>
