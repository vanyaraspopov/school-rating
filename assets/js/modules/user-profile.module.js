'use strict';

(function($) {
    var filterFormSelector = '#filter-form';
    var filterContentWrapper = '#userRatesWrapper';
    var filterContent = '#userRates';

    var $filterForm = $(filterFormSelector);

    var ajaxUrl = $filterForm.data('location');

    var submitFormHandler = function() {
        var data = $filterForm.serialize();
        $(filterContentWrapper).load(ajaxUrl + ' ' + filterContent, data);
        return false;
    };

    $filterForm.on('submit', submitFormHandler);
})(jQuery);