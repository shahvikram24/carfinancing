<?php
	
	require_once("../include/files.php");
	


if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

$Count = 0;
$SQLWhere =' Approve=1 AND Status=1 ';


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
<form method="post" action="approveddealers.php">
	<?php require_once("inc/deals.php"); ?>
</form>


                        		
	        <div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Dealership&nbsp;Name</th>
			                <th>Plan</th>
			                <th>Today's&nbsp;Apps</th>
			                <th>Total&nbsp;Apps&nbsp;Delivered</th>
			                <th>Balance&nbsp;Remaining</th>
			                <th>Plan&nbsp;Start&nbsp;Date</th>
			                <th>Plan&nbsp;End&nbsp;Date</th>
			                <th>&nbsp;</th>
			            </tr>
			        </thead>
			        <tbody>
			        <?php

					$count = 1;
					if($Result->TotalResults>0)
					{
						for($x = 0; $x < $Result->TotalResults ; $x++)
						{	
							$DealerId = $Result->Result[$x]['Id'];
							$DealerPackageId = dealerpackages::GetIdByDealerId($DealerId);
							$AppsWithPackage = Package::GetApps($Result->Result[$x]['DealershipPlan']);
                            $Positive = dealercredits::CountPositive($DealerId,$DealerPackageId);
                            $Negative = dealercredits::CountNegative($DealerId,$DealerPackageId);

                            $Total = $Positive - $Negative;

                            $Manage = $AppsWithPackage + $Total;

                            $TodaysApp = DealerPackageFeatures::CountSentApplications($DealerId,$DealerPackageId,date("Y-m-d"));
                            $Delivered = DealerPackageFeatures::CountSentApplications($DealerId,$DealerPackageId);

                            $dealerpackages = new dealerpackages();
                            $dealerpackages->LoadDealerPackageByDealerId($DealerId);
						?>
						    <tr>
						    		<?php $link =  ADMINAPPROOT . 'dealerinfo.php?' . $Encrypt->encrypt('DealerId='.$DealerId); ?>
					                <td><?php echo $count; ?></td>
					                <td>
					                	<a href="<?= $link ?>">
					                		<?php echo $Result->Result[$x]['DealershipName']; ?>
					                	</a>
					                </td>
					                <td><?= Package::GetName($Result->Result[$x]['DealershipPlan']) ?></td>
					                <td><?php echo $TodaysApp; ?></td>
					                <td><?php echo $Delivered; ?></td>
					                <td><?php echo ($Manage - $Delivered); ?></td>
					                <td><?php echo $dealerpackages->AddDate; ?></td>
					                <td><?php echo $dealerpackages->ExpireDate; ?></td>

					                <td><?php 

					                	if($Assigned)
					                	{
					                		$link =  ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('DealerId='.$DealerId.'&Apply=Apply&ContactId='.$ContactId);
					                		echo '
					                			<a class="btn btn-success" href="'.$link.'">Assign</a>
					                		';
					                	}
					                ?></td>


					                
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

