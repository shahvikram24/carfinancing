<?php
	
	require_once("../include/files.php");
	
echo "<script type='text/javascript' src='inc/functions.js'></script> ";



if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}


if(!isset($ContactId))
{
	header("Location: dashboard.php");
}

if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Submit Score')
{

	$Contact = new Contact();
	$Contact->loadContact($ContactId);

	$ContactInfo = new ContactInfo();
	$ContactInfo->loadContactInfo($Contact->ContactInfoId);
	$ContactInfo->CreditScore = $_POST['CreditScore'];
	$ContactInfo->updateContactInfo();
	

	header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId));
}

if(isset($_POST['ArchiveApplicant']) && $_POST['ArchiveApplicant'] == 'ArchiveIt')
{
	//debugObj($_REQUEST); die();
	$ContactId = $_REQUEST['ContactId'];

	$Notes = new Notes();
	$Notes->Notes = TextScrubber($_REQUEST['ArchiveNotes']);
	$Notes->DatePosted = date('Y-m-d H:i:s');
	$Notes->Status = 1;
	$NotesId = $Notes->InsertNotes();


	$NotesRelations = new NotesRelations();
	$NotesRelations->NotesId = $NotesId;
	$NotesRelations->ContactId = $ContactId;
	$NotesRelations->Status = 1;
	$NotesRelations->InsertRelation();

	$CoApplicant = new CoApplicant();
	if($CoApplicant->loadCoApplicantByRelationContactId($ContactId))
	{
		$CoApplicant->Status=0;
		$CoApplicant->updateCoApplicant();
	}


	$Contact = new Contact();
	if($Contact->loadContact($ContactId))
	{
		$Contact->Status=0;
		$Contact->updateContact();

		$ContactInfo = new ContactInfo();
		$ContactInfo->loadContactInfo($Contact->ContactInfoRelation->Id);
	    $ContactInfo->ArchiveNotes = TextScrubber($_REQUEST['ArchiveNotes']);
	    $ContactInfo->ArchiveNotification = $_REQUEST['date1'];
	    $ContactInfo->updateContactInfo();


	}
	header("Location:".ADMINAPPROOT . 'leads.php?' . $Encrypt->encrypt('Message=Applicant archived successfully.&Success=true'));

}

if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Post Notes')
{
	//debugObj($_REQUEST); die();
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
	
	
	header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId));
}

if(isset($_POST['Finish']) && $_POST['Finish'] == 'Update Coapplicant')
{
	//debugObj($_REQUEST); die();
	

    		$CoDate= $_POST['Co-DYear'] . "-" . $_POST['Co-DMon'] . "-" . $_POST['Co-DDate'];
            $CoContactInfo = new ContactInfo();

            $CoContactInfo->FirstName = $_POST['Co-FirstName'];
            $CoContactInfo->LastName = $_POST['Co-LastName'];
            $CoContactInfo->Email = $_POST['Co-EmailAddress'];
            $CoContactInfo->Phone1 = $_POST['Co-Phone'];
            $CoContactInfo->Address1 = $_POST['Co-Address1'];
            $CoContactInfo->Postal = $_POST['Co-Postal'];
            $CoContactInfo->City = $_POST['Co-City'];
            $CoContactInfo->Province = $_POST['Co-Province'];
            $CoContactInfo->Phone1 = $_POST['Co-Phone'];
            $CoContactInfo->SIN = $_POST['Co-Sin'];
            $CoContactInfo->DOB = $CoDate;
            $CoContactInfo->MaritalStatus = $_POST['Co-MaritalStatus'];
            $CoContactInfo->Gender = $_POST['Co-Gender'];
            $CoContactInfo->Status = 1;
            $CoContactInfoId = $CoContactInfo->addContactInfo();

            $CoEmploymentId= 0;
            $PreviousCoEmploymentId = 0;

            //tblemployment - co-applicant
            $CoEmployment = new Employment();
            $CoEmployment->EmpStatusId   = $Decrypt->decrypt($_POST['CoEmploymentStatus']);
            $CoEmployment->EmpTypeId   = $Decrypt->decrypt($_POST['CoEmploymentType']);
            $CoEmployment->OrganizationName   = $_POST['CoEmpWorkplace'];
            $CoEmployment->JobTitle   = '';
            $CoEmployment->Address1   = $_POST['CoEmpAddress1'];
            $CoEmployment->City   = $_POST['CoEmpCity'];
            $CoEmployment->Province   = $_POST['CoEmpProvince'];
            $CoEmployment->Postal  = $_POST['CoEmpPostal'];
            $CoEmployment->Phone1   = $_POST['CoEmpPhone'];
            $CoEmployment->EmpYears   = $_POST['CoEmpYears'];
            $CoEmployment->EmpMonths   = $_POST['CoEmpMonths'];
            $CoEmployment->GrossIncome   = $_POST['CoMonthlyGrossIncome'];
            $CoEmployment->OtherIncome   = $_POST['CoOtherIncomeAmount'];
            $CoEmployment->FrequencyId   = $Decrypt->decrypt($_POST['CoOtherIncomeFrequency']);
            $CoEmployment->OtherIncomeTypeId   = $Decrypt->decrypt($_POST['CoOtherIncome']);
            $CoEmployment->Status   = 1;
            $CoEmploymentId = $CoEmployment->addEmployment();

           // echo "<br/> CoEmployment completed <br/>";
            $PreviousCoEmploymentId = 0;

            if( $_POST['CoEmpYears'] <= 1 )
            {
                $PreviousCoEmployment = new PreviousEmployment();
                $PreviousCoEmployment->Name = $_POST['CoPreEmployer'];
                $PreviousCoEmployment->PrevEmpYears = $_POST['CoPreEmployerYears'];
                $PreviousCoEmployment->PrevEmpMonths = $_POST['CoPreEmployerMonths'];
                $PreviousCoEmployment->Status   = 1;
                $PreviousCoEmploymentId = $PreviousCoEmployment->addPreviousEmployment();

               //echo "<br/> PreviousCoEmployment completed <br/>";

            }

            $CoApplicantId = 0;
	        //tblcoaplicant - coapplicant 
	        $CoApplicant = new CoApplicant();
	        $CoApplicant->ContactInfoId = $CoContactInfoId;
	        $CoApplicant->EmploymentId = $CoEmploymentId ;
	        $CoApplicant->PreviousEmpId = $PreviousCoEmploymentId;
	        $CoApplicant->RelationContactId = $ContactId;
	        $CoApplicant->Relation = $_POST['Co-Relation'];
	        $CoApplicant->Status = 1;
	        $CoApplicantId = $CoApplicant->addCoApplicant();

			header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('Message=Co-applicant added successfully in the application.&ContactId='.$ContactId.'&Success=true'));

}

