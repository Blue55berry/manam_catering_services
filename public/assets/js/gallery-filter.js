/* Gallery Filter Functionality */
(function ($) {
    $(document).ready(function () {
        // Gallery filter functionality
        $('.cat-filter li').on('click', function () {
            var filterValue = $(this).attr('data-filter');

            // Update active class
            $('.cat-filter li').removeClass('active');
            $(this).addClass('active');

            // Filter items
            if (filterValue === 'all') {
                $('.cat-gallery-grid > div').fadeIn(400);
            } else {
                $('.cat-gallery-grid > div').hide();
                $('.cat-gallery-grid > div' + filterValue).fadeIn(400);
            }
        });
    });
})(jQuery);
