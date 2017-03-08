<?php
	
	require_once("../include/files.php");
	
echo "<script type='text/javascript' src='inc/functions.js'></script> ";


if(!isset($_SESSION['admin_id']))
{
	header("Location: index.php");
}

if(isset($_POST['change']) && $_POST['change'] == 'change')
    {
            
            
               $login = new Admin();
                $login->LoadInfo($_SESSION['admin_id']);
            

           if(Security::ChangeAdminPassword($login->Id, $_POST['NewPassword'], $_POST['CurrentPassword'])) 
            {
                
                header("Location:".ADMINAPPROOT . 'account.php?' . $Encrypt->encrypt("Message=The password has been reset successfully.&Success=true"));
            }
            else{
            	header("Location:".ADMINAPPROOT . 'account.php?' . $Encrypt->encrypt("Message=Current password did not match with the database.&Success=false"));
            	exit();
            }
       
    }


if(isset($_REQUEST['changeaccess']) && $_REQUEST['changeaccess'] == 'changeaccess')
    {
           

           if(Security::ChangeAccessCode($_REQUEST['NewCode'])) 
            {
                
                header("Location:".ADMINAPPROOT . 'account.php?' . $Encrypt->encrypt("Message=The code has been reset successfully.&Success=true"));
            }
            else{
            	header("Location:".ADMINAPPROOT . 'account.php?' . $Encrypt->encrypt("Message=Something went wrong while modifying the code.&Success=false"));
            	exit();
            }
       
    }


//debugObj($jobTitleResultSet);
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once("inc/title.php"); ?>
<script language = "Javascript">
  
function confirmPass() {
        var pass = document.getElementById("NewPassword").value;
        var confPass = document.getElementById("RepeatPassword").value;
        if(pass != confPass) {
            alert('Password did not match. Please confirm your password !');
            document.getElementById("RepeatPassword").focus();
        }
    }

    function confirmPassCode() {
        var pass = document.getElementById("NewCode").value;
        var confPass = document.getElementById("RepeatCode").value;
        if(pass != confPass) {
            alert('Access code did not match. Please confirm your code !');
            document.getElementById("RepeatCode").focus();
        }
    }
</script>



<body>
<?php require_once("inc/header.php"); ?>
<div class="content-section-a" id="how-it-works">
        <div class="container">
            <div class="row">
            	<div class="col-lg-12" id="main-content">
            		<?php   
									
					 	if( isset ($Message) && $Message != "" ) 
						{ 
						  	if($Success && $Success == 'true')
						  		echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
						  	else
						  		echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
					 	}
					 ?>
            	<!-- ============================================= -->
					<div class="col-lg-4">
							    <a href="#" class="small-tile red-back" data-toggle="modal" data-target="#newPassword">
							    	<img class="hide-sm pull-right" width="32" src="../img/options.png"/>
							        <h3 class="h3-tile">Change&nbsp;Password</h3>
							    </a>
					</div>
					<div class="col-lg-4">
					    <a class="small-tile yellow-back" href="#"  data-toggle="modal" data-target="#accesscode">
					    	<img class="hide-sm pull-right" width="32" src="../img/jobseekers.png"/>
					        <h3 class="h3-tile">Inventory&nbsp;Acces&nbsp;Code</h3>
					    </a>
					</div>
					<div class="clearfix"></div>     

				</div>



					

					
				<!-- ============================================= -->

				
				

			</div>
        </div>
    </div>
                        		
	 <div class="clearfix"></div>       

<?php require_once("inc/footer.php"); ?>


<form method="post" autocomplete="off" action="account.php">
	<div class="modal fade" id="newPassword" tabindex="-1" role="dialog" aria-labelledby="newPasswordLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="newPasswordLabel">Change your password </h4>
	      </div>
	      <div class="modal-body">	        
	        <div class="container-fluid">
		        
	        	<div class="form-group">
                    <input type="password" placeholder="Current Password" name="CurrentPassword" id="CurrentPassword" class="form-control required" autocomplete="off">
                </div>

		        <div class="form-group">
                    <input type="password" placeholder="New Password" name="NewPassword" id="NewPassword" class="form-control required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirm New Password" name="RepeatPassword" id="RepeatPassword" class="form-control required" onBlur="confirmPass();"  autocomplete="off">
                </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" id="applyNow">Change&nbsp;Password</button>
	        <input type="hidden" name="change" value="change" />
	      </div>
	    </div>
	  </div>
	</div>
</form>


 <form method="post" autocomplete="off" action="account.php">
	<div class="modal fade" id="accesscode" tabindex="-1" role="dialog" aria-labelledby="accesscodeLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="accesscodeLabel">Change your inventory access code </h4>
	      </div>
	      <div class="modal-body">	        
	        <div class="container-fluid">
		        
		        <div class="form-group">
                    <input type="password" placeholder="New Code" name="NewCode" id="NewCode" class="form-control required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirm New Code" name="RepeatCode" id="RepeatCode" class="form-control required" onBlur="confirmPassCode();"  autocomplete="off">
                </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" id="applyNow">Change&nbsp;Code</button>
	        <input type="hidden" name="changeaccess" value="changeaccess" />
	      </div>
	    </div>
	  </div>
	</div>
 </form>