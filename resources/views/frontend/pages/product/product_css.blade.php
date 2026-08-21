@push('css')
<style>
/* ================================================================
   Products page only
   ================================================================ */
.product-page {
    background: #f7f7f7;
}

.product-page .product-page-hero .container,
.product-page .product-catalog-section .container,
.product-page .tmc-section .container {
    max-width: 960px;
}

/* Hero topbar/header */
.product-page .front-topbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5100;
    background: transparent;
    color: #ffffff;
}

.product-page .front-topbar .front-container {
    min-height: 34px;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.product-page .front-topbar-contact,
.product-page .front-topbar-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.product-page .front-topbar a,
.product-page .front-topbar-contact,
.product-page .front-topbar-meta,
.product-page .front-business-hours,
.product-page .front-whatsapp-icon {
    color: #ffffff;
}

.product-page .front-header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5050;
    background: transparent;
    border-top: 0;
    box-shadow: none;
}

.product-page .front-topbar + .front-header {
    top: 34px;
}

.product-page .front-header.is-scrolled {
    position: fixed;
    top: 0;
    background: rgba(39, 53, 70, .985);
    border-top: 3px solid #5d6671;
    box-shadow: 0 9px 28px rgba(0, 0, 0, .20);
    animation: productHeaderDrop .42s cubic-bezier(.16, 1, .3, 1) both;
}

@keyframes productHeaderDrop {
    from { opacity: 0; transform: translateY(-100%); }
    to { opacity: 1; transform: translateY(0); }
}

/* Hero */
.product-page-hero {
    position: relative;
    min-height: 445px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        linear-gradient(rgba(32, 27, 23, .27), rgba(32, 27, 23, .33)),
        url('{{ asset('frontend/images/about/about-hero.webp') }}') center/cover no-repeat;
}

.product-page-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(24, 18, 12, .04), rgba(31, 42, 54, .08));
    pointer-events: none;
}

.product-hero-inner {
    position: relative;
    z-index: 2;
    min-height: 445px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-hero-content {
    margin-top: 72px;
    text-align: center;
}

.product-hero-content h1 {
    margin: 0 0 20px;
    color: #ffffff;
    font-size: 46px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -.5px;
}

.product-breadcrumb {
    min-height: 40px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 11px;
    background: #ffffff;
    color: #c8a366;
    font-size: 12px;
}

.product-breadcrumb a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #213249;
    text-decoration: none;
}

.product-breadcrumb a:hover {
    color: var(--front-gold-dark);
}

.product-breadcrumb-separator {
    color: #bcc1c6;
    font-size: 9px;
}

/* Catalog heading */
.product-catalog-section {
    min-height: 620px;
    padding: 26px 0 48px;
    background: #f8f8f8;
    border-top: 3px solid var(--front-navy);
}

.product-heading .section-title {
    font-size: 38px;
    line-height: 1.12;
}

.product-heading-line {
    height: 1px;
    margin: 35px 0 48px;
    background: #d7d7d7;
}

/* Category filters */
.product-filter-tabs {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 7px 14px;
    margin-bottom: 33px;
}

.product-filter-tab {
    min-height: 34px;
    padding: 0 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid transparent;
    background: transparent;
    color: #102841;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .35px;
    text-decoration: none !important;
    text-transform: uppercase;
    transition:
        background-color .3s ease,
        color .3s ease,
        border-color .3s ease,
        transform .3s cubic-bezier(.16, 1, .3, 1);
}

.product-filter-tab:hover {
    color: #b58f50;
    transform: translateY(-2px);
}

.product-filter-tab.is-active {
    background: #caae73;
    border-color: #caae73;
    color: #ffffff;
    transform: none;
}

