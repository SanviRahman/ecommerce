@push('css')
<style>
.product-detail-page {
    background: #f7f7f7;
}

.product-detail-page .product-detail-hero .container,
.product-detail-page .product-detail-section .container,
.product-detail-page .related-products-section .container {
    max-width: 960px;
}

.product-detail-page .front-topbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5100;
    background: transparent;
    color: #ffffff;
}

.product-detail-page .front-topbar .front-container {
    min-height: 34px;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.product-detail-page .front-topbar-contact,
.product-detail-page .front-topbar-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.product-detail-page .front-topbar a,
.product-detail-page .front-topbar-contact,
.product-detail-page .front-topbar-meta,
.product-detail-page .front-business-hours,
.product-detail-page .front-whatsapp-icon {
    color: #ffffff;
}

.product-detail-page .front-header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5050;
    background: transparent;
    border-top: 0;
    box-shadow: none;
}

.product-detail-page .front-topbar + .front-header {
    top: 34px;
}

.product-detail-page .front-header.is-scrolled {
    position: fixed;
    top: 0;
    background: rgba(39, 53, 70, .985);
    border-top: 3px solid #5d6671;
    box-shadow: 0 9px 28px rgba(0, 0, 0, .20);
    animation: productDetailHeaderDrop .42s cubic-bezier(.16, 1, .3, 1) both;
}

@keyframes productDetailHeaderDrop {
    from { opacity: 0; transform: translateY(-100%); }
    to { opacity: 1; transform: translateY(0); }
}

.product-detail-hero {
    position: relative;
    min-height: 375px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        linear-gradient(rgba(32, 27, 23, .27), rgba(32, 27, 23, .33)),
        url('{{ asset('frontend/images/about/about-hero.webp') }}') center/cover no-repeat;
}

.product-detail-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(24, 18, 12, .04), rgba(31, 42, 54, .08));
    pointer-events: none;
}

.product-detail-hero-inner {
    position: relative;
    z-index: 2;
    min-height: 375px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-detail-hero-content {
    margin-top: 58px;
    text-align: center;
}

.product-detail-hero-content h1 {
    margin: 0 0 20px;
    color: #ffffff;
    font-size: 46px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -.5px;
}

.product-detail-breadcrumb {
    min-height: 40px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 11px;
    background: #ffffff;
    color: #c8a366;
    font-size: 12px;
}

.product-detail-breadcrumb a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #213249;
    text-decoration: none;
}

.product-detail-breadcrumb a:hover {
    color: var(--front-gold-dark);
}

.product-detail-breadcrumb-separator {
    color: #bcc1c6;
    font-size: 9px;
}

.product-detail-section {
    padding: 22px 0 28px;
    background: #f8f8f8;
    border-top: 3px solid var(--front-navy);
}

.product-detail-row {
    align-items: flex-start;
}

.product-detail-image-column {
    position: sticky;
    top: 100px;
    padding-right: 18px;
}

.product-detail-image-carousel,
.product-detail-image-frame {
    width: 100%;
    min-height: 465px;
}

.product-detail-image-frame {
    overflow: hidden;
    background: #e8e8e8;
}

.product-detail-image-frame img {
    width: 100%;
    height: 465px;
    display: block;
    object-fit: cover;
    transition: transform .75s cubic-bezier(.16, 1, .3, 1);
}

.product-detail-image-frame:hover img {
    transform: scale(1.045);
}

/* Product detail gallery is manual only. No progress/dot bar here. */
.product-detail-image-control {
    width: 36px;
    height: 36px;
    top: 50%;
    bottom: auto;
    border-radius: 50%;
    background: rgba(32, 46, 63, .86);
    color: #ffffff;
    transform: translateY(-50%) scale(.88);
    opacity: 0;
    transition: opacity .3s ease, transform .3s ease;
}

.product-detail-image-control.carousel-control-prev {
    left: 14px;
}

.product-detail-image-control.carousel-control-next {
    right: 14px;
}

