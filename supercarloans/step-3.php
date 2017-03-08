<?php
    require_once("include/files.php");

    /*debugObj($_REQUEST['ContactInfoId']);
    echo "<br/>================= <br/>";
    debugObj($ContactInfoId);
    echo "<br/>================= <br/>";
    debugObj($_REQUEST);*/
    //die();
    
    if(!isset($ContactInfoId))
    {
        if(!isset($_SESSION['ContactInfoId']) && $_SESSION['ContactInfoId']=='')
        {
            session_unset();
            session_destroy();
            session_write_close();
            header("Location: index.php");
            exit();
        }
        else{
            $ContactInfoId = $_SESSION['ContactInfoId'];
        }
    }

    if(isset($_POST['PrimaryInformationButton']) && $_POST['PrimaryInformationButton'] == 'Next')
    {

        if(isset($_REQUEST['ContactId']) && $_REQUEST['ContactId']!='')
        {        
            $ContactInfoId = $_POST['ContactInfoId'];
            $ContactId = $_POST['ContactId'];
            
            //tblcontactinfo - coapplicant
            if($_POST['chkCoApplicantToggle'])
            {
                $CoDate= $_POST['CoDYear'] . "-" . $_POST['CoDMon'] . "-" . $_POST['CoDDate'];
                $CoContactInfo = new ContactInfo();

                $CoContactInfo->FirstName = $_POST['CoFirstName'];
                $CoContactInfo->LastName = $_POST['CoLastName'];
                $CoContactInfo->Email = $_POST['CoEmailAddress'];
                $CoContactInfo->Phone1 = $_POST['CoPhone'];
                $CoContactInfo->Address1 = $_POST['CoAddress1'];
                $CoContactInfo->Postal = $_POST['CoPostal'];
                $CoContactInfo->City = $_POST['CoCity'];
                $CoContactInfo->Province = $_POST['CoProvince'];
                $CoContactInfo->Phone1 = $_POST['CoPhone'];
                $CoContactInfo->SIN = $_POST['CoSin'];
                $CoContactInfo->DOB = $CoDate;
                $CoContactInfo->MaritalStatus = $_POST['CoMaritalStatus'];
                $CoContactInfo->Gender = $_POST['CoGender'];
                $CoContactInfo->Status = 1;
                $CoContactInfoId = $CoContactInfo->addContactInfo();

                //echo "<br/> CoContactInfo completed <br/>";
            
                    $CoEmploymentId= 0;
                    $PreviousCoEmploymentId = 0;
                    
                       //tblemployment - Coapplicant
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
                        $CoEmployment->OtherIncome   = ($_POST['CoOtherIncomeAmount'] ? $_POST['CoOtherIncomeAmount'] : 0.00);
                        $CoEmployment->FrequencyId   = ($Decrypt->decrypt($_POST['CoOtherIncomeFrequency'])? $Decrypt->decrypt($_POST['CoOtherIncomeFrequency']) : 0);
                        $CoEmployment->OtherIncomeTypeId   = ($Decrypt->decrypt($_POST['CoOtherIncome']) ? $Decrypt->decrypt($_POST['CoOtherIncome']) : 0);
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
                    $CoApplicant->Relation = $_POST['CoRelation'];
                    $CoApplicant->Status = 1;
                    $CoApplicantId = $CoApplicant->addCoApplicant();

                   //echo "<br/> CoApplicant completed <br/>";
                    //////////////////////////////////////////////////////////////////////////////////////////////
            }
            
            header("Location: step-4.php?". $Encrypt->encrypt("ContactInfoId=".$ContactInfoId."&ContactId=".$ContactId));
            exit();
        }
        else
        {
            session_unset();
            session_destroy();
            session_write_close();
            header('Location:index.php');
            exit();
        }
    }
    
    
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content=" Collin Snowball - Snowball Media &amp; Design www.snowballmedia.com">
    <title>SuperCarLoans, Canada&#39;s Auto Financing &amp; Car Loan Experts</title>
    <meta name="description" content="SuperCarLoans is Canada&#39;s leading provider of auto car loans and vehicle financing options. It's quick and easy: Apply, Get Approved, Get a car" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="img/logo.png" /></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php#how-it-works">How&nbsp;does&nbsp;it&nbsp;work?</a>
                    </li>
                    <li>
                        <a href="affiliate.php">Referral&nbsp;Program</a>
                    </li>
                    <li>
                        <a href="#">Contact:&nbsp;1-780-483-7516</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/functions.js"></script>
    

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

    <script>
            jQuery(document).ready(function($) {

                var today  = new Date();
                var year = today.getFullYear();
                var newyear = (year - 18);
                //alert (newyear);
                $("#DYear").val(newyear);
                
                
                $("#CoApplicantToggle").hide();
                $("#CoEmpPreviousEmployer").hide();
                
                $('.form_date').datetimepicker({
                language:  'en',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                endDate: new Date(),
                forceParse: 0
            });

               var today  = new Date();
                var year = today.getFullYear();
                var newyear = (year - 18);
                //alert (newyear);
                $("#CoDYear").val(newyear);
                

              /* Every click functions begin */
                $("#chkCoApplicantToggle").click(function() {                    
                    $("#CoApplicantToggle").toggle();
              }); 

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



                
            });
    </script>

    <!-- ============================ Booking Starts =========================== -->
    <form method="post" action="#">
        <input type="hidden" name="ContactInfoId" value="<?= $ContactInfoId ?>"/>
        <input type="hidden" name="ContactId" value="<?= $ContactId ?>"/>
        
            <div class="contact-form" id="contact-form" style="width:65%;left:20%;">                   

                    <!-- ============== Step Applicant Information Starts =========================== -->
                     <!-- Toggle for Primary Applicant starts -->
                    <div id="PrimaryApplicantToggle" class="PrimaryApplicantToggle"> 
                         <legend>Application (Step 3 of 4)</legend>
                         
                          
                            <h3>
                                <input type="checkbox" name="chkCoApplicantToggle" id="chkCoApplicantToggle" class="chkCoApplicantToggle" value="1"/>
                                Do you have a CoApplicant
                            </h3> 
                                                  
                    </div> <!-- Toggle for Primary Applicant ends -->

                    <!-- Toggle for CoApplicant starts -->
                    <div id="CoApplicantToggle" class="CoApplicantToggle"> 
                        <div class="full">
                             <h3>CoApplicant Information</h3>
                            <div class="col-sm-6">
                                        <input name="CoFirstName" id="CoFirstName" type="text" placeholder="Enter First Name*" class="textbox" >
                                </div>

                               <div class="col-sm-6">
                                    <input name="CoLastName" id="CoLastName"  type="text" placeholder="Enter Last Name*" class="textbox" >
                                </div>

                                <div class="col-sm-6">
                                    <input name="CoEmailAddress" id="CoEmailAddress"  type="email" placeholder="Enter Email Address*" class="textbox" >
                                </div>

                                <div class="col-sm-6">
                                    <input name="CoPhone" id="CoPhone"  type="text" placeholder="Enter Phone Number" class="textbox" >
                                </div>
                            <div class="col-sm-12">
                                <span><input name="CoAddress1" id="CoAddress1"  type="text" placeholder="Address*" class="textbox" ></span>
                            </div>


                            <div class="col-sm-6">
                                <span><input name="CoCity"  id="CoCity" type="text" placeholder="City*" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><input name="CoProvince" id="CoProvince"  type="text" placeholder="Province*" class="textbox" ></span>
                            </div>
                            
                            <div class="col-sm-6">
                                <span><input name="CoPostal" id="CoPostal"  type="text" placeholder="Postal Code*" class="textbox" ></span>
                            </div>

                            <div class="col-sm-6">
                                <span><input name="CoSin"  id="CoSin" type="text" placeholder="SIN Number (optional)" min="111111111" max="999999999" class="textbox" ></span>
                            </div>


                        <div class="col-sm-3">
                                    <span><label>Date of Birth (mon-dd-yyyy)</label></span>
                                    <span>
                                        <select id="CoDMon" name="CoDMon" style="width:80%;">
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
                                            
                                            <select id="CoDDate" name="CoDDate" style="width:80%;">
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
                                            <select id="CoDYear" name="CoDYear" style="width:80%;">
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
                                    <span><select id="" name="CoMaritalStatus" style="width:80%;">
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
                                    <span><select id="" name="CoGender" style="width:90%;">
                                        <option value=""></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select></span>
                            </div>

                            <div class="col-sm-3">
                                    <span><label>Relation&nbsp;to&nbsp;Primary</label></span>
                                     <span>
                                        <select id="" name="CoRelation" style="width:90%;">
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

                            <h3>CoApplicant Employment Information</h3>
                          
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
                                            <input name="CoEmpYears" id="CoEmpYears" type="number" min="0" value="0" placeholder="Enter Years" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="CoEmpMonths" id="CoEmpMonths" type="number" min="0" max="11" value="0" placeholder="Enter Months" class="textbox">
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
                                                <input name="CoPreEmployerYears" id="CoPreEmployerYears" type="number"  value="0" min="0" placeholder="Enter Years" class="textbox">
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                <input name="CoPreEmployerMonths" id="CoPreEmployerMonths" type="number"  value="0" min="0" placeholder="Enter Months" class="textbox">
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


                        </div> <!-- End of "full" div -->
                    </div><!-- Toggle for CoApplicant ends -->
                   

                    <div id="PrimaryInformation" class="PrimaryInformation">
                        <div class="col-sm-9">&nbsp;</div>
                         <div class="col-sm-3">
                            <input type="submit" class="btn" id="PrimaryInformationButton" name="PrimaryInformationButton" value="Next" onclick="return CoapplicantToggleCheck();"/>
                        </div>
                    </div><!-- Toggle for Primary Information ends -->

                    <!-- ============== Step Applicant Information Ends =========================== -->
            </div>                
    </form>
</body>

</html>
