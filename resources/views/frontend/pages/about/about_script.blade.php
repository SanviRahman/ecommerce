@push('js')
<script>
(function() {
    const revealElements = document.querySelectorAll('.about-page .reveal');
    const counters = document.querySelectorAll('.about-page .about-count');

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -5% 0px'
        });

        revealElements.forEach(function(element) {
            revealObserver.observe(element);
        });

        const counterObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                const element = entry.target;
                const target = Number(element.dataset.count || 0);
                const duration = 1250;
                const start = performance.now();

                const update = function(now) {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    element.textContent = Math.floor(target * eased).toLocaleString();

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                };

                requestAnimationFrame(update);
                observer.unobserve(element);
            });
        }, {
            threshold: 0.55
        });

        counters.forEach(function(counter) {
            counterObserver.observe(counter);
        });
    } else {
        revealElements.forEach(function(element) {
            element.classList.add('is-visible');
        });

        counters.forEach(function(counter) {
            counter.textContent = Number(counter.dataset.count || 0).toLocaleString();
        });
    }

    const enableCarouselDrag = function(selector) {
        const carousel = document.querySelector(selector);

        if (!carousel) {
            return;
        }

        let startX = null;

        carousel.addEventListener('pointerdown', function(event) {
            startX = event.clientX;
        });

        carousel.addEventListener('pointerup', function(event) {
            if (startX === null) {
                return;
            }

            const distance = event.clientX - startX;
            startX = null;

            if (Math.abs(distance) < 45) {
                return;
            }

            $(carousel).carousel(distance > 0 ? 'prev' : 'next');
        });

        carousel.addEventListener('pointercancel', function() {
            startX = null;
        });
    };

    const testimonialCarousel = $('#testimonialCarousel');

    if (testimonialCarousel.length) {
        testimonialCarousel.carousel({
            interval: 5500,
            pause: false,
            wrap: true,
            keyboard: true,
            touch: true
        });

        testimonialCarousel.carousel('cycle');
        enableCarouselDrag('#testimonialCarousel');

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                testimonialCarousel.carousel('cycle');
            }
        });
    }
})();
</script>
@endpush