.product-detail-image-carousel:hover .product-detail-image-control {
    opacity: 1;
    transform: translateY(-50%) scale(1);
}

.product-detail-content {
    padding-left: 4px;
}

.product-detail-block h2 {
    margin: -2px 0 15px;
    color: #102842;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.2;
}

.product-specification-table {
    border-top: 1px solid #aeb6c0;
    border-left: 1px solid #aeb6c0;
}

.product-specification-row {
    display: grid;
    grid-template-columns: 150px minmax(0, 1fr);
    min-height: 37px;
}

.product-specification-label,
.product-specification-value {
    padding: 9px 14px;
    border-right: 1px solid #aeb6c0;
    border-bottom: 1px solid #aeb6c0;
    color: #16304b;
    font-size: 12px;
    line-height: 1.45;
}

.product-specification-label {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    text-align: center;
}

.product-specification-value {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.product-detail-short-description {
    margin: 0;
    padding: 18px;
    border: 1px solid #d7dbe0;
    color: #1c324b;
    font-size: 13px;
    line-height: 1.8;
}

.product-detail-description {
    margin-top: 31px;
    color: #16304b;
    font-size: 13px;
    line-height: 1.85;
}

.product-data-sheet {
    margin-top: 34px;
}

.product-data-sheet h3 {
    margin: 0 0 14px;
    color: #102842;
    font-size: 13px;
    font-weight: 500;
}

.product-data-sheet-preview {
    width: 196px;
    height: 280px;
    overflow: hidden;
    background: #1a1d21;
    box-shadow: 0 8px 24px rgba(22, 36, 51, .08);
    transition:
        transform .45s cubic-bezier(.16, 1, .3, 1),
        box-shadow .45s ease;
}

.product-data-sheet-preview:hover {
    transform: translateY(-5px) scale(1.015);
    box-shadow: 0 14px 30px rgba(22, 36, 51, .16);
}

.product-data-sheet-preview object {
    width: 100%;
    height: 100%;
    border: 0;
}

.product-data-sheet-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #20242a;
    color: #ffffff;
}

.product-data-sheet-fallback i {
    color: #dc3545;
    font-size: 38px;
}

.product-data-sheet-link {
    margin-top: 10px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #213249;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none !important;
    text-transform: uppercase;
}

.product-data-sheet-link:hover {
    color: #c49c58;
}

.related-products-section {
    min-height: 500px;
    padding: 37px 0 44px;
    overflow: hidden;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.related-products-heading {
    margin-bottom: 58px;
    text-align: center;
}

.related-products-eyebrow {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-bottom: 9px;
    color: #c9a15b;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .55px;
    text-transform: uppercase;
}

.related-products-eyebrow span {
    width: 23px;
    height: 1px;
    background: #c9a15b;
}

.related-products-eyebrow strong {
    font-weight: 500;
}

.related-products-heading h2 {
    margin: 0;
    color: #132941;
    font-size: 38px;
    font-weight: 500;
    line-height: 1.1;
    letter-spacing: -.7px;
}

.related-products-row {
    margin-left: -11px;
    margin-right: -11px;
    justify-content: center;
}

.related-products-row > [class*="col-"] {
    padding-left: 11px;
    padding-right: 11px;
}

.related-product-card {
    display: block;
    color: #132941;
    text-decoration: none !important;
}

.related-product-media {
    position: relative;
    height: 222px;
    overflow: hidden;
    background: #e9e9e9;
}

.related-product-media img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform .72s cubic-bezier(.16, 1, .3, 1);
}

.related-product-overlay {
    position: absolute;
    inset: 0;
    padding: 18px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    background: linear-gradient(
        to top,
        rgba(24, 38, 54, .78),
        rgba(24, 38, 54, 0) 58%
    );
    color: #ffffff;
    opacity: 0;
    transition: opacity .4s ease;
}

.related-product-overlay strong {
    font-size: 17px;
    font-weight: 500;
}

.related-product-overlay small {
    margin-top: 3px;
    color: #e1b868;
    font-size: 10px;
    text-transform: uppercase;
}

