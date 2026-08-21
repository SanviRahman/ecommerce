@extends('frontend.layouts.master')

@section('body_class', 'about-page')
@section('title', 'About Us | '.($siteSetting->site_name ?? config('app.name')))
@section('meta_description', 'Learn about Floor Experts, our vision, mission, experience, services and commitment to premium flooring and surface solutions.')

@section('content')
{{-- Reference-style About hero / breadcrumb --}}
<section class="about-page-hero">
    <div class="container about-hero-inner">
        <div class="about-hero-content">
            <h1>About Us</h1>

            <nav class="about-breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <i class="fas fa-chevron-right breadcrumb-separator"></i>
                <span>About Us</span>
            </nav>
        </div>
    </div>
</section>

{{-- About intro: static copy, reference image + brand mark --}}
<section class="about-main-section section-space">
    <div class="container">
        <div class="row align-items-center about-main-row">
            <div class="col-lg-6">
                <div class="about-main-visual reveal from-left">
                    <img
                        class="about-main-photo"
                        src="{{ asset('frontend/images/about/about-floor-experts.webp') }}"
                        alt="Floor Experts showroom"
                        loading="lazy"
                    >

                    <img
                        class="about-main-mark"
                        src="{{ asset('frontend/images/about/about-mark.webp') }}"
                        alt=""
                        aria-hidden="true"
                    >
                </div>
            </div>

            <div class="col-lg-6">
                <div class="about-main-copy reveal">
                    <div class="section-eyebrow">About Floor Experts</div>
                    <h2 class="section-title">Crafting Surfaces That<br>Define Spaces</h2>

                    <p>
                        At Floor Experts, we specialize in delivering premium surface solutions for residential and
                        commercial spaces across the UAE. Backed by over 15 years of experience, we provide
                        high-performance flooring, cladding, decking, and custom interior features that blend
                        aesthetics with function.
                    </p>

                    <ul class="about-feature-list">
                        <li>15+ years of flooring expertise.</li>
                        <li>Premium flooring collections.</li>
                        <li>Dubai’s trusted surface supplier.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Vision / Mission + stats --}}
<section class="about-purpose-section">
    <div class="container">
        <div class="about-purpose-card">
            <article class="about-purpose-item reveal from-left">
                <h3>Our Vision</h3>
                <p>
                    To lead the region in tailored flooring and furnishing solutions that elevate everyday living
                    through exceptional materials and craftsmanship.
                </p>
                <span class="about-purpose-icon"><i class="far fa-eye"></i></span>
            </article>

            <article class="about-purpose-item reveal from-right">
                <h3>Our Mission</h3>
                <p>
                    To deliver timeless surface and furnishing solutions with a focus on design integrity, technical
                    excellence, and service reliability.
                </p>
                <span class="about-purpose-icon"><i class="fas fa-crosshairs"></i></span>
            </article>
        </div>
    </div>

    <div class="about-stats-band">
        <div class="container">
            <div class="row no-gutters about-stats-row">
                @foreach([
                    ['value' => 15, 'label' => 'Years Of Experience'],
                    ['value' => 1000, 'label' => 'Projects Delivered'],
                    ['value' => 500, 'label' => 'Product Options'],
                    ['value' => 20, 'label' => 'Workers'],
                ] as $stat)
                    <div class="col-6 col-lg-3">
                        <div class="about-stat reveal">
                            <div class="about-stat-number">
                                <strong class="about-count" data-count="{{ $stat['value'] }}">0</strong><span>+</span>
                            </div>
                            <small>{{ $stat['label'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Shared What We Offer section --}}
@include('frontend.partials.what-we-offer')

{{-- Reference-style project/gallery strip --}}
<section class="about-gallery-section">
    <div class="container">
        @php
            $fallbackGallery = collect([
                (object) ['title' => null, 'link_url' => null, 'image_url' => asset('frontend/images/home/hero-background.webp')],
                (object) ['title' => null, 'link_url' => null, 'image_url' => asset('frontend/images/home/about-floor-experts.webp')],
                (object) ['title' => null, 'link_url' => null, 'image_url' => asset('frontend/images/home/product-spc.webp')],
            ]);

            $aboutGalleryItems = $offerGalleryPhotos->isNotEmpty()
                ? $offerGalleryPhotos->take(3)
                : $fallbackGallery;
        @endphp

        <div class="about-gallery-grid">
            @foreach($aboutGalleryItems as $photo)
                <a href="{{ $photo->link_url ?: '#' }}" class="about-gallery-card reveal" style="transition-delay: {{ $loop->index * 90 }}ms">
                    <img
                        src="{{ $photo->image_url }}"
                        alt="{{ $photo->title ?: 'Floor Experts project' }}"
                        loading="lazy"
                    >
                    <span class="about-gallery-play"><i class="fas fa-play"></i></span>
                    @if($photo->title)
                        <span class="about-gallery-label">{{ $photo->title }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Shared dynamic testimonial carousel --}}
@include('frontend.partials.testimonials')
@endsection

@include('frontend.pages.about.about_css')
@include('frontend.pages.about.about_script')
