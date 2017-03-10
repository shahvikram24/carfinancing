<?php
	require_once("../include/files.php");

	session_destroy();
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
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>


<div class="form">
        
        <div id="login">   
          <h1>You have successfully logged out from the system.</h1>
          <div class="col-sm-12 center">
          	<img src="../img/security.png" class="img-responsive img-circle blue" data-bottom-top="opacity:0;" data--75-bottom="opacity:1;" alt="logout">
          </div>
          <h1><a href="login.php">Click here to Login again!</a></h1>
        </div>
      
  </div> <!-- /form -->
</body>
</html>


						