@push('js')
<script>
(function() {
    const revealElements = document.querySelectorAll('.contact-page .reveal');

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
    } else {
        revealElements.forEach(function(element) {
            element.classList.add('is-visible');
        });
    }

    const form = document.querySelector('[data-contact-form]');
    const submitButton = document.querySelector('[data-contact-submit]');

    if (form && submitButton) {
        form.addEventListener('submit', function() {
            submitButton.disabled = true;

            const label = submitButton.querySelector('span');
            if (label) {
                label.textContent = 'Sending...';
            }
        });
    }
})();
</script>
@endpush
