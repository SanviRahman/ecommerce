@push('css')
<style>
/* Home-only sizing: slightly wider/larger without affecting other pages */
.home-hero .container,
.about-preview .container,
.home-products .container,
.offer-section .container,
.offer-gallery-wrap .container,
.tmc-section .container,
.testimonial-section .container,
.faq-section .container,
.payment-section .container {
    max-width: 1020px;
}

.section-heading-row {
    min-height: 70px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 30px;
}

/* Hero */
.home-hero {
    overflow: hidden;
    background: var(--front-navy);
}

.hero-slide {
    position: relative;
    min-height: 545px;
    overflow: hidden;
    background-image: url('{{ asset('frontend/images/home/hero-background.webp') }}');
    background-position: center;
    background-size: cover;
}

.hero-slide::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(39, 49, 63, .12) 0%, rgba(39, 49, 63, .04) 48%, rgba(39, 49, 63, .18) 100%);
    pointer-events: none;
}

.hero-container {
    position: relative;
    z-index: 4;
    min-height: 545px;
}

.hero-copy {
    position: absolute;
    left: 0;
    top: 146px;
    width: 425px;
    animation: heroTextIn 1.15s .08s cubic-bezier(.16, 1, .3, 1) both;
}

.hero-kicker {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    color: #e3b253;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.hero-kicker::before {
    content: '';
    width: 23px;
    height: 1px;
    background: #e3b253;
}

.hero-copy h1 {
    margin: 0 0 34px;
    color: #ffffff;
    font-size: 39px;
    font-weight: 600;
    line-height: 1.12;
    letter-spacing: -.35px;
}

.hero-visual {
    position: absolute;
    z-index: 2;
    inset: 0;
    pointer-events: none;
}

.hero-shape {
    position: absolute;
    object-fit: contain;
    filter: none;
    transform-origin: center center;
    will-change: transform, opacity;
    transition:
        transform 1.45s cubic-bezier(.16, 1, .3, 1),
        opacity 1.05s ease;
}

.hero-shape-main {
    width: 715px;
    height: 545px;
    left: calc(50% - 85px);
    top: 0;
}

.hero-shape-second {
    width: 405px;
    height: 350px;
    right: -13px;
    top: 64px;
}

.hero-shape-third {
    width: 290px;
    height: 350px;
    right: -150px;
    top: 67px;
}

.home-hero .carousel-fade .carousel-item {
    transition: opacity 1.15s ease-in-out;
}

.home-hero .carousel-item:not(.active) .hero-shape-main {
    transform: translateX(70px) scale(.76);
    opacity: .08;
}

.home-hero .carousel-item:not(.active) .hero-shape-second {
    transform: translateX(90px) scale(.74);
    opacity: .05;
}

.home-hero .carousel-item:not(.active) .hero-shape-third {
    transform: translateX(110px) scale(.72);
    opacity: .03;
}

.home-hero .carousel-item.active .hero-shape-main {
    animation: heroVisualZoomIn 1.35s cubic-bezier(.16, 1, .3, 1) both;
}

.home-hero .carousel-item.active .hero-shape-second {
    animation: heroVisualZoomIn 1.45s .08s cubic-bezier(.16, 1, .3, 1) both;
}

.home-hero .carousel-item.active .hero-shape-third {
    animation: heroVisualZoomIn 1.55s .16s cubic-bezier(.16, 1, .3, 1) both;
}

.hero-indicators {
    left: auto;
    right: 247px;
    bottom: 26px;
    width: auto;
    margin: 0;
}

.hero-indicators li {
    width: 8px;
    height: 8px;
    margin: 0 4px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    background: transparent;
    opacity: 1;
}

.hero-indicators .active {
    background: #e4ad4d;
    border-color: #e4ad4d;
}

@keyframes heroTextIn {
    from {
        opacity: 0;
        transform: translateY(38px) scale(.84);
        filter: blur(4px);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }
}