.related-product-card:hover .related-product-media img {
    transform: scale(1.075);
}

.related-product-card:hover .related-product-overlay {
    opacity: 1;
}

/* Only the Our Products carousel gets auto-scroll/progress indicators. */
.related-products-carousel {
    position: relative;
    padding-bottom: 52px;
    overflow: hidden;
}

.related-products-carousel .carousel-item {
    transition:
        opacity .62s ease-in-out,
        transform .72s cubic-bezier(.25, .46, .45, .94);
}

.related-product-indicators {
    bottom: 0;
    margin-bottom: 0;
}

.related-product-indicators li {
    width: 23px;
    height: 3px;
    margin: 0 4px;
    border: 0;
    background: #e7decb;
    opacity: 1;
}

.related-product-indicators .active {
    background: #c8a45f;
}

.product-page .product-grid-link {
    display: block;
    width: 100%;
    height: 100%;
    color: inherit;
    text-decoration: none !important;
}

@media (max-width: 991.98px) {
    .product-detail-page .product-detail-hero .container,
    .product-detail-page .product-detail-section .container,
    .product-detail-page .related-products-section .container {
        max-width: 720px;
    }

    .product-detail-image-column {
        position: relative;
        top: auto;
        padding-right: 0;
        margin-bottom: 38px;
    }

    .product-detail-image-carousel,
    .product-detail-image-frame {
        min-height: 560px;
    }

    .product-detail-image-frame img {
        height: 560px;
    }

    .product-detail-content {
        padding-left: 0;
    }
}

@media (max-width: 767.98px) {
    .product-detail-page .front-topbar {
        display: none;
    }

    .product-detail-page .front-header {
        top: 0;
    }

    .product-detail-page .product-detail-hero .container,
    .product-detail-page .product-detail-section .container,
    .product-detail-page .related-products-section .container {
        max-width: 540px;
    }

    .product-detail-hero,
    .product-detail-hero-inner {
        min-height: 360px;
    }

    .product-detail-hero-content {
        margin-top: 45px;
    }

    .product-detail-hero-content h1 {
        font-size: 38px;
    }

    .product-detail-breadcrumb {
        flex-wrap: wrap;
        justify-content: center;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .product-detail-image-carousel,
    .product-detail-image-frame {
        min-height: 480px;
    }

    .product-detail-image-frame img {
        height: 480px;
    }

    .product-detail-image-control {
        opacity: .9;
        transform: translateY(-50%) scale(1);
    }

    .related-products-heading h2 {
        font-size: 34px;
    }

    .related-product-media {
        height: 290px;
    }

    .related-product-overlay {
        opacity: 1;
        background: linear-gradient(
            to top,
            rgba(24, 38, 54, .56),
            rgba(24, 38, 54, 0) 55%
        );
    }
}

@media (max-width: 575.98px) {
    .product-detail-page .product-detail-hero .container,
    .product-detail-page .product-detail-section .container,
    .product-detail-page .related-products-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .product-detail-hero,
    .product-detail-hero-inner {
        min-height: 330px;
    }

    .product-detail-hero-content h1 {
        font-size: 34px;
    }

    .product-detail-section {
        padding-top: 20px;
    }

    .product-detail-image-carousel,
    .product-detail-image-frame {
        min-height: 0;
    }

    .product-detail-image-frame {
        aspect-ratio: 1 / 1;
    }

    .product-detail-image-frame img {
        height: 100%;
        min-height: 0;
    }

    .product-specification-row {
        grid-template-columns: 118px minmax(0, 1fr);
    }

    .product-specification-label,
    .product-specification-value {
        padding: 8px 9px;
        font-size: 11px;
    }

    .product-data-sheet-preview {
        width: 180px;
        height: 255px;
    }

    .related-products-section {
        padding-top: 35px;
    }

    .related-products-heading {
        margin-bottom: 38px;
    }

    .related-products-heading h2 {
        font-size: 30px;
    }

    .related-product-media {
        height: 270px;
    }
}
</style>
@endpush
