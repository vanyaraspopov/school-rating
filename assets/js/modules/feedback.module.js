'use strict';

(function ($) {
    var feedbackFormSelector = '#feedback-form';
    var feedbackFormMsgWrapperSelector = '#feedback-form-msg-wrapper';
    var feedbackFormMsgSelector = '#feedback-form-msg';

    var $feedbackForm = $(feedbackFormSelector);
    var $feedbackFormMsgWrapper = $(feedbackFormMsgWrapperSelector);
    var $feedbackFormMsg = $(feedbackFormMsgSelector);

    var ajaxRequestHandler = $feedbackForm.data('ajax-request-handler');

    const successMsg = 'Письмо успешно отправлено';

    var successHandler = function (data) {
        data = JSON.parse(data);
        if (data.error) {
            $feedbackFormMsg.text(data.errorMsg);
        } else {
            $feedbackFormMsg.text(successMsg);
            $feedbackForm[0].reset();
        }
        $feedbackFormMsgWrapper.slideDown();
    };

    $feedbackForm.on('submit', function () {
        var data = $feedbackForm.serialize();

        $.ajax({
            url: ajaxRequestHandler,
            method: 'post',
            data: data,
            success: successHandler
        });

        return false;
    });
})(jQuery);