@keyframes heroVisualZoomIn {
    from {
        opacity: .05;
        transform: translateX(80px) scale(.76);
    }

    to {
        opacity: 1;
        transform: translateX(0) scale(1);
    }
}

@keyframes sectionZoomIn {
    from {
        opacity: 0;
        transform: scale(.82);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes cardZoomIn {
    from {
        opacity: 0;
        transform: translateY(34px) scale(.80);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* About */
.about-preview {
    min-height: 552px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.about-row {
    min-height: 474px;
}

.about-copy {
    max-width: 470px;
    margin: 14px 0 0;
    color: #1d3149;
    font-size: 13px;
    line-height: 1.85;
}

.about-rule {
    width: 470px;
    max-width: 100%;
    height: 1px;
    margin: 38px 0 28px;
    background: #d4d4d4;
}

.about-points span {
    position: relative;
    display: block;
    margin-bottom: 14px;
    padding-left: 19px;
    color: #152a43;
    font-size: 12px;
    line-height: 1.25;
}

.about-points span::before {
    content: '';
    position: absolute;
    left: 0;
    top: 5px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #e6b455;
}

.about-btn {
    margin-top: 22px;
}

.about-art-wrap {
    width: 492px;
    max-width: 100%;
    margin-left: auto;
}

.about-art-wrap img {
    width: 100%;
    display: block;
}

/* Products */
.home-products {
    min-height: 552px;
    padding-top: 20px;
    background: #ffffff;
    border-top: 3px solid var(--front-navy);
    background-image:
        radial-gradient(circle at -7% 60%, rgba(213, 184, 119, .10), transparent 20%),
        radial-gradient(circle at 108% 56%, rgba(213, 184, 119, .10), transparent 20%);
}

.products-rule {
    height: 1px;
    margin: 28px 0 52px;
    background: #d8d8d8;
}

.product-row {
    margin-left: -25px;
    margin-right: -25px;
}

.product-row>[class*="col-"] {
    padding-left: 25px;
    padding-right: 25px;
}

.product-showcase-card {
    display: block;
    color: var(--front-ink);
    text-align: center;
    text-decoration: none !important;
}

.product-media {
    height: 228px;
    overflow: hidden;
    background: #eeeeee;
}

.product-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .7s cubic-bezier(.16, 1, .3, 1);
}

.product-showcase-card:hover .product-media img {
    transform: scale(1.10);
}

/*
 * Stable desktop product carousel.
 *
 * Bootstrap handles the horizontal slide. A second translate/scale entrance
 * animation on every newly-active card made the content visibly jump.
 * The card hover image zoom remains unchanged.
 */
#productShowcaseCarousel {
    position: relative;
    overflow: visible;
}

#productShowcaseCarousel .carousel-inner {
    height: 375px;
    overflow: hidden;
}

#productShowcaseCarousel .carousel-item {
    height: 375px;
    backface-visibility: hidden;
    will-change: transform;
    transition: transform .82s cubic-bezier(.22, .61, .36, 1) !important;
}

#productShowcaseCarousel .product-row {
    height: 100%;
}

#productShowcaseCarousel .product-showcase-card {
    animation: none !important;
}

.product-card-body {
    position: relative;
    padding: 51px 5px 0;
}

.product-round-icon {
    position: absolute;
    top: -42px;
    left: 50%;
    width: 78px;
    height: 78px;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #cfad6b;
    color: #ffffff;
    font-size: 28px;
}

.product-card-body h5 {
    margin: 0 0 4px;
    color: #112842;
    font-size: 22px;
    font-weight: 500;
}

.product-card-body small {
    color: #c59c54;
    font-size: 11px;
    letter-spacing: .4px;
    text-transform: uppercase;
}

.product-control {
    width: 36px;
    height: 36px;
    top: 48%;
    bottom: auto;
    z-index: 6;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--front-navy);
    color: #ffffff;
    transform: translateY(-50%);
    opacity: .95;
    visibility: visible;
}

