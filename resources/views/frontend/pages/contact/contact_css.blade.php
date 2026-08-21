@push('css')
<style>
/* ================================================================
   Contact page only
   ================================================================ */
.contact-page {
    background: #f7f7f7;
}

.contact-page .contact-page-hero .container,
.contact-page .contact-main-section .container {
    max-width: 960px;
}

/* Reference-style transparent header over hero. */
.contact-page .front-topbar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5100;
    background: transparent;
    color: #ffffff;
}

.contact-page .front-topbar .front-container {
    min-height: 34px;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.contact-page .front-topbar-contact,
.contact-page .front-topbar-meta {
    display: flex;
    align-items: center;
    gap: 16px;
}

.contact-page .front-topbar a,
.contact-page .front-topbar-contact,
.contact-page .front-topbar-meta,
.contact-page .front-business-hours,
.contact-page .front-whatsapp-icon {
    color: #ffffff;
}

.contact-page .front-business-hours,
.contact-page .front-whatsapp-icon {
    display: inline-flex;
    align-items: center;
    line-height: 1;
}

.contact-page .front-header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5050;
    background: transparent;
    border-top: 0;
    box-shadow: none;
}

.contact-page .front-topbar + .front-header {
    top: 34px;
}

.contact-page .front-header.is-scrolled {
    position: fixed;
    top: 0;
    background: rgba(39, 53, 70, .985);
    border-top: 3px solid #5d6671;
    box-shadow: 0 9px 28px rgba(0, 0, 0, .20);
    animation: contactHeaderDrop .42s cubic-bezier(.16, 1, .3, 1) both;
}

@keyframes contactHeaderDrop {
    from { opacity: 0; transform: translateY(-100%); }
    to { opacity: 1; transform: translateY(0); }
}

/* Hero */
.contact-page-hero {
    position: relative;
    min-height: 455px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        linear-gradient(rgba(30, 31, 34, .28), rgba(30, 31, 34, .34)),
        url('{{ asset('frontend/images/about/about-hero.webp') }}') center/cover no-repeat;
}

.contact-page-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(30, 20, 12, .05), rgba(27, 36, 47, .08));
    pointer-events: none;
}

.contact-hero-inner {
    position: relative;
    z-index: 2;
    min-height: 455px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.contact-hero-content {
    margin-top: 72px;
    text-align: center;
}

.contact-hero-content h1 {
    margin: 0 0 20px;
    color: #ffffff;
    font-size: 46px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: -.4px;
}

.contact-breadcrumb {
    min-height: 40px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 11px;
    background: #ffffff;
    color: #c8a366;
    font-size: 12px;
}

.contact-breadcrumb a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #213249;
    text-decoration: none;
}