if(isset($Archive) && $Archive == 'true')
{
	

	$CoApplicant = new CoApplicant();
	if($CoApplicant->loadCoApplicantByRelationContactId($ContactId))
	{
		$CoApplicant->Status=0;
		$CoApplicant->updateCoApplicant();
	}


	$Contact = new Contact();
	if($Contact->loadContact($ContactId))
	{
		$Contact->Status=0;
		$Contact->updateContact();
	}
	header("Location:".ADMINAPPROOT . 'leads.php?' . $Encrypt->encrypt('Message=Applicant archived successfully.&Success=true'));
}


if(isset($Verify) && $Verify == 'true')
{
	

	
	$Contact = new Contact();
	if($Contact->loadContact($ContactId))
	{
		$Contact->Status=1;
		$Contact->updateContact();

	}
	header("Location:".ADMINAPPROOT . 'leads.php?' . $Encrypt->encrypt('Message='. $Contact->ContactInfoRelation->FirstName.' approved successfully.&Success=true'));
}


if(isset($Apply) && $Apply == 'Apply')
{
	

	//$DealerId = $Decrypt->decrypt($_POST['DealershipId']);
	$DealerPackageFeatures = new DealerPackageFeatures();
    $DealerPackageFeatures->DealerId = $DealerId;
    $DealerPackageFeatures->DealerPackageId = dealerpackages::GetIdByDealerId($DealerId);
    $DealerPackageFeatures->ContactId = $ContactId;
    $DealerPackageFeatures->Timestamp = date('Y-m-d H:i:s');
    $DealerPackageFeatures->Status = 1;

    $AppsWithPackage = Package::GetApps(dealerpackages::GetPlanId($DealerId));
    $Positive = dealercredits::CountPositive($DealerId,dealerpackages::GetIdByDealerId($DealerId));
    $Negative = dealercredits::CountNegative($DealerId,dealerpackages::GetIdByDealerId($DealerId));

    $Total = $Positive - $Negative;
    $Manage = $AppsWithPackage + $Total;

    $AssignApp = DealerPackageFeatures::CountSentApplications($DealerId,dealerpackages::GetIdByDealerId($DealerId));
   	
   

    if($Manage > $AssignApp)
    {

    	$DealerPackageFeatures->addDealerpackageFeatures();
    	header("Location:".ADMINAPPROOT . 'geninfo.php?' . $Encrypt->encrypt('ContactId='.$ContactId."&DealerId=".$DealerId));

	    exit();
    }
    else
    {
    	 header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('Message=Dealer reached his Application limit.&Success=true&ContactId='.$ContactId));    	
    	 exit();
    }
    
}

if(isset($_POST['SubmitSearch']) && $_POST['SubmitSearch'] == 'Upload Files')
{
		
		$Message = 'Files uploaded successfully.';
		$file = isset($_FILES["myfile"])?$_FILES["myfile"]:'';
		$mode = isset($_POST["mode"]) ? addslashes($_POST["mode"]) : '';
		$error = 0;
		$imageupdate = isset($_POST["imageupdate"])?addslashes($_POST["imageupdate"]):'';
		if($imageupdate=="on" && isset($mode) && $mode=="addimage")
		{
			
			foreach($_FILES['myfile']['tmp_name'] as $key => $tmp_name )
			{
			    $file_name = $key.$_FILES['myfile']['name'][$key];
			    $file_size =$_FILES['myfile']['size'][$key];
			    $file_tmp =$_FILES['myfile']['tmp_name'][$key];
			    $file_type=$_FILES['myfile']['type'][$key];
			}
	     

			$counter=0;
			foreach($_FILES['myfile']['tmp_name'] as $key => $tmp_name )
			{	
				$filename = $_FILES['myfile']['name'][$key];
				
			    $file_size =$_FILES['myfile']['size'][$key];
			    $file_tmp =$_FILES['myfile']['tmp_name'][$key];
			    $file_type=$_FILES['myfile']['type'][$key];
			    $imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
			    
			    //echo $file_tmp. "<br/>";

				if (strlen($filename) > 0)
				{
				 	switch($_FILES['myfile']['error'][$key])
				 	{
				  		case 0:
							$name = date('YmdHis')."." . $imageFileType;
				     		$destdir = '../img/';
				     		$destfile = $destdir . $name;
		    			
							if (!file_exists($destfile))
							{
								if (move_uploaded_file($file_tmp, $destfile))
								{
		             			    //echo "Picture was successfully uploaded<br/>";
									chmod($destfile, 0775);
			             			$imagename = $name;

			             			$tblfile = new Files();
			             			$tblfile->FileName = $_REQUEST["fileType"];
			                        $tblfile->FileDescription = '';
			                        $tblfile->FileSize = $file_size;
			                        $tblfile->FileMIME = $file_type;
			                        $tblfile->FileLocation = $name;
			                        $tblfile->Status = 1;
			                        $tblfile->FileVersion = 1;
			                        $tblfile->DownloadCount = 0;
			                        $fileId = $tblfile->InsertFile();

			             			$fileRelations = new FileRelations();
			             			$fileRelations->FileId = $fileId;
			             			$fileRelations->ContactId = $ContactId;
			             			$fileRelations->Status = 1;
			             			$fileRelations->InsertRelation();


									
				             	}
		   	    				else{
									$error = 1;
	        		    			$Message ="There was an error uploading Picture.&Success=false";
	        	    	 		}
	        	    	 		
			     			 }	
							 
			 				break;
			 			case 1:
			 			case 2:
							$error = 1;
			 				$Message ="Max Size Exceeded, Please Upload a smaller Picture.&Success=false";
			 				break;
			 			case 3:
							$error = 1;
			 				$Message ="Picture Upload Incomplete! Please Try Again.&Success=false";
			 				break;
			 			case 4:
							if($imageupdate=="on")
								$error = 1;
	 						$Message = "No Picture Uploaded.&Success=false";
							break;
		 			}
				}
				else{
					$error = 1;
					$Message = "no picture included, process failed.&Success=false";
					header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId."&Message=".$Message));
					exit;
				}
				

			}//end of for each

					
							header("Location:".ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId."&Message=".$Message."&Success=true"));
		}
}


$Contact = new Contact();
$Contact->loadContact($ContactId);

//debugObj($Contact);

$CoApplicant = new CoApplicant();
$CoApplicant->loadCoApplicantByRelationContactId($ContactId) ;

?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>
<script>
    jQuery(document).ready(function($) {

    	$("#CoEmpPreviousEmployer").hide();

    	$("#CoEmpYears").blur(function(){
                    var years =  $('#CoEmpYears').val();
                    if(years <= 0)
                    {
                        $("#CoEmpPreviousEmployer").show();
                    }
                    else
                    {
                        $("#CoEmpPreviousEmployer").hide();
                    }
                });
			
			$("#Co-DYear").change(function(){
                    var day = $("#Co-DDate").val();
                    var month = $("#Co-DMon").val();
                    var year = $("#Co-DYear").val();
                    var age = 18;
                    var mydate = new Date();
                    mydate.setFullYear(year, month-1, day);


                    var currdate = new Date();
                    currdate.setFullYear(currdate.getFullYear() - age);

                    if ((currdate - mydate) < 0){
                        alert("Sorry, only persons over the age of " + age + " may enter this site");
                    }
                });

                
            });
