@push('js')
<script>
(function () {
    const page = document.querySelector('.product-detail-page');

    if (!page) {
        return;
    }

    const prefersReducedMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const revealElements = page.querySelectorAll('.reveal');

    if (!prefersReducedMotion && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.10,
            rootMargin: '0px 0px -45px 0px'
        });

        revealElements.forEach(function (element) {
            revealObserver.observe(element);
        });
    } else {
        revealElements.forEach(function (element) {
            element.classList.add('is-visible');
        });
    }

    /*
     * Main product gallery:
     * manual only — no autoplay and no progress/indicator bar.
     * Existing prev/next + touch functionality is preserved.
     */
    const imageCarousel = $('#productDetailImageCarousel');

    if (imageCarousel.length) {
        imageCarousel.carousel({
            interval: false,
            pause: true,
            wrap: true,
            keyboard: true,
            touch: true
        });

        imageCarousel.carousel('pause');
    }

    /*
     * Our Products:
     * this is the only auto-scrolling carousel on product detail page.
     */
    const relatedCarousel = $('#relatedProductsCarousel');

    if (relatedCarousel.length) {
        relatedCarousel.carousel({
            interval: 4600,
            pause: false,
            wrap: true,
            keyboard: true,
            touch: true
        });

        relatedCarousel.carousel('cycle');

        const carouselElement = relatedCarousel.get(0);
        let startX = null;

        carouselElement.addEventListener('pointerdown', function (event) {
            startX = event.clientX;
        });

        carouselElement.addEventListener('pointerup', function (event) {
            if (startX === null) {
                return;
            }

            const distance = event.clientX - startX;
            startX = null;

            if (Math.abs(distance) < 45) {
                return;
            }

            relatedCarousel.carousel(distance > 0 ? 'prev' : 'next');
        });

        carouselElement.addEventListener('pointercancel', function () {
            startX = null;
        });

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                relatedCarousel.carousel('pause');
                return;
            }

            relatedCarousel.carousel('cycle');
        });
    }
})();
</script>
@endpush
