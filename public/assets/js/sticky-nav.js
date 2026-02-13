/* Sticky Navigation Script */
$(document).ready(function () {
    var header = $('header');
    var stickyThreshold = 100; // Show sticky nav after scrolling 100px

    $(window).scroll(function () {
        if ($(this).scrollTop() > stickyThreshold) {
            header.addClass('sticky-header');
        } else {
            header.removeClass('sticky-header');
        }
    });

    // Run on load in case we start down the page
    if ($(window).scrollTop() > stickyThreshold) {
        header.addClass('sticky-header');
    }
});
