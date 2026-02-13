(function ($) {
    "use strict";

    $(document).ready(function () {
        var testimonialSwiper = new Swiper('.custom-testimonial-slider', {
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            speed: 800,
            navigation: {
                nextEl: '.testimonial-nav-next',
                prevEl: '.testimonial-nav-prev',
            },
            pagination: {
                el: '.pagination-testimonial-swiper',
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 1,
                },
                992: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 2,
                }
            }
        });
    });

})(jQuery);
