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

        switch (curStepBtn) {
            case 'step-1':
                    if(isValid){
                        saveFirstStep($(this));
                    }
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
        var params = '{"vehicle": "' + rel.toLowerCase() + '"}';
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


});

function saveFirstStep(elem) {
    var oForm = $(elem).closest('form#step-form');
    var sFormUrl = $(oForm).find("input[name=step_url]").val();
    var oFormData = $(oForm).serialize();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: sFormUrl,
        data: oFormData,
        beforeSend: function () {
            $(elem).addClass('disabled');
        },
        success: function (data) {
            $(elem).removeClass('disabled');
            if (typeof(data) != 'undefined') {
                if (typeof(data.type) != 'undefined') {
                    if (data.type == 'success') {
                        $(oForm).append('<input type="hidden" name="app_id" value="' + data.id +'" />');
                        $(oForm).find('input[name="Contact[status]"]').val(1);
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


/**
 * send the application form.
 * @param elem
 */
function submitOrder(elem) {
    var oForm = $(elem).closest('form#step-form');
    var oFormData = $(oForm).serialize();
    var oFormUrl = $(oForm).attr('action');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: oFormUrl,
        data: oFormData,
        beforeSend: function () {
            $(elem).addClass('disabled');
        },
        success: function (data) {
            $(elem).removeClass('disabled');
            if (typeof(data) != 'undefined') {
                if (typeof(data.type) != 'undefined') {
                    if (data.type == 'success') {
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