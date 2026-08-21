@include('frontend.partials.tmc-section-css')

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

