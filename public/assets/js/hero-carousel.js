// Hero Carousel Enhancement Script
document.addEventListener('DOMContentLoaded', function () {
    const heroCarousel = document.querySelector('#heroCarousel');

    if (heroCarousel) {
        // Initialize Bootstrap Carousel
        const carousel = new bootstrap.Carousel(heroCarousel, {
            interval: 3000,
            ride: 'carousel',
            pause: 'hover',
            wrap: true,
            touch: true
        });

        // Add smooth fade transition on slide change
        heroCarousel.addEventListener('slide.bs.carousel', function (e) {
            const activeItem = e.relatedTarget;
            activeItem.style.transition = 'opacity 1s ease-in-out';
        });

        // Pause carousel when user interacts with controls
        const controls = heroCarousel.querySelectorAll('.carousel-control-prev, .carousel-control-next');
        controls.forEach(control => {
            control.addEventListener('click', function () {
                carousel.pause();
                setTimeout(() => {
                    carousel.cycle();
                }, 5000); // Resume after 5 seconds
            });
        });

        // Handle touch swipe for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        heroCarousel.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        heroCarousel.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                carousel.next();
            }
            if (touchEndX > touchStartX + 50) {
                carousel.prev();
            }
        }

        console.log('Hero Carousel initialized successfully');
    }
});
