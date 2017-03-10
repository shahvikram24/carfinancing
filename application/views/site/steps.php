<?php
    use yii\helpers\ArrayHelper;
    use yii\bootstrap\ActiveForm;
	?>
<div class="container" style="margin-top: 30px;">
    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger">
        <p><?php echo \yii\bootstrap\Html::encode($error); ?></p>
    </div>
    <?php }
    else { ?>

	    <div class="container">
<div class="stepwizard">
    <div class="stepwizard-row setup-panel">
        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
            <p>Contact Information</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle disabled" disabled="disabled">2</a>
            <p>Residential Information</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle disabled" disabled="disabled">3</a>
            <p>Employment Information</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle disabled" disabled="disabled">4</a>
            <p>Finish</p>
        </div>
    </div>
</div>
	<?php $form = ActiveForm::begin([
		'action' => Yii::$app->urlManager->createUrl('submit-order'),
        'id'          => 'step-form',
		'enableAjaxValidation' => true,
		'validationUrl' => Yii::$app->urlManager->createUrl('validate-order'),
        'options' => array(
            'onsubmit'   => "return false;",/* Disable normal form submit */
            'onkeypress' => " if(event.keyCode == 13){ return false; } " /* Do ajax call when user presses enter key */
        ),
    ]); ?>
		    <?php
			    echo $form->field($oModel, 'vehicle_type_id')->hiddenInput(['value' => $vehicle])->label(FALSE);
            ?>
    <div class="row setup-content" id="step-1">
		<div class="headingWrap">
			<h3 class="text-center headingTop" style="padding-bottom:0; margin-top:0">Contact Information</h3>
			<div class="text-center">
				<?php echo $content['step_c_inf'];?>
			</div>
		</div>

		<div class="contactForm">
			<div class="col-md-12">
				<div class="col-sm-6 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'first_name',['inputOptions' => ['required' => 'required', 'style' => 'text-transform: capitalize;']])->textInput(['placeholder' => 'please enter your first name']); ?>
				</div>

				<div class="col-sm-6 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'last_name', ['inputOptions' => ['required' => 'required', 'style' => 'text-transform: capitalize;']])->textInput(['placeholder' => 'please enter your last name']); ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="col-sm-6 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'email', ['inputOptions' => ['required' => 'required']])->textInput(['placeholder' => 'please enter your email']); ?>
				</div>

				<div class="col-sm-6 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'phone', ['inputOptions' => ['required' => 'required']])->textInput(['placeholder' => 'please enter your phone']); ?>
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-sm-4 kl-fancy-form form-group">
					<?php
	                    echo $form->field($oModel, 'month_of_birth', ['inputOptions' => ['required' => 'required']])
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
	                        ], [
	                                'prompt' => 'please select your month of birth',
	                            ]
	                        )
	                ?>
				</div>

				<div class="col-sm-4 kl-fancy-form form-group">
					<?php
	                    $days = array();
	                    for ($i = 1; $i <= 31; $i++) {
	                        $days[$i] = $i;
	                    }

	                    echo $form->field($oModel, 'day_of_birth', ['inputOptions' => ['required' => 'required']])->dropDownList($days, ['prompt' => 'please select your day of birth']);
	                ?>
				</div>

				<div class="col-sm-4 kl-fancy-form form-group">
					<?php
	                    $years = array();
	                    $maxYear = date("Y") - 18;
	                    for ($i = $maxYear; $i >= 1910; $i--) {
	                        $years[$i] = $i;
	                    }
	                    echo $form->field($oModel, 'year_of_birth', ['inputOptions' => ['required' => 'required']])->dropDownList($years, ['prompt' => 'please select your year of birth']);
	                ?>
				</div>
			</div>
		</div>

		<div class="footerNavWrap clearfix">
		<a href="javascript:void(0);" class="btn btn-info pull-right btn-fyi nextBtn">Next<span class="glyphicon glyphicon-chevron-right"></span></a>
		</div>
    </div>

    <div class="row setup-content" id="step-2" style="display: none;">
		<div class="headingWrap">
			<h3 class="text-center headingTop" style="padding-bottom:0; margin-top:0">Residential Information </h3>
			<div class="text-center">
				<?php echo $content['step_r_inf']; ?>
			</div>
		</div>
		<div class="contactForm">
			<div class="col-md-12">
				<div class="col-sm-6 kl-fancy-form form-group p-field-valid">
					<?php echo $form->field($oModel, 'address', ['inputOptions' => ['required' => 'required']])->textInput(['placeholder' => 'please enter your address']); ?>
				</div>

				<div class="col-sm-6 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'postal_code', ['inputOptions' => ['required' => 'required']])->textInput(['placeholder' => 'please enter your postal code XXX-XXX']); ?>
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-sm-6 kl-fancy-form form-group ">
				<?php
                    echo $form->field($oModel, 'province_id', ['inputOptions' => ['required' => 'required']])
                        ->dropDownList(
                            ArrayHelper::map($provinces, 'id', 'name'),[
                            	'prompt' => 'please select your province',
	                        ]
                        )
                ?>
			</div>

				<div class="col-sm-6 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'city', ['inputOptions' => ['required' => 'required', 'style' => 'text-transform: capitalize;']])->textInput(['placeholder' => 'please enter your city']); ?>
				</div>
			</div>

			<div class="col-md-12">
				<div class="col-sm-4 kl-fancy-form form-group">
					<?php
                        echo $form->field($oModel, 'rent_or_own', ['inputOptions' => ['required' => 'required']])
                            ->dropDownList(
                                [
                                	'rent' => 'Rent',
                                    'own' => 'Own',
                                ], [
                                    'prompt' => 'Please select',
                                ]
                            )
                    ?>
				</div>

				<div class="col-sm-4 kl-fancy-form form-group">
					<?php
                        echo $form->field($oModel, 'residence_years', ['inputOptions' => ['required' => 'required']])
                            ->dropDownList(
                                [
                                    '1' => 'Less than 1 year',
                                    '2'  => '1 to 2 years',
                                    '3'  => '2 to 4 years',
                                    '5'  => '5 or more years',
                                ], [
                                    'prompt' => 'Please select',
                                ]
                            )
                    ?>
				</div>

				<div class="col-sm-4 kl-fancy-form form-group">
					<?php echo $form->field($oModel, 'monthly_payment', ['inputOptions' => ['required' => 'required']])->textInput(['placeholder' => 'please enter your monthly payment']); ?>
				</div>
			</div>

			<div class="footerNavWrap clearfix">
				<a href="javascript:void(0);" class="btn btn-info pull-right btn-fyi nextBtn">Next<span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
		</div>
    </div>

    <div class="row setup-content" id="step-3" style="display: none;">
	    <div class="headingWrap">
		    <h3 class="text-center headingTop" style="padding-bottom:0; margin-top:0">Employment Information</h3>
				<div class="text-center">
				<?php echo $content['step_e_inf']; ?>
			</div>
			    </div>
			<div class="contactForm">
				<div class="col-md-12">
					<div class="col-sm-6 kl-fancy-form form-group">
						<?php echo $form->field($oModel, 'company_name', ['inputOptions' => ['required' => 'required', 'style' => 'text-transform: capitalize;']])->textInput(['placeholder' => 'please enter your company/employer']); ?>
					</div>

					<div class="col-sm-6 kl-fancy-form form-group">
						<?php echo $form->field($oModel, 'job_title', ['inputOptions' => ['required' => 'required', 'style' => 'text-transform: capitalize;']])->textInput(['placeholder' => 'please enter your occupation']); ?>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-sm-6 kl-fancy-form form-group">
						<?php echo $form->field($oModel, 'work_phone', ['inputOptions' => ['required' => 'required']])->textInput(['placeholder' => 'please enter your work phone']); ?>
					</div>

					<div class="col-sm-6 kl-fancy-form form-group">
						<?php echo $form->field($oModel, 'monthly_income', ['inputOptions' => ['required' => 'required', 'onchange' => "(function(el){el.value=parseFloat(el.value).toFixed(2);})(this)"]])->textInput(['placeholder' => 'please enter your monthly income ex: 100.00']); ?>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-sm-4 kl-fancy-form form-group">
						<?php echo $form->field($oModel, 'sin_number')->textInput(['placeholder' => 'please enter your sin number']); ?>
					</div>
					<div class="col-sm-4 kl-fancy-form form-group">
						<?php
	                        $yJ = array();
	                        for ($i = 1; $i <= 35; $i++) {
	                            $yJ[$i] = $i;
	                        }

	                        echo $form->field($oModel, 'years_on_job', ['inputOptions' => ['required' => 'required']])->dropDownList($yJ, ['prompt' => 'Select years on job']);
	                    ?>
					</div>

					<div class="col-sm-4 kl-fancy-form form-group">
						<?php
	                        $months_on_job = array();
	                        for ($i = 0; $i <= 12; $i++) {
	                            $months_on_job[$i] = $i;
	                        }

	                        echo $form->field($oModel, 'months_on_job', ['inputOptions' => ['required' => 'required']])->dropDownList($months_on_job, ['prompt' => 'Select months on job']);
	                    ?>
					</div>
				</div>
				<p class="col-sm-12"><?php echo $content['step_c_footer']; ?></p>
			<div class="clear"></div>

				<div class="footerNavWrap clearfix">
					<button type="submit" class="btn btn-info pull-right btn-fyi" onclick="submitOrder(this);">Submit</button>
				</div>
    </div>
    </div>
    <div class="row setup-content" id="step-4" style="display: none;">
		<h3 class="static-content__subtitle sc-subtitle--centered text-center ">
				<span class="fw-semibold upperxa ">Thank You!</span>
				<div id="thanks-message"></div>
			</h3>
    </div>

