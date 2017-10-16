'use strict';

//  Виджет "Показать больше мероприятий"
(function ($) {
    var eventsListSelector = '#past-events-list';
    var moreEventsBtnSelector = '#more-events-btn';

    var $eventsList = $(eventsListSelector);
    var $moreEventsBtn = $(moreEventsBtnSelector);

    const ajaxRequestHandler = $moreEventsBtn.data('ajax-request-handler');
    var limit = (Number)($moreEventsBtn.data('limit'));
    var filters = $moreEventsBtn.data('filters');
    var showUserEvents = $moreEventsBtn.data('user-events');
    var offset = limit;

    const noMoreEvents = 'Мероприятий больше нет';

    var successHandler = function (data) {
        $eventsList.append(data);
        if (data == '') {
            $moreEventsBtn.text(noMoreEvents);
        } else {
            offset += limit;
        }
    };

    $moreEventsBtn.click(function (e) {
        e.preventDefault();

        var data = {
            snippet: 'eventsMoreEvents',
            limit: limit,
            offset: offset,
            filters: filters,
            showUserEvents: showUserEvents
        };

        $.ajax({
            url: ajaxRequestHandler,
            method: 'post',
            data: data,
            success: successHandler
        });
    });
})(jQuery);

//  Виджет "Заявка на участие в меоприятии"
(function ($) {
    //  Селекторы элементов
    const participationBtnSelector = "#participationBtn";

    const in_modalSelector = '#event-modal';
    const in_modalFormSelector = '#event-participant-form';
    const in_modalFormMsgWrapperSelector = '#event-participant-form-msg-wrapper';
    const in_modalFormMsgSelector = '#event-participant-form-msg';

    const out_modalSelector = '#event-modal-unparticipate';
    const out_modalFormSelector = '#event-unparticipate-form';
    const out_modalFormMsgWrapperSelector = '#event-unparticipate-form-msg-wrapper';
    const out_modalFormMsgSelector = '#event-unparticipate-form-msg';

    //  DOM элементы
    var $participationBtn = $(participationBtnSelector);

    var $in_modal = $(in_modalSelector);
    var $in_modalForm = $(in_modalFormSelector);
    var $in_modalFormMsgWrapper = $(in_modalFormMsgWrapperSelector);
    var $in_modalFormMsg = $(in_modalFormMsgSelector);

    var $out_modal = $(out_modalSelector);
    var $out_modalForm = $(out_modalFormSelector);
    var $out_modalFormMsgWrapper = $(out_modalFormMsgWrapperSelector);
    var $out_modalFormMsg = $(out_modalFormMsgSelector);

    //  URL ajax-обработчика
    const ajaxRequestHandler = $in_modalForm.data('ajax-request-handler');

    //  Сообщения
    const in_btnText = "Участвовать в мероприятии";
    const in_successMsg = 'Заявка успешно отправлена';

    const out_btnText = "Отозвать заявку на участие";
    const out_successMsg = 'Заявка успешно снята';

    var in_successHandler = function (data) {
        data = JSON.parse(data);
        if (data.error) {
            $in_modalFormMsg.text(data.errorMsg);
            $in_modalFormMsgWrapper.slideDown();
        } else {
            $in_modal.modal('hide');
            $participationBtn.text(out_btnText);
            $participationBtn.attr('data-target', out_modalSelector);
        }
    };

    var out_successHandler = function (data) {
        data = JSON.parse(data);
        if (data.error) {
            $out_modalFormMsg.text(data.errorMsg);
            $out_modalFormMsgWrapper.slideDown();
        } else {
            $out_modal.modal('hide');
            $participationBtn.text(in_btnText);
            $participationBtn.attr('data-target', in_modalSelector);
        }
    };

    $in_modalForm.on('submit', function () {
        var data = $in_modalForm.serialize();

        $.ajax({
            url: ajaxRequestHandler,
            method: 'post',
            data: data,
            success: in_successHandler
        });

        return false;
    });

    $out_modalForm.on('submit', function () {
        var data = $out_modalForm.serialize();

        $.ajax({
            url: ajaxRequestHandler,
            method: 'post',
            data: data,
            success: out_successHandler
        });

        return false;
    });
})(jQuery);

//  Виджет карты
(function ($, ymaps) {
    ymaps.ready(init);

    function init() {
        const mapId = 'map';
        var $map = $('#' + mapId);
        var address = $map.data('address');

        var myMap = new ymaps.Map(mapId, {
            center: [55.753994, 37.622093],
            zoom: 9
        });

        // Поиск координат
        ymaps.geocode(address, {
            /**
             * Опции запроса
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
             */
            // Сортировка результатов от центра окна карты.
            // boundedBy: myMap.getBounds(),
            // strictBounds: true,
            // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
            // Если нужен только один результат, экономим трафик пользователей.
            results: 1
        }).then(function (res) {
            // Выбираем первый результат геокодирования.
            var firstGeoObject = res.geoObjects.get(0),
                // Координаты геообъекта.
                coords = firstGeoObject.geometry.getCoordinates(),
                // Область видимости геообъекта.
                bounds = firstGeoObject.properties.get('boundedBy');

            firstGeoObject.options.set('preset', 'islands#darkBlueDotIcon');
            // Получаем строку с адресом и выводим в иконке геообъекта.
            firstGeoObject.properties.set('iconCaption', firstGeoObject.getAddressLine());

            // Добавляем первый найденный геообъект на карту.
            myMap.geoObjects.add(firstGeoObject);
            // Масштабируем карту на область видимости геообъекта.
            myMap.setBounds(bounds, {
                // Проверяем наличие тайлов на данном масштабе.
                checkZoomRange: true
            });

            /**
             * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
             */
            /**
             var myPlacemark = new ymaps.Placemark(coords, {
             iconContent: 'моя метка',
             balloonContent: 'Содержимое балуна <strong>моей метки</strong>'
             }, {
             preset: 'islands#violetStretchyIcon'
             });

             myMap.geoObjects.add(myPlacemark);
             */
        });
    }
})(jQuery, ymaps);