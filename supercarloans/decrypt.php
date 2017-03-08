<?php
    require_once("include/files.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/faq.css">

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
                    <span class="sr-only"><span>Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Encrypt - Decrypt Portal</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    
                    <li>
                        <a href="#">Home</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

   
<form method='post'>
    
    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <h2 class="section-heading center">Debug Information</i></h2>
                    <div class="clearfix"></div>
                    
                    <div class="col-lg-12">                       
                            <input type='text' id='__txtdecrypt' name='__txtdecrypt' class="textbox form-control" />&nbsp;
                    </div>
                    <div class="col-lg-12">
                            <input type='button' id='btnEncrypt' name='btnEncrypt' value='Encrypt' onclick='EncryptDecrypt("Encrypt");'  class="btn"  /> 
                    
                            <input type='button' id='btnDecrypt' name='btnDecrypt' value='Decrypt' onclick='EncryptDecrypt("Decrypt");' class="btn" />
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <div class="features">
                            <strong>Result:</strong> <span id='lblDecryptEncrypt' style='color: Red;' ></span>
                        </div>
                       
                    </div>

            </div>

        </div>
        <!-- /.container -->

    </div>
</form>

    <!-- ============================================================= -->


    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/main.js"></script> <!-- Resource jQuery -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <script src="js/jquery.mobile.custom.min.js"></script>
    <script src="lib/ajaxJS.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script language="javascript">
    function EncryptDecrypt(Params)
    {
        
        var ReturnVal = AjaxFunction("F=3&Mode=" + Params + "&String=" + document.getElementById("__txtdecrypt").value);
        if(ReturnVal!="ERROR")
            document.getElementById("lblDecryptEncrypt").innerHTML = ReturnVal;
    }
    </script>
    
</body>

</html>
