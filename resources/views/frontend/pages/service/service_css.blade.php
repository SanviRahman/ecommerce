@push('css')
<style>
/* ================================================================
   Services page only
   ================================================================ */
.service-page {
    background: #f7f7f7;
}

.service-page .service-page-hero .container,
.service-page .service-list-section .container,
.service-page .service-gallery-section .container,
.service-page .testimonial-section .container {
    max-width: 960px;
}

/* Hero topbar/header */
.service-page .front-topbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5100;
    background: transparent;
    color: #ffffff;
}

.service-page .front-topbar .front-container {
    min-height: 34px;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.service-page .front-topbar-contact,
.service-page .front-topbar-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.service-page .front-topbar a,
.service-page .front-topbar-contact,
.service-page .front-topbar-meta,
.service-page .front-business-hours,
.service-page .front-whatsapp-icon {
    color: #ffffff;
}

.service-page .front-header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5050;
    background: transparent;
    border-top: 0;
    box-shadow: none;
}

.service-page .front-topbar + .front-header {
    top: 34px;
}

.service-page .front-header.is-scrolled {
    position: fixed;
    top: 0;
    background: rgba(39, 53, 70, .985);
    border-top: 3px solid #5d6671;
    box-shadow: 0 9px 28px rgba(0, 0, 0, .20);
    animation: serviceHeaderDrop .42s cubic-bezier(.16, 1, .3, 1) both;
}

@keyframes serviceHeaderDrop {
    from { opacity: 0; transform: translateY(-100%); }
    to { opacity: 1; transform: translateY(0); }
}

/* Hero */
.service-page-hero {
    position: relative;
    min-height: 445px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        linear-gradient(rgba(32, 27, 23, .27), rgba(32, 27, 23, .33)),
        url('{{ asset('frontend/images/about/about-hero.webp') }}') center/cover no-repeat;
}

.service-page-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(24, 18, 12, .04), rgba(31, 42, 54, .08));
    pointer-events: none;
}

.service-hero-inner {
    position: relative;
    z-index: 2;
    min-height: 445px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-hero-content {
    margin-top: 72px;
    text-align: center;
}

.service-hero-content h1 {
    margin: 0 0 20px;
    color: #ffffff;
    font-size: 46px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -.5px;
}

.service-breadcrumb {
    min-height: 40px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 11px;
    background: #ffffff;
    color: #c8a366;
    font-size: 12px;
}

.service-breadcrumb a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #213249;
    text-decoration: none;
}

.service-breadcrumb a:hover {
    color: var(--front-gold-dark);
}

.service-breadcrumb-separator {
    color: #bcc1c6;
    font-size: 9px;
}

/* Service list */
.service-list-section {
    padding: 25px 0 15px;
    background: #f8f8f8;
    border-top: 3px solid var(--front-navy);
}

.service-heading {
    padding-top: 0;
}

.service-heading .section-title {
    font-size: 38px;
}

.service-heading-line {
    height: 1px;
    margin: 34px 0 70px;
    background: #d7d7d7;
}

.service-item {
    margin-bottom: 15px;
}

.service-image-wrap {
    width: 450px;
    max-width: 100%;
    height: 450px;
    overflow: hidden;
    background: #e9e5dc;
}

.service-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1);
    transition: transform .8s cubic-bezier(.16, 1, .3, 1);
}

.service-image-wrap:hover .service-image {
    transform: scale(1.065);
}

.service-copy {
    position: relative;
    min-height: 450px;
    padding: 108px 20px 55px 62px;
}

.service-main-icon {
    position: relative;
    width: 58px;
    height: 58px;
    margin-bottom: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #1b2d43;
    font-size: 32px;
    line-height: 1;
}

.service-main-icon::before {
    content: '';
    position: absolute;
    left: 0;
    top: 1px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #cfad6b;
    z-index: 0;
}

.service-main-icon i {
    position: relative;
    z-index: 1;
}

.service-ghost-icon {
    position: absolute;
    right: 8px;
    top: 112px;
    color: #26384c;
    font-size: 57px;
    opacity: .07;
    pointer-events: none;
}

.service-copy h3 {
    margin: 0 0 11px;
    color: #142942;
    font-size: 22px;
    font-weight: 500;
    line-height: 1.2;
}

