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


<script>
	$(document).ready(function () {

        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function () {
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'],select,input[type=email]"),
                isValid = true;

            switch (curStepBtn){
	            case 'step-1':
	            case 'step-2':
	            case 'step-3':
                    $(".form-group").removeClass("has-error");
                    for (var i = 0; i < curInputs.length; i++) {
                        if (!curInputs[i].validity.valid) {
                            isValid = false;
                            $(curInputs[i]).closest(".form-group").addClass("has-error");
                        }
                    }
	                break;
	            case 'step-4':
                    $('div.setup-panel div a[href="#step-1"]').addClass('disabled');
                    $('div.setup-panel div a[href="#step-2"]').addClass('disabled');
                    $('div.setup-panel div a[href="#step-3"]').addClass('disabled');

	                break;
            }

            if (isValid)
                nextStepWizard.removeClass('disabled');
                nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-primary').trigger('click');
    });

    $(function () {
        var showcase = $("#vehicle-picker");
        showcase.Cloud9Carousel({
            yPos: 42,
            yRadius: 48,
            mirror: {
                gap: 5,
                height: 0.3,
	            opacity: 0.4
            },
            buttonLeft: $(".prev-btn"),
            buttonRight: $(".next-btn"),
            autoPlay: false,
            bringToFront: true,
            onRendered: showcaseUpdated,
            onLoaded: function () {
                showcase.css('visibility', 'visible')
                showcase.css('display', 'none')
                showcase.fadeIn(1500)
            }
        })

        function showcaseUpdated(showcase) {
            var title = $('#item-title').html(
                "I Want a " + $(showcase.nearestItem()).attr('alt')
            );
            $('#item-title-slick').html(
                "I Want a " + $(showcase.nearestItem()).attr('alt')
            );

            var rel = $(showcase.nearestItem()).attr('alt');
            var params = '{"vehicle": "' + rel.toLowerCase() +'"}';
            document.getElementById('item-title').setAttribute('data-params', params);
            document.getElementById('item-title-slick').setAttribute('data-params', params);

            var c = Math.cos((showcase.floatIndex() % 1) * 2 * Math.PI)
            title.css('opacity', 0.5 + (0.5 * c))
        }

        // Simulate physical button click effect
        $('.nav > button').click(function (e) {
            var b = $(e.target).addClass('down')
            setTimeout(function () {
                b.removeClass('down')
            }, 80)
        })

        $(document).keydown(function (e) {
            switch (e.keyCode) {
			    /* left arrow */
                case 37:
                    $('.prev-btn').click()
                    break

			    /* right arrow */
                case 39:
                    $('.next-btn').click()
            }
        })
    })
  </script>
	<script type="text/javascript">
		$('.mobile-vehicle-slider').slick({
            dots: false,
            infinite: false,
            autoplay: false,
            prevArrow: false,
            nextArrow: false,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.mobile-vehicle-slider').on('afterChange', function (event, slick, currentSlide, nextSlide) {
            var relAttr = $(slick.$slides.get(currentSlide)).attr('rel');
            var altAttr = $(slick.$slides.get(currentSlide)).attr('alt');

            $('#item-title-slick').html("I Want a " + altAttr);
            $('#item-title').html("I Want a " + altAttr);
            var params = '{"vehicle": "' + relAttr.toLowerCase() + '"}';
            document.getElementById('item-title-slick').setAttribute('data-params', params);
            document.getElementById('item-title').setAttribute('data-params', params);

        });
	</script>
</body></html>
<?php $this->endPage() ?>
