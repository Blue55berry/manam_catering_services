/* Custom Navigation Fix */
(function ($) {
    $(document).ready(function () {
        // Ensure navigation links work properly
        $('.main-menu > ul > li > a[href^="' + window.location.origin + '"]').on('click', function (e) {
            // Only stop propagation, allow default navigation
            e.stopPropagation();
            // Let the browser navigate normally
            window.location.href = $(this).attr('href');
        });

        // For submenu items
        $('.sub-menu a[href^="' + window.location.origin + '"]').on('click', function (e) {
            e.stopPropagation();
            window.location.href = $(this).attr('href');
        });

        // Fix for mobile menu - prevent parent li click from blocking anchor navigation
        var w = window.innerWidth;
        if (w <= 1199) {
            $('.main-menu > ul > li > a').on('click', function (e) {
                // Allow link navigation
                if ($(this).attr('href') !== 'javascript:void(0);' && $(this).attr('href') !== '#') {
                    window.location.href = $(this).attr('href');
                    return false;
                }
            });
        }
    });
})(jQuery);