.service-copy p {
    max-width: 425px;
    margin: 0;
    color: #20354e;
    font-size: 13px;
    line-height: 1.85;
}

/* Gallery */
.service-gallery-section {
    position: relative;
    min-height: 565px;
    padding: 60px 0 62px;
    overflow: hidden;
    background: linear-gradient(to bottom, #777a7f 0, #777a7f 485px, #ffffff 485px, #ffffff 100%);
    border-top: 3px solid var(--front-navy);
}

.service-gallery-heading {
    padding: 0 0 68px;
    color: #ffffff;
    text-align: center;
}

.service-gallery-eyebrow {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-bottom: 9px;
    color: #d9b671;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .55px;
    text-transform: uppercase;
}

.service-gallery-eyebrow span {
    width: 23px;
    height: 1px;
    background: #d9b671;
}

.service-gallery-eyebrow strong {
    font-weight: 500;
}

.service-gallery-heading h2 {
    max-width: 560px;
    margin: 0 auto;
    color: #ffffff;
    font-size: 38px;
    font-weight: 500;
    line-height: 1.08;
    letter-spacing: -.7px;
}

.service-gallery-viewport {
    width: 100%;
    overflow: hidden;
    touch-action: pan-y;
    cursor: grab;
}

.service-gallery-viewport.is-dragging {
    cursor: grabbing;
}

.service-gallery-track {
    display: flex;
    gap: 30px;
    will-change: transform;
    transition: transform .78s cubic-bezier(.25, .46, .45, .94);
}

.service-gallery-card {
    position: relative;
    flex: 0 0 calc((100% - 60px) / 3);
    height: 285px;
    overflow: hidden;
    background: #ddd;
    color: #ffffff;
    text-decoration: none !important;
}

.service-gallery-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .75s cubic-bezier(.16, 1, .3, 1);
}

.service-gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(25, 36, 48, .06);
    transition: background-color .45s ease;
}

.service-gallery-play {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: #ffffff;
    font-size: 40px;
    text-shadow: 0 3px 12px rgba(0, 0, 0, .25);
    transition: transform .45s cubic-bezier(.16, 1, .3, 1);
}

.service-gallery-label {
    position: absolute;
    left: 14px;
    bottom: 12px;
    padding: 5px 8px;
    background: rgba(39, 49, 63, .82);
    color: #ffffff;
    font-size: 11px;
}

.service-gallery-card:hover img {
    transform: scale(1.08);
}

.service-gallery-card:hover .service-gallery-overlay {
    background: rgba(25, 36, 48, .20);
}

.service-gallery-card:hover .service-gallery-play {
    transform: translate(-50%, -50%) scale(1.12);
}

/* Shared testimonial styling on Service page */
.service-page .testimonial-section {
    min-height: 515px;
    padding: 20px 0 0;
    overflow: hidden;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.service-page .testimonial-section .section-heading-row {
    min-height: 96px;
    padding-bottom: 29px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 30px;
    border-bottom: 1px solid #d7d7d7;
}

.service-page .testimonial-card {
    max-width: 700px;
    min-height: 265px;
    padding: 85px 0 35px;
}

.service-page #testimonialCarousel {
    position: relative;
    height: 340px;
    overflow: hidden;
}

.service-page #testimonialCarousel .carousel-inner,
.service-page #testimonialCarousel .carousel-item {
    height: 340px;
    overflow: hidden;
}

.service-page #testimonialCarousel.carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity .65s ease-in-out;
}

.service-page #testimonialCarousel.carousel-fade .carousel-item.active {
    opacity: 1;
}

.service-page #testimonialCarousel .testimonial-card {
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

.service-page .testimonial-card blockquote {
    max-width: 610px;
    margin: 0 auto 28px;
    color: #44505e;
    font-size: 13px;
    line-height: 1.8;
    text-align: center;
}

.service-page .testimonial-card h6 {
    margin: 0;
    color: #263344;
    font-size: 18px;
    font-weight: 500;
}

.service-page .testimonial-card small {
    color: var(--front-gold-dark);
    font-size: 11px;
}

.service-page .testimonial-avatar {
    width: 58px;
    height: 58px;
    margin-bottom: 10px;
    border-radius: 50%;
    object-fit: cover;
}

