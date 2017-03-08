<?php
	
	require_once("../include/files.php");
	
echo "<script type='text/javascript' src='inc/functions.js'></script> ";


$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>



<body>
<?php require_once("inc/header.php"); ?>
<div class="content-section-a" id="how-it-works">
        <div class="container">
            <div class="row">

            	<div class="col-lg-12" id="">
            		<legend>Dashboard</legend>
            		<span><label>Mange your Administration panel </label></span>
            	</div>

            	<div class="col-lg-12" id="main-content">
				<?php
					$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
					$saturday = date( 'Y-m-d', strtotime( 'saturday this week' ) );

					$SQLWhere = " AND ArchiveNotification BETWEEN '" . $monday . "' AND '" . $saturday . "'";
					$ArchivedContactInfo = new ContactInfo();
					$ArchivedResult = $ArchivedContactInfo->ArchiveNotification($SQLWhere);


					$IPrintLink =  ADMINAPPROOT . 'archivedleadsexport.php?' . $Encrypt->encrypt('SQLWhere='.$SQLWhere.'&Print=true');
				?>

				<div class="col-sm-8"><h3>Contact Archived Applications - (<?php echo $monday . " TO " . $saturday; ?>)</h3></div>
            	<div class="col-sm-4 text-right"><a href="<?php echo $IPrintLink; ?>" class="btn btn-primary" target="_blank">
            		<i class="fa fa-print"></i> <label>Export&nbsp;Archived&nbsp;Application&nbsp;List</label></a>
            	</div>
            	<div class="clearfix"></div>

			        <div class="table-responsive">
					    <table id="incomplete" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Unique ID</th>
					                <th>Full Name</th>
					                
					                <th>Email</th>
					                <th>Phone</th>
					                <th>Referred&nbsp;By</th>
					                <th>Archived&nbsp;Notes</th>
					                <th>&nbsp;</th>
					                
					            </tr>
					        </thead>
					        	
					        <tbody>
					        <?php

							$count = 1;
							if($ArchivedResult->TotalResults>0)
							{
								for($x = 0; $x < $ArchivedResult->TotalResults ; $x++)
								{
									$AffiliateCode = AffiliateTransaction::getAffiliateCode($ArchivedResult->Result[$x]['Id']);
									if($AffiliateCode)
										$ReferredPerson = Affiliate::GetFullName($AffiliateCode);
									else
										$ReferredPerson = " - ";

									
								?>
								    <tr>
								    		<td><?php echo $count; ?></td>
								    		<td><?php echo sprintf('%04d',$ArchivedResult->Result[$x]['Id']); ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['FirstName'] . " " . $ArchivedResult->Result[$x]['LastName']; ?></td>
							                
							                <td><?php echo $ArchivedResult->Result[$x]['Email']; ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['Phone1']; ?></td>
							                <td><?php echo $ReferredPerson; ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['ArchiveNotes']; ?></td>
							                <td><?php echo '<a class="btn btn-info" href="'.APPROOT.'application.php?' . $Encrypt->encrypt('ContactInfoId='.$ArchivedResult->Result[$x]['Id'].'&Assigned=true') . '">Complete Application </a>'; ?>

							                	
							                </td>
					                		
							            </tr>
							    <?php
							    	$count++;
								}
							}
							else
							{
								echo "<tr><td colspan='8'>&nbsp;</td></tr>";
								echo "<tr><td colspan='8' style='text-align:center;'>No records found</td></tr>";
							}

							?>
					        </tbody>
					        
					    </table>
					</div>

				</div>
				<div class="clearfix"></div>   

				<!-- Hidden Notification -->
				<div class="col-lg-12" id="main-content">
				<?php
					$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
					$saturday = date( 'Y-m-d', strtotime( 'saturday this week' ) );

					$SQLWhere = " AND CI.ArchiveNotification BETWEEN '" . $monday . "' AND '" . $saturday . "'";
					$HiddenContact = new Contact();
					$HiddenResult = $HiddenContact->HiddenNotification($SQLWhere);
					
				?>

				<div class="col-sm-8"><h3>Contact Hidden Applications - (<?php echo $monday . " TO " . $saturday; ?>)</h3></div>
            	<div class="clearfix"></div>

			        <div class="table-responsive">
					    <table id="incomplete" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Unique ID</th>
					                <th>Full Name</th>
					                
					                <th>Email</th>
					                <th>Phone</th>
					                <th>Referred&nbsp;By</th>
					                <th>Archived&nbsp;Notes</th>
					                <th>&nbsp;</th>
					                
					            </tr>
					        </thead>
					        	
					        <tbody>
					        <?php

							$count = 1;
							if($HiddenResult->TotalResults>0)
							{
								for($x = 0; $x < $HiddenResult->TotalResults ; $x++)
								{
									$AffiliateCode = AffiliateTransaction::getAffiliateCode($HiddenResult->Result[$x]['Id']);
									if($AffiliateCode)
										$ReferredPerson = Affiliate::GetFullName($AffiliateCode);
									else
										$ReferredPerson = " - ";

									
								?>
								    <tr>
								    		<?php $link =  ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$HiddenResult->Result[$x][0].'&Hidden=true'); ?>
								    		<td><?php echo $count; ?></td>
								    		<td><?php echo sprintf('%04d',$HiddenResult->Result[$x]['Id']); ?></td>
							                <td><a href="<?= $link ?>">
							                	<?php echo $HiddenResult->Result[$x]['FirstName'] . " " . $HiddenResult->Result[$x]['LastName']; ?></td>
							                	</a>
							                
							                <td><?php echo $HiddenResult->Result[$x]['Email']; ?></td>
							                <td><?php echo $HiddenResult->Result[$x]['Phone1']; ?></td>
							                <td><?php echo $ReferredPerson; ?></td>
							                <td><?php echo $HiddenResult->Result[$x]['ArchiveNotes']; ?></td>
							                
					                		
							            </tr>
							    <?php
							    	$count++;
								}
							}
							else
							{
								echo "<tr><td colspan='8'>&nbsp;</td></tr>";
								echo "<tr><td colspan='8' style='text-align:center;'>No records found</td></tr>";
							}

							?>
					        </tbody>
					        
					    </table>
					</div>

				</div>
				<div class="clearfix"></div>   

				<div class="col-lg-12" id="main-content">
					<!-- ============================================= -->
					<a href="leads.php">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-info">
						<div class="panel-heading">
								<div class="row">
									<div class="col-xs-4">
										<!-- <i class="white-link fa fa-list-alt fa-5x"></i> -->
										<div class="huge center bg-danger" style="color:#fff;"><?= Contact::NewLeadsCount() ?></div>
										<div>New&nbsp;Leads</div>
									</div>
									<div class="col-xs-4">
										<!-- <i class="white-link fa fa-list-alt fa-5x"></i> -->
										<div class="huge center bg-primary"><?= ContactInfo::UnreadCount() ?></div>
										<div>Incomplete</div>
									</div>
									
									<div class="col-xs-4 text-right">
										<div class="huge"><?= Contact::LeadsCount() ?></div>
										<div>Total</div>
									</div>
								</div>
							</div>
							
							
								<div class="panel-footer gray-gradient">
									<span class="pull-left">View Leads Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							
						</div>
					</div>
					</a>


					<!-- ============================================= -->
					<a href="dealermngt.php">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-users fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge"><?= dealership::DealershipCount() ?></div>
										<div>Dealership</div>
									</div>
								</div>
							</div>
							
								<div class="panel-footer gray-gradient">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							
						</div>
					</div>
					</a>
					<!-- ============================================= -->
					<!-- <div class="col-lg-3 col-md-6">
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-institution fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">4</div>
										<div>Manage</div>
									</div>
								</div>
							</div>
							<a href="manage.php">
								<div class="panel-footer gray-gradient">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div> -->

					<!-- ============================================= -->

					<!-- ============================================= -->
					
					<a href="affiliates.php">
					<div class="col-lg-3 col-md-6">

						<div class="panel panel-yellow">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-4">
										<!-- <i class="white-link fa fa-paw fa-5x"></i> -->
										<?php if(Affiliate::PendingCount() > 0)
									{
									?>
										<div class="huge bg-danger center"><?=  Affiliate::PendingCount() ?></div>
										<div>Awaiting&nbsp;Approval</div>
									<?php } else{ echo '<i class="white-link fa fa-paw fa-5x"></i>'; }
									?>

										
									</div>
									
									<div class="col-xs-4">&nbsp;</div>
									<div class="col-xs-4 text-right">									
										<div class="huge"><?=  Affiliate::AffiliateCount() ?></div>
										<div>Affiliates</div>									
									</div>
								</div>
							</div>
							<div class="panel-footer gray-gradient">
								<span class="pull-left">View Affiliates Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
							
						</div>
					</div>
					</a>

					<!-- ============================================= -->
					<a href="superaffiliates.php">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-info">
						<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="white-link fa fa-user fa-5x"></i>
									</div>
									
									<div class="col-xs-9 text-right">
										<div class="huge"><?= SuperAffiliate::AffiliateCount() ?></div>
										<div>Super Affiliates</div>
									</div>
								</div>
							</div>
							
							
								<div class="panel-footer gray-gradient">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							
						</div>
					</div>
					</a>


					<!-- ============================================= -->
					<a href="account.php">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-bar-chart-o fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">2</div>
										<div>My Account</div>
									</div>
								</div>
							</div>
							
								<div class="panel-footer gray-gradient">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							
						</div>
					</div>
					</a>
				<!-- ============================================= -->

				<div class="clearfix"></div>     
				</div>


			</div>
        </div>
    </div>
                        		
	 <div class="clearfix"></div>       

<?php require_once("inc/footer.php"); ?>