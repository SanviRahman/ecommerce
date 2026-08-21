@push('css')
<style>
/* ================================================================
   About page only
   ================================================================ */
.about-page {
    background: #f7f7f7;
}

.about-page .about-page-hero .container,
.about-page .about-main-section .container,
.about-page .about-purpose-section .container,
.about-page .offer-section .container,
.about-page .about-gallery-section .container,
.about-page .testimonial-section .container {
    max-width: 960px;
}

/* Transparent hero header initially; solid sticky nav only after scroll. */
.about-page .front-topbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5100;
    background: transparent;
    color: #ffffff;
}

.about-page .front-topbar .front-container {
    min-height: 34px;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.about-page .front-topbar-contact,
.about-page .front-topbar-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.about-page .front-topbar a,
.about-page .front-topbar-contact,
.about-page .front-topbar-meta,
.about-page .front-topbar > * {
    color: #ffffff;
}

.about-page .front-business-hours,
.about-page .front-instagram-icon {
    display: inline-flex;
    align-items: center;
    color: #ffffff;
    line-height: 1;
}

.about-page .front-instagram-icon {
    font-size: 13px;
}

.about-page .front-header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5050;
    background: transparent;
    border-top: 0;
    box-shadow: none;
}

/* When topbar exists, the header sits directly below it. */
.about-page .front-topbar + .front-header {
    top: 34px;
}

.about-page .front-header.is-scrolled {
    position: fixed;
    top: 0;
    background: rgba(39, 53, 70, .985);
    border-top: 3px solid #5d6671;
    box-shadow: 0 9px 28px rgba(0, 0, 0, .20);
    animation: aboutHeaderDrop .42s cubic-bezier(.16, 1, .3, 1) both;
}

@keyframes aboutHeaderDrop {
    from { opacity: 0; transform: translateY(-100%); }
    to { opacity: 1; transform: translateY(0); }
}

/* Hero */
.about-page-hero {
    position: relative;
    min-height: 455px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        linear-gradient(rgba(30, 31, 34, .28), rgba(30, 31, 34, .33)),
        url('{{ asset('frontend/images/about/about-hero.webp') }}') center/cover no-repeat;
}

.about-page-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(30, 20, 12, .05), rgba(27, 36, 47, .08));
    pointer-events: none;
}

.about-hero-inner {
    position: relative;
    z-index: 2;
    min-height: 455px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.about-hero-content {
    margin-top: 72px;
    text-align: center;
}

.about-hero-content h1 {
    margin: 0 0 20px;
    color: #ffffff;
    font-size: 46px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -.4px;
}

.about-breadcrumb {
    min-height: 40px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 11px;
    background: #ffffff;
    color: #c8a366;
    font-size: 12px;
}

.about-breadcrumb a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #213249;
    text-decoration: none;
}

