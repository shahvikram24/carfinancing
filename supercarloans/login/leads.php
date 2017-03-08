<?php
	
	require_once("../include/files.php");
	
echo "<script type='text/javascript' src='inc/functions.js'></script> ";

$act = isset($_REQUEST["act"])?trim($_REQUEST["act"]):"";

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}


if( isset($_POST['AssignAffiliate']) && $_POST['AssignAffiliate'] == 'AssignAffiliate' )   
{  
	//debugObj($_REQUEST); die();
	if($_REQUEST['AffiliateId'] !='')
	{
		if(AffiliateTransaction::UpdateConditionally(' affiliateid = '. $_REQUEST['AffiliateId'] , ' contactinfoid =  '. $_REQUEST['ContactInfoId']))
		{
			header('Location:leads.php?' . $Encrypt->encrypt("Message=Affiliate has been assigned successfully to the lead.&Success=true"));
			exit();
		}
		else{
			header('Location:leads.php?' . $Encrypt->encrypt("Message=Affiliate has NOT been assigned successfully to the lead.&Success=false"));
			exit();
		}
	}
	else{
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Select Affiliate first.&Success=false"));
			exit();
	}
		
}

$Count = 0;
$SQLWhere ='';

if(isset($_POST['sendtemplate']) && $_POST['sendtemplate'] == 'Send')
{
	if(count($_REQUEST['Leads']>0))
	{
		if(ContactInfo::SendTemplate($_REQUEST['Leads'],$_REQUEST['Templateselect']))
		{
			header('Location:leads.php?' . $Encrypt->encrypt("Message=Contacting leads is successful.&Success=true"));
			exit();
		}	
	}
	else
	{
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Please select atleast one lead to be contacted.&Success=false"));
		exit();
	}
}


if(isset($_POST['sendtemplate']) && $_POST['sendtemplate'] == 'Mark as read')
{
	if(count($_REQUEST['Notification']>0))
	{
		$Notification = implode(",",$_REQUEST['Notification']);
		ContactInfo::setNotification($Notification,0);
		
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Selected notifications has been marked as read.&Success=true"));
		exit();
	}
	else
	{
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Please select atleast one lead to mark as read.&Success=false"));
		exit();
	}
}

if(isset($_POST['sendtemplate']) && $_POST['sendtemplate'] == 'Mark as unread')
{
	if(count($_REQUEST['Notification']>0))
	{
		$Notification = implode(",",$_REQUEST['Notification']);
		ContactInfo::setNotification($Notification,1);
		
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Selected notifications has been marked as unread.&Success=true"));
		exit();
	}
	else
	{
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Please select atleast one lead to mark as unread.&Success=false"));
		exit();
	}
}

if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Post Notes')
{
	//debugObj($_REQUEST); die();
	$ContactId = $Decrypt->decrypt($_REQUEST['ContactId']);
	$Notes = new Notes();
	$Notes->Notes = TextScrubber($_REQUEST['Notes']);
	$Notes->DatePosted = date('Y-m-d H:i:s');
	$Notes->Status = 1;
	$NotesId = $Notes->InsertNotes();


	$NotesRelations = new NotesRelations();
	$NotesRelations->NotesId = $NotesId;
	$NotesRelations->ContactId = $ContactId;
	$NotesRelations->Status = 1;
	$NotesRelations->InsertRelation();
	
	
	header("Location:".ADMINAPPROOT . 'leads.php?' . $Encrypt->encrypt('ContactId='.$ContactId));
}

if(isset($_POST['SubmitIncSearch']) && $_POST['SubmitIncSearch'] == 'Post Notes')
{
	//debugObj($_REQUEST); die();
	$ContactInfoId = $Decrypt->decrypt($_REQUEST['ContactInfoId']);
	$Notes = new Notes();
	$Notes->Notes = TextScrubber($_REQUEST['Notes']);
	$Notes->DatePosted = date('Y-m-d H:i:s');
	$Notes->Status = 1;
	$NotesId = $Notes->InsertNotes();


	$NotesRelations = new NotesRelations();
	$NotesRelations->NotesId = $NotesId;
	$NotesRelations->ContactInfoId = $ContactInfoId;
	$NotesRelations->Status = 1;
	$NotesRelations->InsertRelation();
	
	
	header("Location:".ADMINAPPROOT . 'leads.php');
}

