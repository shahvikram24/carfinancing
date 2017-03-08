<?php

		require_once("../include/files.php");
		
if(isset($_SESSION['admin_id']))
{
	header("Location: dashboard.php");
}


if( isset($_POST['submit']) && $_POST['submit'] == 'Login' )   
{   

	
	if(Security::AuthorizeAdmin($_POST['username'],$_POST['password']))
	{
		header("Location: dashboard.php");
	}
	else
	{
		$msg="Invalid username / Password";
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SupeCarLoans | Admin </title>

<!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/landing-page.css" rel="stylesheet">
    <link href="../css/simple-line-icons.css" rel="stylesheet">
    

    <!-- Custom Fonts -->
    <link href="../font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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




  
  <!-- Header -->
    <div class="content-section-a">

        <div class="container">

            <div class="contact-form" id="contact-form">
				<form name="login_form" method="post">
					<legend>Login Form</legend>
						<div class="full">
							<?php   
								if( isset ($msg) && $msg != "" ) 
								{ 
							?>
							  <div class="col-sm-12" style="color:red;"><?php echo $msg; ?></div>

							 <?php
							 	}
							 ?>
							<div class="col-sm-12">
								<input type="text" placeholder="Username" required="" id="username" name="username"/>
							</div>
							<div class="col-sm-12">
								<input type="password" placeholder="Password" required="" id="password" name="password"/>
							</div>
							<div>
								<input name="submit" type="submit" value="Login" onclick="return Validate();"/>
								<!-- <a href="#">Lost your password?</a>
								<a href="#">Register</a> -->
							</div>
						</div>
				</form><!-- form -->
			</div>
		</div>
	</div>
</body>
</html>

