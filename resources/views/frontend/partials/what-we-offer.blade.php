<section class="offer-section section-space">
    <div class="container">
        <div class="section-heading-row reveal">
            <div>
                <div class="section-eyebrow offer-eyebrow">What We Offer</div>
                <h2 class="section-title text-white">Expertise At Every Step.</h2>
            </div>

            <a href="{{ \Illuminate\Support\Facades\Route::has('services.index') ? route('services.index') : '#' }}" class="front-btn">
                View More <i class="fas fa-long-arrow-alt-right"></i>
            </a>
        </div>

        <div class="offer-divider"></div>

        <div class="row offer-grid">
            @foreach([
                ['icon' => 'fas fa-drafting-compass', 'title' => 'Design Consultation', 'text' => 'Expert guidance to select the right materials, finishes, and layout for your project vision.'],
                ['icon' => 'fas fa-couch', 'title' => 'Custom Fabrication', 'text' => 'Tailored furniture and feature elements built to your specifications—perfectly integrated into your space.'],
                ['icon' => 'fas fa-tools', 'title' => 'Expert Installation', 'text' => 'Seamless, efficient on-site flooring and furnishing installation by our in-house specialists.'],
                ['icon' => 'fas fa-layer-group', 'title' => 'After-Sales Support', 'text' => 'Ongoing service, warranty assistance, and care guidance to protect your investment long-term.'],
            ] as $index => $service)
                <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0 reveal" style="transition-delay: {{ $index * 90 }}ms">
                    <div class="offer-card h-100">
                        <div class="offer-icon-wrap">
                            <span class="offer-icon"><i class="{{ $service['icon'] }}"></i></span>
                        </div>
                        <h5>{{ $service['title'] }}</h5>
                        <p>{{ $service['text'] }}</p>
                        <span class="offer-arrow"><span></span><i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
