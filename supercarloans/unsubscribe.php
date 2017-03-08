<?php
	
	require_once("include/files.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
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

    

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/functions.js"></script>
    

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>



    
    <!-- ============================ Booking Starts =========================== -->
    <form method="post" action="#">
            <div class="contact-form" id="contact-form" style="width:30%;left:20%;border:1px solid black;padding-bottom:10px;">                   

                    <!-- ============== Step Applicant Information Starts =========================== -->
                     <!-- Toggle for Primary Applicant starts -->
                    	
                    		<?php   
                                    
					            if( isset ($Message) && $Message != "" ) 
					            { 
					                if($Success && $Success == 'true')
					                    echo '<legend>Thank You</legend>
                         					<h3>'. $Message . '</h3></div>';
					                
					            }
					         ?>
				<?php
					if(isset($Unsubscribe) && $Unsubscribe == 'true' && isset($subscriberId) && $subscriberId !='')
					{
				?>
                    	 <input type='hidden' name='subscriberId' value='<?= $subscriberId ?>' />
                         <legend>Confirm Unsubscription</legend>
                         <h3>Are you sure you want to unsubscribe from this list?</h3>
                          
                            <div class="col-sm-2">
                                <span>
                                    <input type="radio" id="" name="answer" value="yes" checked/> Yes
                                </span>
                           </div>
                           <div class="col-sm-2">
                                <span>
                                    <input type="radio" id="" name="answer" value="no"/> No
                                </span>
                           </div>
                           <div class="clearfix"></div>
                       		
                            <div class="col-sm-3">
                                <input type="submit" class="btn" id="Submit" name="Submit" value="Submit" />
                            </div>
                            <div class="clearfix"></div>
                    <?php 
					}
					?>

            </div>                
    </form>


    
</body>

</html>

<?php

if( isset($_POST['Submit']) && $_POST['Submit'] == 'Submit' )   
{

	
	if($_POST['answer'] == 'yes')
	{
		if(subscribers::unSubscribe($_POST['subscriberId'],0))
			$Message = 'We are sorry to see you go. Please give us 1-2 days to remove you from our mailing list ';

	}	
	else if($_POST['answer'] == 'no')
	{
		if(subscribers::unSubscribe($_POST['subscriberId'],1))
			$Message = 'You havent unsubscribed from our mailing list.';	
	}
	else
		$Message = 'You havent unsubscribed from our mailing list.';	

	
	header("Location:".APPROOT . 'unsubscribe.php?' . $Encrypt->encrypt("Message=".$Message."&Success=true"));
}

?>