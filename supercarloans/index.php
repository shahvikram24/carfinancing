<?php
    require_once("include/files.php");

    
   $ContactInfo = new ContactInfo();

    if(isset($_POST['service']) && $_POST['service'] == 'Submit')
    {
        
         $ContactInfo->FirstName = $_POST['FirstName'];
         $ContactInfo->LastName = $_POST['LastName'];
         $ContactInfo->Email = $_POST['EmailAddress'] ;
         $ContactInfo->Phone1 = $_POST['Phone'];
         $ContactInfo->Created = date('Y-m-d H:i:s');
         $ContactInfo->Status = 3;
         
         
           
            $ContactInfoId = $ContactInfo->addContactInfo();
            $_SESSION['ContactInfoId'] = $ContactInfoId;
            
           

            if($_POST['Referral'] !='' && Affiliate::AffiliateExists($_POST['Referral']))
            {
                $affiliate = new Affiliate();
                $affiliate->loadAffiliateByCode("code like '".$_POST['Referral'] . "'");

                $affiliateTransaction = new AffiliateTransaction();
                $affiliateTransaction->affiliateid = $affiliate->affiliate_id;
                $affiliateTransaction->contactinfoid = $ContactInfoId;
                $affiliateTransaction->description = 1;
                $affiliateTransaction->amount = 0.00;
                $affiliateTransaction->dateadded = date("Y-m-d H:i:s");
                $affiliateTransaction->status = 3;

                $affiliateTransaction->addTransaction();

                
            }

            // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= "From: no-reply@supercarloans.ca" .  "\r\n";
            $mailObj = new Email(ADMINEMAIL, "no-reply@supercarloans.ca", "New Lead From Super Car Loans Website");

            $baseStr .= "<br/>Name: ".$_POST['FirstName'] . " " .$_POST['LastName'];
            $baseStr .= "<br/>Email: ".$_POST['EmailAddress'];
            $baseStr .= "<br/>Phone: " . $_POST['Phone'];
            

            $mailObj->TextOnly = false;
            $mailObj->Headers = $headers;

            $mailObj->Content = $baseStr; 

            $mailObj->Send();

            header("Location: application.php");
            exit();      
    }

    

        
        
        $path_info = parse_path();
        
        if ($path_info['call_parts'][0])
            $Referral = $path_info['call_parts'][0];
        else
            $Referral = '';

        
    
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   

    <title>SuperCarLoans, Canada&#39;s Auto Financing &amp; Car Loan Experts</title>
    <meta name="description" content="SuperCarLoans is Canada&#39;s leading provider of auto car loans and vehicle financing options. It's quick and easy: Apply, Get Approved, Get a car" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

   
    <script type="text/javascript" src="js/jquery.cycle2.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>

</head>