.about-breadcrumb a:hover { color: var(--front-gold-dark); }
.about-breadcrumb .breadcrumb-separator { color: #bcc1c6; font-size: 9px; }

/* Main intro */
.about-main-section {
    min-height: 520px;
    padding: 40px 0 48px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.about-main-row { min-height: 430px; }

.about-main-visual {
    position: relative;
    width: 465px;
    max-width: 100%;
}

.about-main-photo {
    display: block;
    width: 350px;
    height: 350px;
    object-fit: cover;
}

.about-main-mark {
    position: absolute;
    right: 0;
    bottom: -52px;
    width: 180px;
    height: auto;
}

.about-main-copy {
    max-width: 435px;
    margin-left: auto;
}

.about-main-copy .section-title {
    font-size: 39px;
    line-height: 1.08;
}

.about-main-copy > p {
    margin: 14px 0 18px;
    color: #142b45;
    font-size: 13px;
    line-height: 1.9;
}

.about-feature-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.about-feature-list li {
    position: relative;
    margin: 0 0 14px;
    padding-left: 21px;
    color: #53606f;
    font-size: 13px;
}

.about-feature-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 7px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #e1ae50;
}

/* Vision / Mission */
.about-purpose-section {
    position: relative;
    padding-top: 37px;
    background: #f5f5f5;
    border-top: 3px solid var(--front-navy);
}

.about-purpose-card {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    min-height: 260px;
    background: #ffffff;
}

.about-purpose-item {
    position: relative;
    min-height: 260px;
    padding: 43px 35px 35px;
}

.about-purpose-item + .about-purpose-item {
    border-left: 1px solid #dfdfdf;
}

.about-purpose-item h3 {
    margin: 0 0 16px;
    color: #10253e;
    font-size: 18px;
    font-weight: 500;
}

.about-purpose-item p {
    max-width: 410px;
    margin: 0;
    color: #18304b;
    font-size: 13px;
    line-height: 1.9;
}

.about-purpose-icon {
    position: absolute;
    left: 34px;
    bottom: 42px;
    color: #d0ad6c;
    font-size: 43px;
    line-height: 1;
}

.about-stats-band {
    margin-top: 0;
    min-height: 160px;
    display: flex;
    align-items: center;
    background: #ecb255;
}

.about-stats-row { min-height: 160px; align-items: center; }

.about-stat {
    min-height: 70px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    text-align: center;
}

.about-stats-row > div:not(:first-child) .about-stat {
    border-left: 1px solid rgba(255, 255, 255, .42);
}

.about-stat-number {
    line-height: .92;
    white-space: nowrap;
}

.about-stat strong {
    font-size: 47px;
    font-weight: 500;
}

.about-stat span {
    font-size: 36px;
    font-weight: 500;
}

.about-stat small {
    margin-top: 9px;
    color: #ffffff;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

/* Shared What We Offer styling for About page */
.about-page .offer-section {
    min-height: 516px;
    padding-top: 58px;
    padding-bottom: 44px;
    background:
        linear-gradient(rgba(112, 114, 119, .90), rgba(112, 114, 119, .90)),
        url('{{ asset('frontend/images/home/hero-background.webp') }}') center/cover no-repeat;
    border-top: 3px solid var(--front-navy);
}

.about-page .section-heading-row {
    min-height: 70px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 30px;
}

.about-page .offer-eyebrow { color: #d8ad61 !important; }
.about-page .offer-eyebrow::before { background: #d8ad61; }

.about-page .offer-divider {
    height: 1px;
    margin: 34px 0 48px;
    background: rgba(255, 255, 255, .24);
}

.about-page .offer-card {
    color: #243143;
    transition: transform .55s cubic-bezier(.16, 1, .3, 1);
}

.about-page .offer-card:hover { transform: translateY(-8px) scale(1.025); }
.about-page .offer-icon-wrap { height: 67px; }

.about-page .offer-icon {
    width: 54px;
    height: 54px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #caae73;
    color: #ffffff;
    font-size: 26px;
}

.about-page .offer-card h5 {
    margin: 8px 0 7px;
    color: #ffffff;
    font-size: 21px;
    font-weight: 500;
}

.about-page .offer-card p {
    margin: 0;
    color: #213246;
    font-size: 13px;
    line-height: 1.85;
}

.about-page .offer-arrow {
    display: flex;
    align-items: center;
    margin-top: 26px;
    color: #ffffff;
}

.about-page .offer-arrow > span {
    width: 32px;
    height: 1px;
    background: #ffffff;
}

.about-page .offer-arrow i {
    width: 28px;
    height: 28px;
    margin-left: -1px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .6);
    border-radius: 50%;
    font-size: 10px;
}

/* Gallery strip */
.about-gallery-section {
    min-height: 515px;
    padding: 70px 0 94px;
    background: linear-gradient(to bottom, #6d6f74 0, #6d6f74 158px, #ffffff 158px, #ffffff 100%);
    border-top: 3px solid var(--front-navy);
}

.about-gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.about-gallery-card {
    position: relative;
    height: 293px;
    overflow: hidden;
    background: #dddddd;
    color: #ffffff;
    text-decoration: none !important;
}

.about-gallery-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .7s cubic-bezier(.16, 1, .3, 1);
}

.about-gallery-card:hover img { transform: scale(1.08); }

.about-gallery-play {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: #ffffff;
    font-size: 40px;
    text-shadow: 0 3px 12px rgba(0, 0, 0, .25);
}

.about-gallery-label {
    position: absolute;
    left: 14px;
    bottom: 12px;
    padding: 5px 8px;
    background: rgba(39, 49, 63, .82);
    color: #ffffff;
    font-size: 11px;
}

/* Shared testimonial styling for About page */
.about-page .testimonial-section {
    position: relative;
    min-height: 515px;
    padding-top: 20px;
    overflow: hidden;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}


.about-page .testimonial-section .section-heading-row {
    padding-bottom: 29px;
    border-bottom: 1px solid #d7d7d7;
}

.about-page .testimonial-card {
    max-width: 700px;
    min-height: 265px;
    padding: 85px 0 35px;
}

.about-page #testimonialCarousel {
    position: relative;
    height: 340px;
    overflow: hidden;
}

.about-page #testimonialCarousel .carousel-inner,
.about-page #testimonialCarousel .carousel-item {
    height: 340px;
    overflow: hidden;
}

.about-page #testimonialCarousel.carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity .65s ease-in-out;
}

.about-page #testimonialCarousel.carousel-fade .carousel-item.active { opacity: 1; }

.about-page #testimonialCarousel .testimonial-card {
    width: 100%;
    height: 340px;
    min-height: 0;
    padding: 54px 55px 46px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transform: none !important;
    animation: none !important;
}

.about-page .testimonial-card blockquote {
    max-width: 610px;
    margin: 0 auto 28px;
    color: #44505e;
    font-size: 13px;
    line-height: 1.8;
    text-align: center;
}

.about-page .testimonial-card h6 {
    margin: 0;
    color: #263344;
    font-size: 18px;
    font-weight: 500;
}

.about-page .testimonial-card small {
    color: var(--front-gold-dark);
    font-size: 11px;
}

.about-page .testimonial-avatar {
    width: 58px;
    height: 58px;
    margin-bottom: 10px;
    border-radius: 50%;
    object-fit: cover;
}

