<?php
	
	require_once("../include/files.php");
	
echo "<script type='text/javascript' src='inc/functions.js'></script> ";

$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}



//debugObj($jobTitleResultSet);
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>



<body>
<?php require_once("inc/header.php"); ?>
<div class="content-section-a" id="how-it-works">
        <div class="container">
            <div class="row">
            	<div class="col-lg-12" id="main-content">
            	<!-- ============================================= -->
					<div class="col-lg-3">
							    <a class="small-tile yellow-back" href="approveddealers.php"><img class="hide-sm pull-right" width="32" src="../img/jobseekers.png"/>
							        <h3 class="h3-tile">Approved&nbsp;Dealers</h3>
							    </a>
					</div>
					<div class="col-lg-3">
					    <a class="small-tile lila-back" href="pendingdealers.php"><img class="hide-sm pull-right" width="32" src="../img/field_values.png"/>
					        <h3 class="h3-tile">Pending&nbsp;Approvals</h3>
					    </a>
					</div>
					
					<!-- <div class="col-lg-3">
						    <a class="small-tile gray-back" href="brands.php"><img class="hide-sm pull-right" width="32" src="../img/banners.png"/>
						        <h3 class="h3-tile">Brands</h3>
						    </a>
					</div>

					<div class="col-lg-3">
						    <a class="small-tile blue-back" href="joblocations.php"><img class="hide-sm pull-right" width="32" src="../img/locations.png"/>
						        <h3 class="h3-tile">Locations</h3>
						    </a>
					</div> -->

					<div class="clearfix"></div>
				</div>



					

					
				<!-- ============================================= -->

				
				

			</div>
        </div>
    </div>
                        		
	 <div class="clearfix"></div>       

<?php require_once("inc/footer.php"); ?>