if(isset($_POST['sendtemplate']) && $_POST['sendtemplate'] == 'Delete Application')
{
	if(count($_REQUEST['Notification']>0))
	{
		$Notification = implode(",",$_REQUEST['Notification']);
		ContactInfo::deleteApplication($Notification);
		
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Selected application(s) has been deleted permanently.&Success=true"));
		exit();
	}
	else
	{
		header('Location:leads.php?' . $Encrypt->encrypt("Message=Please select atleast one application to delete it.&Success=false"));
		exit();
	}
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Status')
{
	
    $affiliateTransaction = new AffiliateTransaction();

    for($x=0; $x < count($_POST['affiliatetransactionid']); $x++)
    {
        $affiliateTransaction->loadTransactionId($_POST['affiliatetransactionid'][$x]);
        $affiliateTransaction->description = $Decrypt->decrypt($_POST['description'][$x]);
        $affiliateTransaction->UpdateTransaction();
    }

    header('Location:leads.php?' . $Encrypt->encrypt("Message=Deal status has been updated successfully.&Success=true"));
    exit();
}


if(isset($_POST['ArchiveApplicant']) && $_POST['ArchiveApplicant'] == 'ArchiveIt')
{
	//debugObj($_REQUEST); die();
	$ContactInfo = new ContactInfo();
	$ContactInfo->loadContactInfo($_REQUEST['ContactInfoId']);
    $ContactInfo->ArchiveNotes = $_REQUEST['ArchiveNotes'];
    $ContactInfo->ArchiveNotification = $_REQUEST['date1'];
    $ContactInfo->Status = 0;
    $ContactInfo->updateContactInfo();
    header('Location:leads.php?' . $Encrypt->encrypt("Message=Incomplete lead application archived completely.&Success=true"));
    exit();
}

if(isset($_POST['ApplicantNotes']) && $_POST['ApplicantNotes'] == 'AddNotes')
{
	//debugObj($_REQUEST); die();
	$Notes = new Notes();
	$Notes->Notes = TextScrubber($_REQUEST['AddNotes']);
	$Notes->DatePosted = date('Y-m-d H:i:s');
	$Notes->Status = 1;
	$NotesId = $Notes->InsertNotes();


	$NotesRelations = new NotesRelations();
	$NotesRelations->NotesId = $NotesId;
	$NotesRelations->ContactId = $_REQUEST['ContactId'];
	$NotesRelations->Status = 1;
	$NotesRelations->InsertRelation();
	header('Location:leads.php?' . $Encrypt->encrypt("Message=Notes added successfully.&Success=true"));
    exit();
}


if(isset($_POST['Date1']) && $_POST['Date1'] !='')
{
	$Date1 = $_POST['Date1'];
	if(isset($_POST['Date2']) && $_POST['Date2'] !='')
		$Date2 = $_POST['Date2'];
	else
		$Date2 = date('Y-m-d');

	$Date = true;
	$SQLWhere .= " AND (C.CreateDate >= '" . $Date1 . "%'  AND C.CreateDate <= '" . $Date2 . "%')";
}
else
{
	$Date = false;
}	




if((isset($_POST['StartCreditScore']) && $_POST['StartCreditScore'] !='') || (isset($_POST['EndCreditScore']) && $_POST['EndCreditScore'] !=''))
{
	//$StartCreditScore = $_POST['StartCreditScore'];

	if(isset($_POST['StartCreditScore']) && $_POST['StartCreditScore'] !='')
		$StartCreditScore = $_POST['StartCreditScore'];
	else
		$StartCreditScore = 300;

	if(isset($_POST['EndCreditScore']) && $_POST['EndCreditScore'] !='')
		$EndCreditScore = $_POST['EndCreditScore'];
	else
		$EndCreditScore = 900;

	$CreditScore = true;
	$SQLWhere .= " AND CI.CreditScore BETWEEN " . $StartCreditScore . " AND " . $EndCreditScore;
}
else
{
	$CreditScore = false;
}


//echo str_replace(",","",$_POST['MonthlyPayment']) : 0.00;

if((isset($_POST['StartIncome']) && $_POST['StartIncome'] !='') || (isset($_POST['EndIncome']) && $_POST['EndIncome'] !=''))
{
	

	if(isset($_POST['StartIncome']) && $_POST['StartIncome'] !='')
	{
		$StartIncome = str_replace(",","",$_POST['StartIncome']);
		$StartIncome = str_replace("$","",$StartIncome);
		$SQLWhere .= " AND (EMP.GrossIncome >= " . $StartIncome . ")";
	}
	

	if(isset($_POST['EndIncome']) && $_POST['EndIncome'] !='')
	{
		$EndIncome = str_replace(",","",$_POST['EndIncome']);
		$EndIncome = str_replace("$","",$EndIncome);
		$SQLWhere .= " AND (EMP.GrossIncome <= " . $EndIncome . ")";
	}
	
}
else
{
	$Income = false;
}

if(isset($_POST['FullName']) && $_POST['FullName'] !='')
{
	$FullName = $_POST['FullName'];
	$SQLWhere .= " AND  CONCAT(CI.FirstName ,". ' ' . "CI.LastName) LIKE '%" . $FullName . "%'" ;
}	
else
	$FullName = '';


if(isset($_POST['City']) && $_POST['City'] !='')
{
	$City = $_POST['City'];
	$SQLWhere .= " AND  CI.City LIKE '%" . $City . "%'" ;
}	
else
	$City = '';

if(isset($_POST['Province']) && $_POST['Province'] !='')
{
	$Province = $_POST['Province'];
	$SQLWhere .= " AND  CI.Province LIKE '%" . $Province . "%'" ;
}	
else
	$Province = '';

if(isset($_POST['Phone']) && $_POST['Phone'] !='')
{
	$Phone = substr($_POST['Phone'], -1, 10);
	$SQLWhere .= " AND  CI.Phone1 LIKE '%" . $Phone . "%'" ;
}	
else
	$Phone = '';

if(isset($_POST['EmpLength']) && $_POST['EmpLength'] !='')
{
	switch($_POST['EmpLength'])
	{

		case "Less than 30":
			$EmpYears = 0;
			$EmpMonths = 1;
			$Residence = 1;
			$SQLWhere .= " AND  (EMP.EmpYears =0 AND EMP.EmpMonths <= 1) " ;
			break;


		case "Less than 90":
			$EmpYears = 0;
			$EmpMonths = 3;
			$Residence = 1;
			$SQLWhere .= " AND  (EMP.EmpYears =0 AND EMP.EmpMonths <= 3) " ;
			break;


		case "Less than 1":
			$EmpYears = 0;
			$EmpMonths = 11;
			$Residence = 1;
			$SQLWhere .= " AND  (EMP.EmpYears =0 AND EMP.EmpMonths <= 11) " ;
			break;

		case "One to Two":
			$EmpYears = 1;
			$EmpMonths = 11;
			$Residence = 2;
			$SQLWhere .= " AND  (EMP.EmpYears = 1 AND EMP.EmpMonths <= 11) " ;
			break;

		case "More than 2":
			$EmpYears = 2;
			$EmpMonths = 0;
			$Residence = 3;
			$SQLWhere .= " AND  (EMP.EmpYears >= 2) " ;
			break;
		default:
			$Residence = 0;

	}
	$Residence = 0;
}


$Contact = new Contact();
$Result = $Contact->loadSearchInfo($SQLWhere);


?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>



				<script src="<?= APPROOT ?>js/jquery-1.12.0.min.js"></script>
				<script src="<?= APPROOT ?>js/jquery.dataTables.min.js"></script>
				<script src="<?= APPROOT ?>js/dataTables.bootstrap.min.js"></script>
				
				
				<link href="<?= APPROOT ?>css/dataTables.bootstrap.min.css" rel="stylesheet">


<body>
<?php require_once("inc/header.php"); ?>
<form method="post" action="leads.php">
	<?php require_once("inc/search.php"); ?>
</form>

<?php   
	                        
	if( isset ($Message) && $Message != "" ) 
	{ 
	    if($Success && $Success == 'true')
	        echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
	    else
	        echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
	}
?>

<?php
		$countComplete = Contact::PendingCount('AccountStatus = 2');
		$countIncomplete = ContactInfo::IncompleteCount();
		$unreadIncomplete = ContactInfo::UnreadCount();
		$TotalLeads = Contact::LeadsCount();
		$Archived = ContactInfo::ArchivedCount();
		$Hidden = Contact::HiddenCount();

		$PrintLink =  ADMINAPPROOT . 'completeleadsexport.php?' . $Encrypt->encrypt('SQLWhere='.$SQLWhere.'&Print=true');
?>

<form method="post" autocomplete="off" action="#">

<ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="myTab">
    <li class="active" role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#tab1"><i class="fa fa-user"></i> <label>Completed&nbsp;Applications</label>
    	<?php if($countComplete) echo '&nbsp;<label class="badge label-danger" title="Pending Verification">'.$countComplete.'</label>'; ?>
    	<?php if($TotalLeads) echo '&nbsp;<label class="badge primary" title="Total Number of leads in the system">'.$TotalLeads.'</label>'; ?>
    </a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#tab2"><i class="fa fa-user"></i> <label>Incomplete&nbsp;Applications</label>
    	<?php if($unreadIncomplete) echo '&nbsp;<label class="badge label-danger" title="Unread Applications which needs to be read">'.$unreadIncomplete.'</label>'; ?>
    	<?php if($countIncomplete) echo '&nbsp;<label class="badge primary" title="Total Incomplete Applications which needs to be completed">'.$countIncomplete.'</label>'; ?>
    	
    </a></li>
    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#tab3"><i class="fa fa-user"></i> <label>Archived&nbsp;Applications</label>
    	<?php if($Archived) echo '&nbsp;<label class="badge label-danger" title="Total number of Archived Applications">'.$Archived.'</label>'; ?>
    </a></li>

    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#tab4"><i class="fa fa-user"></i> <label>Hidden&nbsp;Completed&nbsp;Applications</label>
    <?php if($Hidden) echo '&nbsp;<label class="badge label-danger" title="Total number of Hidden Applications">'.$Hidden.'</label>'; ?>
    </a></li>
</ul>			
 
 	<div class="tab-content" id="myTabContent">
            <div aria-labelledby="tab1-tab" id="tab1" class="tab-pane fade in active" role="tabpanel">	
		        
            	<div class="col-sm-6"><h3>Complete Applications</h3></div>
            	<div class="col-sm-6 text-right"><a href="<?php echo $PrintLink; ?>" class="btn btn-primary" target="_blank">
            		<i class="fa fa-print"></i> <label>Export&nbsp;PDF&nbsp;List</label></a>
            	</div>
            	<div class="clearfix"></div>

		        <div class="table-responsive">
				    <table id="incomplete" class="table table-striped table-bordered" cellspacing="0" width="100%">
				  		<!-- <thead>
				  			<tr>
				  				<?php   
	                                    
						            if( isset ($Message) && $Message != "" ) 
						            { 
						                if($Success && $Success == 'true')
						                    echo '<th colspan="12" style="color:green;">'.  $Message . '</th>';
						                else
						                    echo '<th colspan="12" style="color:red;">'.  $Message . '</th>';
						            }
						         	?>
				  				</tr>
				  		</thead>     -->  

				        <thead>
				            <tr>
				                <th>#</th>
				                <th>Unique ID</th>
				                <th>Full Name</th>
				                <th>Email</th>
				                <th>Phone</th>
				                <th>Credit<br/>Score</th>
				                <th>Referred By</th>
				                <th>Assigned<br/>Dealer</th>
				                <th>Verified<br/>Status</th>
				                <th>Deal<br/>Status</th>
				                <th>Date<br/>Completed</th>
				                
				            </tr>
				        </thead>
				        <tbody>
				        <?php

						$count = 1;
						if($Result->TotalResults>0)
						{
							/* Deal Status of Contact */
		                	$affiliateTransaction = new AffiliateTransaction();

							$dealStatus = new DealStatus();
							$dealStatusResult = $dealStatus->loadAllDealStatus();

							for($x = 0; $x < $Result->TotalResults ; $x++)
							{
								$Assigned = DealerPackageFeatures::CheckContactExists($Result->Result[$x]['ContactId']);
								if($Assigned)
		                		{
		                			$dealerpackagefeaturesResultSet = DealerPackageFeatures::LoadFeaturesByContactId($Result->Result[$x]['ContactId'],true);
		                			$AssignedText = $dealerpackagefeaturesResultSet[0]->DealerRelation->DealershipName ;
		                		}
		                		else{
		                			$AssignedText = '<a class="btn btn-info" href="approveddealers.php?' . $Encrypt->encrypt('ContactId='.$Result->Result[$x]['ContactId'].'&Assigned=true') . '">Assign and Email to Dealer </a>';
		                		}

		                		$AffiliateCode = AffiliateTransaction::getAffiliateCode($Result->Result[$x]['Id']);
								if($AffiliateCode)
									$ReferredPerson = '<a href="' . ADMINAPPROOT . 'affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$AffiliateCode) . '" >' . Affiliate::GetFullName($AffiliateCode) . '</a>';
								else
									$ReferredPerson = '<a class="affiliatereffered btn btn-primary" href="" data-toggle="modal" data-id="'. $Result->Result[$x]['Id'] . '" data-target="#AssignAffiliate">Assign Affiliate</a>';


		                		$VerifyManual = false;
		                		if($Result->Result[$x]['AccountStatus'] == 2)
		                		{
		                			$VerifyManual = '<a class="btn btn-primary" href="info.php?' . $Encrypt->encrypt('ContactId='.$Result->Result[$x]['ContactId'].'&Verify=true') . '">Verify Manual </a>';	
		                		}
		                		$CreditScoreResult = Files::LoadCreditScore($Result->Result[$x]['ContactId']);

							?>
							    <tr>
							    		<?php $link =  ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$Result->Result[$x]['ContactId']); ?>
						                <td><?php echo $count; ?></td>
						                <td><?php echo sprintf('%04d',$Result->Result[$x]['Id']); ?></td>
						                <td><a href="<?= $link ?>">
						                		<?php echo $Result->Result[$x]['FirstName'] . " " . $Result->Result[$x]['LastName']; ?>
						                	</a>
						                	<span><a class="notesadd" data-id="<?php echo $Result->Result[$x]['ContactId']; ?>"  data-toggle="modal" data-target="#notesModal">&nbsp; <i class="fa fa-pencil"></i> <label>Notes</label></a></span>
						                </td>
						                <td><?php echo $Result->Result[$x]['Email']; ?></td>
						                <td><?php echo $Result->Result[$x]['Phone1']; ?></td>
						                <td><?php if($CreditScoreResult)
						                				echo '<a href="'. APPROOT . 'img/'. $CreditScoreResult->Result[0]['FileLocation'] .'" target="_blank">'
															. $Result->Result[$x]['CreditScore'] . '</a>'; 
												 else{
												 	echo $Result->Result[$x]['CreditScore'];
												 }
										?></td>
						                <td><?php echo $ReferredPerson; ?></td>
						                <td><?php echo $AssignedText; ?></td>
						                <td><?php 
						                		echo Contact::Status($Result->Result[$x]['AccountStatus']); 
						                		if($Result->Result[$x]['AccountStatus'] == 2)
						                			echo "<br/>" . $VerifyManual;
						                	?>
						                </td>
						                <td>
						                	
						            <?php 
                                    	$ResultTransaction = $affiliateTransaction->loadTransactionByContactInfo($Result->Result[$x]['Id']);
                                    	//echo "<br/>affiliatetransactionid - ". $ResultTransaction->affiliatetransactionid;
                                    	echo '<input type="hidden" name="affiliatetransactionid[]" value="'. $ResultTransaction->affiliatetransactionid . '"/>';
                                        if($ResultTransaction->description == 7)
                                        {

                                        	echo '<span><select style="display:none;" id="description" name="description[]" >';
                                        	echo "<option value='". $Encrypt->encrypt(DealStatus::getStatusId($ResultTransaction->description)) ."'>".
                                                            DealStatus::getStatusText($ResultTransaction->description)
                                                      . "</option>";
                                            echo '</select></span>';    

                                            echo "<span><label class='alert alert-success' role='alert' style='width:100%;'>" . DealStatus::getStatusText($ResultTransaction->description) ."</label></span>";
                                        }
                                        else
                                        {
                                            echo '<span><select id="description" name="description[]" >';
                                            for($y = 0; $y < $dealStatusResult->TotalResults ; $y++)
                                            {
                                                if($dealStatusResult->Result[$y]['Id'] == $ResultTransaction->description)
                                                {
                                                    echo "<option value='". $Encrypt->encrypt($dealStatusResult->Result[$y]['Id']) ."' selected >".
                                                            $dealStatusResult->Result[$y]['StatusText']
                                                      . "</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='". $Encrypt->encrypt($dealStatusResult->Result[$y]['Id']) ."'>".
                                                            $dealStatusResult->Result[$y]['StatusText']
                                                      . "</option>";
                                                }
                                            }
                                            echo '</select></span>';    
                                        }
                                	?>      

						                </td>
						                <td><?php echo $Result->Result[$x]['Created']; ?></td>
						        </tr>
						    <?php
						    	$count++;
							}
						}
						else
						{
							echo "<tr><td colspan='11'>&nbsp;</td></tr>";
							echo "<tr><td colspan='11' style='text-align:center;'>No Results found</td></tr>";
						}

						?>
				        </tbody>
				        <tfoot>
				            <tr>
				                <th>#</th>
				                <th>Unique ID</th>
				                <th>Full Name</th>
				                <th>Email</th>
				                <th>Phone</th>
				                <th>Credit<br/>Score</th>
				                <th>Referred By</th>
				                <th>Assigned<br/>Dealer</th>
				                <th>Verified<br/>Status</th>
				                <th><input type="submit" id="Finish" name="Finish" value="Update Status" /></th>
				                <th>Date<br/>Completed</th>
				                
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>

			
			<div aria-labelledby="tab2-tab" id="tab2" class="tab-pane" role="tabpanel">
				<?php 
					$IncompleteContactInfo = new ContactInfo();
					$IncompleteResult = $IncompleteContactInfo->loadIncompleteApplication($SQLWhere);

					$Template = new Template();
					$TemplateResult = $Template->loadAllTemplate(' AND Type = 2 ');

					$IPrintLink =  ADMINAPPROOT . 'incompleteleadsexport.php?' . $Encrypt->encrypt('SQLWhere='.$SQLWhere.'&Print=true');
				?>

				<div class="col-sm-6"><h3>Incomplete Applications</h3></div>
            	<div class="col-sm-6 text-right"><a href="<?php echo $IPrintLink; ?>" class="btn btn-primary" target="_blank">
            		<i class="fa fa-print"></i> <label>Export&nbsp;Incomplete&nbsp;Application&nbsp;List</label></a>
            	</div>
            	<div class="clearfix"></div>

			        <div class="table-responsive">
					    <table id="incomplete" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Unique ID</th>
					                <th>Full Name</th>
					                <th>Notes</th>
					                <th>Select<br/>Template:<br/>
					            		<select id="Templateselect" name="Templateselect"  >
						            		<?php 
		                                    for($x = 0; $x < $TemplateResult->TotalResults ; $x++)
		                                    {
		                                        	echo "<option value='". $TemplateResult->Result[$x]['Id'] ."'>".
		                                                    $TemplateResult->Result[$x]['Title']
		                                              . "</option>";
		                                    }
		                                ?>
					            		</select>
					            	</th>
					                <th>Email</th>
					                <th>Phone</th>
					                <th>Referred<br/>By</th>
					                <th>Application<br/>Started</th>
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
										$ReferredPerson = '<a href="' . ADMINAPPROOT . 'affiliateinfo.php?' . $Encrypt->encrypt('affiliate_id='.$AffiliateCode) . '" >' . Affiliate::GetFullName($AffiliateCode) . '</a>';
									else
										$ReferredPerson = " - ";

									$MailResults = TblMail::loadMailNotification(' AND m.ContactInfoId = ' . $IncompleteResult->Result[$x]['Id']);
								?>
								<?php 
										if($IncompleteResult->Result[$x]['Notification'] ==1 )
											echo '<tr class="info">';
										else
											echo '<tr>';
								?>
								    
								    		<td><input type="checkbox" id="Leads" name="Notification[]" value="<?php echo $IncompleteResult->Result[$x]['Id']; ?>"/></td>
								    		<td><?php echo sprintf('%04d',$IncompleteResult->Result[$x]['Id']); ?></td>
							                <td><?php echo $IncompleteResult->Result[$x]['FirstName'] . " " . $IncompleteResult->Result[$x]['LastName'];

