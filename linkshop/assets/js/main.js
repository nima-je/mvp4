(function ($) {
    'use strict';

    $(function () {
        $('.primary-nav .menu > li.menu-item-has-children').each(function () {
            var $item = $(this);
            var $toggle = $('<button class="submenu-toggle" aria-label="باز کردن زیرمنو">▾</button>');
            $item.append($toggle);
            $toggle.on('click', function (e) {
                e.preventDefault();
                $item.toggleClass('is-open');
                $item.children('ul').slideToggle(150);
            });
        });
    });
})(jQuery);
