<?php
	
	require_once("../include/files.php");
	


if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

$Count = 0;
$SQLWhere =' approved=3 AND status=1 ';


if(isset($_POST['firstname']) && $_POST['firstname'] !='')
{
	$firstname = strtolower($_POST['firstname']);
	$SQLWhere .= " AND LOWER(`firstname`) like '%". $firstname ."%'";
}

if(isset($_POST['lastname']) && $_POST['lastname'] !='')
{
	$lastname = strtolower($_POST['lastname']);
	$SQLWhere .= " AND LOWER(`lastname`) like '%". $lastname ."%'";
}

if(isset($_POST['telephone']) && $_POST['telephone'] !='')
{
	$telephone = strtolower($_POST['telephone']);
	$SQLWhere .= " AND LOWER(`telephone`) like '%". $telephone ."%'";
}


$affiliate = new Affiliate();
$Result = $affiliate->loadAllAffiliateInfo($SQLWhere);


?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>



<body>
<?php require_once("inc/header.php"); ?>
<form method="post" action="approvedaffiliates.php">
	<?php require_once("inc/affiliates.php"); ?>
</form>


                        		
	        <div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Affiliate&nbsp;First&nbsp;Name</th>
			                <th>Affiliate&nbsp;Last&nbsp;Name</th>
			                <th>Email</th>
			                <th>Phone</th>
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
							$affiliate_id = $Result->Result[$x]['affiliate_id'];
						?>
						    <tr>
						    		<?php $link =  ADMINAPPROOT . 'affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$affiliate_id); ?>
					                <td><?php echo $count; ?></td>
					                <td>
					                	<a href="<?= $link ?>">
					                		<?php echo $Result->Result[$x]['firstname']; ?>
					                	</a>
					                </td>
					                <td><?php echo $Result->Result[$x]['lastname']; ?></td>
					                <td><?php echo $Result->Result[$x]['email']; ?></td>
					                <td><?php echo $Result->Result[$x]['telephone']; ?></td>
					                
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

