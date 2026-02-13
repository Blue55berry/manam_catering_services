/* Chef Team Carousel Auto-Scroll */
(function ($) {
    $(document).ready(function () {
        // Initialize Chef Team Slider with autoplay and center mode
        if ($('.cat-team-slider').length) {
            var teamSwiper = new Swiper('.cat-team-slider', {
                slidesPerView: 3, // Show 3 cards at a time
                centeredSlides: true, // Center the active slide
                spaceBetween: 30, // Spacing between slides
                loop: true, // Infinite loop
                speed: 600, // FASTER Transition speed (was 800)
                autoplay: {
                    delay: 1500, // FASTER Delay (was 2000)
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                        centeredSlides: false // Disable center mode on tablets if crowded
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        centeredSlides: true
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        centeredSlides: true
                    }
                }
            });

            // Pause autoplay on mouse enter and resume on mouse leave
            $('.cat-team-slider').on('mouseenter', function () {
                teamSwiper.autoplay.stop();
            });
            $('.cat-team-slider').on('mouseleave', function () {
                teamSwiper.autoplay.start();
            });
        }
    });
})(jQuery);