.contact-breadcrumb a:hover { color: var(--front-gold-dark); }
.contact-breadcrumb .breadcrumb-separator { color: #bcc1c6; font-size: 9px; }

/* Contact content */
.contact-main-section {
    min-height: 530px;
    padding: 62px 0 70px;
    background: #f7f7f7;
    border-top: 3px solid var(--front-navy);
}

.contact-main-row {
    min-height: 385px;
    align-items: flex-start;
}

.contact-copy {
    max-width: 440px;
    padding-top: 6px;
}

.contact-eyebrow {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 7px;
    color: #c69f5d;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: .4px;
    text-transform: uppercase;
}

.contact-eyebrow::before {
    content: '';
    width: 18px;
    height: 1px;
    background: #c69f5d;
}

.contact-copy h2 {
    margin: 0 0 13px;
    color: #102842;
    font-size: 32px;
    font-weight: 500;
    line-height: 1.08;
    letter-spacing: -.35px;
}

.contact-intro-text {
    max-width: 430px;
    margin: 0 0 22px;
    color: #243850;
    font-size: 12px;
    line-height: 1.85;
}

.contact-info-list {
    max-width: 430px;
}

.contact-info-item {
    min-height: 68px;
    padding: 16px 0;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    border-bottom: 1px solid #d8d8d8;
}

.contact-info-item:last-child {
    border-bottom: 0;
}

.contact-info-icon {
    width: 22px;
    flex: 0 0 22px;
    padding-top: 2px;
    color: #c7a363;
    font-size: 12px;
    text-align: center;
}

.contact-info-item h6 {
    margin: 0 0 7px;
    color: #263548;
    font-size: 11px;
    font-weight: 500;
}

.contact-info-item p,
.contact-info-item a {
    max-width: 300px;
    margin: 0;
    color: #34475c;
    font-size: 11px;
    line-height: 1.7;
    text-decoration: none;
}

.contact-info-item a:hover {
    color: var(--front-gold-dark);
}

/* Form */
.contact-form-panel {
    width: 360px;
    max-width: 100%;
    min-height: 360px;
    margin-left: auto;
    padding: 29px 18px 27px;
    background: #9ba3ad;
}

.contact-form-row {
    margin-left: -3px;
    margin-right: -3px;
}

.contact-form-row > [class*="col-"] {
    padding-left: 3px;
    padding-right: 3px;
}

.contact-field {
    margin-bottom: 10px;
}

.contact-field label {
    margin: 0 0 5px;
    display: block;
    color: #24374e;
    font-size: 10px;
    line-height: 1;
    transition: color .3s ease, transform .3s cubic-bezier(.16, 1, .3, 1);
}

.contact-field label span {
    color: #d53e35;
}

.contact-field input,
.contact-field textarea {
    width: 100%;
    border: 1px solid transparent;
    border-radius: 0;
    background: #ffffff;
    color: #26384b;
    font-family: inherit;
    font-size: 12px;
    outline: 0;
    box-shadow: none;
    transition:
        border-color .3s ease,
        box-shadow .3s ease,
        transform .3s cubic-bezier(.16, 1, .3, 1);
}

.contact-field input {
    height: 34px;
    padding: 6px 9px;
}

.contact-field textarea {
    min-height: 94px;
    padding: 8px 9px;
    resize: vertical;
}

.contact-field:focus-within label {
    color: #ffffff;
    transform: translateX(2px);
}

.contact-field input:focus,
.contact-field textarea:focus {
    border-color: #d3ad68;
    box-shadow: 0 0 0 2px rgba(211, 173, 104, .18);
}

.contact-field input.is-invalid,
.contact-field textarea.is-invalid {
    border-color: #b93f3f;
}

.contact-field-error {
    display: block;
    margin-top: 4px;
    color: #722424;
    font-size: 10px;
}

.contact-submit {
    min-width: 96px;
    height: 38px;
    padding: 0 14px;
    border: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #c7a363;
    color: #ffffff;
    font-family: inherit;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    cursor: pointer;
    transition:
        background-color .35s ease,
        transform .4s cubic-bezier(.16, 1, .3, 1),
        box-shadow .35s ease;
}

.contact-submit:hover:not(:disabled) {
    background: #b78f4c;
    transform: translateY(-3px);
    box-shadow: 0 7px 18px rgba(38, 51, 67, .20);
}

.contact-submit:disabled {
    cursor: wait;
    opacity: .72;
}

.contact-success,
.contact-errors {
    margin-bottom: 12px;
    padding: 9px 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
}

.contact-success {
    background: rgba(238, 255, 241, .92);
    color: #27643a;
}

.contact-errors {
    background: rgba(255, 238, 238, .92);
    color: #813535;
}

/* Full-width static map area */
.contact-map-section {
    width: 100%;
    height: 335px;
    overflow: hidden;
    background: #e2e2e2;
    border-top: 3px solid var(--front-navy);
}

.contact-map-section iframe {
    display: block;
    width: 100%;
    height: 100%;
    border: 0;
}

.contact-map-empty {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #667382;
    text-align: center;
}

.contact-map-empty i {
    color: var(--front-gold-dark);
    font-size: 28px;
}

@media (max-width: 991.98px) {
    .contact-page .contact-page-hero .container,
    .contact-page .contact-main-section .container {
        max-width: 720px;
    }

    .contact-main-section {
        padding-top: 70px;
    }

    .contact-copy {
        max-width: 100%;
        margin-bottom: 45px;
    }

    .contact-info-list {
        max-width: 100%;
    }

    .contact-form-panel {
        width: 100%;
        margin: 0;
    }
}

@media (max-width: 767.98px) {
    .contact-page .front-topbar {
        display: none;
    }

    .contact-page .front-header {
        top: 0;
    }

    .contact-page .contact-page-hero .container,
    .contact-page .contact-main-section .container {
        max-width: 540px;
    }

    .contact-page-hero,
    .contact-hero-inner {
        min-height: 400px;
    }

    .contact-hero-content {
        margin-top: 45px;
    }

    .contact-hero-content h1 {
        font-size: 38px;
    }

    .contact-form-panel {
        padding: 24px 18px;
    }

    .contact-map-section {
        height: 300px;
    }
}

@media (max-width: 575.98px) {
    .contact-page .contact-page-hero .container,
    .contact-page .contact-main-section .container {
        width: calc(100% - 30px);
        max-width: none;
    }

    .contact-page-hero,
    .contact-hero-inner {
        min-height: 365px;
    }

    .contact-hero-content h1 {
        font-size: 34px;
    }

    .contact-breadcrumb {
        min-height: 38px;
        padding: 0 13px;
    }

    .contact-main-section {
        padding: 55px 0 60px;
    }

    .contact-copy h2 {
        font-size: 29px;
    }

    .contact-form-panel {
        padding: 22px 15px;
    }

    .contact-map-section {
        height: 270px;
    }
}
</style>
@endpush
