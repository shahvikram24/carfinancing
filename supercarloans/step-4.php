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



    if(isset($_POST['Finish']) && $_POST['Finish'] == 'Finish')
    {

        if(isset($_REQUEST['ContactId']) && $_REQUEST['ContactId']!='')
        {    
            $ContactInfoId = $_REQUEST['ContactInfoId'];
            $ContactId = $_REQUEST['ContactId'];
            $ContactInfo = new ContactInfo();
            $ContactInfo->loadContactInfo($ContactInfoId);

            
            if($ContactInfo->Email !='')
                {
                    $VerifyManual = APPROOT.'info.php?' . $Encrypt->encrypt('ContactId='.$ContactId.'&Verify=true');
                    $Name = $ContactInfo->FirstName . " " . $ContactInfo->LastName;

                    ContactInfo::ConfirmAccount($ContactInfo->Email,$VerifyManual,$Name);
                }
                

            session_unset();
            session_destroy();
            session_write_close();
            header('Location:index.php?' . $Encrypt->encrypt("Message=Congratulations. Now sit back, relax and wait for your approval phone call."));
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

    
    <!-- ============================ Booking Starts =========================== -->
    <form method="post" action="#">
        <input type="hidden" name="ContactInfoId" value="<?= $ContactInfoId ?>"/>
        <input type="hidden" name="ContactId" value="<?= $ContactId ?>"/>
        
            <div class="contact-form" id="contact-form" style="width:65%;left:20%;">                   

                    <!-- ============== Step Privacy/Consent Starts =========================== -->

                    <!-- Toggle for Privacy starts -->
                    <div id="PrivacyToggle" class="PrivacyToggle"> 
                         <legend>Application (Step 4 of 4)</legend>
                         <h3>Terms and Conditions</h3>
                          
                            <div class="full">
                                <div class="col-sm-12">
                                        <span><label>
                                        supercarloans.ca website is a Division of 1292709 Alberta Ltd.  All the services provided through this website are done by members/agents of 1292709 Alberta Ltd.  Your participation on this website and use of the services provided, signifies that you are in full and complete agreement of all of the Terms and Condition herein and constitutes a legally binding contract between you (USER) and supercarloans.ca (THE SITE). All other rights that are not currently expressed in our Terms and Conditions are hereby reserved by supercarloans.ca and 1292709 Alberta Ltd.
                                        supercarloans.ca (SCL.ca) reserves the right to update the terms and conditions of  THE SITE for any reason, at any time and without advance notice to the USER and cannot be held liable for any addition, deletion, or modification of  our terms and/or the services provided.  You are responsible to review the terms and conditions periodically to ensure that you are in Acceptance of any modifications to the Terms and Conditions.  Your continued use of THE SITE will imply that you are still in acceptance of all Terms and Conditions.
                                    </label></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>  

                            <h3>Your Usage of THE SITE</h3>
                          
                            <div class="full">
                                <div class="col-sm-12">
                                        <span><label>
                                        Once you Agree to the Terms and Conditions you will be granted individual and personal and use of all the features of site to assist you in the car buying process.  Any commercial use of this website, or copying, or re-distribution or subletting of any its services or data, whether for compensation or for free, is prohibited without expressed written consent of SCL.ca.
                                    </label></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>  


                         <h3>Disclosure & Privacy Notice</h3>
                          
                            <div class="full">
                                <div class="col-sm-12">
                                        <span><label>
                                        By checking this box, I consent to the collection, use and disclosure of my personal information 
                                        as described in this paragraph. I agree that the personal information provided above may be used 
                                        and disclosed by SuperCarLoans and/or its agents or service providers 
                                        (collectively, the "Dealer") as necessary to obtain credit, financial and related personal 
                                        information (including a credit or consumer information report) about me from any credit 
                                        bureau or credit reporting agency, and to advise me on credit availability in connection 
                                        with product and/or service purchase financing. I further agree that the personal information 
                                        provided above may be disclosed to the provider of Dealer’s website hosting or related services 
                                        for the purpose of enabling Dealer to access my personal information for marketing purposes. 
                                        Personal information I provide and credit information obtained may also be retained by Dealer 
                                        and used to facilitate the application process should I subsequently choose to apply for 
                                        credit through Dealer.
                                    </label></span>
                                </div>
                                <div class="clearfix"></div>
                                   <div class="col-sm-12">
                                        <span>
                                            <input type="checkbox" id="AgreeTerms" disabled checked readonly/> I have read and agree to the Terms & Conditions above. 
                                        </span>
                                   </div>
                            </div> 

                    </div> <!-- Toggle for Privacy ends -->

                    <!-- Toggle for Privacy Buttons starts -->
                    <div id="Privacy" class="Privacy">
                        
                        <div class="col-sm-9">&nbsp;</div>
                         <div class="col-sm-3">
                            <input type="submit" class="btn" id="Finish" name="Finish" value="Finish" />
                        </div>
                    </div><!-- Toggle for Privacy Buttons ends -->

                    <!-- ============== Step Privacy/Consent Ends =========================== -->
            </div>                
    </form>
</body>

</html>
