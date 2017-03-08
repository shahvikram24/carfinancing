<?php
	
	require_once("../include/files.php");
	
echo "<script type='text/javascript' src='inc/functions.js'></script> ";

$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

$Count = 0;
$SQLWhere ='';


$IncompleteContactInfo = new ContactInfo();
$IncompleteResult = $IncompleteContactInfo->loadIncompleteApplication($SQLWhere);


?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>


<body>
<?php require_once("inc/header.php"); ?>
<div class="contact-form" id="contact-form" style="width:95%;left:2%;">
<h3>Incomplete Applications</h3>                        		
	        <div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Unique ID</th>
			                <th>Full Name</th>
			                <th>Email</th>
			                <th>Phone</th>
			                <th>Referred&nbsp;Person</th>
			                <th>Application&nbsp;Started</th>
			                <th>&nbsp;</th>

			            </tr>
			        </thead>
			        <tbody>
			        <?php

					$count = 1;
					if($IncompleteResult->TotalResults>0)
					{
						for($x = 0; $x < $IncompleteResult->TotalResults ; $x++)
						{
							$AffiliateCode = AffiliateTransaction::getAffiliateCode($IncompleteResult->Result[$x]['Id']);
							if($AffiliateCode)
								$ReferredPerson = Affiliate::GetFullName($AffiliateCode);
							else
								$ReferredPerson = " - ";
						?>
						    <tr>
						    		<td><?php echo $count; ?></td>
						    		<td><?php echo sprintf('%04d',$IncompleteResult->Result[$x]['Id']); ?></td>
					                <td><?php echo $IncompleteResult->Result[$x]['FirstName'] . " " . $IncompleteResult->Result[$x]['LastName']; ?></td>
					                <td><?php echo $IncompleteResult->Result[$x]['Email']; ?></td>
					                <td><?php echo $IncompleteResult->Result[$x]['Phone1']; ?></td>
					                <td><?php echo $ReferredPerson; ?></td>
					                <td><?php echo $IncompleteResult->Result[$x]['Created']; ?></td>
					                <td><?php echo '<a class="btn btn-info" href="'.APPROOT.'application.php?' . $Encrypt->encrypt('ContactInfoId='.$IncompleteResult->Result[$x]['Id'].'&Assigned=true') . '">Complete Application </a>'; ?></td>
			                
					            </tr>
					    <?php
					    	$count++;
						}
					}
					else
					{
						echo "<tr><td colspan='6'>&nbsp;</td></tr>";
						echo "<tr><td colspan='6' style='text-align:center;'>No records found</td></tr>";
					}

					?>
			        </tbody>
			    </table>
			</div>

			<?php require_once("inc/footer.php"); ?>
</div>




