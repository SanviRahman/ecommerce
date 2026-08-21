@extends('frontend.layouts.master')

@section('body_class', 'contact-page')
@section('title', 'Contact Us | '.($siteSetting->site_name ?? config('app.name')))
@section('meta_description', 'Contact our flooring and surface specialists for product information, project guidance and consultation.')

@section('content')
{{-- Reference-style Contact hero / breadcrumb --}}
<section class="contact-page-hero">
    <div class="container contact-hero-inner">
        <div class="contact-hero-content">
            <h1>Contact Us</h1>

            <nav class="contact-breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <i class="fas fa-chevron-right breadcrumb-separator"></i>
                <span>Contact Us</span>
            </nav>
        </div>
    </div>
</section>

{{-- Contact details + form --}}
<section class="contact-main-section">
    <div class="container">
        <div class="row contact-main-row">
            <div class="col-lg-6">
                <div class="contact-copy reveal">
                    <div class="contact-eyebrow">Our Contact</div>
                    <h2>Get In Touch With Floor<br>Experts</h2>

                    <p class="contact-intro-text">
                        Planning a renovation or a commercial flooring project? Our team can help you choose the right
                        surface solution, answer product questions and arrange a consultation for your space.
                    </p>

                    <div class="contact-info-list">
                        <div class="contact-info-item reveal from-left" style="transition-delay: 70ms">
                            <span class="contact-info-icon"><i class="fas fa-home"></i></span>
                            <div>
                                <h6>Visit Our Office</h6>
                                <p>{{ $siteSetting->address ?: 'Address available on request' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item reveal from-left" style="transition-delay: 140ms">
                            <span class="contact-info-icon"><i class="fas fa-phone-alt"></i></span>
                            <div>
                                <h6>Contact Us</h6>
                                @if($siteSetting->contact_phone)
                                    <a href="tel:{{ preg_replace('/\s+/', '', $siteSetting->contact_phone) }}">
                                        {{ $siteSetting->contact_phone }}
                                    </a>
                                @else
                                    <p>Phone number available soon</p>
                                @endif
                            </div>
                        </div>

                        <div class="contact-info-item reveal from-left" style="transition-delay: 210ms">
                            <span class="contact-info-icon"><i class="fas fa-envelope"></i></span>
                            <div>
                                <h6>Email Us</h6>
                                @if($siteSetting->contact_email)
                                    <a href="mailto:{{ $siteSetting->contact_email }}">
                                        {{ $siteSetting->contact_email }}
                                    </a>
                                @else
                                    <p>Email address available soon</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contact-form-panel reveal">
                    @if(session('contact_success'))
                        <div class="contact-success" role="alert">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('contact_success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="contact-errors" role="alert">
                            <strong>Please check the highlighted fields.</strong>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="contact-form" data-contact-form>
                        @csrf

                        <div class="row contact-form-row">
                            <div class="col-md-6">
                                <div class="contact-field">
                                    <label for="contact_name">Name <span>*</span></label>
                                    <input
                                        id="contact_name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        maxlength="150"
                                        autocomplete="name"
                                        required
                                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    >
                                    @error('name')<small class="contact-field-error">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-field">
                                    <label for="contact_phone">Phone <span>*</span></label>
                                    <input
                                        id="contact_phone"
                                        type="tel"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        maxlength="50"
                                        autocomplete="tel"
                                        required
                                        class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                    >
                                    @error('phone')<small class="contact-field-error">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="contact-field">
                            <label for="contact_email">Email <span>*</span></label>
                            <input
                                id="contact_email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                maxlength="190"
                                autocomplete="email"
                                required
                                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            >
                            @error('email')<small class="contact-field-error">{{ $message }}</small>@enderror
                        </div>

                        <div class="contact-field">
                            <label for="contact_message">Message <span>*</span></label>
                            <textarea
                                id="contact_message"
                                name="message"
                                rows="5"
                                maxlength="5000"
                                required
                                class="{{ $errors->has('message') ? 'is-invalid' : '' }}"
                            >{{ old('message') }}</textarea>
                            @error('message')<small class="contact-field-error">{{ $message }}</small>@enderror
                        </div>

                        <button type="submit" class="contact-submit" data-contact-submit>
                            <span>Submit</span>
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Static map/location area --}}
<section class="contact-map-section" aria-label="Map location">
    @php
        $contactMapUrl = trim((string) ($siteSetting->map_embed_url ?? ''));

        if ($contactMapUrl === '' && $siteSetting->address) {
            $contactMapUrl = 'https://www.google.com/maps?q='.rawurlencode($siteSetting->address).'&output=embed';
        }
    @endphp

    @if($contactMapUrl !== '')
        <iframe
            src="{{ $contactMapUrl }}"
            title="{{ $siteSetting->site_name ?? 'Business' }} location map"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    @else
        <div class="contact-map-empty">
            <i class="fas fa-map-marker-alt"></i>
            <span>Map location will appear here when an address or map URL is configured.</span>
        </div>
    @endif
</section>
@endsection

@include('frontend.pages.contact.contact_css')
@include('frontend.pages.contact.contact_script')
