<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Carloans - Admin</title>

	<!-- Bootstrap Core CSS -->
    <link href="<?php echo Yii::getAlias('@web'); ?>/admin/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
    <link href="<?php echo Yii::getAlias('@web'); ?>/admin/css/sb-admin.css" rel="stylesheet">
	<!-- Custom Fonts -->
    <link href="<?php echo Yii::getAlias('@web'); ?>/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Yii::$app->urlManager->createUrl('admin/application') ?>">Carloans Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav hidden-xs">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Yii::$app->user->identity->username;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo Yii::$app->urlManager->createUrl('admin/settings');?>"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
	                        <?php

                                use yii\helpers\Html;
                                echo Html::beginForm(['/admin/logout'], 'post');
                                echo Html::submitButton(
                                    '<i class="fa fa-fw fa-power-off"></i> Log Out',
                                    ['class' => 'btn btn-link logout']
                                );
                                echo Html::endForm();
		                        ?>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="<?php echo (Yii::$app->controller->id == 'application') ? 'active' : ''; ?>">
                        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/application');?>"><i class="fa fa-fw fa-dashboard"></i> Application</a>
                    </li>
                    <li class="<?php echo (Yii::$app->controller->id == 'provinces') ? 'active' : ''; ?>">
                        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/provinces'); ?>"><i class="fa fa-fw fa-edit"></i> Provinces</a>
                    </li>
                    <li class="<?php echo (Yii::$app->controller->id == 'pages') ? 'active' : ''; ?>">
                        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/pages'); ?>"><i class="fa fa-fw fa-edit"></i> Content</a>
                    </li>
	                <li class="visible-xs">
                            <a href="<?php echo Yii::$app->urlManager->createUrl('admin/settings'); ?>"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
	                <li class="divider"></li>
                        <li class="visible-xs">
	                        <?php
                                echo Html::beginForm(['/admin/logout'], 'post');
                                echo Html::submitButton(
                                    '<i class="fa fa-fw fa-power-off"></i> Log Out',
                                    ['class' => 'btn btn-link logout']
                                );
                                echo Html::endForm();
                            ?>
                        </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper" class="container-fluid">

            <div class="container-fluid">
                    <?= $content ?>
            </div>
	        <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo Yii::getAlias('@web'); ?>/admin/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo Yii::getAlias('@web'); ?>/admin/js/bootstrap.min.js"></script>


</body>

</html>
