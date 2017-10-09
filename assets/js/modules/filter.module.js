'use strict';

(function ($) {
    var filterFormSelector = '#filter-form';
    var filterLevelSelector = '#filter_grade';
    var filterSectionSelector = '#filter_route';

    var $filterForm = $(filterFormSelector);
    var $filterLevel = $(filterLevelSelector);
    var $filterSection = $(filterSectionSelector);

    var location = prepareLocation($filterForm.data('location'));
    var alias = $filterForm.data('alias');

    var aliasFilter = 'filter';

    var criteriaDelimiter = '--';
    var criterionDelimiter = '-';

    var levelKey = 'level';
    var sectionKey = 'section';

    var submitFormHandler = function () {
        var criteria = $filterForm.serializeArray();
        var filters = [];
        for (var i in criteria) {
            if (criteria[i].value) {
                filters.push(criteria[i].name + criterionDelimiter + criteria[i].value);
            }
        }
        var filterString = filters.join(criteriaDelimiter);
        window.location.href = location + aliasFilter + '/' + filterString;
        return false;
    };

    $filterForm.on('submit', submitFormHandler);
    $(document).ready(setSelectedOptions);

    function setSelectedOptions() {
        var tmp = window.location.pathname.split('/');
        if (tmp.length > 3 && tmp[tmp.length - 3] == alias && tmp[tmp.length - 2] == aliasFilter) {
            var filterString = tmp[tmp.length - 1];
            var criteria = filterString.split(criteriaDelimiter);
            for (var i in criteria) {
                var cr = criteria[i].split(criterionDelimiter);

                if (cr[0] == levelKey) {
                    $filterLevel.find('option[value=' + cr[1] + ']').attr('selected', 'selected');
                }

                if (cr[0] == sectionKey) {
                    $filterSection.find('option[value=' + decodeURIComponent(cr[1]) + ']').attr('selected', 'selected');
                }
            }
        }
    };

    function prepareLocation(location) {
        if (location[location.length - 1] !== '/') {
            location += '/';
        }
        return location;
    }
})(jQuery);