.service-page .testimonial-rating {
    color: var(--front-gold);
    font-size: 11px;
}

.service-page .testimonial-control {
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

.service-page .testimonial-control.carousel-control-prev {
    left: 78px;
}

.service-page .testimonial-control.carousel-control-next {
    right: 78px;
}

.service-page .testimonial-indicators {
    bottom: 22px;
    margin-bottom: 0;
}

.service-page .testimonial-indicators li {
    width: 22px;
    height: 3px;
    margin: 0 4px;
    border: 0;
    background: #e5dcc9;
    opacity: 1;
}

.service-page .testimonial-indicators .active {
    background: #c7a769;
}

@media (max-width: 991.98px) {
    .service-page .service-page-hero .container,
    .service-page .service-list-section .container,
    .service-page .service-gallery-section .container,
    .service-page .testimonial-section .container {
        max-width: 720px;
    }

    .service-heading-line {
        margin-bottom: 50px;
    }

    .service-image-wrap {
        width: 100%;
        height: 430px;
    }

    .service-copy {
        min-height: 390px;
        padding: 80px 25px 45px 45px;
    }

    .service-ghost-icon {
        top: 84px;
        right: 20px;
    }

    .service-gallery-card {
        flex-basis: calc((100% - 30px) / 2);
    }
}

@media (max-width: 767.98px) {
    .service-page .front-topbar {
        display: none;
    }

    .service-page .front-header {
        top: 0;
    }

    .service-page .service-page-hero .container,
    .service-page .service-list-section .container,
    .service-page .service-gallery-section .container,
    .service-page .testimonial-section .container {
        max-width: 540px;
    }

    .service-page-hero,
    .service-hero-inner {
        min-height: 400px;
    }

    .service-hero-content {
        margin-top: 45px;
    }

    .service-hero-content h1 {
        font-size: 38px;
    }

    .service-list-section {
        padding-top: 45px;
    }

    .service-image-wrap {
        height: auto;
        aspect-ratio: 1 / 1;
    }

    .service-copy {
        min-height: 0;
        padding: 48px 10px 65px;
    }

    .service-ghost-icon {
        right: 15px;
        top: 48px;
    }

    .service-item {
        margin-bottom: 0;
    }

    .service-gallery-section {
        padding-top: 45px;
        background: linear-gradient(to bottom, #777a7f 0, #777a7f 445px, #ffffff 445px, #ffffff 100%);
    }

    .service-gallery-card {
        flex-basis: 100%;
        height: 320px;
    }

    .service-page .testimonial-section .section-heading-row {
        display: block;
    }

    .service-page .testimonial-section .front-btn {
        margin-top: 20px;
    }

    .service-page .testimonial-control.carousel-control-prev {
        left: 10px;
    }

    .service-page .testimonial-control.carousel-control-next {
        right: 10px;
    }
}

@media (max-width: 575.98px) {
    .service-page .service-page-hero .container,
    .service-page .service-list-section .container,
    .service-page .service-gallery-section .container,
    .service-page .testimonial-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .service-page-hero,
    .service-hero-inner {
        min-height: 365px;
    }

    .service-hero-content h1 {
        font-size: 34px;
    }

    .service-breadcrumb {
        min-height: 38px;
        padding: 0 13px;
    }

    .service-heading .section-title {
        font-size: 30px;
    }

    .service-heading-line {
        margin: 28px 0 38px;
    }

    .service-copy {
        padding: 38px 0 55px;
    }

    .service-copy h3 {
        font-size: 21px;
    }

    .service-copy p {
        font-size: 13px;
    }

    .service-ghost-icon {
        font-size: 48px;
        opacity: .055;
    }

    .service-gallery-section {
        padding-top: 36px;
    }

    .service-gallery-heading {
        padding-bottom: 45px;
    }

    .service-gallery-heading h2 {
        font-size: 31px;
    }

    .service-gallery-card {
        height: 280px;
    }

    .service-page #testimonialCarousel,
    .service-page #testimonialCarousel .carousel-inner,
    .service-page #testimonialCarousel .carousel-item,
    .service-page #testimonialCarousel .testimonial-card {
        height: 390px;
    }

    .service-page #testimonialCarousel .testimonial-card {
        padding: 48px 38px;
    }
}
</style>
@endpush
