<?php

		require_once("../include/files.php");
		
if(isset($_SESSION['affiliate_id']))
{
	header("Location: dashboard.php");
}



if( isset($_POST['LostPassword']) && $_POST['LostPassword'] == 'AddIt' )
{  
	if(Security::CheckUserExistsByLogin($_POST['username'], ' AND STATUS IN (1)')) 
    {
    	$login = new Affiliate();
    	$login->loadAffiliateByCode("email like '".$_POST['username'] . "'");
    	$Encryption = $Encrypt->encrypt('affiliate_id=' . $login->affiliate_id . '&ExpireDate=' . date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") + 2, date("Y"))) . '&ResetAccount=true');
    	
    	if($login->sendRecoverPasswordLink($login->email,$Encryption))
    	{
    		header("Location:".AFFILIATEURL . 'index.php?' . $Encrypt->encrypt("Message=Check your e-mail for the confirmation link.&Success=true"));
    		exit();
    	}
    }
    else{
    	header("Location:".AFFILIATEURL . 'index.php?' . $Encrypt->encrypt("Message=User does not exist.&Success=false"));
    		exit();
    }

}


if( isset($_POST['submit']) && $_POST['submit'] == 'Login' )   
{   
	//echo "<br/>===================== 1454 <br/>"; 
	
	if(Security::Authorize($_POST['username'],$_POST['password']))
	{
		header("Location: account.php");
	}
	else
	{
		$Message="Invalid username / Password";
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SupeCarLoans | Affiliate </title>

<!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/normalize_login.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    

    <!-- Custom Fonts -->
    <link href="../font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
	<script src="../js/index.js"></script>

<script language = "Javascript">
  
function Validate()
{

    if (document.login_form.username.value == '') 
    {
        alert('Please fill in your username!');
        return false;
    }
    if (document.login_form.password.value == '') 
    {
       alert('Please fill in your password!');
      return false;
    }

    return true;
}
</script>


</head>

<body>

    <div class="form">
      
      <ul class="tab-group">
        <li class="tab"><a href="../index.php">Home</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
        <li class="tab"><a href="signup.php">Register</a></li>
      </ul>
      
      
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          <?php   
                                    
            if( isset ($Message) && $Message != "" ) 
            { 
                if($Success && $Success == 'true')
                    echo '<div class="col-sm-12" style="color:green;">'.  $Message . '</div>';
                else
                    echo '<div class="col-sm-12" style="color:red;">'.  $Message . '</div>';
            }
         ?>
          <form name="login_form" method="post">
          
           	  <div class="field-wrap">
	            <input type="text" placeholder="Email address" required="" id="username" name="username"/>
	          </div>
          
	          <div class="field-wrap">
	            <input type="password" placeholder="Password" required="" id="password" name="password"/>
	          </div>
          
	          <p class="forgot"><a href="" data-toggle="modal" data-target="#lostPassword">Forgot Password?</a></p>
	          
	          <button name="submit" type="submit" value="Login" class="button button-block" onclick="return Validate();" >Login</button>
          
          </form>

        </div>
        
      
      
	</div> <!-- /form -->
    
    
<form method="post" autocomplete="off" action="index.php">
  <div class="modal fade" id="lostPassword" tabindex="-1" role="dialog" aria-labelledby="lostPasswordLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="lostPasswordLabel">Please enter your username or email address. 
                      <br/>You will receive a link to create a new password via email.
          </h4>
        </div>
        <div class="modal-body">          
              <div class="container-fluid">
              <div class="row">
                
                <input type="text" class="form-control" id="job-Location" name="username" placeholder="Enter your username here:" autocomplete="off" required>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="applyNow">Get&nbsp;New&nbsp;Password</button>
          <input type="hidden" name="LostPassword" value="AddIt" />
        </div>
      </div>
    </div>
  </div>
</form>
    
  </body>
</html>