.about-page .testimonial-rating { color: var(--front-gold); font-size: 11px; }

.about-page .testimonial-control {
    width: 35px;
    height: 35px;
    top: 61%;
    bottom: auto;
    border-radius: 50%;
    background: #c9aa6b;
    color: #ffffff;
    transform: translateY(-50%);
    opacity: 1;
}

.about-page .testimonial-control.carousel-control-prev { left: 78px; }
.about-page .testimonial-control.carousel-control-next { right: 78px; }

.about-page .testimonial-indicators {
    bottom: 22px;
    margin-bottom: 0;
}

.about-page .testimonial-indicators li {
    width: 22px;
    height: 3px;
    margin: 0 4px;
    border: 0;
    background: #e5dcc9;
    opacity: 1;
}

.about-page .testimonial-indicators .active { background: #c7a769; }

@media (max-width: 991.98px) {
    .about-page .about-page-hero .container,
    .about-page .about-main-section .container,
    .about-page .about-purpose-section .container,
    .about-page .offer-section .container,
    .about-page .about-gallery-section .container,
    .about-page .testimonial-section .container {
        max-width: 720px;
    }

    .about-main-visual { margin: 0 auto 70px; }
    .about-main-copy { margin: 0 auto; }
    .about-main-section { padding-top: 70px; }
    .about-purpose-card { grid-template-columns: 1fr; }
    .about-purpose-item + .about-purpose-item { border-left: 0; border-top: 1px solid #dfdfdf; }
    .about-purpose-item { min-height: 230px; }
    .about-stats-band, .about-stats-row { min-height: 230px; }
    .about-stat { margin: 18px 0; }
    .about-stats-row > div:nth-child(3) .about-stat { border-left: 0; }
    .about-page .offer-section { min-height: auto; }
    .about-page .section-heading-row { align-items: flex-end; }
    .about-gallery-card { height: 245px; }
    .about-page .testimonial-section { min-height: auto; }
}

@media (max-width: 767.98px) {
    .about-page .front-topbar { display: none; }
    .about-page .front-header { top: 0; }

    .about-page .about-page-hero .container,
    .about-page .about-main-section .container,
    .about-page .about-purpose-section .container,
    .about-page .offer-section .container,
    .about-page .about-gallery-section .container,
    .about-page .testimonial-section .container {
        max-width: 540px;
    }

    .about-page-hero,
    .about-hero-inner { min-height: 400px; }
    .about-hero-content { margin-top: 45px; }
    .about-hero-content h1 { font-size: 38px; }

    .about-main-photo { width: 100%; height: auto; }
    .about-main-mark { width: 145px; right: -8px; bottom: -45px; }
    .about-main-copy .section-title { font-size: 34px; }

    .about-page .section-heading-row { display: block; }
    .about-page .section-heading-row .front-btn { margin-top: 22px; }

    .about-gallery-grid { grid-template-columns: 1fr; gap: 18px; }
    .about-gallery-section {
        background: linear-gradient(to bottom, #6d6f74 0, #6d6f74 150px, #ffffff 150px, #ffffff 100%);
    }
    .about-gallery-card { height: 300px; }

    .about-page .testimonial-control.carousel-control-prev { left: 10px; }
    .about-page .testimonial-control.carousel-control-next { right: 10px; }
    .about-page #testimonialCarousel,
    .about-page #testimonialCarousel .carousel-inner,
    .about-page #testimonialCarousel .carousel-item,
    .about-page #testimonialCarousel .testimonial-card { height: 360px; }
}

@media (max-width: 575.98px) {
    .about-page .about-page-hero .container,
    .about-page .about-main-section .container,
    .about-page .about-purpose-section .container,
    .about-page .offer-section .container,
    .about-page .about-gallery-section .container,
    .about-page .testimonial-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .about-page-hero,
    .about-hero-inner { min-height: 365px; }
    .about-hero-content h1 { font-size: 34px; }
    .about-breadcrumb { min-height: 38px; padding: 0 13px; }

    .about-main-section { padding-top: 55px; }
    .about-main-visual { margin-bottom: 60px; }
    .about-main-mark { width: 120px; right: -2px; bottom: -38px; }
    .about-main-copy .section-title { font-size: 30px; }

    .about-purpose-item { padding: 35px 24px 30px; }
    .about-purpose-icon { left: 24px; bottom: 30px; font-size: 38px; }
    .about-stats-band, .about-stats-row { min-height: 260px; }
    .about-stat strong { font-size: 38px; }
    .about-stat span { font-size: 29px; }
    .about-stat small { font-size: 9px; }

    .about-page .offer-section { padding-top: 55px; }
    .about-gallery-card { height: 250px; }

    .about-page #testimonialCarousel,
    .about-page #testimonialCarousel .carousel-inner,
    .about-page #testimonialCarousel .carousel-item,
    .about-page #testimonialCarousel .testimonial-card { height: 390px; }
    .about-page #testimonialCarousel .testimonial-card { padding: 48px 38px; }
}
</style>
@endpush