</script>

<body>
<?php require_once("inc/header.php"); ?>

<div class="container" style="padding-top:40px;padding-bottom:0px;">
&nbsp;
</div>


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
         	<div class="col-sm-12">
         		<span><label>Full Name</label>:&nbsp;<?= $Contact->ContactInfoRelation->FirstName . " " .  $Contact->ContactInfoRelation->LastName?></span>
         	</div>
			<ul role="tablist" class="nav nav-tabs bs-adaptive-tabs" id="myTab">
			    <?php 

			    	$ArchiveLink =  ADMINAPPROOT . 'info.php?' . $Encrypt->encrypt('ContactId='.$Contact->Id.'&Archive=true');
			    	$PrintLink =  ADMINAPPROOT . 'geninfo.php?' . $Encrypt->encrypt('ContactId='.$Contact->Id.'&Print=true');
			    	if($Contact->ContactInfoRelation)
			    		echo '<li class="active" role="presentation">
			    				<a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab1-tab" href="#tab1"><i class="fa fa-home"></i> 
			    					<label>Contact&nbsp;Info</label>
			    				</a>
			    			  </li>';

			    	if($CoApplicant)
			    		echo '<li role="presentation">
			    				<a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab2-tab" href="#tab2"><i class="fa fa-archive"></i> 
			    					<label>Co-Applicant&nbsp;Info</label>
			    				</a>
			    			</li>';

			   	?>			    
			    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab3-tab" href="#tab3"><i class="fa fa-calendar"></i> <label>View&nbsp;Files</label></a></li>
			    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab4-tab" href="#tab4"><i class="fa fa-cog"></i> <label>Assigned&nbsp;Dealer</label></a></li>
			    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="modal" role="tab" id="tab5-tab" href="<?php echo $PrintLink; ?>" target="_blank"><i class="fa fa-print"></i> <label>Print&nbsp;Applicant</label></a></li>
			    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="modal" role="tab" id="tab6-tab" href="#contactFormEmail"><i class="fa fa-envelope"></i> <label>Contact&nbsp;Applicant</label></a></li>
			    <li role="presentation"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="tab7-tab" href="#tab7"><i class="fa fa-pencil"></i> <label>Notes</label></a></li>
			    <?php if(!$Hidden) { ?>
			    <li role="presentation"><a aria-expanded="true" aria-controls="home" class="modaledit" data-id="<?php echo $Contact->Id; ?>"  data-toggle="modal" data-target="#exampleModal" role="tab" id="tab8-tab" ><i class="fa fa-times"></i> <label>Hide&nbsp;Applicant</label></a></li>
			    <?php } ?>
			</ul>

			<div class="tab-content" id="myTabContent">
				<div aria-labelledby="tab1-tab" id="tab1" class="tab-pane fade in active" role="tabpanel">
					<p>&nbsp;</p>
					<!-- Toggle for Primary Information starts -->
                    <div id="PrimaryInformation" class="PrimaryInformation">
                    	<hr/>
                    	<h3>Primary Applicant Information</h3>
                        <div class="col-sm-3">
                            <span><label>Full Name</label>:&nbsp;<?= $Contact->ContactInfoRelation->FirstName . " " .  $Contact->ContactInfoRelation->LastName?></span>
                        </div>
                        <div class="col-sm-3">
                            <span><label>Address</label>:&nbsp;
                            	<?= 
                            		"<br/>" . $Contact->ContactInfoRelation->Address1 . "<br/>" 
                            		.	$Contact->ContactInfoRelation->City . " , "	.$Contact->ContactInfoRelation->Province . "<br/>" 
                            		.	$Contact->ContactInfoRelation->Postal . "<br/>" 
                            		.	$Contact->ContactInfoRelation->Phone1 . "<br/>" 
                            		.	$Contact->ContactInfoRelation->Email . "<br/>" 
                            	?>
                            </span>
                        </div>
                          
                        <div class="col-sm-3">
                            <span><label>Social Insurance Number</label>:&nbsp;<?= ($Contact->ContactInfoRelation->SIN) ? $Contact->ContactInfoRelation->SIN : 'N/A' ?></span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Date of Birth</label>:&nbsp;<?= ($Contact->ContactInfoRelation->DOB) ? $Contact->ContactInfoRelation->DOB : 'N/A' ?></span>
                        </div> 

                        <div class="col-sm-3">
                            <span><label>Marital Status</label>:&nbsp;
                            	<?= ($Contact->ContactInfoRelation->MaritalStatus) ? $Contact->ContactInfoRelation->MaritalStatus : 'N/A' ?>
                            </span>
                        </div> 

                        <div class="col-sm-3">
                            <span><label>Gender</label>:&nbsp;
                            	<?= ($Contact->ContactInfoRelation->Gender) ? $Contact->ContactInfoRelation->Gender : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Length of Residence</label>:&nbsp;
                            	<?= ($Contact->ContactInfoRelation->ResidenceYears) ? $Contact->ContactInfoRelation->ResidenceYears . " Year(s) " : 'N/A' ?>
                            	<?= ($Contact->ContactInfoRelation->ResidenceMonths) ? $Contact->ContactInfoRelation->ResidenceMonths . " Months " : ' 0 Months' ?>
                            </span>
                        </div> 
                   		
                   		<?php
                   			if( empty($Contact->ContactInfoRelation->CreditScore))
                   			{


                   		?>
                   		<form name="myform" action="#" method="post">
	                        
	                        <div class="col-sm-2">
	                            <span><label>Credit Score</label></span>
	                            <span>
	                            	<input name="CreditScore" id="CreditScore" type="text"  placeholder="Enter Credit Score *" class="" >
	                            	<input type="submit" class="btn btn-primary" id="SubmitSearch" name="SubmitSearch" value="Submit Score" style="width:auto;padding:3px;margin-top:3px;"/>
	                        	</span>
	                        </div>

	                    </form>
	                   <?php
	               		}
	               		else
	               		{
	               		?> <div class="col-sm-2">
	                            <span><label>Credit Score</label>:&nbsp;
	                            	<?= $Contact->ContactInfoRelation->CreditScore  ?>
	                            </span>
	                        </div>
	                        
	               		<?php }
	               		?>

                    <div class="clearfix"></div>
                    <?php
                    if($Contact->MortgageRelation)
				    {
				    ?>


                    	<hr/>
                    	<h3>Mortgage Information</h3>
                        <div class="col-sm-3">
                            <span><label>Mortgage Type</label>:&nbsp;
                            	<?= ($Contact->MortgageRelation->MortgageType) ? $Contact->MortgageRelation->MortgageType : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Mortgage Payment</label>:&nbsp;
                            	<?= ($Contact->MortgageRelation->MortgagePayment) ? "$ ".$Contact->MortgageRelation->MortgagePayment : 'N/A' ?>
                            </span>
                        </div>
                        
                        <div class="col-sm-3">
                            <span><label>Mortgage Amount</label>:&nbsp;
                            	<?= ($Contact->MortgageRelation->MortgageAmount) ? "$ ".$Contact->MortgageRelation->MortgageAmount : 'N/A' ?>
                            </span>
                        </div>
                        
                        <div class="col-sm-3">
                            <span><label>Mortgage Holder</label>:&nbsp;
                            	<?= ($Contact->MortgageRelation->MortgageHolder) ? $Contact->MortgageRelation->MortgageHolder : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Market Value</label>:&nbsp;
                            	<?= ($Contact->MortgageRelation->MarketValue) ? "$ ".$Contact->MortgageRelation->MarketValue : 'N/A' ?>
                            </span>
                        </div>
				    <?php
					}
					?>
                    <div class="clearfix"></div>
                    <?php
                    if($Contact->EmploymentRelation)
				    {
				    ?>

                    	<hr/>
                    	<h3>Employment Information</h3>

                    	<div class="col-sm-3">
                            <span><label>Organization Name:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->OrganizationName) ? $Contact->EmploymentRelation->OrganizationName : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Employment Status:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->EmpStatusId) ? EmpStatus::getStatusText($Contact->EmploymentRelation->EmpStatusId) : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Employment Type:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->EmpTypeId) ? EmpType::getType($Contact->EmploymentRelation->EmpTypeId) : 'N/A' ?>
                            </span>
                        </div>                        

                        <div class="col-sm-3">
                            <span><label>Job Title:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->JobTitle) ? $Contact->EmploymentRelation->JobTitle : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Address:</label>:&nbsp;
                            	<?= 
                            		"<br/>" . $Contact->EmploymentRelation->Address1 . "<br/>" 
                            		.	$Contact->EmploymentRelation->City . " , "	.$Contact->EmploymentRelation->Province . "<br/>" 
                            		.	$Contact->EmploymentRelation->Postal . "<br/>" 
                            		.	$Contact->EmploymentRelation->Phone1 . "<br/>" 
                            		.	$Contact->EmploymentRelation->Email . "<br/>" 
                            	?>
                            </span>
                        </div>
                        <div class="col-sm-3">
                            <span><label>Length of Employment:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->EmpYears) ? $Contact->EmploymentRelation->EmpYears . " Year(s) " : ' 0 Years' ?>
                            	<?= ($Contact->EmploymentRelation->EmpMonths) ? $Contact->EmploymentRelation->EmpMonths . " Months " : ' 0 Months' ?>
                            </span>
                        </div> 
                        
                        <div class="col-sm-3">
                            <span><label>Gross Income:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->GrossIncome) ? $Contact->EmploymentRelation->GrossIncome : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Other Income:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->OtherIncome) ? $Contact->EmploymentRelation->OtherIncome : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Frequency:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->FrequencyId) ? Frequency::getFrequency($Contact->EmploymentRelation->FrequencyId) : 'N/A' ?>
                            </span>
                        </div>  

                        <div class="col-sm-3">
                            <span><label>OtherIncomeType:</label>:&nbsp;
                            	<?= ($Contact->EmploymentRelation->OtherIncomeTypeId) ? OtherIncomeType::getIncomeType($Contact->EmploymentRelation->OtherIncomeTypeId) : 'N/A' ?>
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                        	if($Contact->PreviousEmpRelation)
				        	{ 
				        ?>
				        		<div class="col-sm-3">
		                            <span><label>Previous Organization Name:</label>:&nbsp;
		                            	<?= ($Contact->PreviousEmpRelation->Name) ? $Contact->PreviousEmpRelation->Name : 'N/A' ?>
		                            </span>
		                        </div>

		                        <div class="col-sm-3">
		                            <span><label>Previous Length of Employment:</label>:&nbsp;
		                            	<?= ($Contact->PreviousEmpRelation->PrevEmpYears) ? $Contact->PreviousEmpRelation->PrevEmpYears . " Year(s) " : ' 0 Years' ?>
		                            	<?= ($Contact->PreviousEmpRelation->PrevEmpMonths) ? $Contact->PreviousEmpRelation->PrevEmpMonths . " Months " : ' 0 Months' ?>
		                            </span>
		                        </div> 
				        <?php
				        	}

				       	?>
				    <?php
				   	}

				   	?>
				   	<div class="clearfix"></div>
				   	<!-- <hr/>
                    	<h3>Leads Notes</h3>

                    	<div class="col-sm-12">
                            <span><label>Notes</label>:&nbsp;
                            	<?= ($Contact->ContactInfoRelation->Notes) ? $Contact->ContactInfoRelation->Notes : 'N/A' ?>
                            </span>
                        </div> -->

				   	 </div>
                <!-- Toggle for Primary Information ends -->
				</div>
	            <div aria-labelledby="tab2-tab" id="tab2" class="tab-pane" role="tabpanel">
	                <p>&nbsp;</p>
	                <!-- Toggle for Primary Information starts -->
                    <div id="CoApplicantInformation" class="CoApplicantInformation">

                    	<hr/>
                    	<h3>Co-Applicant Information</h3>
                        
                        <?php

                    if($CoApplicant->Id !=0)
				    {
				    ?>
					    <div class="col-sm-3">
	                            <span><label>Full Name</label>:&nbsp;<?= $CoApplicant->ContactInfoRelation->FirstName . " " .  $CoApplicant->ContactInfoRelation->LastName?></span>
	                        </div>
	                        <div class="col-sm-3">
	                            <span><label>Address</label>:&nbsp;
	                            	<?= 
	                            		"<br/>" . $CoApplicant->ContactInfoRelation->Address1 . "<br/>" 
	                            		.	$CoApplicant->ContactInfoRelation->City . " , "	.$CoApplicant->ContactInfoRelation->Province . "<br/>" 
	                            		.	$CoApplicant->ContactInfoRelation->Postal . "<br/>" 
	                            		.	$CoApplicant->ContactInfoRelation->Phone1 . "<br/>" 
	                            		.	$CoApplicant->ContactInfoRelation->Email . "<br/>" 
	                            	?>
	                            </span>
	                        </div>
	                          
	                        <div class="col-sm-3">
	                            <span><label>Social Insurance Number</label>:&nbsp;<?= ($CoApplicant->ContactInfoRelation->SIN) ? $CoApplicant->ContactInfoRelation->SIN : 'N/A' ?></span>
	                        </div>

	                        <div class="col-sm-3">
	                            <span><label>Date of Birth</label>:&nbsp;<?= ($CoApplicant->ContactInfoRelation->DOB) ? $CoApplicant->ContactInfoRelation->DOB : 'N/A' ?></span>
	                        </div> 

	                        <div class="col-sm-3">
	                            <span><label>Marital Status</label>:&nbsp;
	                            	<?= ($CoApplicant->ContactInfoRelation->MaritalStatus) ? $CoApplicant->ContactInfoRelation->MaritalStatus : 'N/A' ?>
	                            </span>
	                        </div> 

	                        <div class="col-sm-3">
	                            <span><label>Gender</label>:&nbsp;
	                            	<?= ($CoApplicant->ContactInfoRelation->Gender) ? $CoApplicant->ContactInfoRelation->Gender : 'N/A' ?>
	                            </span>
	                        </div>

	                        <div class="col-sm-3">
	                            <span><label>Length of Residence</label>:&nbsp;
	                            	<?= ($CoApplicant->ContactInfoRelation->ResidenceYears) ? $CoApplicant->ContactInfoRelation->ResidenceYears . " Year(s) " : 'N/A' ?>
	                            	<?= ($CoApplicant->ContactInfoRelation->ResidenceMonths) ? $CoApplicant->ContactInfoRelation->ResidenceMonths . " Months " : ' 0 Months' ?>
	                            </span>
	                        </div> 

	                        <div class="clearfix"></div>
	                <?php
                    }
				    else{
				    ?>
				    	<form name="myform" enctype="multipart/form-data" action="#" method="post">
					    	<input type="hidden" name="ContactId" value="<?= $Encrypt->encrypt($ContactId) ?>">
	                        <div class="full">
	                             
	                            <div class="col-sm-6">
	                                        <input name="Co-FirstName" type="text" placeholder="Enter First Name*" class="textbox" >
	                                </div>

	                               <div class="col-sm-6">
	                                    <input name="Co-LastName" type="text" placeholder="Enter Last Name*" class="textbox" >
	                                </div>

	                                <div class="col-sm-6">
	                                    <input name="Co-EmailAddress" type="email" placeholder="Enter Email Address*" class="textbox" >
	                                </div>

	                                <div class="col-sm-6">
	                                    <input name="Co-Phone" type="text" placeholder="Enter Phone Number" class="textbox" >
	                                </div>
	                            <div class="col-sm-12">
	                                <span><input name="Co-Address1" type="text" placeholder="Address*" class="textbox" ></span>
	                            </div>


	                            <div class="col-sm-6">
	                                <span><input name="Co-City" type="text" placeholder="City*" class="textbox" ></span>
	                            </div>

	                            <div class="col-sm-6">
	                                <span><input name="Co-Province" type="text" placeholder="Province*" class="textbox" ></span>
	                            </div>
	                            
	                            <div class="col-sm-6">
	                                <span><input name="Co-Postal" type="text" placeholder="Postal Code" class="textbox" ></span>
	                            </div>

	                            <div class="col-sm-6">
	                                <span><input name="Co-Sin" type="text" placeholder="SIN Number (optional)" min="111111111" max="999999999" class="textbox" ></span>
	                            </div>


		                        <div class="col-sm-3">
		                                    <span><label>Date of Birth (mon-dd-yyyy)</label></span>
		                                    <span>
		                                        <select id="Co-DMon" name="Co-DMon" style="width:80%;">
		                                            <option value="01">Jan</option>
		                                            <option value="02">Feb</option>
		                                            <option value="03">Mar</option>
		                                            <option value="04">Apr</option>
		                                            <option value="05">May</option>
		                                            <option value="06">Jun</option>
		                                            <option value="07">Jul</option>
		                                            <option value="08">Aug</option>
		                                            <option value="09">Sept</option>
		                                            <option value="10">Oct</option>
		                                            <option value="11">Nov</option>
		                                            <option value="12">Dec</option>
		                                        </select>
		                                    </span>
		                        </div>
                                <div class="col-sm-3">
                                    <span><label>&nbsp;</label></span>
                                    <span>
                                            
                                            <select id="Co-DDate" name="Co-DDate" style="width:80%;">
                                                <?php 
                                                    for($i=1;$i<=31;$i++)
                                                       echo '<option value="'.$i.'">'.$i.'</option>';
                                                ?>
                                            </select>
                                    </span>
                                </div>
                                <div class="col-sm-3">
                                    <span><label>&nbsp;</label></span>
                                    <span>
                                            <select id="Co-DYear" name="Co-DYear" style="width:80%;">
                                                <?php 
                                                    for($i=date('Y');$i>=1901;$i--)
                                                       echo '<option value="'.$i.'">'.$i.'</option>';
                                                ?>
                                            </select>
                                        </span>
                                </div>

                                <div class="clearfix"></div>

	                            <div class="col-sm-3">
	                                    <span><label>Marital Status</label></span>
	                                    <span><select id="" name="Co-MaritalStatus" style="width:80%;">
	                                        <option value=""></option>
	                                            <option value="Single">Single</option>
	                                            <option value="Married">Married</option>
	                                            <option value="Common Law">Common Law</option>
	                                            <option value="Separated">Separated</option>
	                                            <option value="Divorced">Divorced</option>
	                                            <option value="Widow/Widower">Widow/Widower</option>
	                                    </select></span>
	                            </div>
	                            <div class="col-sm-3">
	                                    <span><label>Gender</label></span>
	                                    <span><select id="" name="Co-Gender" style="width:90%;">
	                                        <option value=""></option>
	                                        <option value="Male">Male</option>
	                                        <option value="Female">Female</option>
	                                    </select></span>
	                            </div>

	                            <div class="col-sm-3">
	                                    <span><label>Relation&nbsp;to&nbsp;Primary</label></span>
	                                     <span>
	                                        <select id="" name="Co-Relation" style="width:90%;">
	                                            <option value=""></option>
	                                            <option value="Spouse">Spouse</option>
	                                            <option value="Common Law">Common Law</option>
	                                            <option value="Employer">Employer</option>
	                                            <option value="I-N-Law">I-N-Law</option>
	                                            <option value="Parental">Parental</option>
	                                            <option value="Grand Parent">Grand Parent</option>
	                                            <option value="Brother">Brother</option>
	                                            <option value="Sister">Sister</option>
	                                            <option value="Other">Other</option>
	                                        </select>
	                                    </span>
	                            </div>
	                            <div class="clearfix"></div>

                        	</div> <!-- End of "full" div -->

                        		<h3>Employment Section</h3>
                        		<div class="col-sm-6">
                                        <span><label>Employment Status*</label></span>
                                        <select id="CoEmploymentStatus" name="CoEmploymentStatus" style="width:80%;">
                                            <option selected="selected" value=""></option>
                                            <?php
                                                $Result = EmpStatus::loadAllEmpStatus();
                                                if($Result->TotalResults>0)
                                                {
                                                    for($x = 0; $x < $Result->TotalResults ; $x++)
                                                    {
                                                        echo '<option value="'. $Encrypt->encrypt($Result->Result[$x]['Id']) .'">'. $Result->Result[$x]['StatusText'] .'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                </div>
                                <div class="col-sm-6">
                                        <span><label>Employment Type*</label></span>
                                        <select id="CoEmploymentType" name="CoEmploymentType" style="width:80%;">
                                            <option selected="selected" value=""></option>
                                            <?php
                                                $Result = EmpType::loadAllEmpType();
                                                if($Result->TotalResults>0)
                                                {
                                                    for($x = 0; $x < $Result->TotalResults ; $x++)
                                                    {
                                                        echo '<option value="'. $Encrypt->encrypt($Result->Result[$x]['Id']) .'">'. $Result->Result[$x]['Type'] .'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                </div>
                                <div class="col-sm-6">
                                    <span><label>Workplace Name</label></span>
                                    <span><input name="CoEmpWorkplace" id="CoEmpWorkplace" type="text" placeholder="Ente Workplace Name" class="textbox"></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Work Address</label></span>
                                    <span><input name="CoEmpAddress1" id="CoEmpAddress1" type="text" placeholder="Work Address" class="textbox"></span>
                                </div>

                                
                                <div class="col-sm-6">
                                    <span><label>City*</label></span>
                                    <span><input name="CoEmpCity" id="CoEmpCity" type="text" placeholder="City" class="textbox"></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Province*</label></span>
                                    <span><input name="CoEmpProvince" id="CoEmpProvince" type="text" placeholder="Province" class="textbox"></span>
                                </div>
                                
                                <!-- <div class="col-sm-6">
                                    <span><label>Postal Code</label></span>
                                    <span><input name="CoEmpPostal" id="CoEmpPostal" type="text" placeholder="Postal Code" class="textbox"></span>
                                </div> -->

                                <div class="col-sm-6">
                                    <span><label> Length of Employment?</label></span>
                                    
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="CoEmpYears" id="CoEmpYears" type="number" min="0" placeholder="Enter Years" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="CoEmpMonths" id="CoEmpMonths" type="number" min="0" placeholder="Enter Months" class="textbox">
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <!-- ============================================= -->

                                <div class="col-sm-6">
                                    <span><label>Monthly Gross Income</label></span>
                                    <span><input name="CoMonthlyGrossIncome" id="CoMonthlyGrossIncome" type="text" placeholder="Enter Your Gross Income" class="textbox"></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Phone Number</label></span>
                                    <span><input name="CoEmpPhone" id="CoEmpPhone" type="text" placeholder="Employer Phone Number" class="textbox" ></span>
                                </div>

                                <div class="clearfix"></div>

                                <!-- ============================================= -->
                                <div id="CoEmpPreviousEmployer" class="CoEmpPreviousEmployer">                           
                                    <hr/>
                                    <div class="col-sm-4">
                                        <span><label>Previous Employer Name*</label></span>
                                        <span><input name="CoPreEmployer" id="CoPreEmployer" type="text" placeholder="Name of Previous Employer" class="textbox"></span>
                                    </div>

                                    <div class="col-sm-4">
                                        <span><label> Length of Employment?*</label></span>
                                        
                                        <div class="col-sm-6">
                                            <span>
                                                <input name="CoPreEmployerYears" id="CoPreEmployerYears" type="number"  value="" min="0" placeholder="Enter Years" class="textbox">
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                <input name="CoPreEmployerMonths" id="CoPreEmployerMonths" type="number"  value="" min="0" placeholder="Enter Months" class="textbox">
                                            </span>
                                        </div>
                                    </div>

                                    
                                    <div class="clearfix"></div>
                                </div>
                                <!-- ============================================= -->
                                <hr/>
                                
                                <div class="col-sm-6">
                                    <span><label>Other Income</label></span>
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="CoOtherIncomeAmount" id="CoOtherIncomeAmount" type="text" placeholder="Enter the Amount" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="CoOtherIncomeFrequency" name="CoOtherIncomeFrequency" style="width:80%;">
                                            <option selected="selected" value="">Frequency</option>
                                            <?php
                                                $Result = Frequency::loadAllFrequency();
                                                if($Result->TotalResults>0)
                                                {
                                                    for($x = 0; $x < $Result->TotalResults ; $x++)
                                                    {
                                                        echo '<option value="'. $Encrypt->encrypt($Result->Result[$x]['Id']) .'">'. $Result->Result[$x]['Frequency'] .'</option>';
                                                    }
                                                }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <span><label>Other Income Type</label></span>
                                        <select id="CoOtherIncome" name="CoOtherIncome" style="width:80%;">
                                            <option selected="selected" value=""></option>
                                            <?php
                                                $Result = OtherIncomeType::loadAllOtherIncomeType();
                                                if($Result->TotalResults>0)
                                                {
                                                    for($x = 0; $x < $Result->TotalResults ; $x++)
                                                    {
                                                        echo '<option value="'. $Encrypt->encrypt($Result->Result[$x]['Id']) .'">'. $Result->Result[$x]['IncomeType'] .'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                </div>

                                <div class="clearfix"></div> <!-- end of toggle div -->


		                        <div class="col-sm-9">&nbsp;</div>
		                        <div class="col-sm-3">
		                            <input type="submit" class="btn" id="Finish" name="Finish" value="Update Coapplicant" />
		                        </div>
		                        <div class="clearfix"></div>
		                </form>

				    <?php
				    	echo '<div class="clearfix"></div>';
				    }
				    ?>    
                     <?php

                    if($CoApplicant->EmploymentRelation)
				    {
				    ?>

                    	<hr/>
                    	<h3>Employment Information</h3>

                    	<div class="col-sm-3">
                            <span><label>Organization Name:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->OrganizationName) ? $CoApplicant->EmploymentRelation->OrganizationName : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Employment Status:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->EmpStatusId) ? EmpStatus::getStatusText($CoApplicant->EmploymentRelation->EmpStatusId) : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Employment Type:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->EmpTypeId) ? EmpType::getType($CoApplicant->EmploymentRelation->EmpTypeId) : 'N/A' ?>
                            </span>
                        </div>                        

                        <div class="col-sm-3">
                            <span><label>Job Title:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->JobTitle) ? $CoApplicant->EmploymentRelation->JobTitle : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Address:</label>:&nbsp;
                            	<?= 
                            		"<br/>" . $CoApplicant->EmploymentRelation->Address1 . "<br/>" 
                            		.	$CoApplicant->EmploymentRelation->City . " , "	.$CoApplicant->EmploymentRelation->Province . "<br/>" 
                            		.	$CoApplicant->EmploymentRelation->Postal . "<br/>" 
                            		.	$CoApplicant->EmploymentRelation->Phone1 . "<br/>" 
                            		.	$CoApplicant->EmploymentRelation->Email . "<br/>" 
                            	?>
                            </span>
                        </div>
                        <div class="col-sm-3">
                            <span><label>Length of Employment:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->EmpYears) ? $CoApplicant->EmploymentRelation->EmpYears . " Year(s) " : ' 0 Years' ?>
                            	<?= ($CoApplicant->EmploymentRelation->EmpMonths) ? $CoApplicant->EmploymentRelation->EmpMonths . " Months " : ' 0 Months' ?>
                            </span>
                        </div> 
                        
                        <div class="col-sm-3">
                            <span><label>Gross Income:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->GrossIncome) ? $CoApplicant->EmploymentRelation->GrossIncome : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Other Income:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->OtherIncome) ? $CoApplicant->EmploymentRelation->OtherIncome : 'N/A' ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <span><label>Frequency:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->FrequencyId) ? Frequency::getFrequency($CoApplicant->EmploymentRelation->FrequencyId) : 'N/A' ?>
                            </span>
                        </div>  

                        <div class="col-sm-3">
                            <span><label>OtherIncomeType:</label>:&nbsp;
                            	<?= ($CoApplicant->EmploymentRelation->OtherIncomeTypeId) ? OtherIncomeType::getIncomeType($CoApplicant->EmploymentRelation->OtherIncomeTypeId) : 'N/A' ?>
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                        	if($CoApplicant->PreviousEmpRelation)
				        	{ 
				        ?>
				        		<div class="col-sm-3">
		                            <span><label>Previous Organization Name:</label>:&nbsp;
		                            	<?= ($CoApplicant->PreviousEmpRelation->Name) ? $CoApplicant->PreviousEmpRelation->Name : 'N/A' ?>
		                            </span>
		                        </div>

		                        <div class="col-sm-3">
		                            <span><label>Previous Length of Employment:</label>:&nbsp;
		                            	<?= ($CoApplicant->PreviousEmpRelation->PrevEmpYears) ? $CoApplicant->PreviousEmpRelation->PrevEmpYears . " Year(s) " : ' 0 Years' ?>
		                            	<?= ($CoApplicant->PreviousEmpRelation->PrevEmpMonths) ? $CoApplicant->PreviousEmpRelation->PrevEmpMonths . " Months " : ' 0 Months' ?>
		                            </span>
		                        </div> 
				        <?php
				        	}

				       	?>
				    <?php
				   	}

				   	?>
                    </div>
                    <div class="clearfix"></div>
                <!-- Toggle for Primary Information ends -->
	            </div>
	            <div aria-labelledby="tab3-tab" id="tab3" class="tab-pane" role="tabpanel">
	                <p>&nbsp;</p>
	                <!-- Toggle for Files Information starts -->
                    <div id="FilesInformation" class="FilesInformation">

                    	<hr/>
                    	<h3>Files Section</h3>
                    	<?php

                    		$count = 1;
                    		$FilesResultset = Files::LoadFileInfo($ContactId);
                    		if($FilesResultset->TotalResults>0)
							{
						?>
								<div class="table-responsive">
								    <table class="table">
								        <thead>
								            <tr>
								                <th>#</th>
								                <th>Filename</th>
								                <th>Action</th>
								                <th>&nbsp;</th>
								            </tr>
								        </thead>
								    <tbody>
						<?php

								for($x = 0; $x < $FilesResultset->TotalResults ; $x++)
								{
                    	?>
		                    	<tr>
		                            <td><?php echo $count; ?></td>
		                        
		                            <td><?php echo $FilesResultset->Result[$x]['FileName']; ?></td>
		                       
		                            <td>
		                            	<?php
												echo '<a href="'. APPROOT . 'lib/download.php?f='. $FilesResultset->Result[$x]['FileLocation'] .'">'
												.'Click here to download'; 
										?>
									</td>
									<td>
		                            	<?php
												echo '<a href="'. APPROOT . 'img/'. $FilesResultset->Result[$x]['FileLocation'] .'" target="_blank">'
												.'View File'; 
										?>
									</td>

		                        </tr>
		                        
		                  <?php
					    			$count++;
								}
							?>
									 </tbody>
								</table>
							</div>
		                    <div class="clearfix"></div>
							<?php

							}

							?>
							<hr/>

						<?php
							$UploadCount = Files::FileuploadCount($ContactId);
							
							if($UploadCount < 5)
							{
						?>
                        <form name="myform" enctype="multipart/form-data" action="#" method="post">
	                        <div class="col-sm-3">
	                            <span><label>Upload Files</label>:&nbsp;</span>
	                            <span><input type="file" name="myfile[]" multiple="multiple" class="btn btn-warning" ></span>
	                            <input type ="hidden" name="imageupdate" value="on">
	                            <input type="hidden" name="mode" value="addimage">
	                            <input type="hidden" name="ContactId" value="<?= $Encrypt->encrypt($ContactId) ?>">

	                        </div>

	                        <div class="col-sm-3">
	                            <span><label>File Type:</label></span>
	                            <span>
	                            	<select name="fileType" style="padding:5px 10px;">
	                            		<option>Driver Licence</option>
	                            		<option>Credit Report</option>
	                            		<option>Contract Docs</option>
	                            		<option>Credit App</option>
	                            		<option>Bill of Sale</option>
	                            		<option>Other</option>
	                            	</select>
	                            </span>
	                        </div>

	                        <div class="col-sm-3">
	                            <span><label>&nbsp;</label></span>
	                            <span>
	                            	<input type="submit" class="btn btn-primary" id="SubmitSearch" name="SubmitSearch" value="Upload Files" />
	                            </span>
	                        </div>
	                    </form>
                        
                          
                       <?php } ?> 

                        <div class="clearfix"></div>
                     	
                    
                    </div>
                    <div class="clearfix"></div>
                <!-- Toggle for Primary Information ends -->
	            </div>
	            <div aria-labelledby="tab4-tab" id="tab4" class="tab-pane" role="tabpanel">
	                <p>&nbsp;</p>

	                <?php
	                	$Assigned = DealerPackageFeatures::CheckContactExists($Contact->Id);
	                	if($Assigned)
	                	{
	                		
	                		$dealerpackagefeaturesResultSet = DealerPackageFeatures::LoadFeaturesByContactId($Contact->Id,true);
	                		//debugObj($dealerpackagefeaturesResultSet[0]->DealerRelation->DealershipName);
	                		echo '
	                			<div class="col-sm-12">
				                	<label for="resume" class="control-label">Assigned Dealership:</label>
				                	<label for="resume" class="control-label"> ' 
				                	. $dealerpackagefeaturesResultSet[0]->DealerRelation->DealershipName 
				                	.  ' </label>
				            	</div>
	                		';

	                	}
	                	else{
	                		echo '
	                			<div class="col-sm-8">
				                	<span><a class="btn btn-info" href="approveddealers.php?' . $Encrypt->encrypt('ContactId='.$Contact->Id.'&Assigned=true') . '">Assign and Email Info to Dealer </a></span>
				            	</div>
	                		';
	                	}
	                ?>
	                
	        	</div>

	        	<div aria-labelledby="tab5-tab" id="tab5" class="tab-pane" role="tabpanel">
	                <p>&nbsp;</p>
	        	</div>

	        	<div aria-labelledby="tab7-tab" id="tab7" class="tab-pane" role="tabpanel">
	                <p>&nbsp;</p>
	                <form method="post" action="#">
	                <input type="hidden" name="ContactId" value="<?= $Encrypt->encrypt($ContactId) ?>">
                    	<h3>Notes</h3>

                    	<div class="col-sm-8">
                            <span>
                            	<input type="text" name="Notes" id="messageNotes" placeholder="Please type your notes" required="required"  />
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <span>
                            	<input type="submit" class="btn btn-primary " id="SubmitSearch" name="SubmitSearch" value="Post Notes" style="width:50%;"/>
                            </span>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <?php

                    		$count = 1;
                    		$NotesResultset = Notes::LoadNotesInfo('ContactId',$ContactId);
                    		if($NotesResultset->TotalResults>0)
							{
						?>
								<div class="table-responsive">
								    <table class="table">
								        <thead>
								            <tr>
								                <th>#</th>
								                <th>Notes</th>
								                <th>Date&nbsp;Posted</th>
								                <th>&nbsp;</th>
								            </tr>
								        </thead>
								    <tbody>
						<?php

								for($x = 0; $x < $NotesResultset->TotalResults ; $x++)
								{
                    	?>
		                    	<tr>
		                            <td><?php echo $count; ?></td>
		                        
		                            <td><?php echo $NotesResultset->Result[$x]['Notes']; ?></td>
		                            <td><?php echo $NotesResultset->Result[$x]['DatePosted']; ?></td>
		                       
		                        </tr>
		                        
		                  <?php
					    			$count++;
								}
							?>
									 </tbody>
								</table>
							</div>
		                    <div class="clearfix"></div>
							<?php

							}

							?>
							<?= ($Contact->ContactInfoRelation->Notes) ? $Contact->ContactInfoRelation->Notes : '' ?>

	        	</div>

            <div class="clearfix"></div>           

          	<hr/>
