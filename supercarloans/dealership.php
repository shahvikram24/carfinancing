<?php
    require_once("include/files.php");
    if(isset($_POST['Finish']) && $_POST['Finish'] == 'Finish')
    {
        
        $dealership = new dealership();
        $dealership->DealershipName = ucwords($_POST['DealershipName']); 
        $dealership->DealershipPlan = $Decrypt->decrypt($_POST['DealershipPlan']); 
        $dealership->Address = $_POST['Address']; 
        $dealership->Phone = $_POST['Phone']; 
        $dealership->Email = $_POST['Email']; 
        $dealership->Fax = $_POST['Fax']; 
        $dealership->ContactName = $_POST['ContactName']; 
        $dealership->LicenceNo = $_POST['LicenceNo']; 
        $dealership->Remarks = $_POST['Remarks']; 
        $dealership->CreatedDate  = date('Y-m-d H:i:s');
        $dealership->Approve = 2; 
        $dealership->Status = 1; 
        $dealership->addDealershipInfo();

        $dealerpackages = new dealerpackages();
        $dealerpackages->AddDate = date('Y-m-d H:i:s');
        if($Decrypt->decrypt($_POST['DealershipPlan']) == 1) 
            $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+365 days")));
        else
            $dealerpackages->ExpireDate = FormatDate(date('Y-m-d H:i:s', strtotime("+30 days")));

        $dealerpackages->PlanId = $Decrypt->decrypt($_POST['DealershipPlan']);
        $dealerpackages->Term = 0;
        $dealerpackages->DealerId = $_POST['DealerId'];
        $dealerpackages->Timestamp = date('Y-m-d H:i:s');
        $dealerpackages->Status = 1;
        $DealerPackageId = $dealerpackages->InsertDealerPackage();

        header('Location:index.php?' . $Encrypt->encrypt("Message=Application received successfully. One of our dealer agent will contact you shortly."));
        exit();
    }
    $Package = new Package();
    $PackageResultSet = $Package->GetPackages(false,false,' P. Status=1 ');

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                <a class="navbar-brand" href="index.php">SuperCarLoans</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php#how-it-works">How&nbsp;does&nbsp;it&nbsp;work?</a>
                    </li>
                    <li>
                        <a href="faq.php">Faq</a>
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


    <script type="text/javascript">
        window.document.onkeydown = function (e)
        {
            if (!e){
                e = event;
            }
            if (e.keyCode == 27){
                lightbox_close();
            }
        }
        
    </script>

    
    <!-- ============================ Booking Starts =========================== -->
    <form method="post" action="dealership.php">
            <div class="contact-form" id="contact-form" style="width:65%;left:20%;">                   

                    <!-- ============== Step Applicant Information Starts =========================== -->
                     <!-- Toggle for Primary Applicant starts -->
                    <div id="PrimaryApplicantToggle" class="PrimaryApplicantToggle"> 
                         <legend>Dealership Registration</legend>
                         <h3>Dealership Information</h3>
                          
                            <div class="full">

                                <div class="col-sm-6">
                                    <span><label>&nbsp;</label></span>
                                    <span><input name="DealershipName" id="DealershipName" type="text" placeholder="Dealership Name" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><label>Dealership Plan *</label></span>
                                        <span><select id="DealershipPlan" name="DealershipPlan" >
                                        <?php 
                                            for($x = 0; $x < $PackageResultSet->TotalResults ; $x++)
                                            {
                                               
                                                    echo "<option value='". $Encrypt->encrypt($PackageResultSet->Result[$x]['Id']) ."'>".
                                                            $PackageResultSet->Result[$x]['Name']
                                                      . "</option>";
                                            }
                                        ?>                                        
                                    </select></span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <span><input name="Address" id="Address" type="text" placeholder="Address *" class="textbox" ></span>
                                </div>

                                
                                <div class="col-sm-6">
                                    <span><input name="Phone" id="Phone" type="text" placeholder="Phone Number *" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><input name="Email" id="Email" type="text" placeholder="Email Address *" class="textbox" ></span>
                                </div>
                                
                                <div class="col-sm-6">
                                    <span><input name="Fax" id="Fax" type="text" placeholder="Fax Number" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><input name="ContactName" id="ContactName" type="text" placeholder="Contact Person Name" class="textbox" ></span>
                                </div>

                                <div class="col-sm-6">
                                    <span><input name="LicenceNo" id="LicenceNo" type="text" placeholder="Dealership Licence Number" class="textbox" ></span>
                                </div>

                                <div class="col-sm-12">
                                    <span>
                                        <textarea name="Remarks" id="Remarks" placeholder="Leave your comments"></textarea>
                                        
                                    </span>
                                </div>

                                <div class="clearfix"></div>
                                


                                <div class="clearfix"></div>
                            </div> <!-- end of toggle div -->

                        <div class="col-sm-9">&nbsp;</div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn" id="Finish" name="Finish" value="Finish" />
                            </div>
                            <div class="clearfix"></div>
                    </div> <!-- Toggle for Primary Applicant ends -->
            </div>                
    </form>


    
</body>

</html>