/* Product grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    grid-auto-flow: dense;
    gap: 18px;
    min-height: 220px;
    transition:
        opacity .35s ease,
        transform .35s cubic-bezier(.16, 1, .3, 1);
}

.product-grid.is-filtering {
    opacity: .18;
    transform: scale(.985);
    pointer-events: none;
}

.product-grid-card {
    position: relative;
    min-width: 0;
    height: 220px;
    overflow: hidden;
    background: #ddd;
}

.product-grid-card:first-child {
    grid-column: span 2;
}

.product-grid-media {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.product-grid-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1);
    transition: transform .7s cubic-bezier(.16, 1, .3, 1);
}

.product-card-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: flex-end;
    padding: 20px;
    background: linear-gradient(
        to top,
        rgba(24, 38, 54, .82),
        rgba(24, 38, 54, .08) 58%,
        rgba(24, 38, 54, 0)
    );
    opacity: 0;
    transition: opacity .42s ease;
}

.product-card-meta {
    transform: translateY(14px);
    transition: transform .48s cubic-bezier(.16, 1, .3, 1);
}

.product-card-meta small {
    display: block;
    margin-bottom: 4px;
    color: #e0b968;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: .5px;
    text-transform: uppercase;
}

.product-card-meta h3 {
    margin: 0;
    color: #ffffff;
    font-size: 20px;
    font-weight: 500;
    line-height: 1.2;
}

.product-card-meta p {
    max-width: 360px;
    margin: 7px 0 0;
    color: rgba(255, 255, 255, .82);
    font-size: 11px;
    line-height: 1.55;
}

.product-grid-card:hover .product-grid-media img {
    transform: scale(1.075);
}

.product-grid-card:hover .product-card-overlay {
    opacity: 1;
}

.product-grid-card:hover .product-card-meta {
    transform: translateY(0);
}

.product-empty-state {
    padding: 70px 20px;
    color: #6d7580;
    text-align: center;
}

.product-empty-state i {
    margin-bottom: 12px;
    color: #caae73;
    font-size: 36px;
}

.product-empty-state p {
    margin: 0;
    font-size: 14px;
}

/* More button - same-page expansion */
.product-more-wrap {
    padding-top: 34px;
    text-align: center;
}

.product-more-btn {
    min-width: 116px;
    height: 42px;
    padding: 0 23px;
    border: 0;
    background: #273546;
    color: #ffffff;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .45px;
    text-transform: uppercase;
    transition:
        transform .3s cubic-bezier(.16, 1, .3, 1),
        background-color .3s ease;
}

.product-more-btn i {
    margin-left: 11px;
    transition: transform .3s ease;
}

.product-more-btn:hover {
    background: #caae73;
    transform: translateY(-3px);
}

.product-more-btn:hover i {
    transform: translateY(3px);
}

.product-more-btn:disabled {
    cursor: wait;
    opacity: .65;
    transform: none;
}

/* Make the shared TMC match Products page spacing */
.product-page .tmc-section {
    margin-top: 0;
}

@media (max-width: 991.98px) {
    .product-page .product-page-hero .container,
    .product-page .product-catalog-section .container,
    .product-page .tmc-section .container {
        max-width: 720px;
    }

    .product-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .product-grid-card:first-child {
        grid-column: span 2;
    }

    .product-grid-card {
        height: 245px;
    }
}

@media (max-width: 767.98px) {
    .product-page .front-topbar {
        display: none;
    }

    .product-page .front-header {
        top: 0;
    }

    .product-page .product-page-hero .container,
    .product-page .product-catalog-section .container,
    .product-page .tmc-section .container {
        max-width: 540px;
    }

    .product-page-hero,
    .product-hero-inner {
        min-height: 400px;
    }

    .product-hero-content {
        margin-top: 45px;
    }

    .product-hero-content h1 {
        font-size: 38px;
    }

    .product-filter-tabs {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 6px;
        scrollbar-width: none;
    }

    .product-filter-tabs::-webkit-scrollbar {
        display: none;
    }

    .product-filter-tab {
        flex: 0 0 auto;
    }
}

@media (max-width: 575.98px) {
    .product-page .product-page-hero .container,
    .product-page .product-catalog-section .container,
    .product-page .tmc-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .product-page-hero,
    .product-hero-inner {
        min-height: 365px;
    }

    .product-hero-content h1 {
        font-size: 34px;
    }

    .product-breadcrumb {
        min-height: 38px;
        padding: 0 13px;
    }

    .product-catalog-section {
        padding-top: 42px;
    }

    .product-heading .section-title {
        font-size: 30px;
    }

    .product-heading-line {
        margin: 28px 0 35px;
    }

    .product-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .product-grid-card,
    .product-grid-card:first-child {
        grid-column: span 1;
        height: 280px;
    }

    .product-card-overlay {
        opacity: 1;
        background: linear-gradient(
            to top,
            rgba(24, 38, 54, .62),
            rgba(24, 38, 54, .02) 55%,
            rgba(24, 38, 54, 0)
        );
    }

    .product-card-meta {
        transform: none;
    }

    .product-card-meta p {
        display: none;
    }
}
</style>
@endpush
