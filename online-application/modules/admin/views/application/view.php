<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Application */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Application', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">
        <?php echo Html::beginForm(['/admin/application/delete?id=' . $model->id], 'post');
        echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary', 'style' => 'padding-right: 15px;margin-right:20px;']);
            echo Html::submitButton(
                '<i class="fa fa-trash"></i> Delete',
                [
                    'class' => 'btn btn-danger',
                    'onclick' => "return confirm('Are you sure you want to delete this item?');",
                ]
            );
            echo Html::endForm(); ?>
<?php
	$aView = array();
	foreach($model as $k => $row) {
		$aView[$k] = $row;
		$aView['vehicle'] = $model->vehicleType->name;
		$aView['birth_day'] = date("F j, Y", strtotime($model->year_of_birth . '-' . $model->month_of_birth . '-' . $model->day_of_birth));
		$aView['full_name'] = $model->first_name . ' ' . $model->last_name;
		$aView['province'] = (!empty($model->province->name)) ? $model->province->name : '(not set)';
	}
	?>
    <?= DetailView::widget([
        'model' => $aView,
        'attributes' => [
            'vehicle',
            'full_name',
            'email:email',
            'phone',
            'birth_day',
            'address',
            'postal_code',
            'province',
            'city',
            'rent_or_own',
            'residence_years',
            'monthly_payment',
            'company_name',
            'job_title',
            'work_phone',
            'monthly_income',
            'sin_number',
            'years_on_job',
            'months_on_job',
        ],
    ]) ?>

</div>
