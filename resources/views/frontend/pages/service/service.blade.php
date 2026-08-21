@extends('frontend.layouts.master')

@section('body_class', 'service-page')
@section('title', 'Our Services | '.($siteSetting->site_name ?? config('app.name')))
@section('meta_description', 'Explore Floor Experts design consultation, custom fabrication, expert installation and after-sales support services.')

@section('content')
{{-- Reference-style Service hero / breadcrumb --}}
<section class="service-page-hero">
    <div class="container service-hero-inner">
        <div class="service-hero-content">
            <h1>Our Services</h1>

            <nav class="service-breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <i class="fas fa-chevron-right service-breadcrumb-separator"></i>
                <span>Our Services</span>
            </nav>
        </div>
    </div>
</section>

{{-- Static service content; gallery/reviews remain dynamic --}}
<section class="service-list-section">
    <div class="container">
        <div class="service-heading reveal">
            <div class="section-eyebrow">What We Offer</div>
            <h2 class="section-title">Provides Best Services</h2>
        </div>

        <div class="service-heading-line"></div>

        @php
            $services = [
                [
                    'title' => 'Design Consultation',
                    'icon' => 'fas fa-drafting-compass',
                    'image' => asset('frontend/images/service/service-design-consultation.webp'),
                    'text' => 'We provide personalized design consultations to help you choose the right flooring, wall cladding, or custom furnishing solution. Our experts guide you through product options, layouts, and finishes—ensuring the final outcome matches both your vision and functional needs.',
                ],
                [
                    'title' => 'Custom Fabrication',
                    'icon' => 'fas fa-desktop',
                    'image' => asset('frontend/images/service/service-custom-fabrication.webp'),
                    'text' => 'From bespoke TV units and consoles to outdoor decking and cladding, our custom fabrication service delivers precision-crafted pieces tailored to your space. We combine modern design principles with expert craftsmanship to achieve lasting results.',
                ],
                [
                    'title' => 'Expert Installation',
                    'icon' => 'fas fa-tools',
                    'image' => asset('frontend/images/service/service-expert-installation.webp'),
                    'text' => 'Our certified installers guarantee professional execution across all flooring and surface types. Whether it’s SPC vinyl, engineered wood, or laminate, we ensure each installation is performed with technical accuracy, clean finishing, and minimal disruption.',
                ],
                [
                    'title' => 'After-Sales Support',
                    'icon' => 'fas fa-layer-group',
                    'image' => asset('frontend/images/service/service-after-sales-support.webp'),
                    'text' => 'Our commitment continues beyond project completion. We offer dedicated after-sales service including maintenance guidance, touch-up solutions, and responsive client support—ensuring your investment stays flawless for years to come.',
                ],
            ];
        @endphp

        <div class="service-items">
            @foreach($services as $service)
                @php
                    $imageReveal = $loop->odd ? 'from-left' : 'from-right';
                    $copyReveal = $loop->odd ? 'from-right' : 'from-left';
                @endphp

                <article class="service-item">
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-6">
                            <div class="service-image-wrap reveal {{ $imageReveal }}">
                                <img
                                    class="service-image"
                                    src="{{ $service['image'] }}"
                                    alt="{{ $service['title'] }}"
                                    loading="lazy"
                                >
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="service-copy reveal {{ $copyReveal }}">
                                <span class="service-main-icon">
                                    <i class="{{ $service['icon'] }}"></i>
                                </span>

                                <span class="service-ghost-icon" aria-hidden="true">
                                    <i class="{{ $service['icon'] }}"></i>
                                </span>

                                <h3>{{ $service['title'] }}</h3>
                                <p>{{ $service['text'] }}</p>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Dynamic gallery: existing after_what_we_offer CMS photos --}}
<section id="service-gallery" class="service-gallery-section">
    <div class="container">
        <div class="service-gallery-heading reveal">
            <div class="service-gallery-eyebrow">
                <span></span>
                <strong>Our Gallery</strong>
                <span></span>
            </div>
            <h2>Crafting Surfaces. Defining<br>Spaces.</h2>
        </div>

        @php
            $fallbackGallery = collect([
                (object) [
                    'title' => null,
                    'link_url' => null,
                    'image_url' => asset('frontend/images/home/hero-background.webp'),
                ],
                (object) [
                    'title' => null,
                    'link_url' => null,
                    'image_url' => asset('frontend/images/home/about-floor-experts.webp'),
                ],
                (object) [
                    'title' => null,
                    'link_url' => null,
                    'image_url' => asset('frontend/images/home/product-spc.webp'),
                ],
            ]);

            $serviceGalleryItems = $serviceGalleryPhotos->isNotEmpty()
                ? $serviceGalleryPhotos
                : $fallbackGallery;
        @endphp

        <div class="service-gallery-viewport reveal" data-service-gallery>
            <div class="service-gallery-track" data-service-gallery-track>
                @foreach($serviceGalleryItems as $photo)
                    <a
                        href="{{ $photo->link_url ?: '#service-gallery' }}"
                        class="service-gallery-card"
                        @if($photo->link_url)
                            target="_blank"
                            rel="noopener"
                        @endif
                    >
                        <img
                            src="{{ $photo->image_url }}"
                            alt="{{ $photo->title ?: 'Floor Experts project' }}"
                            loading="lazy"
                        >

                        <span class="service-gallery-overlay"></span>
                        <span class="service-gallery-play">
                            <i class="fas fa-play"></i>
                        </span>

                        @if($photo->title)
                            <span class="service-gallery-label">
                                {{ $photo->title }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Existing shared dynamic testimonial carousel --}}
@include('frontend.partials.testimonials')
@endsection

@include('frontend.pages.service.service_css')
@include('frontend.pages.service.service_script')
