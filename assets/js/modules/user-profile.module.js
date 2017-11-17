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


// Обрезка фото при загрузке
$(function () {
    var maxFileSize = 2 * 1024 * 1024;
    var fileSizeLimitText = 'Размер файла больше чем 2 Мб';

    var imgWidth = 160;
    var imgHeight = 160;

    var cropPhotoModalSelector = '#cropPhotoModal';
    var imageSelector = '#img-photo';
    var imageErrorSelector = '#img-error';
    var inputSelector = '#photo';

    var $cropPhotoModal = $(cropPhotoModalSelector);
    var $image = $(imageSelector);
    var $imageError = $(imageErrorSelector);
    var $input = $(inputSelector);

    // Произошло изменение значения инпута
    $input.on('change', function (e) {
        // Если браузер не поддерживает FileReader, то ничего не делаем
        if (!window.FileReader) {
            console.log('Браузер не поддерживает File API');
            return;
        }

        // Получаем выбранный файл (изображение)
        var file = e.target.files[0];
        // Выводим сообщение, что браузер не поддерживает указанный тип файла
        if (!((file.type == 'image/png') || (file.type == 'image/jpeg'))) {
            $imageError.text('Загруженный файл не является изображением');
            return;
        }
        // Выводим сообщение, что файл имеет большой размер
        if (file.size >= maxFileSize) {
            $imageError.text(fileSizeLimitText);
            return;
        }

        //  Если всё ок
        $imageError.text('');

        // Создаём экземпляр объекта FileReader, посредством которого будем читать файл
        var reader = new FileReader();
        // После успешного завершения операции чтения файла
        $(reader).on('load', function (event) {
            // Указываем в качестве значения атрибута src изображения содержимое файла (картинки)
            $image.attr('src', event.target.result);
            cropInit();
        });
        // Запускает процесс чтения файла (изображения). После завершения чтения файла его содержимое будет доступно посредством атрибута result
        reader.readAsDataURL(file);

    });

    function cropInit() {
        var jcrop_api;

        $image.Jcrop({
            onChange: setCoords,
            onSelect: setCoords,
            aspectRatio: 1,
            minSize: [imgWidth, imgHeight],
            setSelect: [0, 0, imgWidth, imgHeight],
            boxWidth: 500,
            boxHeight: 400
        }, function () {
            jcrop_api = this;
            $cropPhotoModal.modal('show');
            //  При закрытии модального окна очищаем инпут и убираем изображение
            $cropPhotoModal.on('hide.bs.modal', function () {
                $image.attr('src', '');
                $input.val('');
                jcrop_api.destroy();
            });
        });

        // При изменении координат расставляем их по инпутам
        function setCoords(c) {
            $('#x1').val(c.x);
            $('#y1').val(c.y);
            $('#x2').val(c.x2);
            $('#y2').val(c.y2);
            $('#w').val(c.w);
            $('#h').val(c.h);
        }
    }
});


//  Круговая диаграмма
$(document).ready(function () {
    var chart = 'chart';
    var $chart = $('#' + chart);
    var data = $chart.data('rating');

    var chartData = [];
    for (var name in data) {
        if (data.hasOwnProperty(name)) {
            chartData.push([name, data[name]]);
        }
    }

    var colors = ['#ed5c91', '#ee4d39', '#59a66a', '#fcd447', '#00aef0', '#dddddd'];

    var plot1 = $.jqplot(chart, [chartData], {
        grid: {
            background: 'white',
            borderColor: 'white',
            shadow: false
        },
        gridPadding: {top: 0, bottom: 38, left: 0, right: 0},
        seriesColors: colors,
        seriesDefaults: {
            renderer: $.jqplot.PieRenderer,
            trendline: {
                show: false
            },
            rendererOptions: {
                padding: 8,
                showDataLabels: true,
                dataLabels: 'value',
                dataLabelFormatString: '%s'
            }
        },
        legend: {
            show: true,
            placement: 'outside',
            rendererOptions: {
                numberRows: 3,
                numberColumns: 3
            },
            location: 's',
            marginTop: '15px'
        }
    });
});