<body>
    <?php 
        if(isset($Message) && $Message !='')
        {
    ?>

        <div class="content-section-b" style="padding-top:40px;padding-bottom:0px;">
            <div class="container">
                <div class="row center">
                    <h3 class="center"><?= $Message ?></h3>
                </div>
                <div id="fade" onClick="lightbox_close();"></div>
            </div>
        </div>
    <?php } ?>
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

    

	<!-- Header -->
    <div class="intro-header">

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Get Approved Today! Good Credit, Bad Credit, No Credit Car Loans</h1>
                        <h3> Super Fast, Super Easy... SuperCarLoans.ca</h3>
                        <!-- <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="https://twitter.com/websuiteprocrm" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/rave.edm.3?fref=ts" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/web-suite-pro" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.intro-header -->
	
	<div class="content-section-b"  id="how-it-works">
        <div class="container">
            <div class="row center">
                <h2 class="section-heading center">SuperCarLoans - Finance Application</h2>
                <p class="lead center">Our financing process is very simple. Start by filling out our easy credit application, phoning us at <strong>1-780-483-7516 </strong> or emailing <strong>info@supercarloans.ca</strong></p>
                <ul class="list-inline intro-social-buttons">
                    <li>
                        <a href="#" onclick="lightbox_open();" class="btn btn-default btn-lg"><i class="fa fa-car fa-fw"></i> <span class="network-name">Get Approved Now</span></a>
                    </li>
                </ul>
            </div>
            <div id="fade" onClick="lightbox_close();"></div>
        </div>
    </div>

    <div class="content-section-a" id="about">

        <div class="container">

            <div class="row">
                <h2 class="section-heading center">About Super Car Loans</h2>
                    <div class="col-lg-12">
                        <div class="features">
                            <!-- Main Title -->
                            <p>Super Car Loans is a Canadian owned company whose main objective is to help people with challenging credit, or no credit, get approved for vehicle financing though certified car dealerships in their area.  These Dealer Partners will help Applicants find the right vehicle to suit their budget, and help them rebuild and strengthen their credit.</p>

                            <p>Super Car Loans partner only with certified car dealerships, which have legitimate lending programs with various national banks and car financing companies.  We are strongly committed to protect your privacy through our highly secure website, and provide you with an unmatched level of customer service.</p>
                            <!-- Main Text -->
                        </div>
                        <!-- End Main Points -->
                    </div>
                    
            </div>

        </div>
        <!-- /.container -->

    </div>


    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <h2 class="section-heading center">3 Super Easy Steps</h2>
                <p class="lead center">How does it work? </p>
                <div class="clearfix"></div>
                <div class="col-lg-5 col-sm-6">
                   
                    <!-- How It Works List -->
                                    <ul class="steps-list">
                                        <li>
                                            <span>1</span><!-- Step Number -->
                                            <h4><a href="#" onclick="lightbox_open();" >Online Finance Application</a></h4>
                                            <!-- Step Title -->
                                            <p>Fill out our 2-minute simple online Finance Application. NO SIN# required.!</p>
                                            <!-- Step Description -->
                                        </li>
                                        
                                        <li>
                                            <span>2</span>
                                            <h4>Verify Your Contact Information</h4>
                                            <p>Verify your contact information by clicking a link sent to your email or by our text 
                                                message option.</p>

                                        </li>
                                        <li>
                                            <span>3</span>
                                            <h4>Congratulations... Your Approved!</h4>
                                            <p>One of our Friendly Dealer Affiliates will contact you, often within hours, 
                                                with your Approval details and info on the vehicle you want. 
                                               You will receive the full details of your approval with an interest rate ranging 
                                               from prime to sub-prime. Interest rates are based on your credit rating.</p>

                                        </li>
                                    </ul>
                                    <!-- End How It Works List -->

                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="img/Mids1.jpg" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>

    
	
	<div class="content-section-b"  id="how-it-works">
        <div class="container">
            <div class="row center">
                <h2 class="section-heading center">SuperCarLoans - Finance Application</h2>
                <p class="lead center">Our financing process is very simple. Start by filling out our easy credit application, phoning us at <strong>1-780-483-7516 </strong> or emailing <strong>info@supercarloans.ca</strong></p>
                <ul class="list-inline intro-social-buttons">
                    <li>
                        <a href="#" onclick="lightbox_open();" class="btn btn-default btn-lg"><i class="fa fa-car fa-fw"></i> <span class="network-name">Get Approved Now</span></a>
                    </li>
                </ul>
            </div>
            <div id="fade" onClick="lightbox_close();"></div>
        </div>
    </div>

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <h2 class="section-heading center">Whether GOOD, BAD or UGLY Credit, We'll get you APPROVED.</h2>
                <p class="lead center">New to Canada? Bankruptcy? New Job?... NO PROBLEM! </p>
                    <div class="clearfix"></div>
                    <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                        <div class="features">
                            <!-- Main Points -->
                            <i class="blue fa fa-fw fa-shield"></i><!-- Main Point Icon -->
                            <h3>Bad Credit? No Credit? No Problem!</h3>
                            <!-- Main Title -->
                            <p>Our Lender Affiliates have programs available for ALL credit situations.  
                                Zero ($0.00) down payment options available.</p>
                            <!-- Main Text -->
                        </div>
                        <!-- End Main Points -->
                        <div class="features">
                            <i class="blue fa-fw fa fa-plane"></i>
                            <h3>New to Canada? No Worries!</h3>
                            <p>If you are a New Permanent Resident of Canada or are here on a Canadian work visa, our Lenders have finance options available to get you driving quickly with the right car for your budget.  Even if you have no credit as yet, or just started a new job in Canada, you may qualify for a low interest rate car loan.</p>
                        </div>
                        <div class="features">
                            <i class="blue fa-fw fa fa-bank"></i>
                            <h3>Bankruptcy? No Worries!</h3>
                            <p>Whether you have been recently discharged from Bankruptcy or are currently in a Consumer Debt Proposal program, our Lenders have the right finance options to help get you into a vehicle quickly and help rebuild your credit.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                        <img class="img-responsive" src="img/Mids2.jpg" alt="">
                    </div>
            </div>

        </div>
        <!-- /.container -->

    </div>

    <div class="content-section-b"  id="how-it-works">
        <div class="container">
            <div class="row center">
                <h2 class="section-heading center">SuperCarLoans - Finance Application</h2>
                <p class="lead center">Our financing process is very simple. Start by filling out our easy credit application, phoning us at <strong>1-780-483-7516 </strong> or emailing <strong>info@supercarloans.ca</strong></p>
                <ul class="list-inline intro-social-buttons">
                    <li>
                        <a href="#" onclick="lightbox_open();" class="btn btn-default btn-lg"><i class="fa fa-car fa-fw"></i> <span class="network-name">Get Approved Now</span></a>
                    </li>
                </ul>
            </div>
            <div id="fade" onClick="lightbox_close();"></div>
        </div>
    </div>

	<!-- ============================================================= -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <h2 class="section-heading center">Frequently Asked Questions</h2>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="features">
                            <!-- Main Points -->
                            <i class=" blue fa fa-fw fa-question-circle"></i><!-- Main Point Icon -->
                            <h3>Do I need any down payment?</h3>
                            <!-- Main Title -->
                            <p class="pfaq">A down payment is not mandatory in most cases but may be needed to bridge the gap between the 
                                total amount you are approved for and the actual price of the car you want.  </p>
                            <!-- Main Text -->
                        </div>
                        <!-- End Main Points -->
                        
                        <div class="features">
                            <i class="blue fa-fw fa fa-question-circle"></i>
                            <h3> Do You Accept Trades?</h3>
                            <p class="pfaq">Yes. Our Dealer Partners will gladly accept your current vehicle as trade and 
                                payout any balance owed to your previous lender.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="features">
                            <i class="blue fa-fw fa fa-question-circle"></i>
                            <h3>Will this Application cost me anything?</h3>
                           <p class="pfaq">
                                The Service we Provide is ABSOLUTELY FREE to all ALL Applicants and there are no cancellation fees WHATSOEVER.
                            </p>
                        </div>
                        <div class="features">
                            <i class="blue fa-fw fa fa-question-circle"></i>
                            <h3>I have no credit. What are my Options?</h3>
                            <p class="pfaq">
                                Our Dealer Affiliates have Lenders that have programs designed to accommodate credit ‘first-timers’. 
                                No Worries!
                            </p>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    


                    <div class="container">
                        <div class="row center">
                            <h2 class="section-heading center">Get Approved Today</h2>
                            <ul class="list-inline intro-social-buttons">
                                <li>
                                    <a href="#" onclick="lightbox_open();" class="btn btn-default btn-lg"><i class="fa fa-car fa-fw"></i> <span class="network-name">Apply Now</span></a>
                                </li>
                            </ul>
                        </div>
                        <div id="fade" onClick="lightbox_close();"></div>
                    </div>
    

            </div>

        </div>
        <!-- /.container -->

    </div>
	
    
	
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="#home">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="affiliate.php">Referral&nbsp;Program</a>
                        </li> 
                        <!-- <li class="footer-menu-divider">&sdot;</li>
                        
                        <li>
                            <a href="dealership.php">Dealership</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li> -->
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy; Supercarloans.ca. All Rights Reserved | Powered By: 
                      <a href="http://www.snowballmedia.com" target="_blank">Snowball Media</a></p>
                </div>
            </div>
        </div>
    </footer>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


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
        function lightbox_open(){
            window.scrollTo(0,0);
            document.getElementById('contact-form').style.display='block';
            document.getElementById('fade').style.display='block';  
        }

        function lightbox_close(){
            document.getElementById('contact-form').style.display='none';
            document.getElementById('fade').style.display='none';
        }
    </script>

    
