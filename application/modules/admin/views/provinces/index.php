<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProvincesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Provinces';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	@media only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px){
		/* Force table to not be like tables anymore */
		table, thead, tbody, th, td, tr{
			display: block;
			}

		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr{
			position: absolute;
			top: -9999px;
			left: -9999px;
			}

		tr{ border: 1px solid #ccc; }

		td{
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee;
			position: relative;
			padding-left: 50%;
			}

		td:before{
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
			}

		/*
		Label the data
		*/
		td:nth-of-type(1):before{ content: ""; }
		td:nth-of-type(2):before{ content: "Province"; }
		td:nth-of-type(3):before{ content: "Active"; }
		td:nth-of-type(9):before{ content: "Actions"; }
		}

	/* Smartphones (portrait and landscape) ----------- */
	@media only screen
	and (min-device-width: 320px)
	and (max-device-width: 480px){
		body{
			padding: 0;
			margin: 0;
			width: 320px; }

		#page-wrapper{
			position: absolute;
			margin-top: 50px;
			}
		}

	/* iPads (portrait and landscape) ----------- */
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px){
		body{
			width: 495px;
			}

		#page-wrapper{
			position: absolute;
			margin-top: 50px;
			}
		}

	</style>
<div class="provinces-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Provinces', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => ''],
        'columns' => [
            'name',
            'is_active',

            [
                'class'          => 'yii\grid\ActionColumn',
                'visibleButtons' => ['delete' => FALSE],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
