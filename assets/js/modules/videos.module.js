'use strict';

document.addEventListener("DOMContentLoaded", function() {
    var videoListSelector = '#videos-list';
    var moreVideosBtnSelector = '#more-videos-btn';

    var $videoList = $(videoListSelector);
    var $moreVideosBtn = $(moreVideosBtnSelector);

    var ajaxRequestHandler = $moreVideosBtn.data('ajax-request-handler');
    const limit = (Number)($moreVideosBtn.data('limit'));
    var offset = limit;

    const noMoreVideos = 'Видео больше нет';

    var successHandler = function(data) {
        $videoList.append(data);
        if (data == '') {
            $moreVideosBtn.text(noMoreVideos);
        } else {
            offset += limit;
        }
    };

    $moreVideosBtn.click(function (e) {
        e.preventDefault();

        var data = {
            snippet: 'videogalleryMoreVideos',
            limit: limit,
            offset: offset
        };

        $.ajax({
            url: ajaxRequestHandler,
            method: 'post',
            data: data,
            success: successHandler
        });
    });
});