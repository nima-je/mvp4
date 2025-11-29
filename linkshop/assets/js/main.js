(function ($) {
    'use strict';

    function linkshopApplyStoredTheme() {
        var stored = localStorage.getItem('linkshop_theme_mode');
        var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (stored === 'dark' || (!stored && prefersDark)) {
            document.body.classList.add('ls-theme-dark');
        }
    }

    window.linkshopToggleThemeMode = function () {
        var body = document.body;
        var nowDark = body.classList.toggle('ls-theme-dark');
        localStorage.setItem('linkshop_theme_mode', nowDark ? 'dark' : 'light');
    };

    linkshopApplyStoredTheme();

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

        var mediaFrame;
        $('.ls-logo-picker').on('click', function (e) {
            e.preventDefault();
            if (typeof wp === 'undefined' || !wp.media) {
                return;
            }

            if (mediaFrame) {
                mediaFrame.open();
                return;
            }

            mediaFrame = wp.media({
                title: 'انتخاب لوگو',
                button: { text: 'استفاده از این تصویر' },
                multiple: false
            });

            mediaFrame.on('select', function () {
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                $('#logo_id').val(attachment.id);
                var preview = $('<img />', { src: attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url, alt: attachment.alt || '' });
                $('#ls-logo-preview').empty().append(preview);
            });

            mediaFrame.open();
        });

        $('.ls-clear-logo').on('click', function (e) {
            e.preventDefault();
            $('#logo_id').val('');
            $('#ls-logo-preview').html('<span class="ls-logo-placeholder">' + $(this).data('placeholder') + '</span>');
        });
    });
})(jQuery);
