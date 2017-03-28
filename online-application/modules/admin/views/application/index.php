<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Application';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">
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
		td:nth-of-type(1):before{ content: "Vehicle"; }
		td:nth-of-type(2):before{ content: "First Name"; }
		td:nth-of-type(3):before{ content: "Last Name"; }
		td:nth-of-type(4):before{ content: "Email"; }
		td:nth-of-type(5):before{ content: "Phone"; }
		td:nth-of-type(6):before{ content: "Address"; }
		td:nth-of-type(7):before{ content: "Province"; }
		td:nth-of-type(8):before{ content: "Actions"; }
		}
	/* Smartphones (portrait and landscape) ----------- */
	@media only screen
	and (min-device-width: 320px)
	and (max-device-width: 480px){
		body{
			padding: 0;
			margin: 0;
			width: 320px; }

		#page-wrapper {
			position: absolute;
			margin-top:50px;
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

    <h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => ''],
        'columns' => [
            'vehicleType.name',
            'first_name',
            'last_name',
            'email:email',
            'phone',
            'address',
            [
            	'label' => 'Status',
                'value' => function($data){
					return ($data->status == 1) ? 'finished' : 'unfinished';
                }
            ],
            'province.name',
            [
            	'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => ['delete' => false],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
