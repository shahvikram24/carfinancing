<?php
	
	require_once("../include/files.php");
	

if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

/*echo "<br/><br/><br/><br/><br/><br/>";
debugObj($_POST);*/

$filename = $Decrypt->decrypt($_REQUEST['filename']); 
$subject = $_REQUEST['subject']; 
//echo "<br/> filename = " . $filename . "<br/>";


if(isset($filename) && $filename!='')
{
	$Message = subscribers::sendNewsletter($filename, $subject);
	header("Location:".ADMINAPPROOT . 'newsletter.php?' . $Encrypt->encrypt("Message=".$Message."&Success=true"));
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
            		<legend>Newsletter</legend>
            		<span><label>Mange your Newsletter panel </label></span>
            	</div>

            	<?php   
                                    
		            if( isset ($Message) && $Message != "" ) 
		            { 
		                if($Success && $Success == 'true')
		                    echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
		                else
		                    echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
		            }
		         ?>


				<div class="col-lg-12" id="main-content">
					<!-- ============================================= -->
				 <form method="post" action="#" id="myForm">
					<a href="#" onclick="document.getElementById('myForm').submit();  return false;">
					<?php $link =  $Encrypt->encrypt("newsletter.html"); ?>
					<input type="hidden" name="filename" value=<?php echo $link; ?> />
					<input type="hidden" name="subject" value='Benefits of Buying a Used Car - SupeCarLoans'/>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-info">
						<div class="panel-heading">
								<div class="row">
																	
									<div class="col-xs-12">
										<div>Topic: &nbsp; Benefits of Buying a Used Car</div>
									</div>
								</div>
							</div>							
							
								<div class="panel-footer gray-gradient">
									<span class="pull-left">Send Newsletter</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							
						</div>
					</div>
					</a>
				 </form>
				 
				 <form method="post" action="#" id="myForm1">
					<a href="#" onclick="document.getElementById('myForm1').submit();  return false;">
					<?php $link =  $Encrypt->encrypt("maximizereferrals.html"); ?>
					<input type="hidden" name="filename" value=<?php echo $link; ?> />
					<input type="hidden" name="subject" value='5 Top Ways to Maximize Your Referrals - SupeCarLoans'/>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-info">
						<div class="panel-heading">
								<div class="row">
																	
									<div class="col-xs-12">
										<div>Topic: &nbsp; 5 Top Ways to Maximize Your Referrals</div>
									</div>
								</div>
							</div>							
							
								<div class="panel-footer gray-gradient">
									<span class="pull-left">Send Newsletter</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							
						</div>
					</div>
					</a>
				 </form>

				<div class="clearfix"></div>     
				</div>

			</div>
        </div>
    </div>
                        		
	 <div class="clearfix"></div>       

<?php require_once("inc/footer.php"); ?>

