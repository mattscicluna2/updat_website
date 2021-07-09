(function ($) {
    "use strict";
    // header sticky add class js
    $(window).on('scroll', function () {
        var window_top = $(window).scrollTop() + 0;
        if (window_top > 0) {
            $('.drdt_sticky_section').addClass('drdt_sticky_fixed');
        } else {
            $('.drdt_sticky_section').removeClass('drdt_sticky_fixed');
        }
    });

}(jQuery));