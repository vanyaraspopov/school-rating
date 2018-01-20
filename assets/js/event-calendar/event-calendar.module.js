'use strict';

$(function () {
    var $calendar = $('#eventCalendar');
    var _dateFormat = 'DD.MM.YYYY';
    var _eventsFile = 'assets/js/event-calendar/events.json.php';

    //  Запрашиваем json файл с мероприятиями
    $.getJSON(_eventsFile, function (json) {

        //  Создаём ассоциативный массив типа {"date": "url"}
        var dates = {};
        for (var i in json) {
            if (json.hasOwnProperty(i)) {
                var date = moment(json[i]['date']).format(_dateFormat);
                dates[date] = json[i]['url'];
            }
        }

        /**
         * ВНИМАНИЕ!
         * В библиотеке jQuery Event Calendar были произведены правки
         * необходимые для проекта.
         * В истории коммитов под тегом "event-calendar-change"
         */
        //  Вешаем календарь
        $calendar.eventCalendar({
            dates: dates,
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

    });
});