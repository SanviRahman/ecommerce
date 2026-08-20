@extends('frontend.layouts.master')

@section('title', 'Premium Flooring Solutions | '.($siteSetting->site_name ?? config('app.name')))
@section('meta_description', 'Premium flooring, wall and surface solutions with expert consultation, installation and
after-sales support.')

@section('content')
{{-- Hero / Banner: static copy + reference-style slider --}}
<section class="home-hero">
    <div id="homeHeroCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="6000"
        data-touch="true">
        <div class="carousel-inner">
            @foreach([1, 2, 3] as $heroSlide)
            <div class="carousel-item {{ $heroSlide === 1 ? 'active' : '' }}">
                <div class="hero-slide">
                    <div class="container hero-container">
                        <div class="hero-copy">
                            <span class="hero-kicker">Crafting Surfaces. Defining Spaces.</span>
                            <h1>SPC Flooring For<br>Every Space</h1>
                            <a href="{{ \Illuminate\Support\Facades\Route::has('about.index') ? route('about.index') : '#about-floor-experts' }}"
                                class="front-btn">
                                About Us <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="hero-visual" aria-hidden="true">
                        <img class="hero-shape hero-shape-main"
                            src="{{ asset('frontend/images/home/hero-slide-01.webp') }}" alt="">
                        <img class="hero-shape hero-shape-second"
                            src="{{ asset('frontend/images/home/hero-slide-02.webp') }}" alt="">
                        <img class="hero-shape hero-shape-third"
                            src="{{ asset('frontend/images/home/hero-slide-03.webp') }}" alt="">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <ol class="carousel-indicators hero-indicators">
            <li data-target="#homeHeroCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#homeHeroCarousel" data-slide-to="1"></li>
            <li data-target="#homeHeroCarousel" data-slide-to="2"></li>
        </ol>
    </div>
</section>

{{-- About Floor Experts: static --}}
<section id="about-floor-experts" class="about-preview section-space">
    <div class="container">
        <div class="row align-items-center about-row">
            <div class="col-lg-6 reveal from-left">
                <div class="section-eyebrow">About Floor Experts</div>
                <h2 class="section-title">A Legacy Of Precision And<br>Design Excellence</h2>

                <p class="about-copy">
                    With over 15 years of hands-on experience, Floor Experts has become the trusted name for curated
                    flooring, wall, and surface solutions in the UAE. Our Dubai-based team brings together technical
                    craftsmanship and design vision to transform residential, commercial, and outdoor spaces into
                    lasting statements of style.
                </p>

                <div class="about-rule"></div>

                <div class="row about-points">
                    <div class="col-sm-6"><span>15+ Years Of Proven Expertise</span></div>
                    <div class="col-sm-6"><span>Custom-Made Furniture</span></div>
                    <div class="col-sm-6"><span>Exclusive SPC Vinyl With IXPE</span></div>
                    <div class="col-sm-6"><span>Seamless Installation</span></div>
                    <div class="col-sm-6"><span>Comprehensive Surface Solutions</span></div>
                    <div class="col-sm-6"><span>Guaranteed Durability</span></div>
                </div>

                <a href="{{ \Illuminate\Support\Facades\Route::has('about.index') ? route('about.index') : '#' }}"
                    class="front-btn front-btn-dark about-btn">
                    Read More <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </div>

            <div class="col-lg-6 reveal from-right">
                <div class="about-art-wrap">
                    <img src="{{ asset('frontend/images/home/about-floor-experts.webp') }}"
                        alt="Floor Experts interior design showcase" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Our Products: dynamic home_section_photos / our_products --}}
