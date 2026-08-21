<script>
    (function () {
        const loader = document.querySelector('.front-preloader');
        const header = document.querySelector('.front-header');

        window.addEventListener('load', function () {
            if (loader) {
                loader.classList.add('is-hidden');
            }
        });

        const updateHeader = function () {
            if (!header) {
                return;
            }

            const usesHeroHeader =
                document.body.classList.contains('about-page') ||
                document.body.classList.contains('contact-page') ||
                document.body.classList.contains('service-page');

            const scrollThreshold = usesHeroHeader ? 220 : 20;

            header.classList.toggle(
                'is-scrolled',
                window.scrollY > scrollThreshold
            );
        };

        updateHeader();

        window.addEventListener(
            'scroll',
            updateHeader,
            { passive: true }
        );

        const floatingSocial =
            document.querySelector('[data-floating-social]');

        const floatingToggle =
            document.querySelector('[data-floating-toggle]');

        const floatingItems =
            document.querySelector('[data-floating-items]');

        const backToTop =
            document.querySelector('[data-back-to-top]');

        if (
            floatingSocial &&
            floatingToggle &&
            floatingItems
        ) {
            const setFloatingState = function (isOpen) {
                floatingSocial.classList.toggle(
                    'is-open',
                    isOpen
                );

                floatingToggle.setAttribute(
                    'aria-expanded',
                    isOpen ? 'true' : 'false'
                );

                floatingItems.setAttribute(
                    'aria-hidden',
                    isOpen ? 'false' : 'true'
                );
            };

            floatingToggle.addEventListener(
                'click',
                function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    setFloatingState(
                        !floatingSocial.classList.contains(
                            'is-open'
                        )
                    );
                }
            );

            document.addEventListener(
                'click',
                function (event) {
                    if (
                        floatingSocial.classList.contains('is-open') &&
                        !floatingSocial.contains(event.target)
                    ) {
                        setFloatingState(false);
                    }
                }
            );

            document.addEventListener(
                'keydown',
                function (event) {
                    if (event.key === 'Escape') {
                        setFloatingState(false);
                    }
                }
            );
        }

        if (backToTop) {
            const updateBackToTop = function () {
                backToTop.classList.toggle(
                    'is-visible',
                    window.scrollY > 350
                );
            };

            backToTop.addEventListener(
                'click',
                function () {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            );

            updateBackToTop();

            window.addEventListener(
                'scroll',
                updateBackToTop,
                { passive: true }
            );
        }
    })();
</script>
