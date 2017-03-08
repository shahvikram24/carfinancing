<?php
	
	require_once("../include/files.php");
	


if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

$Count = 0;
$SQLWhere =' Approve=2 AND Status=1 ';


if(isset($_POST['DealershipName']) && $_POST['DealershipName'] !='')
{
	$DealershipName = strtolower($_POST['DealershipName']);
	$SQLWhere .= " AND LOWER(`DealershipName`) like '%". $DealershipName ."%'";
}

if(isset($_POST['DealershipPlan']) && $_POST['DealershipPlan'] !='')
{
	$DealershipPlan = $Decrypt->decrypt($_POST['DealershipPlan']); 
	$SQLWhere .= " AND DealershipPlan = ". $DealershipPlan;
}

$dealership = new dealership();
$Result = $dealership->loadAllDealershipInfo($SQLWhere);


?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>



<body>
<?php require_once("inc/header.php"); ?>
<form method="post" action="pendingdealers.php">
	<?php require_once("inc/deals.php"); ?>
</form>


                        		
	        <div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Dealership&nbsp;Name</th>
			                <th>Address</th>
			                <th>Phone</th>
			                <th>Contact&nbsp;Name</th>
			                <th>View&nbsp;Info</th>
			            </tr>
			        </thead>
			        <tbody>
			        <?php

					$count = 1;
					if($Result->TotalResults>0)
					{
						for($x = 0; $x < $Result->TotalResults ; $x++)
						{

						?>
						    <tr>
						    		<?php $link =  ADMINAPPROOT . 'dealerinfo.php?' . $Encrypt->encrypt('DealerId='.$Result->Result[$x]['Id']); ?>
					                <td><?php echo $count; ?></td>
					                <td><?php echo $Result->Result[$x]['DealershipName']; ?></td>
					                <td><?php echo $Result->Result[$x]['Address']; ?></td>
					                <td><?php echo $Result->Result[$x]['Phone']; ?></td>
					                <td><?php echo $Result->Result[$x]['ContactName']; ?></td>
					                <td><a href="<?= $link ?>">View Info</a></td>
					                
					            </tr>
					    <?php
					    	$count++;
						}
					}
					else
					{
						echo "<tr><td colspan='6'>&nbsp;</td></tr>";
						echo "<tr><td colspan='6' style='text-align:center;'>No Results found</td></tr>";
					}

					?>
			        </tbody>
			    </table>
			</div>
	




<?php require_once("inc/footer.php"); ?>