.product-control.carousel-control-prev {
    left: -18px;
}

.product-control.carousel-control-next {
    right: -18px;
}

.product-carousel-mobile {
    overflow: hidden;
}

#productShowcaseMobileCarousel .carousel-inner {
    overflow: hidden;
}

#productShowcaseMobileCarousel .carousel-item {
    transition: transform .82s cubic-bezier(.22, .61, .36, 1) !important;
    backface-visibility: hidden;
    will-change: transform;
}

#productShowcaseMobileCarousel .mobile-product-card {
    width: 100%;
    max-width: 360px;
    margin: 0 auto;
}

#productShowcaseMobileCarousel .carousel-item.active .mobile-product-card {
    animation: none !important;
    transform: none !important;
}

/* What we offer */
.offer-section {
    min-height: 552px;
    padding-top: 84px;
    padding-bottom: 54px;
    background:
        linear-gradient(rgba(116, 118, 122, .90), rgba(116, 118, 122, .90)),
        url('{{ asset('frontend/images/home/hero-background.webp') }}') center/cover no-repeat;
    border-top: 3px solid var(--front-navy);
}

.offer-eyebrow {
    color: #d8ad61 !important;
}

.offer-eyebrow::before {
    background: #d8ad61;
}

.offer-divider {
    height: 1px;
    margin: 42px 0 55px;
    background: rgba(255, 255, 255, .22);
}


.offer-card {
    color: #243143;
    transition: transform .55s cubic-bezier(.16, 1, .3, 1);
}

.offer-card:hover {
    transform: translateY(-8px) scale(1.025);
}

.offer-icon-wrap {
    height: 67px;
}

.offer-icon {
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

.offer-card h5 {
    margin: 8px 0 7px;
    color: #ffffff;
    font-size: 21px;
    font-weight: 500;
}

.offer-card p {
    margin: 0;
    color: #213246;
    font-size: 13px;
    line-height: 1.85;
}

.offer-arrow {
    display: flex;
    align-items: center;
    margin-top: 26px;
    color: #ffffff;
}

.offer-arrow>span {
    width: 32px;
    height: 1px;
    background: #ffffff;
}

.offer-arrow i {
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

/* Gallery */
.offer-gallery-wrap {
    min-height: 558px;
    padding: 118px 0 98px;
    background: linear-gradient(to bottom, #6d6f74 0, #6d6f74 199px, #ffffff 199px, #ffffff 100%);
    border-top: 3px solid var(--front-navy);
}

.offer-gallery {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.offer-gallery-item {
    position: relative;
    height: 314px;
    overflow: hidden;
    background: #dddddd;
    color: #ffffff;
    text-decoration: none !important;
}

.offer-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .75s cubic-bezier(.16, 1, .3, 1);
}

.offer-gallery-item:hover img {
    transform: scale(1.10);
}

#offerGalleryCarousel .carousel-item.active .offer-gallery-item {
    animation: cardZoomIn 1s cubic-bezier(.16, 1, .3, 1) both;
}

#offerGalleryCarousel .carousel-item.active .offer-gallery-item:nth-child(2) {
    animation-delay: .11s;
}

#offerGalleryCarousel .carousel-item.active .offer-gallery-item:nth-child(3) {
    animation-delay: .22s;
}

.gallery-play {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    color: #ffffff;
    font-size: 39px;
    text-shadow: 0 2px 12px rgba(0, 0, 0, .25);
}

.gallery-label {
    position: absolute;
    left: 14px;
    bottom: 12px;
    padding: 5px 8px;
    background: rgba(39, 49, 63, .82);
    color: #ffffff;
    font-size: 11px;
}

.gallery-control {
    width: 36px;
    height: 36px;
    top: 50%;
    bottom: auto;
    border-radius: 50%;
    background: var(--front-gold);
    transform: translateY(-50%);
    opacity: 1;
}

