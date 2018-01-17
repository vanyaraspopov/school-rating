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
        var filters = getCurrentFilters();
        for (var i in criteria) {
            if (criteria.hasOwnProperty(i)) {
                if (criteria[i].value) {
                    filters[criteria[i].name] = criteria[i].value;
                } else {
                    delete filters[criteria[i].name];
                }
            }
        }
        var filterString = filtersToString(filters);
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
                if (criteria.hasOwnProperty(i)) {
                    var cr = criteria[i].split(criterionDelimiter);

                    if (cr[0] == levelKey) {
                        $filterLevel.find('option[value=' + cr[1] + ']').attr('selected', 'selected');
                    }

                    if (cr[0] == sectionKey) {
                        $filterSection.find('option[value=' + decodeURIComponent(cr[1]) + ']').attr('selected', 'selected');
                    }
                }
            }
        }
    }

    function prepareLocation(location) {
        if (location[location.length - 1] !== '/') {
            location += '/';
        }
        return location;
    }

    function getCurrentFilters() {
        var filters = {};
        var tmp = window.location.pathname.split('/');
        if (tmp.length > 3 && tmp[tmp.length - 3] == alias && tmp[tmp.length - 2] == aliasFilter) {
            var filterString = tmp[tmp.length - 1];
            var criteria = filterString.split(criteriaDelimiter);
            for (var i = 0; i < criteria.length; i++) {
                var cr = criteria[i].split(criterionDelimiter);
                filters[cr[0]] = decodeURIComponent(cr[1]);
            }
        }
        return filters;
    }

    function filtersToString(filters) {
        var filtersArr = [];
        for (var name in filters) {
            if (filters.hasOwnProperty(name)) {
                filtersArr.push(name + criterionDelimiter + filters[name])
            }
        }
        return filtersArr.join(criteriaDelimiter);
    }
})(jQuery);