<div class="clearfix"></div>
<?php require_once("inc/footer.php"); ?>

<!-- This one is for email-->
<script type="text/javascript">

var messageDelay = 2000;  // How long to display status messages (in milliseconds)

// initEmail the form once the document is ready
$( initEmail );


// initEmailialize the form

function initEmail() {

  // Hide the form initEmail initially.
  // Make submitFormEmail() the form's submit handler.
  // Position the form so it sits in the centre of the browser window.
  $('#contactFormEmail').hide().submit( submitFormEmail ).addClass( 'positioned' );

  // When the "Send us an email" link is clicked:
  // 1. Fade the contentEmail out
  // 2. Display the form
  // 3. Move focus to the first field
  // 4. Prevent the link being followed

  $('a[href="#contactFormEmail"]').click( function() {
    $('#contentEmail').fadeTo( 'slow', .2 );
    $('#contactFormEmail').fadeIn( 'slow', function() {
      $('#senderNameEmail').focus();
    } )

    return false;
  } );
  
  // When the "CancelEmail" button is clicked, close the form
  $('#CancelEmail').click( function() { 
    $('#contactFormEmail').fadeOut();
    $('#contentEmail').fadeTo( 'slow', 1 );
  } );  

  // When the "Escape" key is pressed, close the form
  $('#contactFormEmail').keydown( function( event ) {
    if ( event.which == 27 ) {
      $('#contactFormEmail').fadeOut();
      $('#contentEmail').fadeTo( 'slow', 1 );
    }
  } );

}