.gallery-control.carousel-control-prev {
    left: -28px;
}

.gallery-control.carousel-control-next {
    right: -28px;
}

/* Testimonials */
.testimonial-section {
    min-height: 550px;
    padding-top: 20px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.testimonial-section .section-heading-row {
    padding-top: 0;
}

.testimonial-section .container>.section-heading-row {
    padding-bottom: 30px;
    border-bottom: 1px solid #d7d7d7;
}

.testimonial-card {
    max-width: 700px;
    min-height: 265px;
    padding: 102px 0 40px;
}

#testimonialCarousel {
    position: relative;
    height: 340px;
    overflow: hidden;
}

#testimonialCarousel .carousel-inner {
    position: relative;
    width: 100%;
    height: 340px;
    overflow: hidden;
}

#testimonialCarousel .carousel-item {
    height: 340px;
    min-height: 0;
    overflow: hidden;
    transform: none !important;
}

#testimonialCarousel.carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity .25s ease-in-out;
}

#testimonialCarousel.carousel-fade .carousel-item.active {
    opacity: 1;
}

#testimonialCarousel .testimonial-card {
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

#testimonialCarousel .testimonial-card blockquote {
    max-height: 115px;
    overflow: hidden;
}

#testimonialCarousel .carousel-control-prev,
#testimonialCarousel .carousel-control-next {
    z-index: 3;
}

.testimonial-card blockquote {
    margin: 0 auto 28px;
    color: #44505e;
    font-size: 13px;
    line-height: 1.8;
    max-width: 610px;
}

.testimonial-card h6 {
    margin: 0;
    color: #263344;
    font-size: 18px;
    font-weight: 500;
}

.testimonial-card small {
    color: var(--front-gold-dark);
    font-size: 11px;
}

