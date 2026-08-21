@push('js')
<script>
(function () {
    const root = document.querySelector('.service-page');

    if (!root) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealElements = root.querySelectorAll('.reveal');

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
            threshold: 0.12,
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
     * Gallery: seamless right-to-left autoplay + pointer drag.
     * Original cards are cloned once; resetting happens on identical
     * cloned content so the loop does not visually jump.
     */
    const gallery = root.querySelector('[data-service-gallery]');
    const galleryTrack = root.querySelector('[data-service-gallery-track]');

    if (gallery && galleryTrack) {
        const originals = Array.from(galleryTrack.children);
        const originalCount = originals.length;

        if (originalCount > 1) {
            originals.forEach(function (item) {
                const clone = item.cloneNode(true);
                clone.setAttribute('aria-hidden', 'true');
                clone.querySelectorAll('a').forEach(function (link) {
                    link.setAttribute('tabindex', '-1');
                });
                galleryTrack.appendChild(clone);
            });

            let index = 0;
            let timer = null;
            let pointerStartX = null;
            let pointerDeltaX = 0;
            let dragging = false;

            const transitionValue = 'transform .78s cubic-bezier(.25, .46, .45, .94)';

            const getStep = function () {
                const first = galleryTrack.children[0];

                if (!first) {
                    return 0;
                }

                const styles = window.getComputedStyle(galleryTrack);
                const gap = parseFloat(styles.columnGap || styles.gap || 0);

                return first.getBoundingClientRect().width + gap;
            };

            const applyPosition = function (animate) {
                galleryTrack.style.transition = animate ? transitionValue : 'none';
                galleryTrack.style.transform = 'translate3d(' + (-getStep() * index) + 'px, 0, 0)';
            };

            const next = function () {
                index += 1;
                applyPosition(true);
            };

            const prev = function () {
                if (index === 0) {
                    index = originalCount;
                    applyPosition(false);

                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            index -= 1;
                            applyPosition(true);
                        });
                    });

                    return;
                }

                index -= 1;
                applyPosition(true);
            };

            const stopAuto = function () {
                if (timer) {
                    window.clearInterval(timer);
                    timer = null;
                }
            };

            const startAuto = function () {
                stopAuto();

                if (document.hidden || prefersReducedMotion) {
                    return;
                }

                timer = window.setInterval(next, 3600);
            };

            galleryTrack.addEventListener('transitionend', function (event) {
                if (event.propertyName !== 'transform') {
                    return;
                }

                if (index >= originalCount) {
                    index = 0;
                    applyPosition(false);
                }
            });

            gallery.addEventListener('mouseenter', stopAuto);
            gallery.addEventListener('mouseleave', startAuto);

            gallery.addEventListener('pointerdown', function (event) {
                pointerStartX = event.clientX;
                pointerDeltaX = 0;
                dragging = true;
                gallery.classList.add('is-dragging');
                stopAuto();

                if (gallery.setPointerCapture) {
                    gallery.setPointerCapture(event.pointerId);
                }
            });

            gallery.addEventListener('pointermove', function (event) {
                if (!dragging || pointerStartX === null) {
                    return;
                }

                pointerDeltaX = event.clientX - pointerStartX;
            });

            const finishDrag = function () {
                if (!dragging) {
                    return;
                }

                dragging = false;
                gallery.classList.remove('is-dragging');

                if (Math.abs(pointerDeltaX) >= 45) {
                    pointerDeltaX < 0 ? next() : prev();
                }

                pointerStartX = null;
                pointerDeltaX = 0;
                startAuto();
            };

            gallery.addEventListener('pointerup', finishDrag);
            gallery.addEventListener('pointercancel', finishDrag);

            window.addEventListener('resize', function () {
                applyPosition(false);
            });

            document.addEventListener('visibilitychange', function () {
                document.hidden ? stopAuto() : startAuto();
            });

            applyPosition(false);
            startAuto();
        }
    }

    /*
     * Shared testimonials: Bootstrap fade autoplay + pointer swipe.
     */
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

        const carousel = testimonialCarousel.get(0);
        let startX = null;

        carousel.addEventListener('pointerdown', function (event) {
            startX = event.clientX;
        });

        carousel.addEventListener('pointerup', function (event) {
            if (startX === null) {
                return;
            }

            const distance = event.clientX - startX;
            startX = null;

            if (Math.abs(distance) < 45) {
                return;
            }

            testimonialCarousel.carousel(distance > 0 ? 'prev' : 'next');
        });

        carousel.addEventListener('pointercancel', function () {
            startX = null;
        });

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                testimonialCarousel.carousel('cycle');
            }
        });
    }
})();
</script>
@endpush
