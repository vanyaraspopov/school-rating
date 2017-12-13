'use strict';

(function ($) {
    var $sharingList = $('#sharingList');
    var url = $sharingList.data('url');

    //  vk
    var $vk = $('#vk_like');
    var vkKey = $vk.data('key');
    VK.init({
        apiId: vkKey,
        onlyWidgets: true
    });
    VK.Widgets.Like("vk_like", {type: "button", verb: 1, height: 30});
    VK.Observer.subscribe('widgets.like.shared', function f(shareCount) {
        updateRating('vk');
    });

    //  facebook
    var $fb = $('#fb_post');
    var fbKey = $fb.data('key');
    var fbLink = $fb.data('link');
    window.fbAsyncInit = function () {
        FB.init({
            appId: fbKey,
            status: true,
            xfbml: false,
            version: 'v2.11'
        });
    };
    $(function (event) {
        $('#fb_post').click(function (e) {
            e.preventDefault();
            FB.ui({
                    method: 'feed',
                    link: fbLink,
                    display: 'popup'
                },
                function (response) {
                    if (response && response.post_id) {
                        updateRating('fb');
                    }
                }
            );
        });
    });

    //  twitter
    twttr.ready(function (twttr) {
        twttr.events.bind('tweet', function (event) {
            updateRating('tw');
        });
    });

    //  Функция отправки запроса на сервер, чтобы начислить баллы пользователю
    function updateRating(netFlag) {
        var data = {
            snippet: 'srRatingForSharing',
            net: netFlag
        };
        $.ajax({
            url: url,
            method: 'POST',
            data: data
        });
    }
})(jQuery);