<section id="our-products" class="home-products section-space">
    <div class="container">
        <div class="section-heading-row reveal">
            <div>
                <div class="section-eyebrow">Our Products</div>
                <h2 class="section-title">Engineered For Elegance</h2>
            </div>

            <a href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : '#' }}"
                class="front-btn front-btn-dark">
                Read More <i class="fas fa-long-arrow-alt-right"></i>
            </a>
        </div>

        <div class="products-rule"></div>

        <div id="productShowcaseCarousel" class="carousel slide reveal" data-ride="carousel" data-interval="5000"
            data-touch="true">
            <div class="carousel-inner">
                @forelse($products->chunk(3) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row product-row">
                        @foreach($chunk as $product)
                        @php
                        $productImage = $product->getFirstMediaUrl('featured_image')
                        ?: asset('frontend/images/home/product-spc.webp');

                        $productUrl = '#';

                        if (\Illuminate\Support\Facades\Route::has('products.show')) {
                        $productUrl = route('products.show', ['product' => $product->slug]);
                        } elseif (\Illuminate\Support\Facades\Route::has('products.index')) {
                        $productUrl = route('products.index');
                        }
                        @endphp

                        <div class="col-md-4 mb-4 mb-md-0">
                            <a href="{{ $productUrl }}" class="product-showcase-card">
                                <div class="product-media">
                                    <img src="{{ $productImage }}" alt="{{ $product->name }}" loading="lazy">
                                </div>

                                <div class="product-card-body">
                                    <span class="product-round-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </span>

                                    <h5>{{ $product->name }}</h5>

                                    @if($product->category)
                                    <small>{{ $product->category->name }}</small>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="carousel-item active">
                    <div class="text-center py-5">
                        <p class="mb-0">No products available.</p>
                    </div>
                </div>
                @endforelse
            </div>

            @if($products->count() > 3)
            <a class="carousel-control-prev product-control" href="#productShowcaseCarousel" role="button"
                data-slide="prev" aria-label="Previous products">
                <i class="fas fa-chevron-left"></i>
            </a>

            <a class="carousel-control-next product-control" href="#productShowcaseCarousel" role="button"
                data-slide="next" aria-label="Next products">
                <i class="fas fa-chevron-right"></i>
            </a>
            @endif
        </div>
    </div>
    </div>
</section>

{{-- What We Offer: reusable static partial --}}
@include('frontend.partials.what-we-offer')

{{-- Dynamic gallery after What We Offer --}}
<section class="offer-gallery-wrap">
    <div class="container">
        @php
        $fallbackGallery = collect([
        (object) [
        'title' => null,
        'link_url' => null,
        'image_url' => asset('frontend/images/home/hero-slide-01.webp'),
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

        $galleryItems = $offerGalleryPhotos->isNotEmpty() ? $offerGalleryPhotos : $fallbackGallery;
        @endphp

        <div id="offerGalleryCarousel" class="carousel slide reveal" data-ride="carousel" data-interval="4800"
            data-touch="true">
            <div class="carousel-inner">
                @foreach($galleryItems->chunk(3) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="offer-gallery">
                        @foreach($chunk as $photo)
                        <a href="{{ $photo->link_url ?: '#' }}" class="offer-gallery-item">
                            <img src="{{ $photo->image_url }}" alt="{{ $photo->title ?: 'Flooring project gallery' }}"
                                loading="lazy">
                            <span class="gallery-play"><i class="fas fa-play"></i></span>
                            @if($photo->title)
                            <span class="gallery-label">{{ $photo->title }}</span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            @if($galleryItems->count() > 3)
            <a class="carousel-control-prev gallery-control" href="#offerGalleryCarousel" role="button"
                data-slide="prev" aria-label="Previous gallery">
                <i class="fas fa-chevron-left"></i>
            </a>
            <a class="carousel-control-next gallery-control" href="#offerGalleryCarousel" role="button"
                data-slide="next" aria-label="Next gallery">
                <i class="fas fa-chevron-right"></i>
            </a>
            @endif
        </div>
    </div>
</section>

{{-- Signature / TMC: static copy + image carousel --}}
<section class="tmc-section section-space">
    <div class="container">
        <div class="section-eyebrow reveal">TMC: Our Signature Flooring Brand</div>
        <h2 class="section-title reveal">SPC Vinyl Flooring With IXPE Backing</h2>
        <div class="tmc-rule"></div>

        <div class="row align-items-center tmc-row">
            <div class="col-lg-6 reveal from-left">
                <p class="tmc-copy">
                    With over 15 years of hands-on experience, Floor Experts has become the trusted name for curated
                    flooring, wall, and surface solutions in the UAE. Our Dubai-based team brings together technical
                    craftsmanship and design vision to transform residential, commercial, and outdoor spaces into
                    lasting statements of style.
                </p>

                <ul class="tmc-list">
                    <li><strong>TMC Styles Include:</strong> Forest Oak, Walnut Brown, Butter Nut, Warm Teak, Pearl Grey
                    </li>
                    <li><strong>Warranty:</strong> 15 Years (Residential), 7 Years (Commercial) – Color Fading
                        Guaranteed</li>
                </ul>

                <a href="{{ \Illuminate\Support\Facades\Route::has('products.index') ? route('products.index') : '#' }}"
                    class="front-btn front-btn-dark tmc-btn">
                    Read More <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </div>

            <div class="col-lg-6 reveal from-right">
                <div id="tmcCarousel" class="carousel slide tmc-art" data-ride="carousel" data-interval="4200"
                    data-touch="true">
                    <div class="carousel-inner">
                        @foreach([0, 1, 2] as $tmcSlide)
                        <div class="carousel-item {{ $tmcSlide === 0 ? 'active' : '' }}">
                            <div class="tmc-plank-stage tmc-stage-{{ $tmcSlide + 1 }}">
                                <img class="tmc-plank plank-1"
                                    src="{{ asset('frontend/images/home/tmc-tile-01.webp') }}" alt="Forest Oak flooring"
                                    loading="lazy">
                                <img class="tmc-plank plank-2"
                                    src="{{ asset('frontend/images/home/tmc-tile-04.webp') }}"
                                    alt="Walnut Brown flooring" loading="lazy">
                                <img class="tmc-plank plank-3"
                                    src="{{ asset('frontend/images/home/tmc-tile-03.webp') }}" alt="Warm Teak flooring"
                                    loading="lazy">
                                <img class="tmc-plank plank-4"
                                    src="{{ asset('frontend/images/home/tmc-tile-02.webp') }}" alt="Pearl Grey flooring"
                                    loading="lazy">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <ol class="carousel-indicators tmc-indicators">
                        <li data-target="#tmcCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#tmcCarousel" data-slide-to="1"></li>
                        <li data-target="#tmcCarousel" data-slide-to="2"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Reusable dynamic testimonials --}}
@include('frontend.partials.testimonials')

{{-- Experience / Projects + FAQ: static --}}
<section class="faq-section section-space">
    <div class="container">
        <div class="row align-items-center faq-row">
            <div class="col-lg-6 reveal from-left">
                <div class="faq-visual">
                    <img src="{{ asset('frontend/images/home/faq-chair.webp') }}" alt="Flooring interior with bar chair"
                        loading="lazy">
                    <div class="stats-row">
                        <div class="stat-box stat-gold">
                            <div><strong class="count-number" data-count="15">0</strong><span>+</span></div>
                            <small>Year Of Experience</small>
                        </div>
                        <div class="stat-box stat-navy">
                            <div><strong class="count-number" data-count="1000">0</strong><span>+</span></div>
                            <small>Project Completed</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 reveal from-right">
                <div class="section-eyebrow">Common Queries</div>
                <h2 class="section-title faq-title">Asked Questions ?</h2>

                <div id="homeFaq" class="faq-accordion">
                    @foreach([
                    ['What Is SPC Vinyl Flooring With IXPE Backing?', 'SPC (Stone Plastic Composite) vinyl flooring with
                    IXPE is a durable, waterproof surface with built-in acoustic insulation. It’s ideal for high-traffic
                    residential and commercial spaces.'],
                    ['What Types Of Flooring Do You Offer?', 'We supply premium SPC vinyl flooring with IXPE backing,
                    versatile LVT click flooring for acoustic comfort, and durable laminate flooring for elegant,
                    long-lasting surfaces.'],
                    ['What Warranties Do You Provide On Flooring?', 'Our TMC SPC vinyl flooring comes with a 15-year
                    residential and 7-year commercial warranty against color fading, ensuring long-term performance.'],
                    ['Do You Manufacture Custom TV Units & Consoles?', 'Yes. We design and build made-to-measure TV
                    units, wall racks, and consoles in modern finishes—tailored to fit your space, style, and
                    functionality requirements.'],
                    ] as $index => $faq)
                    <div class="faq-item">
                        <button class="faq-question" type="button" data-toggle="collapse" data-target="#faq{{ $index }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="faq{{ $index }}">
                            <i class="fas {{ $index === 0 ? 'fa-minus' : 'fa-plus' }}"></i>
                            <span>{{ $faq[0] }}</span>
                        </button>

                        <div id="faq{{ $index }}" class="collapse {{ $index === 0 ? 'show' : '' }}"
                            data-parent="#homeFaq">
                            <div class="faq-answer">{{ $faq[1] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Payment Options: static --}}
<section class="payment-section section-space">
    <div class="container">
        <div class="row align-items-center payment-row">
            <div class="col-lg-6 reveal from-left">
                <div class="section-eyebrow">Payment Options</div>
                <h2 class="section-title">Secure &amp; Convenient<br>Payments</h2>
                <p class="payment-copy">
                    We offer flexible and secure payment methods to make your experience seamless:<br>
                    Credit &amp; Debit Cards – Accepting all major cards.<br>
                    Cash on Delivery – Convenient payment upon receipt.
                </p>
            </div>

            <div class="col-lg-6 reveal from-right">
                <div class="payment-art">
                    <img src="{{ asset('frontend/images/home/payment-options.webp') }}" alt="Accepted payment options"
                        loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@include('frontend.pages.home_css')

@include('frontend.pages.home_script')