'use strict';

(function ($) {
    var uploadFileInputSelector = '#upload_doc';
    var agreementFilepathInputSelector = '#agreement_filepath';

    var regFormSelector = '.js-reg-form';
    var regConfirmModalSelector = '#confirmPhoneModal';
    var regConfirmFormSelector = '#form-confirm-phone';
    var sendCodeBtnSelector = '#sendCodeBtn';
    var checkCodeBtnSelector = '#checkCodeBtn';

    const resendCodeTimeout = 2 * 60 * 1000;
    const resendText = 'Получить код ещё раз {timer}';

    var $fileInput = $(uploadFileInputSelector);
    var $agreementFilepathInput = $(agreementFilepathInputSelector);

    var $regForm = $(regFormSelector);
    var $regConfirmModal = $(regConfirmModalSelector);
    var $regConfirmForm = $(regConfirmFormSelector);
    var $sendCodeBtn = $(sendCodeBtnSelector);
    var $checkCodeBtn = $(checkCodeBtnSelector);

    var ajaxUrl = $regConfirmForm.data('ajax-url');

    $regForm.find('input[type="tel"]').mask('+7 (999) 999-99-99');
    $regForm.find('input.js-date').mask('99.99.9999');
    $regForm.on('submit', submitHandler);
    $regConfirmForm.on('submit', function () {
        return false;
    });
    $sendCodeBtn.on('click', sendCodeHandler);
    $checkCodeBtn.on('click', checkCodeHandler);

    $fileInput.on('change', uploadFile);

    function submitHandler() {
        var phone = $(this).find('input[name="phone"]').val();
        var submitBtn = $(this).find('input[type="submit"]').attr('name');

        $regConfirmForm.find('input[name="phone"]').val(phone);
        $regConfirmForm.find('input[name="submitBtn"]').val(submitBtn);

        $regConfirmModal.modal('show');
        return false;
    }

    function sendCodeHandler(e) {
        var phone = $regConfirmForm.find('input[name="phone"]').val();

        var responseHandler = function (data) {
            data = JSON.parse(data);
            if (data.error) {
                alert(data.errorMsg);
            } else {
                afterSendCode();
            }
        };

        if (validatePhone(phone)) {
            sendCode(phone, responseHandler);
        } else {
            alert('Телефонный номер некорректен');
        }
        return false;
    }

    function afterSendCode() {
        $regConfirmForm.find('input[name="code"]').removeAttr('disabled');
        setResendCodeTimer();
    }

    function setResendCodeTimer() {
        $sendCodeBtn.attr('disabled', 'disabled');
        const deadline = new Date(Date.parse(new Date()) + resendCodeTimeout);
        var interval = setInterval(function () {
            var now = new Date();
            var diff = deadline - now; // разница в миллисекундах
            var minutes = Math.floor(Math.round(diff / 1000) / 60);
            var seconds = Math.floor(Math.round(diff / 1000) % 60);
            $sendCodeBtn.val(resendText.replace('{timer}', '(' + minutes + ':' + seconds + ')'));
        }, 1000);
        setTimeout(function () {
            clearInterval(interval);
            $sendCodeBtn.removeAttr('disabled');
            $sendCodeBtn.val(resendText.replace('{timer}', ''));
        }, resendCodeTimeout);
    }

    function checkCodeHandler() {
        var phone = $regConfirmForm.find('input[name="phone"]').val();
        var code = $regConfirmForm.find('input[name="code"]').val();
        var submitBtn = $regConfirmForm.find('input[name="submitBtn"]').val();

        var responseHandler = function (data) {
            data = JSON.parse(data);
            if (data.error) {
                alert(data.errorMsg);
            } else {
                $regForm.unbind('submit', submitHandler);
                $regForm.find('input[type="submit"][name="' + submitBtn + '"]').click();
            }
        };

        checkCode(phone, code, responseHandler);
        return false;
    }

    function validatePhone(phone) {
        return true;
    }

    function sendCode(phone, successHandler) {
        var snippet = 'sendCode';

        var data = {
            snippet: snippet,
            phoneNumber: phone
        };

        $.ajax({
            url: ajaxUrl,
            method: 'post',
            data: data,
            success: successHandler
        });
    }

    function checkCode(phone, code, successHandler) {
        var snippet = 'checkCode';

        var data = {
            snippet: snippet,
            phoneNumber: phone,
            code: code
        };

        $.ajax({
            url: ajaxUrl,
            method: 'post',
            data: data,
            success: successHandler
        });
    }

    function uploadFile() {
        var fd = new FormData;

        fd.append('agreement', $fileInput.prop('files')[0]);
        fd.append('snippet', 'uploadAgreement');

        $.ajax({
            url: ajaxUrl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                data = JSON.parse(data);
                if (data.error) {
                    alert(data.errorMsg);
                } else {
                    $agreementFilepathInput.val(data.agreementFilepath);
                }
            }
        });
    }
})(jQuery);