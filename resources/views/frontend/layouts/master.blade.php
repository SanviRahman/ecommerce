<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', $siteSetting->site_name ?? config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">

    @if($siteSetting?->favicon_url)
        <link rel="icon" href="{{ $siteSetting->favicon_url }}?v={{ optional($siteSetting->updated_at)->timestamp }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @include('frontend.partials.tracking-pixels', ['placement' => 'head'])

    <style>
        :root {
            --front-navy: #27313f;
            --front-navy-deep: #25303e;
            --front-gold: #d3ad68;
            --front-gold-dark: #c49c57;
            --front-ink: #142942;
            --front-body: #243244;
            --front-muted: #53606f;
            --front-soft: #f6f6f6;
            --front-line: #d7d7d7;
        }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--front-body);
            background: #ffffff;
            font-family: 'Jost', Arial, sans-serif;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        .container { max-width: 960px; }
        a {
            transition:
                color .38s cubic-bezier(.16, 1, .3, 1),
                background-color .38s cubic-bezier(.16, 1, .3, 1),
                border-color .38s cubic-bezier(.16, 1, .3, 1),
                transform .38s cubic-bezier(.16, 1, .3, 1);
        }
        img { max-width: 100%; }

        .section-space { padding: 35px 0 40px; }

        .section-eyebrow {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 10px;
            color: var(--front-gold-dark);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .55px;
            text-transform: uppercase;
        }

        .section-eyebrow::before {
            content: '';
            width: 23px;
            height: 1px;
            background: var(--front-gold);
        }

        .section-title {
            margin: 0;
            color: var(--front-ink);
            font-size: 38px;
            font-weight: 500;
            line-height: 1.08;
            letter-spacing: -.7px;
        }

        .front-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 145px;
            min-height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 0;
            background: var(--front-gold);
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .2px;
            text-transform: uppercase;
        }

        .front-btn i { margin-left: 14px !important; }

        .front-btn:hover {
            background: var(--front-navy);
            color: #ffffff;
            text-decoration: none;
            transform: translateY(-3px) scale(1.025);
        }

        .front-btn.front-btn-dark {
            background: var(--front-navy);
        }

        .front-btn.front-btn-dark:hover {
            background: var(--front-gold);
        }

        .front-preloader {
            position: fixed;
            inset: 0;
            z-index: 12000;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--front-navy-deep);
            transition: opacity .35s ease, visibility .35s ease;
        }

        .front-preloader.is-hidden { opacity: 0; visibility: hidden; }

        .front-preloader-mark {
            width: 44px;
            height: 44px;
            border: 3px solid rgba(255, 255, 255, .23);
            border-top-color: var(--front-gold);
            border-radius: 50%;
            animation: frontSpin .8s linear infinite;
        }

        @keyframes frontSpin { to { transform: rotate(360deg); } }

        /*
        |--------------------------------------------------------------------------
        | Header / Topbar
        |--------------------------------------------------------------------------
        */

        .front-container {
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
            padding-left: 0;
            padding-right: 0;
        }

        .front-topbar {
            background: #202a36;
            color: rgba(255, 255, 255, .78);
            font-size: 12px;
        }

        .front-topbar .front-container {
            min-height: 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .front-topbar-contact {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .front-topbar a {
            color: rgba(255, 255, 255, .82);
            text-decoration: none;
        }

        .front-topbar a:hover {
            color: var(--front-gold);
        }

        .front-header {
            position: sticky;
            top: 0;
            z-index: 5000;
            width: 100%;
            background: #273546;
            border-top: 3px solid #5d6671;
            transition:
                box-shadow .45s cubic-bezier(.16, 1, .3, 1),
                background-color .45s cubic-bezier(.16, 1, .3, 1);
        }

        .front-header.is-scrolled {
            background: rgba(39, 53, 70, .985);
            box-shadow: 0 9px 28px rgba(0, 0, 0, .20);
        }

        .front-navbar {
            position: relative;
            width: 100%;
            min-height: 68px;
            height: 68px;
        }

        .front-brand {
            position: relative;
            z-index: 3;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
        }

        .site-logo-img {
            display: block;
            width: 116px;
            height: auto;
            max-height: 46px;
            object-fit: contain;
        }

        .brand-fallback {
            color: #ffffff;
            font-size: 19px;
            font-weight: 700;
            line-height: 1;
        }

        /*
         * Desktop nav follows the reference:
         * logo = left, menu = true center, CTA = right.
         */
        @media (min-width: 992px) {
            .front-header .navbar-collapse {
                position: static;
                display: flex !important;
                align-items: center;
                flex-basis: auto;
                flex-grow: 1;
                min-width: 0;
            }

            .front-menu {
                position: absolute;
                left: 50%;
                top: 0;
                height: 68px;
                margin: 0 !important;
                transform: translateX(-50%);
                display: flex;
                align-items: center;
                white-space: nowrap;
            }

            .front-header .navbar-nav .nav-item {
                height: 68px;
                display: flex;
                align-items: center;
            }

            .front-header .navbar-nav .nav-link {
                height: 68px;
                padding: 0 13px !important;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ffffff;
                font-size: 12px;
                font-weight: 600;
                line-height: 1;
                letter-spacing: .18px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .header-cta {
                margin-left: auto;
            }
        }

        .front-header .navbar-nav .nav-link {
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .18px;
            text-transform: uppercase;
        }

        .front-header .navbar-nav .nav-link:hover {
            color: var(--front-gold);
        }

        /* Reference keeps selected menu visually white. */
        .front-header .navbar-nav .nav-item.active .nav-link {
            color: #ffffff;
        }

        .header-cta {
            position: relative;
            z-index: 3;
            flex: 0 0 auto;
            width: 143px;
            height: 39px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            background: #c7ab74;
            color: #ffffff !important;
            font-size: 11.5px;
            font-weight: 600;
            line-height: 1;
            letter-spacing: .08px;
            text-transform: uppercase;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .header-cta-arrow {
            display: inline-flex;
            align-items: center;
            margin-left: 10px;
        }

        .header-cta-line {
            width: 27px;
            height: 1px;
            margin-right: -5px;
            background: rgba(255, 255, 255, .92);
        }

        .header-cta-arrow i {
            font-size: 12px;
            line-height: 1;
        }

        .header-cta:hover {
            background: #b99a60;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .front-toggler {
            border: 0;
            padding: 7px;
            outline: none !important;
            box-shadow: none !important;
        }

        .front-toggler span {
            display: block;
            width: 27px;
            height: 2px;
            margin: 5px 0;
            background: #ffffff;
        }

        .front-footer {
            min-height: 404px;
            padding: 136px 0 18px;
            background: var(--front-navy);
            color: #ffffff;
        }

        .footer-title {
            margin-bottom: 17px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 500;
            line-height: 1.2;
        }

        .footer-text,
        .footer-list a,
        .footer-contact,
        .footer-contact a {
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.85;
        }

        .footer-text { max-width: 215px; }
        .footer-list { margin: 0; padding: 0; list-style: none; }
        .footer-list li { margin-bottom: 6px; }
        .footer-list a { text-decoration: none; }
        .footer-list a:hover { color: var(--front-gold) !important; }
        .footer-list i { display: none; }

        .footer-contact {
            display: block;
            margin-bottom: 13px;
        }

        .footer-contact i { display: none; }

        .footer-socials { margin-top: 17px; }

        .footer-social-link {
            width: 32px;
            height: 32px;
            margin: 0 6px 6px 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, .18);
            color: #ffffff;
            text-decoration: none;
        }

        .footer-social-link:hover {
            background: var(--front-gold);
            border-color: var(--front-gold);
            color: #ffffff;
            text-decoration: none;
        }

        .footer-bottom {
            margin-top: 72px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, .15);
            color: #ffffff;
            font-size: 11px;
            text-align: center;
        }

        /* Smooth viewport reveal: pronounced zoom-out -> zoom-in */
        .reveal {
            opacity: 0;
            filter: blur(4px);
            transform: translate3d(0, 54px, 0) scale(.80);
            transform-origin: center center;
            will-change: transform, opacity, filter;
            transition:
                opacity 1.05s cubic-bezier(.16, 1, .3, 1),
                transform 1.15s cubic-bezier(.16, 1, .3, 1),
                filter .9s ease;
        }

        .reveal.from-left {
            transform: translate3d(-72px, 0, 0) scale(.80);
        }

        .reveal.from-right {
            transform: translate3d(72px, 0, 0) scale(.80);
        }

        .reveal.is-visible {
            opacity: 1;
            filter: blur(0);
            transform: translate3d(0, 0, 0) scale(1);
        }


        /*
        |--------------------------------------------------------------------------
        | Global Floating Contact Actions
        |--------------------------------------------------------------------------
        */

        .floating-tools {
            --floating-size: 42px;
            --floating-gap: 8px;
        }

        .floating-social {
            position: fixed;
            left: 15px;
            bottom: 18px;
            z-index: 4700;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .floating-social-items {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--floating-gap);
            margin-bottom: var(--floating-gap);
            pointer-events: none;
        }

        .floating-action {
            width: var(--floating-size);
            height: var(--floating-size);
            border: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            text-decoration: none !important;
            box-shadow: 0 5px 14px rgba(15, 28, 43, .22);
            opacity: 0;
            visibility: hidden;
            transform: translateY(16px) scale(.72);
            transition:
                opacity .32s ease,
                visibility .32s ease,
                transform .48s cubic-bezier(.16, 1, .3, 1),
                box-shadow .28s ease;
        }

        .floating-action:hover {
            color: #ffffff !important;
            text-decoration: none !important;
            box-shadow: 0 8px 20px rgba(15, 28, 43, .28);
            transform: translateY(0) scale(1.07);
        }

        .floating-action-message {
            background: #1689ee;
        }

        .floating-action-whatsapp {
            background: #20c96b;
        }

        .floating-action-instagram {
            background: #ec4867;
        }

        .floating-action-toggle {
            position: relative;
            z-index: 2;
            background: #cfad6b;
            opacity: 1;
            visibility: visible;
            transform: none;
            cursor: pointer;
            font-size: 17px;
        }

        .floating-action-toggle i {
            transition: transform .38s cubic-bezier(.16, 1, .3, 1);
        }

        .floating-social.is-open .floating-social-items {
            pointer-events: auto;
        }

        .floating-social.is-open .floating-social-items .floating-action {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .floating-social.is-open .floating-social-items .floating-action:nth-child(1) {
            transition-delay: .03s;
        }

        .floating-social.is-open .floating-social-items .floating-action:nth-child(2) {
            transition-delay: .07s;
        }

        .floating-social.is-open .floating-social-items .floating-action:nth-child(3) {
            transition-delay: .11s;
        }

        .floating-social.is-open .floating-action-toggle i {
            transform: rotate(45deg);
        }

        /*
        |--------------------------------------------------------------------------
        | Global Back To Top
        |--------------------------------------------------------------------------
        */

        .floating-back-to-top {
            position: fixed;
            right: 18px;
            bottom: 20px;
            z-index: 4700;
            width: 43px;
            height: 43px;
            border: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #cfad6b;
            color: #ffffff;
            box-shadow: 0 5px 14px rgba(15, 28, 43, .22);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(16px) scale(.78);
            transition:
                opacity .30s ease,
                visibility .30s ease,
                transform .42s cubic-bezier(.16, 1, .3, 1),
                background-color .28s ease;
        }

        .floating-back-to-top.is-visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .floating-back-to-top:hover {
            background: var(--front-navy);
            transform: translateY(-3px) scale(1.05);
        }

        .floating-back-to-top:focus,
        .floating-action-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(211, 173, 104, .28);
        }

        @media (max-width: 575.98px) {
            .floating-tools {
                --floating-size: 38px;
                --floating-gap: 7px;
            }

            .floating-social {
                left: 10px;
                bottom: 12px;
            }

            .floating-back-to-top {
                right: 10px;
                bottom: 13px;
                width: 40px;
                height: 40px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }

            .reveal { opacity: 1; filter: none; transform: none; }
        }

        @media (max-width: 991.98px) {
            .container { max-width: 720px; }

            .front-container {
                max-width: 720px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .front-topbar .front-container {
                flex-direction: column;
                align-items: flex-start;
                padding-top: 8px;
                padding-bottom: 8px;
                gap: 4px;
            }

            .front-topbar-contact {
                flex-wrap: wrap;
                gap: 8px 14px;
            }

            .front-navbar {
                min-height: 67px;
                height: auto;
            }

            .front-header .navbar-collapse {
                padding: 8px 0 18px;
            }

            .front-menu {
                margin: 0 !important;
            }

            .front-header .navbar-nav .nav-link {
                padding: 10px 0 !important;
                color: #ffffff;
                font-size: 12px;
            }

            .header-cta {
                width: 143px;
                height: 39px;
                margin: 8px 0 0;
            }

            .section-title { font-size: 33px; }
            .front-footer { min-height: auto; padding: 70px 0 25px; }
            .footer-bottom { margin-top: 35px; }
        }

        @media (max-width: 767.98px) {
            .container { max-width: 540px; }

            .front-container {
                max-width: 540px;
            }
        }

        @media (max-width: 575.98px) {
            .container { width: calc(100% - 30px); }

            .front-container {
                max-width: 100%;
                padding-left: 15px;
                padding-right: 15px;
            }

            .site-logo-img { width: 105px; }
            .section-title { font-size: 29px; }
            .section-space { padding: 50px 0; }
        }
    </style>

    @stack('css')
</head>
<body>
    @include('frontend.partials.tracking-pixels', ['placement' => 'body_start'])
    @include('frontend.partials.page-loader')
    @include('frontend.partials.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')
    @include('frontend.partials.floating-actions')
    @include('frontend.partials.tracking-pixels', ['placement' => 'body_end'])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

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
                if (header) {
                    header.classList.toggle('is-scrolled', window.scrollY > 20);
                }
            };

            updateHeader();
            window.addEventListener('scroll', updateHeader, { passive: true });

            const floatingSocial = document.querySelector('[data-floating-social]');
            const floatingToggle = document.querySelector('[data-floating-toggle]');
            const floatingItems = document.querySelector('[data-floating-items]');
            const backToTop = document.querySelector('[data-back-to-top]');

            if (floatingSocial && floatingToggle && floatingItems) {
                const setFloatingState = function (isOpen) {
                    floatingSocial.classList.toggle('is-open', isOpen);
                    floatingToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    floatingItems.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
                };

                floatingToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    setFloatingState(!floatingSocial.classList.contains('is-open'));
                });

                document.addEventListener('click', function (event) {
                    if (
                        floatingSocial.classList.contains('is-open') &&
                        !floatingSocial.contains(event.target)
                    ) {
                        setFloatingState(false);
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        setFloatingState(false);
                    }
                });
            }

            if (backToTop) {
                const updateBackToTop = function () {
                    backToTop.classList.toggle('is-visible', window.scrollY > 350);
                };

                backToTop.addEventListener('click', function () {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                updateBackToTop();
                window.addEventListener('scroll', updateBackToTop, { passive: true });
            }
        })();
    </script>

    @stack('js')
</body>
</html>
