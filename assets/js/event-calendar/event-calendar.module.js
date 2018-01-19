'use strict';

$(function () {
    var $calendar = $('#eventCalendar');
    var _dateFormat = 'MM.DD.YYYY';
    var _eventsFile = 'assets/js/event-calendar/events.json.php';

    //  Запрашиваем json файл с мероприятиями
    $.getJSON(_eventsFile, function(json) {

        //  Вешаем календарь
        $calendar.eventCalendar({
            jsonData: json,
            jsonDateFormat: 'human',
            locales: {
                locale: "ru",
                monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
                    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда',
                    'Четверг', 'Пятница', 'Суббота'],
                dayNamesShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                txt_noEvents: "Нет событий",
                txt_SpecificEvents_prev: "",
                txt_SpecificEvents_after: "события:",
                txt_next: "след.",
                txt_prev: "пред.",
                txt_NextEvents: "Следующие события:",
                txt_GoToEventUrl: "Перейти",
                moment: {
                    "months": ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
                        "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                    "monthsShort": ["Янв", "Фев", "Мар", "Апр", "Май", "Июн",
                        "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
                    "weekdays": ['Воскресенье', 'Понедельник', 'Вторник', 'Среда',
                        'Четверг', 'Пятница', 'Суббота'],
                    "weekdaysShort": ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                    "weekdaysMin": ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                    "longDateFormat": {
                        "LT": "H:mm",
                        "LTS": "LT:ss",
                        "L": "DD/MM/YYYY",
                        "LL": "D MMMM YYYY",
                        "LLL": "D MMMM YYYY LT",
                        "LLLL": "dddd, D MMMM YYYY LT"
                    },
                    "week": {
                        "dow": 1,
                        "doy": 4
                    }
                }
            }
        });

        //  Скрываем вывод списка мероприятий
        $('.eventCalendar-list-wrap').hide();

        //  Создаём ассоциативный массив типа {"date": "url"}
        var dates = {};
        for (var i in json) {
            if (json.hasOwnProperty(i)) {
                var date = moment(json[i]['date']).format(_dateFormat);
                dates[date] = json[i]['url'];
            }
        }

        //  Обрабатываем клик по ссылке в календаре
        $('.eventCalendar-day a').on('click', function(e){
            e.preventDefault();
            var year = (Number)($calendar.attr('data-current-year')),
                month = ((Number)($calendar.attr('data-current-month'))),
                day = (Number)($(this).parent().attr('rel'));
            month++;

            var _date = new Date(year + '-' + month + '-' + day);
            var date = moment(_date).format(_dateFormat);
            var url = dates[date];
            if (url) {
                window.open(url, '_blank');
            }
        });

    });
});