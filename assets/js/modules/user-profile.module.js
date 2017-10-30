'use strict';

(function ($) {
    var filterFormSelector = '#filter-form';
    var filterContentWrapper = '#userRatesWrapper';
    var filterContent = '#userRates';

    var $filterForm = $(filterFormSelector);

    var ajaxUrl = $filterForm.data('location');

    var submitFormHandler = function () {
        var data = $filterForm.serialize();
        $(filterContentWrapper).load(ajaxUrl + ' ' + filterContent, data);
        return false;
    };

    $filterForm.on('submit', submitFormHandler);
})(jQuery);


//  Изменение пароля
(function ($) {
    //  cp = change password
    var cpFormSelector = '#changePasswordForm';
    var cpErrorMessageSelector = '#cpErrorMessage';
    var cpSuccessMessageSelector = '#cpSuccessMessage';

    var $cpForm = $(cpFormSelector);
    var $cpErrorMessage = $(cpErrorMessageSelector);
    var $cpSuccessMessage = $(cpSuccessMessageSelector);
    var ajaxUrl = $cpForm.data('ajax-url');

    $cpForm.on('submit', submitHandler);

    function submitHandler() {
        var data = $cpForm.serializeArray();
        $.ajax({
            url: ajaxUrl,
            method: 'POST',
            data: data,
            success: successHandler
        });
        return false;
    }

    function successHandler(res) {
        var response = JSON.parse(res);
        if (response.error) {
            $cpErrorMessage.text(response.errorMsg);
            $cpSuccessMessage.hide();
            $cpErrorMessage.show();
        } else {
            $cpErrorMessage.hide();
            $cpSuccessMessage.show();
            $cpForm[0].reset();
        }
    }
})(jQuery);


//  Обрезка изображения
(function ($) {
    var imageSelector = '#img-photo';

    $(imageSelector).each(function () {
        var image = $(this),
            cropwidth = image.attr('cropwidth'),
            cropheight = image.attr('cropheight'),
            results = image.next('.results'),
            x = $('.cropX', results),
            y = $('.cropY', results),
            w = $('.cropW', results),
            h = $('.cropH', results),
            download = results.next('.download').find('a');

        image.cropbox({
            width: cropwidth,
            height: cropheight,
            maxZoom: 2.0,
            showControls: 'auto'
            //controls: $cropControls
        })
            .on('cropbox', function (event, results, img) {
                x.text(results.cropX);
                y.text(results.cropY);
                w.text(results.cropW);
                h.text(results.cropH);
                download.attr('href', img.getDataURL());
            });
    });
})(jQuery);