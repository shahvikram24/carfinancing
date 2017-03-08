<?php
	
	require_once("../include/files.php");
	


if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

$Count = 0;

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


$affiliate = new SuperAffiliate();
$ResultApproved = $affiliate->loadAllAffiliateInfo(' approved=1 AND status=1 '. $SQLWhere);

$ResultPending = $affiliate->loadAllAffiliateInfo(' approved=2 AND status=1 '. $SQLWhere);

$ResultRejected = $affiliate->loadAllAffiliateInfo(' approved=3 AND status=1 '. $SQLWhere);

//debugObj($ResultRejected);
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>



<body>
<?php require_once("inc/header.php"); ?>
<form method="post" action="superaffiliates.php">
	<?php require_once("inc/affiliates.php"); ?>
</form>


                        		
	        <div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Affiliate&nbsp;Full&nbsp;Name</th>
			                <th>Affiliate&nbsp;Last&nbsp;Name</th>
			                <th>Email</th>
			                <th>Phone</th>
			                <th>Status</th>
			            </tr>
			        </thead>
			        <tbody>
			        <?php
			        if($ResultPending || $ResultApproved || $ResultRejected)
					{
							$count = 1;
							if($ResultPending->TotalResults>0)
							{
								for($x = 0; $x < $ResultPending->TotalResults ; $x++)
								{	
									$superaffiliate_id = $ResultPending->Result[$x]['superaffiliate_id'];
								?>
								    <tr>
								    		<?php $link =  ADMINAPPROOT . 'superaffiliateinfo.php?' . $Encrypt->encrypt('superaffiliate_id='.$superaffiliate_id); ?>
							                <td><?php echo $count; ?></td>
							                <td>
							                	<a href="<?= $link ?>">
							                		<?php echo $ResultPending->Result[$x]['firstname']; ?>
							                	</a>
							                </td>
							                <td><?php echo $ResultPending->Result[$x]['lastname']; ?></td>
							                <td><?php echo $ResultPending->Result[$x]['email']; ?></td>
							                <td><?php echo $ResultPending->Result[$x]['telephone']; ?></td>
							                <td><span class="btn btn-primary">Awaiting</span></td>
							            </tr>
							    <?php
							    	$count++;
								}
							}
							

							if($ResultApproved->TotalResults>0)
							{
								for($x = 0; $x < $ResultApproved->TotalResults ; $x++)
								{	
									$superaffiliate_id = $ResultApproved->Result[$x]['superaffiliate_id'];
								?>
								    <tr>
								    		<?php $link =  ADMINAPPROOT . 'superaffiliateinfo.php?' . $Encrypt->encrypt('superaffiliate_id='.$superaffiliate_id); ?>
							                <td><?php echo $count; ?></td>
							                <td>
							                	<a href="<?= $link ?>">
							                		<?php echo $ResultApproved->Result[$x]['firstname']; ?>
							                	</a>
							                </td>
							                <td><?php echo $ResultApproved->Result[$x]['lastname']; ?></td>
							                <td><?php echo $ResultApproved->Result[$x]['email']; ?></td>
							                <td><?php echo $ResultApproved->Result[$x]['telephone']; ?></td>
							                <td><span class="btn btn-success">Approved</span></td>
							            </tr>
							    <?php
							    	$count++;
								}
							}
							
							if($ResultRejected->TotalResults>0)
							{
								for($x = 0; $x < $ResultRejected->TotalResults ; $x++)
								{	
									$superaffiliate_id = $ResultRejected->Result[$x]['superaffiliate_id'];
								?>
								    <tr>
								    		<?php $link =  ADMINAPPROOT . 'superaffiliateinfo.php?' . $Encrypt->encrypt('superaffiliate_id='.$superaffiliate_id); ?>
							                <td><?php echo $count; ?></td>
							                <td>
							                	<a href="<?= $link ?>">
							                		<?php echo $ResultRejected->Result[$x]['firstname']; ?>
							                	</a>
							                </td>
							                <td><?php echo $ResultRejected->Result[$x]['lastname']; ?></td>
							                <td><?php echo $ResultRejected->Result[$x]['email']; ?></td>
							                <td><?php echo $ResultRejected->Result[$x]['telephone']; ?></td>
							                <td><span class="btn btn-danger">Rejected</span></td>
							            </tr>
							    <?php
							    	$count++;
								}
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

