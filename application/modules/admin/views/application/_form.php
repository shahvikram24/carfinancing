<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'vehicle_type_id')->dropDownList($vehicles, array('options' => array($model->vehicle_type_id => array('selected' => TRUE)))); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	<?php
        echo $form->field($model, 'month_of_birth')
            ->dropDownList([
                '1'  => 'January',
                '2'  => 'February',
                '3'  => 'March',
                '4'  => 'April',
                '5'  => 'May',
                '6'  => 'June',
                '7'  => 'July',
                '8'  => 'August',
                '9'  => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December',
            ], array('options' => array($model->month_of_birth => array('selected' => TRUE)))
            )
    ?>

    <?php
        $days = array();
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }

        echo $form->field($model, 'day_of_birth')->dropDownList($days, array('options' => array($model->day_of_birth => array('selected' => TRUE))));
    ?>

    <?php
        $years = array();
        for ($i = 2005; $i >= 1910; $i--) {
            $years[$i] = $i;
        }
        echo $form->field($model, 'year_of_birth')->dropDownList($years, array('options' => array($model->year_of_birth => array('selected' => TRUE))));
    ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'province_id')->dropDownList($provinces, array('options' => array($model->province_id => array('selected' => TRUE)))); ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

	<?php
        echo $form->field($model, 'rent_or_own')
            ->dropDownList(
                [
                    'rent' => 'Rent',
                    'own'  => 'Own',
                ], array('options' => array($model->rent_or_own => array('selected' => TRUE)))
            )
    ?>
	<?php
        echo $form->field($model, 'residence_years')
            ->dropDownList(
                [
                    '1' => 'Less than 1 year',
                    '2' => '1 to 2 years',
                    '3' => '2 to 4 years',
                    '5' => '5 or more years',
                ], array('options' => array($model->residence_years => array('selected' => TRUE)))
            )
    ?>

    <?= $form->field($model, 'monthly_payment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'monthly_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sin_number')->textInput(['maxlength' => true]) ?>

    <?php
        $yJ = array();
        for ($i = 1; $i <= 35; $i++) {
            $yJ[$i] = $i;
        }

        echo $form->field($model, 'years_on_job')->dropDownList($yJ, array('options' => array($model->years_on_job => array('selected' => TRUE))));
    ?>
	<?php
        $months_on_job = array();
        for ($i = 0; $i <= 12; $i++) {
            $months_on_job[$i] = $i;
        }

        echo $form->field($model, 'months_on_job')->dropDownList($months_on_job, array('options' => array($model->months_on_job => array('selected' => TRUE))));
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