.testimonial-avatar {
    width: 58px;
    height: 58px;
    margin-bottom: 10px;
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-rating {
    color: var(--front-gold);
    font-size: 11px;
}

.testimonial-control {
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

.testimonial-control.carousel-control-prev {
    left: 78px;
}

.testimonial-control.carousel-control-next {
    right: 78px;
}

.testimonial-indicators {
    bottom: 22px;
    margin-bottom: 0;
}

.testimonial-indicators li {
    width: 22px;
    height: 3px;
    margin: 0 4px;
    border: 0;
    background: #e5dcc9;
    opacity: 1;
}

.testimonial-indicators .active {
    background: #c7a769;
}

/* FAQ */
.faq-section {
    min-height: 555px;
    padding-top: 30px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.faq-row {
    min-height: 495px;
}

.faq-visual {
    position: relative;
    width: 430px;
    max-width: 100%;
}

.faq-visual>img {
    width: 100%;
    height: 430px;
    object-fit: cover;
}

.stats-row {
    position: absolute;
    left: 86px;
    bottom: -4px;
    display: flex;
    width: 390px;
    max-width: calc(100vw - 40px);
}

.stat-box {
    width: 205px;
    height: 120px;
    display: flex;
    transition: transform .5s cubic-bezier(.16, 1, .3, 1);
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    text-align: center;
}

.stat-gold {
    background: #efb14f;
}

.stat-navy {
    background: #323b46;
}

.stat-box:hover {
    transform: translateY(-5px) scale(1.025);
}

.stat-box>div {
    line-height: 1;
}

.stat-box strong {
    font-size: 42px;
    font-weight: 500;
}

.stat-box span {
    font-size: 32px;
    font-weight: 500;
}

.stat-box small {
    margin-top: 9px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
}

.faq-title {
    margin-bottom: 28px;
}

.faq-item {
    border-bottom: 1px solid #d6d6d6;
}

.faq-question {
    width: 100%;
    min-height: 59px;
    padding: 15px 0;
    display: flex;
    align-items: flex-start;
    gap: 11px;
    border: 0;
    background: transparent;
    color: #102843;
    font-size: 17px;
    font-weight: 500;
    line-height: 1.35;
    text-align: left;
    transition: color .3s ease, transform .3s cubic-bezier(.16, 1, .3, 1);
}

.faq-question:hover {
    color: var(--front-gold-dark);
    transform: translateX(3px);
}

.faq-question:focus {
    outline: none;
}

.faq-question i {
    width: 12px;
    margin-top: 5px;
    color: #17304b;
    font-size: 12px;
}

.faq-answer {
    padding: 0 6px 19px 23px;
    color: #1d3149;
    font-size: 13px;
    line-height: 1.85;
}

/* Payment */
.payment-section {
    min-height: 450px;
    padding-top: 108px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.payment-row {
    min-height: 265px;
}

.payment-copy {
    margin: 18px 0 0;
    color: #1a3049;
    font-size: 13px;
    line-height: 1.9;
}

.payment-art {
    width: 455px;
    max-width: 100%;
    margin-left: auto;
}

.payment-art img {
    width: 100%;
    display: block;
    transition: transform .65s cubic-bezier(.16, 1, .3, 1);
}

.payment-art:hover img {
    transform: scale(1.035);
}

.carousel-item.motion-refresh.active .hero-copy {
    animation: heroTextIn 1.15s .06s cubic-bezier(.16, 1, .3, 1) both;
}

.carousel-item.motion-refresh.active .hero-shape-main,
.carousel-item.motion-refresh.active .hero-shape-second,
.carousel-item.motion-refresh.active .hero-shape-third {
    animation-name: heroVisualZoomIn;
}

@media (max-width: 1199.98px) {
    .hero-copy {
        left: 15px;
    }

    .hero-shape-main {
        left: calc(50% - 50px);
    }

    .hero-shape-second {
        right: -70px;
    }

    .hero-shape-third {
        right: -195px;
    }
}

@media (max-width: 991.98px) {

    .home-hero .container,
    .about-preview .container,
    .home-products .container,
    .offer-section .container,
    .offer-gallery-wrap .container,
    .tmc-section .container,
    .testimonial-section .container,
    .faq-section .container,
    .payment-section .container {
        max-width: 720px;
    }

    .hero-slide,
    .hero-container {
        min-height: 470px;
    }

    .hero-copy {
        left: 0;
        top: 125px;
        width: 440px;
    }

    .hero-copy h1 {
        font-size: 38px;
    }

    .hero-visual {
        opacity: .35;
    }

    .hero-shape-main {
        left: 36%;
    }

    .hero-shape-second {
        right: -180px;
    }

    .hero-shape-third {
        display: none;
    }

    .hero-indicators {
        right: 30px;
    }

    .about-preview,
    .home-products,
    .offer-section,
    .offer-gallery-wrap,
    .tmc-section,
    .testimonial-section,
    .faq-section,
    .payment-section {
        min-height: auto;
    }

    .about-row,
    .tmc-row,
    .faq-row,
    .payment-row {
        min-height: auto;
    }

    .about-art-wrap {
        margin: 35px auto 0;
    }

    .section-heading-row {
        align-items: flex-end;
    }

    .product-row {
        margin-left: -15px;
        margin-right: -15px;
    }

    .product-row>[class*="col-"] {
        padding-left: 15px;
        padding-right: 15px;
    }

    .offer-section {
        padding-top: 65px;
    }

    .offer-gallery {
        gap: 18px;
    }

    .offer-gallery-item {
        height: 245px;
    }

    .faq-visual {
        margin: 0 auto 100px;
    }

    .stats-row {
        left: 50%;
        transform: translateX(-50%);
    }

    .payment-section {
        padding-top: 70px;
    }

    .payment-art {
        margin: 35px auto 0;
    }
}

@media (max-width: 767.98px) {

    .home-hero .container,
    .about-preview .container,
    .home-products .container,
    .offer-section .container,
    .offer-gallery-wrap .container,
    .tmc-section .container,
    .testimonial-section .container,
    .faq-section .container,
    .payment-section .container {
        max-width: 540px;
    }

    .section-heading-row {
        display: block;
    }

    .section-heading-row .front-btn {
        margin-top: 22px;
    }

    .hero-visual {
        opacity: .2;
    }

    .hero-copy {
        left: 15px;
        right: 15px;
        width: auto;
    }

    .hero-copy h1 {
        font-size: 34px;
    }

    .hero-shape-main {
        left: 20%;
    }

    #productShowcaseMobileCarousel {
        width: 100%;
        overflow: hidden;
    }

    #productShowcaseMobileCarousel .carousel-inner,
    #productShowcaseMobileCarousel .carousel-item {
        height: 385px;
        min-height: 385px;
        overflow: hidden;
    }

    #productShowcaseMobileCarousel .mobile-product-card {
        max-width: 360px;
        height: 100%;
    }

    #productShowcaseMobileCarousel .product-media {
        height: 255px;
    }

    .offer-gallery {
        grid-template-columns: 1fr;
    }

    .offer-gallery-item {
        height: 300px;
    }

    .offer-gallery-wrap {
        background: linear-gradient(to bottom, #6d6f74 0, #6d6f74 160px, #ffffff 160px, #ffffff 100%);
    }

    .testimonial-control.carousel-control-prev {
        left: 10px;
    }

    .testimonial-control.carousel-control-next {
        right: 10px;
    }

    .testimonial-card {
        padding-left: 45px;
        padding-right: 45px;
    }

    #testimonialCarousel,
    #testimonialCarousel .carousel-inner,
    #testimonialCarousel .carousel-item,
    #testimonialCarousel .testimonial-card {
        height: 360px;
    }

    #testimonialCarousel .testimonial-card {
        padding-top: 52px;
        padding-bottom: 52px;
    }
}

