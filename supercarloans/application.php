<?php
    require_once("include/files.php");

    

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

        if(isset($_REQUEST['ContactInfoId']) && $_REQUEST['ContactInfoId']!='')
        {        
            $ContactInfoId = $_POST['ContactInfoId'];
            $ContactInfo = new ContactInfo();
            $ContactInfo->loadContactInfo($ContactInfoId);

            $DOB= $_POST['DYear'] . "-" . $_POST['DMon'] . "-" . $_POST['DDate'];
            //tblcontactinfo - primary applicant
            $ContactInfo->Address1 = $_POST['Address1'];
            $ContactInfo->Postal = $_POST['Postal'];
            $ContactInfo->City = $_POST['City'];
            $ContactInfo->Province = $_POST['Province'];
            $ContactInfo->SIN = $_POST['Sin'];
            $ContactInfo->DOB = FormatDate($DOB,'Y-m-d');
            $ContactInfo->MaritalStatus = $_POST['MaritalStatus'];
            $ContactInfo->Gender = $_POST['Gender'];
            $ContactInfo->ResidenceYears = $_POST['ResidenceYears'];
            $ContactInfo->ResidenceMonths = $_POST['ResidenceMonths'];
            $ContactInfo->Created = date('Y-m-d H:i:s');
            $ContactInfo->Status = 1;
            $ContactInfo->updateContactInfo();

            //echo "<br/> ContactInfo completed <br/>";

            //tblmortgage - applicant
            $Mortgage = new Mortgage();

            $MortgageId = 0;
            $Mortgage->MortgageType = "'". TypeOfHouse($_POST['TypeOfHouse']) . "'";
            $Mortgage->MortgagePayment = ($_POST['MonthlyPayment']) ? $_POST['MonthlyPayment'] : 0.00;
            $Mortgage->MortgageAmount = ($_POST['MortgageAmount']) ? $_POST['MortgageAmount'] : 0.00;
            $Mortgage->MortgageHolder = ($_POST['MortgageHolder']) ? $_POST['MortgageHolder'] : '';
            $Mortgage->MarketValue = ($_POST['MarketValue']) ? $_POST['MarketValue'] : 0.00;
            $Mortgage->Status = 1;
            $MortgageId = $Mortgage->addMortgage();

            //tblemployment - applicant
            $Employment = new Employment();
            $Employment->EmpStatusId   = $Decrypt->decrypt($_POST['EmploymentStatus']);
            $Employment->EmpTypeId   = $Decrypt->decrypt($_POST['EmploymentType']);
            $Employment->OrganizationName   = ($_POST['EmpWorkplace']) ? $_POST['EmpWorkplace'] : '';
            $Employment->JobTitle   = $_POST['EmpJobTitle'];
            $Employment->Address1   = $_POST['EmpAddress1'];
            $Employment->City   = $_POST['EmpCity'];
            $Employment->Province   = $_POST['EmpProvince'];
            $Employment->Postal   = $_POST['EmpPostal'];
            $Employment->Phone1   = $_POST['EmpPhone'];
            $Employment->EmpYears   = $_POST['EmpYears'];
            $Employment->EmpMonths   = $_POST['EmpMonths'];
            $Employment->GrossIncome   = ($_POST['GrossIncome']) ? $_POST['GrossIncome'] : 0.00;
            $Employment->OtherIncome   = ($_POST['OtherIncomeAmount']) ? $_POST['OtherIncomeAmount'] : 0.00;
            if($Decrypt->decrypt($_POST['OtherIncomeFrequency']) != '')
                $Employment->FrequencyId   = $Decrypt->decrypt($_POST['OtherIncomeFrequency']);
            else
                $Employment->FrequencyId   = 5;

            if($Decrypt->decrypt($_POST['OtherIncomeFrequency']) != '')
                $Employment->OtherIncomeTypeId   = $Decrypt->decrypt($_POST['OtherIncome']);
            else
                $Employment->OtherIncomeTypeId   = 9;

            $Employment->Status   = 1;
            $EmploymentId = $Employment->addEmployment();

            
            $PreviousEmploymentId = 0;

            if( $_POST['EmpYears'] <= 1 )
            {
                
                $PreviousEmployment = new PreviousEmployment();
                $PreviousEmployment->Name = $_POST['PreEmployer'];
                $PreviousEmployment->PrevEmpYears = $_POST['PreEmployerYears'];
                $PreviousEmployment->PrevEmpMonths = $_POST['PreEmployerMonths'];
                $PreviousEmployment->Status   = 1;
                $PreviousEmploymentId = $PreviousEmployment->addPreviousEmployment();

                //echo "<br/> PreviousEmployment completed <br/>";

            }

            $ContactId =0;
            //tblcontact - applicant 
            $Contact = new Contact();
            $Contact->ContactInfoId = $ContactInfoId;
            $Contact->MortgageId = $MortgageId ;
            $Contact->EmploymentId = $EmploymentId;
            $Contact->PreviousEmpId = $PreviousEmploymentId;
            $Contact->CreateDate = date('Y-m-d H:i:s');
            $Contact->Status = 2;
            $ContactId = $Contact->addContact();
            //////////////////////////////////////////////////////////////////////////////////////////////

            //echo "<br/> Contact completed <br/>";

            //affiliatetransaction update affiliate
            $affiliateTransaction = new AffiliateTransaction();
            if($affiliateTransaction->loadTransactionByContactInfo($_REQUEST['ContactInfoId']))
            {
                $affiliateTransaction->status = 1;
                $affiliateTransaction->description = 2;
                $affiliateTransaction->UpdateTransaction();
            }
            else{
                $affiliateTransaction->affiliateid = 0;
                $affiliateTransaction->amount = 0.00;
                $affiliateTransaction->status = 1;
                $affiliateTransaction->dateadded = date("Y-m-d H:i:s");
                $affiliateTransaction->description = 2;
            }
            header("Location: step-3.php?". $Encrypt->encrypt("ContactInfoId=".$ContactInfoId."&ContactId=".$ContactId));
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


function TypeOfHouse($Type)
    {
        
        switch($Type)
        {
            case "OW": return "Own with Mortgage"; break;
            case "OF": return "Own Free Clear"; break;
            case "RE": return "Rent"; break;
            case "PA": return "With Parents"; break;
            case "RH": return "Reserve Housing"; break;
            case "OT": return "Other"; break;
            default: return '';
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
                
            

                $("#PrimaryApplicantToggle").show();
                $("#PrimaryInformation").show();
               $("#EmpPreviousEmployer").hide();

                /* Every click functions begin */
                $("#chkCoApplicantToggle").click(function() {                    
                    $("#CoApplicantToggle").toggle();
              });
            

                $("#TypeOfHouse").click(function() {
                    var TypeOfHouse =  $(this).val();
                    
                    if(TypeOfHouse == "OW")
                    {
                        $("#ForMonthlyPayment").text("Monthly Rent/Mortgage Payment*");
                        $("#ForMortgageAmount").text("Approximate Balance owing on Mortgage*");
                        $("#ForMortgageHolder").text("Mortgage Holder*");
                        $("#ForMarketValue").text("Estimated Market Value*");

                        $('#MonthlyPayment').attr("disabled", false);
                        $('#MortgageAmount').attr("disabled", false);
                        $('#MortgageHolder').attr("disabled", false);
                        $('#MarketValue').attr("disabled", false);

                    }
                    else{
                        $("#ForMonthlyPayment").text("Monthly Rent/Mortgage Payment");
                        $("#ForMortgageAmount").text("Approximate Balance owing on Mortgage");
                        $("#ForMortgageHolder").text("Mortgage Holder");
                        $("#ForMarketValue").text("Estimated Market Value");
                        
                    }

                    if(TypeOfHouse == "OF")
                    {
                        $('#MonthlyPayment').attr("disabled", "disabled");
                        $('#MortgageAmount').attr("disabled", "disabled");
                        $('#MortgageHolder').attr("disabled", "disabled");
                        $('#MarketValue').attr("disabled", false);
                    }

                    if(TypeOfHouse == "RE" || TypeOfHouse == "PA" || TypeOfHouse == "RH" || TypeOfHouse == "OT")
                    {
                        $('#MonthlyPayment').attr("disabled", false);
                        $('#MortgageAmount').attr("disabled", "disabled");
                        $('#MortgageHolder').attr("disabled", "disabled");
                        $('#MarketValue').attr("disabled", "disabled");
                        $("#ForMonthlyPayment").text("Monthly Rent/Mortgage Payment*");
                    }

                });               

                
                $("#DYear").change(function(){
                    var day = $("#DDate").val();
                    var month = $("#DMon").val();
                    var year = $("#DYear").val();
                    var age = 18;
                    var mydate = new Date();
                    mydate.setFullYear(year, month-1, day);


                    var currdate = new Date();
                    currdate.setFullYear(currdate.getFullYear() - age);

                    if ((currdate - mydate) < 0){
                        alert("Sorry, only persons over the age of " + age + " may enter this site");
                    }
                });

                $("#EmpYears").blur(function(){
                    var years =  $('#EmpYears').val();
                    if(years <= 0)
                    {
                        $("#EmpPreviousEmployer").show();
                    }
                    else
                    {
                        $("#EmpPreviousEmployer").hide();
                    }
                });



                
            });
    </script>

    <!-- ============================ Booking Starts =========================== -->
    <form method="post" action="#">
        <input type="hidden" name="ContactInfoId" value="<?= $ContactInfoId ?>"/>
            <div class="contact-form" id="contact-form" style="width:65%;left:20%;">                   

                    <!-- ============== Step Applicant Information Starts =========================== -->
                     <!-- Toggle for Primary Applicant starts -->
                    <div id="PrimaryApplicantToggle" class="PrimaryApplicantToggle"> 
                         <legend>Application (Step 2 of 4)</legend>
                         <h3>Primary Applicant Information</h3>
                          
                            <div class="full">
                                <div class="col-sm-12">
                                    <span><input name="Address1" id="Address1" type="text" placeholder="Address *" class="textbox" ></span>
                                </div>

                                
                                <div class="col-sm-6">
                                    <span><input name="City" id="City" type="text" placeholder="City *" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><input name="Province" id="Province" type="text" placeholder="Province *" class="textbox" ></span>
                                </div>
                                
                                <div class="col-sm-6">
                                    <span><input name="Postal" id="Postal" type="text" placeholder="Postal Code" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><input name="Sin" id="Sin" type="text" placeholder="SIN Number (optional)" min="" max="" class="textbox" ></span>
                                </div>


                                <div class="col-sm-3">
                                    <span><label>&nbsp;</label></span>
                                    <span>
                                            <select id="DMon" name="DMon" style="width:80%;">
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
                                    <span><label>Date of Birth (mon-dd-yy) *</label></span>
                                        <span>
                                            <select id="DDate" name="DDate" style="width:80%;">
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
                                            <select id="DYear" name="DYear" style="width:80%;">
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
                                        <span>
                                            <select id="MaritalStatus" name="MaritalStatus" style="width:80%;">
                                                <option value=""></option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Common Law">Common Law</option>
                                                <option value="Separated">Separated</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Widow/Widower">Widow/Widower</option>
                                            </select>
                                        </span>
                                </div>
                                <div class="col-sm-2">
                                        <span><label>Gender *</label></span>
                                        <span><select id="Gender" name="Gender" style="width:80%;">
                                            <option value=""></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select></span>
                                </div>

                                <div class="col-sm-4">
                                    <span><label> Length at residence? *</label></span>
                                    
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="ResidenceYears" id="ResidenceYears" type="number" value="0" min="0" placeholder="Years" class="textbox" >
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="ResidenceMonths" id="ResidenceMonths" type="number" value="0" min="0" placeholder="Months" class="textbox" max="11" >
                                        </span>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <hr/>
                                <h3>Housing Information</h3>
                                
                                

                                <div class="col-sm-4">
                                        <span><label>Do you rent or own?</label></span>
                                        <span><select name="TypeOfHouse" id="TypeOfHouse">
                                            <option value=""></option>
                                            <option value="RE">Rent</option>
                                            <option value="OW" selected="selected">Own with Mortgage</option>
                                            <option value="OF">Own Free &amp; Clear</option>                                            
                                            <option value="PA">With Parents</option>
                                            <option value="RH">Reserve Housing</option>
                                            <option value="OT">Other</option>

                                        </select> </span>                                   
                                </div>
                                <div class="col-sm-4">
                                        <span><label id="ForMonthlyPayment">Monthly Rent/Mortgage Payment*</label></span>
                                            <span>
                                                <input name="MonthlyPayment" id="MonthlyPayment" type="text" placeholder="Enter Monthly Housing Payment" class="textbox">
                                            </span>
                                </div>
                                <div class="col-sm-4">
                                        <span><label id="ForMortgageAmount">Approximate Balance owing on Mortgage*</label></span>
                                            <span>
                                                <input name="MortgageAmount" id="MortgageAmount" type="text" placeholder="Enter Approximate Balance owing on Mortgage" class="textbox">
                                            </span>
                                </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-4">
                                        <span><label id="ForMortgageHolder">Mortgage Holder*</label></span>
                                            <span>
                                                <input name="MortgageHolder" id="MortgageHolder" type="text" placeholder="Enter Mortgage Holder" class="textbox">
                                            </span>
                                </div>
                                <div class="col-sm-4">
                                        <span><label id="ForMarketValue">Estimated Market Value*</label></span>
                                            <span>
                                                <input name="MarketValue" id="MarketValue" type="text" placeholder="Enter Market Value" class="textbox">
                                            </span>
                                </div>

                                <div class="clearfix"></div>
                            </div> <!-- end of toggle div -->

                                                  
                    </div> <!-- Toggle for Primary Applicant ends -->

                    <!-- ============== Step Applicant Employment Information Starts =========================== -->
                    <h3>Primary Employment Information</h3>
                          
                            <div class="full">
                                
                                <div class="col-sm-6">
                                        <span><label>Employment Status*</label></span>
                                        <select id="EmploymentStatus" name="EmploymentStatus" style="width:80%;">
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
                                        <select id="EmploymentType" name="EmploymentType" style="width:80%;">
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
                                    <span><label>Workplace Name*</label></span>
                                    <span><input name="EmpWorkplace" id="EmpWorkplace" type="text" placeholder="Enter Workplace Name" class="textbox"></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Job Title*</label></span>
                                    <span><input name="EmpJobTitle" id="EmpJobTitle" type="text" placeholder="Enter Employee Job Title" class="textbox" ></span>
                                </div>

                                <div class="col-sm-12">
                                    <span><label>Work Address</label></span>
                                    <span><input name="EmpAddress1" id="EmpAddress1" type="text" placeholder="Address 1" class="textbox"></span>
                                </div>

                                

                                <div class="col-sm-6">
                                    <span><label>City*</label></span>
                                    <span><input name="EmpCity" id="EmpCity" type="text" placeholder="City" class="textbox"></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Province*</label></span>
                                    <span><input name="EmpProvince" id="EmpProvince" type="text" placeholder="Procince" class="textbox"></span>
                                </div>
                                
                                <!-- <div class="col-sm-6">
                                    <span><label>Postal Code</label></span>
                                    <span><input name="EmpPostal" id="EmpPostal" type="text" placeholder="Postal Code" class="textbox"></span>
                                </div> -->

                                <div class="col-sm-6">
                                    <span><label> Length of Employment?*</label></span>
                                    
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="EmpYears" id="EmpYears" type="number" min="0" value="0" placeholder="Enter Years" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span>
                                            <input name="EmpMonths" id="EmpMonths" type="number" value="0" min="0" placeholder="Enter Months" class="textbox">
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <!-- ============================================= -->

                                <div class="col-sm-6">
                                    <span><label>Monthly Gross Income</label></span>
                                    <span><input name="GrossIncome" id="GrossIncome" type="text" placeholder="Enter Your Gross Income" class="textbox"></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Phone Number</label></span>
                                    <span><input name="EmpPhone" id="EmpPhone" type="text" placeholder="Employer Phone Number" class="textbox" ></span>
                                </div>

                                <div class="clearfix"></div>

                                <!-- ============================================= -->                                
                                <hr/>
                                <div id="EmpPreviousEmployer" class="EmpPreviousEmployer"> 
                                        <div class="col-sm-4">
                                            <span><label>Previous Employer Name*</label></span>
                                            <span><input name="PreEmployer" id="PreEmployer" type="text" placeholder="Name of Previous Employer" class="textbox"></span>
                                        </div>

                                        <div class="col-sm-4">
                                            <span><label> Length of Employment?*</label></span>
                                            
                                            <div class="col-sm-6">
                                                <span>
                                                    <input name="PreEmployerYears" id="PreEmployerYears" type="number"  value="0" min="0" placeholder="Enter Years" class="textbox">
                                                </span>
                                            </div>
                                            <div class="col-sm-6">
                                                <span>
                                                    <input name="PreEmployerMonths" id="PreEmployerMonths" type="number" value="0" min="0" placeholder="Enter Months" class="textbox">
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
                                            <input name="OtherIncomeAmount" id="OtherIncomeAmount" type="text" placeholder="Enter the Amount" class="textbox">
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="OtherIncomeFrequency" name="OtherIncomeFrequency" style="width:80%;">
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
                                        <select id="OtherIncome" name="OtherIncome" style="width:80%;">
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

                                <div class="clearfix"></div>

                                
                                </div> <!-- end of toggle div -->

                                <!-- ============================================= -->

                    <div id="PrimaryInformation" class="PrimaryInformation">
                        <div class="col-sm-9">&nbsp;</div>
                         <div class="col-sm-3">
                            <input type="submit" class="btn" id="PrimaryInformationButton" name="PrimaryInformationButton" value="Next" onclick="return PrimaryApplicantToggle();"/>
                        </div>
                    </div><!-- Toggle for Primary Information ends -->

                    <!-- ============== Step Applicant Information Ends =========================== -->
            </div>                
    </form>
</body>

</html>