// Submit the form via Ajax

function submitFormEmail() {
  var contactFormEmail = $(this);

  // Are all the fields filled in?

  if ( !$('#messageEmail').val() ) {

    // No; display a warning message and return to the form
    $('#incompleteMessageEmail').fadeIn().delay(messageDelay).fadeOut();
    contactFormEmail.fadeOut().delay(messageDelay).fadeIn();

  } else {

    // Yes; submit the form to the PHP script via Ajax

    $('#sendingMessageEmail').fadeIn();
    contactFormEmail.fadeOut();

    $.ajax( {
      url: contactFormEmail.attr( 'action' ) + "?ajax=true",
      type: contactFormEmail.attr( 'method' ),
      data: contactFormEmail.serialize(),
      success: submitFinishedEmail
    } );
  }

  // Prevent the default form submission occurring
  return false;
}


// Handle the Ajax response

function submitFinishedEmail( response ) {
  response = $.trim( response );
  $('#sendingMessageEmail').fadeOut();

  if ( response == "success" ) {

    // Form submitted successfully:
    // 1. Display the success message
    // 2. Clear the form fields
    // 3. Fade the contentEmail back in

    $('#successMessageEmail').fadeIn().delay(messageDelay).fadeOut();
    $('#senderNameEmail').val( "" );
    $('#senderEmail').val( "" );
    $('#messageEmail').val( "" );

    $('#contentEmail').delay(messageDelay+500).fadeTo( 'slow', 1 );

  } else {

    // Form submission failed: Display the failure message,
    // then redisplay the form
    $('#failureMessageEmail').fadeIn().delay(messageDelay).fadeOut();
    $('#contactFormEmail').delay(messageDelay+500).fadeIn();
  }
}

