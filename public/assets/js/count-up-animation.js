/**
 * CountUp Animation - Vanilla JS Implementation
 * Mimics behavior of React Spring/Framer Motion CountUp
 */
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.cat-counter-section h4');

    // Intersection Observer options
    const observerOptions = {
        threshold: 0.5, // Trigger when 50% visible
        rootMargin: '0px'
    };

    // Animation function with easing
    const animateValue = (obj, start, end, duration) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);

            // Easing function (easeOutExpo for smooth spring-like feel)
            // 1 - Math.pow(2, -10 * progress) for a nice snap at end
            const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);

            const current = Math.floor(easeProgress * (end - start) + start);

            // Format number (add commas if > 1000)
            obj.innerHTML = current.toLocaleString();

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                obj.innerHTML = end.toLocaleString(); // Ensure final value is exact
            }
        };
        window.requestAnimationFrame(step);
    }

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 seconds duration

                // Reset to 0 before starting if not already
                // counter.innerHTML = '0'; 

                animateValue(counter, 0, target, duration);

                // Stop observing after animation starts
                observer.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        // Store the original value as target
        const targetValue = parseInt(counter.innerText.replace(/,/g, ''));
        counter.setAttribute('data-target', targetValue);
        counter.innerText = '0'; // Set initial value to 0
        observer.observe(counter);
    });
});
