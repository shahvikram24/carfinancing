<?php
    /* @var $this \yii\web\View */
    /* @var $content string */
    use yii\helpers\Html;
    use app\assets\AppAsset;

    AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<?php $this->title = $this->title ? $this->title : \Yii::$app->params['title'];
            $pageTitle = Html::encode($this->title); ?>
        <title><?php echo $pageTitle; ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <?php $description = (!empty($this->description)) ? $this->description : \Yii::$app->params['description']; ?>
        <meta name="description" content="<?php echo $description; ?>">
		<meta name="author" content="<?php echo \Yii::$app->params['author']; ?>">

        <!-- Schema.org markup for Google+ -->
	<meta itemprop="name" content="<?php echo $pageTitle; ?>">
	<meta itemprop="description" content="<?php echo $description; ?>">

        <!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:url" content="<?php echo \Yii::$app->request->absoluteUrl; ?>" />
	<meta name="twitter:title" content="<?php echo $pageTitle; ?>">
	<meta name="twitter:description" content="<?php echo $description; ?>">
        <!-- Twitter summary card with large image must be at least 280x150px -->

        <!-- Open Graph data -->
	<meta property="og:title" content="<?php echo $pageTitle; ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo \Yii::$app->request->absoluteUrl; ?>" />
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:site_name" content="<?php echo \Yii::$app->params['author']; ?>" />

        <!-- Favicon -->
        <?php $this->head() ?>
</head>
	<body>
<?php $this->beginBody() ?>

<?php echo $this->render('_header.php');?>

<?= $content ?>

<?php echo $this->render('_footer.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