</script>



<form id="contactFormEmail" action="processForm.php" method="post">

  <h2>Contact Applicant through Email ...</h2>

  <ul>

   <input type="hidden" name="ContactId" value="<?= $ContactId ?>" />
    <input type="hidden" name="mode" value="email" />

    <li>
      <label for="message" style="padding-top: .5em;">Your Message</label>
      <textarea name="message" id="messageEmail" placeholder="Please type your message" required="required" cols="80" rows="10" maxlength="10000"></textarea>
    </li>

  </ul>

  <div id="formButtons">
    <input type="submit" id="sendMessageEmail" name="sendMessageEmail" value="Send Message" />
    <input type="button" id="CancelEmail" name="CancelEmail" value="Cancel" />
  </div>

</form>

<div id="sendingMessageEmail" class="statusMessage"><p>Sending your message. Please wait...</p></div>
<div id="successMessageEmail" class="statusMessage"><p>Thanks for sending your message!.</p></div>
<div id="failureMessageEmail" class="statusMessage"><p>There was a problem sending your message. Please try again.</p></div>
<div id="incompleteMessageEmail" class="statusMessage"><p>Please complete all the fields in the form before sending.</p></div>


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
	        
	        	<input type="hidden" id="ContactId" name="ContactId" value="">

	          	
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
	        <input type="hidden" name="Archive" value="true" />
	        <input type="hidden" name="ArchiveApplicant" value="ArchiveIt" />
	        
	      </div>
	    </div>
	  </div>
	</div>
</form>

<script>
$(document).on("click", ".modaledit", function () {
    var contact= $(this).data('id');
    $("#exampleModal #ContactId").val( contact );
});
</script>