<?php ActiveForm::end();?>

		    <script>

			    function submitOrder(elem){
					var oForm = $(elem).closest('form#step-form');
					var oFormData = $(oForm).serialize();
					var oFormUrl = $(oForm).attr('action');

					$.ajax({
					    type: 'POST',
						dataType: 'json',
						url: oFormUrl,
						data: oFormData,
						beforeSend: function(){
							$(elem).addClass('disabled');
						},
						success: function (data) {
                            $(elem).removeClass('disabled')
							if(typeof(data) != 'undefined'){
							    if(typeof(data.type) != 'undefined') {
							        if(data.type == 'success'){
                                        $('div.setup-panel div a[href="#step-1"]').addClass('disabled');
                                        $('div.setup-panel div a[href="#step-2"]').addClass('disabled');
                                        $('div.setup-panel div a[href="#step-3"]').addClass('disabled');
                                        $('div.setup-panel div a[href="#step-4"]').removeClass('disabled');
                                        $('div.setup-panel div a[href="#step-4"]').removeAttr('disabled').trigger('click');
										$('div#thanks-message').html(data.msg);
							        } else {
                                        swal("Error...", data.msg, 'error');
							        }
							    }
							}
                        },
                        error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            swal("Error...", msg, 'error');
                        }

					})
			    }

		    </script>
</div>
    <?php } ?>
</div>