</script>


    <script>
            jQuery(document).ready(function($) {
                $(".full").hide();
                $(".full").first().show();
                 $(".contact-form").hide();

                $(".greenalert").click(function() {
                    $(".full").hide();
                    $(this).parent().next(".full").show();
              });
            });
    </script>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-69038907-1', 'auto');
      ga('send', 'pageview');

    </script>

    

    <!-- ============================ Booking Starts =========================== -->

    <div class="contact-form" id="contact-form">
          <form method="post" action="#">
            <input type='hidden' name='Referral' value='<?= $Referral ?>' />
            <!-- ============================================= -->
              <legend>APPLY Now! It's Fast</legend>
              
                <div class="full">
                    <div class="col-sm-12">
                            <input name="FirstName" type="text" placeholder="Enter First Name" class="textbox" value="" required>
                    </div>

                   <div class="col-sm-12">
                        <input name="LastName" type="text" placeholder="Enter Last Name" class="textbox" value="" required>
                    </div>

                    <div class="col-sm-12">
                        <input name="EmailAddress" type="email" placeholder="Enter Email Address" class="textbox" value="" required>
                    </div>

                    <div class="col-sm-12">
                        <input name="Phone" type="text"  placeholder="Enter Phone Number" class="textbox" value="" required>
                    </div>
                    
                <div class="clearfix"></div>
                <div>
                    <input type="submit" class="btn" name="service" value="Submit" />
                </div>
                </div> <!-- end of toggle div -->

                <!-- =====================  Applicant Employer Information ======================= -->

                
               
            <!-- ============================================= -->

        </form>
                    
    </div>




</body>

</html>
