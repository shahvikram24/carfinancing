<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;

    $this->title = 'Change Password';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div id="page-wrapper" class="container-fluid" style="width: 90%;">

            <div class="container-fluid">
	            <?php if(!empty($success)){ ?>
		            <div class="alert alert-success">
  <strong>Success!</strong> <?php echo $success;?>
</div>
	            <?php } else { ?>
	            <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to change password :</p>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>

	            <div class="form-group">
            <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
        </div>
                <?php ActiveForm::end(); ?>
            </div>
	            <?php } ?>

</div>