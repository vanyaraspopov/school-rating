'use strict';

document.addEventListener("DOMContentLoaded", function () {
    var albumListSelector = '#photo-albums';
    var moreAlbumsBtnSelector = '#more-albums-btn';

    var $albumList = $(albumListSelector);
    var $moreAlbumsBtn = $(moreAlbumsBtnSelector);

    var ajaxRequestHandler = $moreAlbumsBtn.data('ajax-request-handler');
    const limit = (Number)($moreAlbumsBtn.data('limit'));
    var offset = limit;

    const noMorePhoto = 'Фотоальбомов больше нет';

    var successHandler = function (data) {
        $albumList.append(data);
        if (data == '') {
            $moreAlbumsBtn.text(noMorePhoto);
        } else {
            offset += limit;
        }
    };

    $moreAlbumsBtn.click(function (e) {
        e.preventDefault();

        var data = {
            snippet: 'photogalleryMoreAlbums',
            limit: limit,
            offset: offset,
        };

        $.ajax({
            url: ajaxRequestHandler,
            method: 'post',
            data: data,
            success: successHandler
        });
    });
});