@push('js')
<script>
(function () {
    const page = document.querySelector('.product-page');
    const catalog = document.querySelector('[data-load-url]');
    const grid = document.querySelector('[data-product-grid]');

    if (!page || !catalog || !grid) {
        return;
    }

    const loadUrl = catalog.dataset.loadUrl;
    const tabs = Array.from(page.querySelectorAll('[data-product-filter]'));
    const moreWrap = page.querySelector('[data-product-more-wrap]');
    const moreButton = page.querySelector('[data-product-more]');
    const moreText = page.querySelector('[data-more-text]');
    const emptyState = page.querySelector('[data-product-empty]');

    const prefersReducedMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let activeCategory =
        page.querySelector('[data-product-filter].is-active')?.dataset.productFilter || '';

    let currentOffset = Number(moreButton?.dataset.offset || 0);
    let requestController = null;

    const revealElement = function (element) {
        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            element.classList.add('is-visible');
            return;
        }

        revealObserver.observe(element);
    };

    const revealObserver = !prefersReducedMotion && 'IntersectionObserver' in window
        ? new IntersectionObserver(function (entries, observer) {
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
        })
        : null;

    page.querySelectorAll('.reveal').forEach(revealElement);

    const observeNewCards = function (scope) {
        scope.querySelectorAll('.reveal:not(.is-visible)').forEach(revealElement);
    };

    const setActiveTab = function (category) {
        tabs.forEach(function (tab) {
            const isActive = tab.dataset.productFilter === category;

            tab.classList.toggle('is-active', isActive);
            tab.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
    };

    const setMoreState = function (hasMore, offset, category) {
        currentOffset = Number(offset || 0);

        if (!moreButton || !moreWrap) {
            return;
        }

        moreButton.dataset.offset = String(currentOffset);
        moreButton.dataset.category = category || '';
        moreWrap.classList.toggle('d-none', !hasMore);
    };

    const setLoading = function (loading) {
        if (!moreButton) {
            return;
        }

        moreButton.disabled = loading;

        if (moreText) {
            moreText.textContent = loading ? 'Loading...' : 'More';
        }
    };

    const requestProducts = async function (category, offset) {
        if (requestController) {
            requestController.abort();
        }

        requestController = new AbortController();

        const url = new URL(loadUrl, window.location.origin);

        if (category) {
            url.searchParams.set('category', category);
        }

        url.searchParams.set('offset', String(offset));

        const response = await fetch(url.toString(), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: requestController.signal
        });

        if (!response.ok) {
            throw new Error('Unable to load products.');
        }

        return response.json();
    };

    const updateBrowserUrl = function (category) {
        const url = new URL(window.location.href);

        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }

        window.history.replaceState(
            { productCategory: category },
            '',
            url.pathname + url.search
        );
    };

    const filterProducts = async function (category, fallbackUrl) {
        activeCategory = category;
        setActiveTab(category);

        grid.classList.add('is-filtering');

        if (moreWrap) {
            moreWrap.classList.add('d-none');
        }

        try {
            const data = await requestProducts(category, 0);

            grid.innerHTML = data.html;
            setMoreState(data.has_more, data.next_offset, category);

            emptyState?.classList.toggle('d-none', data.total > 0);

            updateBrowserUrl(category);
            observeNewCards(grid);

            window.requestAnimationFrame(function () {
                grid.classList.remove('is-filtering');
            });
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            grid.classList.remove('is-filtering');

            if (fallbackUrl) {
                window.location.href = fallbackUrl;
            }
        }
    };

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function (event) {
            event.preventDefault();

            const category = tab.dataset.productFilter || '';

            if (category === activeCategory) {
                return;
            }

            filterProducts(category, tab.href);
        });
    });

    if (moreButton) {
        moreButton.addEventListener('click', async function () {
            setLoading(true);

            try {
                const data = await requestProducts(activeCategory, currentOffset);

                if (data.html) {
                    const holder = document.createElement('div');
                    holder.innerHTML = data.html;

                    Array.from(holder.children).forEach(function (card) {
                        grid.appendChild(card);
                    });

                    observeNewCards(grid);
                }

                setMoreState(
                    data.has_more,
                    data.next_offset,
                    activeCategory
                );

                emptyState?.classList.toggle(
                    'd-none',
                    grid.querySelectorAll('[data-product-item]').length > 0
                );
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error(error);
                }
            } finally {
                setLoading(false);
            }
        });
    }

    window.addEventListener('popstate', function () {
        window.location.reload();
    });
})();
</script>
@endpush