@media (max-width: 575.98px) {

    .home-hero .container,
    .about-preview .container,
    .home-products .container,
    .offer-section .container,
    .offer-gallery-wrap .container,
    .tmc-section .container,
    .testimonial-section .container,
    .faq-section .container,
    .payment-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .hero-slide,
    .hero-container {
        min-height: 430px;
    }

    .hero-copy {
        top: 105px;
    }

    .hero-copy h1 {
        font-size: 31px;
    }

    .about-rule {
        margin: 28px 0 20px;
    }

    .product-media {
        height: 240px;
    }

    .offer-gallery-item {
        height: 250px;
    }

    #productShowcaseMobileCarousel .carousel-inner,
    #productShowcaseMobileCarousel .carousel-item {
        height: 350px;
        min-height: 350px;
        overflow: hidden;
    }

    #productShowcaseMobileCarousel .mobile-product-card {
        max-width: 100%;
        height: 100%;
        padding-left: 8px;
        padding-right: 8px;
    }

    #productShowcaseMobileCarousel .product-media {
        height: 230px;
    }

    .faq-visual {
        width: 100%;
    }

    .faq-visual>img {
        height: auto;
    }

    .stats-row {
        width: 96%;
    }

    .stat-box {
        width: 50%;
        height: 100px;
    }

    .stat-box strong {
        font-size: 34px;
    }

    .stat-box span {
        font-size: 27px;
    }

    #testimonialCarousel,
    #testimonialCarousel .carousel-inner,
    #testimonialCarousel .carousel-item,
    #testimonialCarousel .testimonial-card {
        height: 390px;
    }

    #testimonialCarousel .testimonial-card {
        padding: 48px 38px;
    }

    #testimonialCarousel .testimonial-card blockquote {
        max-height: 145px;
    }

    .payment-section {
        padding-top: 55px;
    }
}
</style>
@endpush