/*
							                	if($IncompleteResult->Result[$x]['Notes'] !='')
							                		{
							                			echo '<span class="dropt" >
																		<span style="width:300px;">
																			<strong>Notes&nbsp;:</strong> '.$IncompleteResult->Result[$x]['Notes'].'<br/>
																		</span>
														</span>';	
							                		}
							                		*/

							                ?>
							                	<span><a class="incnotesadd" data-id="<?php echo $IncompleteResult->Result[$x]['Id']; ?>"  data-toggle="modal" data-target="#incnotesModal">&nbsp; <i class="fa fa-pencil"></i> <label>Notes</label></a></span>

							                </td>
							                <td><?php echo $IncompleteResult->Result[$x]['Notes']; ?></td>
							                <td>
					                			<input type="checkbox" id="Leads" name="Leads[]" value="<?php echo $IncompleteResult->Result[$x]['Id']; ?>"/>
					            		<?php
					                			if($MailResults->TotalResults>0)
												{
													for($y = 0; $y < $MailResults->TotalResults ; $y++)
													{
														echo '<span class="box dropt" style="background:'.$MailResults->Result[$y]['Color'].';" >
																		<span style="width:300px;">
																			<strong>Template&nbsp;Name:</strong> '.$MailResults->Result[$y]['Title'].'<br/>
																			<strong>Date&nbsp;Sent:</strong> '.$MailResults->Result[$y]['DateSent'].'<br/>
																		</span>
														</span>';
													}
												}
										?>
					                		</td>
							                <td><?php echo $IncompleteResult->Result[$x]['Email']; ?></td>
							                <td><?php echo $IncompleteResult->Result[$x]['Phone1']; ?></td>
							                <td><?php echo $ReferredPerson; ?></td>
							                <td><?php echo $IncompleteResult->Result[$x]['Created']; ?></td>
							                <td><?php echo '<a class="btn btn-info" href="'.APPROOT.'application.php?' . $Encrypt->encrypt('ContactInfoId='.$IncompleteResult->Result[$x]['Id'].'&Assigned=true') . '">Complete Application </a>'; ?>

							                	<a href="" class="modaledit btn btn-danger" data-id="<?php echo $IncompleteResult->Result[$x]['Id']; ?>"  data-toggle="modal" data-target="#exampleModal">Archive Application</a>
							                </td>
					                		
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
					        <tfoot>
					        	<tr>
					                <th>
					                	<input type="submit" name="sendtemplate" class="info" value="Mark as read" /> <br/>
					                	<input type="submit" name="sendtemplate" class="danger" value="Mark as unread" /><br/>
					                	<input type="submit" name="sendtemplate" class="warning" value="Delete Application" />

					                </th>
					                <th>Unique ID</th>
					                <th>Full Name</th>
					                <th><label><input type="checkbox" id="checkAll"/> Check all</label>
					                	<input type="submit" name="sendtemplate" value="Send" />
					            	</th>
					                <th>Email</th>
					                <th>Phone</th>
					                <th>Referred&nbsp;By</th>
					                <th>Application&nbsp;Started</th>
					                <th>&nbsp;</th>
					                
					            </tr>

					        </tfoot>
					    </table>
					</div>

			</div>

			<div aria-labelledby="tab3-tab" id="tab3" class="tab-pane" role="tabpanel">
				<?php 
					$ArchivedContactInfo = new ContactInfo();
					$ArchivedResult = $ArchivedContactInfo->loadArchivedApplication($SQLWhere);


					$IPrintLink =  ADMINAPPROOT . 'archivedleadsexport.php?' . $Encrypt->encrypt('SQLWhere='.$SQLWhere.'&Print=true');
				?>

				<div class="col-sm-6"><h3>Archived Applications</h3></div>
            	<div class="col-sm-6 text-right"><a href="<?php echo $IPrintLink; ?>" class="btn btn-primary" target="_blank">
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
					                <th>Notify&nbsp;Date</th>
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

									$MailResults = TblMail::loadMailNotification(' AND m.ContactInfoId = ' . $ArchivedResult->Result[$x]['Id']);
								?>
								    <tr>
								    		<td><?php echo $count; ?></td>
								    		<td><?php echo sprintf('%04d',$ArchivedResult->Result[$x]['Id']); ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['FirstName'] . " " . $ArchivedResult->Result[$x]['LastName']; ?></td>
							                
							                <td><?php echo $ArchivedResult->Result[$x]['Email']; ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['Phone1']; ?></td>
							                <td><?php echo $ReferredPerson; ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['ArchiveNotes']; ?></td>
							                <td><?php echo $ArchivedResult->Result[$x]['ArchiveNotification']; ?></td>
							                <td><?php echo '<a class="btn btn-info" href="'.APPROOT.'application.php?' . $Encrypt->encrypt('ContactInfoId='.$ArchivedResult->Result[$x]['Id'].'&Assigned=true') . '">Complete Application </a>'; ?>

							                	
							                </td>
					                		
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

			</div>
			
			<div aria-labelledby="tab4-tab" id="tab4" class="tab-pane" role="tabpanel">
				<?php 
					$HiddenContact = new Contact();
					$HiddenResult = $HiddenContact->loadHiddenApplication($SQLWhere);

				?>

				<div class="col-sm-6"><h3>Hidden Applications</h3></div>
            	
            	<div class="clearfix"></div>

			        <div class="table-responsive">
					    <table id="hidden" class="table table-striped table-bordered" cellspacing="0" width="100%">
					        
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Unique ID</th>
					                <th>Full Name</th>
					                
					                <th>Email</th>
					                <th>Phone</th>
					                <th>Referred&nbsp;By</th>
					                <th>Archived&nbsp;Notes</th>
					                <th>Notify&nbsp;Date</th>
					                <th>&nbsp;</th>
					                
					            </tr>
					        </thead>
					        	
					        <tbody>
					        <?php

							$count = 1;
							if($HiddenResult)
							{
								for($x = 0; $x < count($HiddenResult) ; $x++)
								{
									$AffiliateCode = AffiliateTransaction::getAffiliateCode($HiddenResult[$x]->Id);
									if($AffiliateCode)
										$ReferredPerson = Affiliate::GetFullName($AffiliateCode);
									else
										$ReferredPerson = " - ";

									$MailResults = TblMail::loadMailNotification(' AND m.ContactInfoId = ' . $HiddenResult[$x]->Id);
								?>
								    <tr>
								    		<td><?php echo $count; ?></td>
								    		<td><?php echo sprintf('%04d',$HiddenResult[$x]->ContactInfoRelation->Id); ?></td>
							                <td><?php echo $HiddenResult[$x]->ContactInfoRelation->FirstName . " " . $HiddenResult[$x]->ContactInfoRelation->LastName; ?></td>
							                
							                <td><?php echo $HiddenResult[$x]->ContactInfoRelation->Email; ?></td>
							                <td><?php echo $HiddenResult[$x]->ContactInfoRelation->Phone1; ?></td>
							                <td><?php echo $ReferredPerson; ?></td>
							                <td><?php echo $HiddenResult[$x]->ContactInfoRelation->ArchiveNotes; ?></td>
							                <td><?php echo $HiddenResult[$x]->ContactInfoRelation->ArchiveNotification; ?></td>
							                
					                		
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

			</div>

	</div>


<script>
	$(document).ready(function() {
	    $('table#incomplete').DataTable();	    
	} );

	$("#checkAll").change(function () {
	    $("input:checkbox").prop('checked', $(this).prop("checked"));
	});



</script>

</form>
<!-- AssignAffiliate -->
<form method="post" autocomplete="off" action="leads.php">
  <div class="modal fade" id="AssignAffiliate" tabindex="-1" role="dialog" aria-labelledby="AssignAffiliateLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="AssignAffiliateLabel">Please assign an affiliate to the lead.</h4>
        </div>
        <?php
        	$Affiliate = new Affiliate();
        	$AffiliateResultset = Affiliate::loadAllAffiliateInfo(' status = 1 and approved = 1 ');
        	//debugObj($AffiliateResultset);
        ?>
        <div class="modal-body">          
              <div class="container-fluid">
              <div class="row">                
                
                <select id="AffiliateId" name="AffiliateId"  >
            		<?php 
                    for($x = 0; $x < $AffiliateResultset->TotalResults ; $x++)
                    {
                        	echo "<option value='". $AffiliateResultset->Result[$x]['affiliate_id'] ."'>".
                                    $AffiliateResultset->Result[$x]['firstname'] . " " . $AffiliateResultset->Result[$x]['lastname']
                              . "</option>";
                    }
                ?>
        		</select>
              </div>
            </div>
        </div>

        <input type="hidden" id="ContactInfoId" name="ContactInfoId" value="">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="applyNow">Assign&nbsp;Affiliate</button>
          <input type="hidden" name="AssignAffiliate" value="AssignAffiliate" />
        </div>
      </div>
    </div>
  </div>
</form>

<script>
$(document).on("click", ".affiliatereffered", function () {
    var contact= $(this).data('id');
    $("#AssignAffiliate #ContactInfoId").val( contact );
});
</script>

<!-- Archive Applicant -->
<form method="post" autocomplete="off" action="#">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="exampleModalLabel">Archive Applicant</h4>
	      </div>
	      <div class="modal-body">
	        
	        	<input type="hidden" id="ContactInfoId" name="ContactInfoId" value="">

	          	
		        <div class="form-group">
		          	<label for="resume" class="control-label">Archive Notes:</label>
		            <input type="text" class="form-control" id="ArchiveNotes" name="ArchiveNotes" placeholder="Add notes" autocomplete="off" required>
		        </div>
		        
			        
			            
					        <span><label>Notification Date (yyyy-mm-dd):</label></span>
                               
	                                 <div class="controls input-append date" id="datePicker" data-date="" data-date-format="yyyy-mm-dd"  data-link-format="yyyy-mm-dd">
	                                    <input size="16" type="text" name="date1" value="" readonly>
	                                    <span class="add-on"><i class="icon-remove"></i></span>
	                                    <span class="add-on"><i class="icon-th"></i></span>
	                                </div>
	                                
					   
			        
			        <script type="text/javascript">
			            $(function () {
			                $('#datePicker').datetimepicker({
			                    language:  'en',
			                    weekStart: 1,
			                    todayBtn:  1,
			                    autoclose: 1,
			                    todayHighlight: 1,
			                    startView: 2,
			                    minView: 2,
			                    forceParse: 0
			                });
			            });
			        </script>
			    

	      
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" id="applyNow">Archive</button>
	        <input type="hidden" name="ArchiveApplicant" value="ArchiveIt" />
	      </div>
	    </div>
	  </div>
	</div>
</form>

<script>
$(document).on("click", ".modaledit", function () {
    var contact= $(this).data('id');
    $("#exampleModal #ContactInfoId").val( contact );
});
</script>


<!-- Applicant Notes -->
<form method="post" autocomplete="off" action="leads.php">
	<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="notesModalLabel">Notes</h4>
	      </div>
	      <div class="modal-body">
	        <div class="form-data"></div>         
	      
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <!-- <button type="submit" class="btn btn-primary" id="applyNow">Add</button>
	        <input type="hidden" name="ApplicantNotes" value="AddNotes" /> -->
	      </div>
	    </div>
	  </div>
	</div>
</form>

<!-- <script>
$(document).on("click", ".notesadd", function () {
    var contact= $(this).data('id');
    $("#notesModal #ContactId").val( contact );
});
</script> -->


<script>
//jQuery Library Comes First
//Bootstrap Library
$( document ).ready(function() { 
  $('.notesadd').click(function(){
    var id= $(this).data('id');
    $.ajax({
      type : 'post',
       url : 'notes.php', //Here you should run query to fetch records
      data : 'ContactId='+ id, //Here pass id via 
      success : function(data){
          $('#notesModal').show('show'); //Show Modal
          $('.form-data').html(data); //Show Data
       }
    });
  });
});
</script>

<!-- Applicant Notes -->
<form method="post" autocomplete="off" action="leads.php">
	<div class="modal fade" id="incnotesModal" tabindex="-1" role="dialog" aria-labelledby="incnotesModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="incnotesModalLabel">Notes</h4>
	      </div>
	      <div class="modal-body">
	        <div class="inc-form-data"></div>         
	      
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <!-- <button type="submit" class="btn btn-primary" id="applyNow">Add</button>
	        <input type="hidden" name="ApplicantNotes" value="AddNotes" /> -->
	      </div>
	    </div>
	  </div>
	</div>
</form>

<script>
//jQuery Library Comes First
//Bootstrap Library
$( document ).ready(function() { 
  $('.incnotesadd').click(function(){
    var id= $(this).data('id');
    $.ajax({
      type : 'post',
       url : 'incnotes.php', //Here you should run query to fetch records
      data : 'ContactInfoId='+ id, //Here pass id via 
      success : function(data){
          $('#incnotesModal').show('show'); //Show Modal
          $('.inc-form-data').html(data); //Show Data
       }
    });
  });
});
</script>