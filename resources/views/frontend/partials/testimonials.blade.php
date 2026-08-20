<section id="home-testimonials" class="testimonial-section section-space">
    <div class="container">
        <div class="section-heading-row reveal">
            <div>
                <div class="section-eyebrow">Our Testimonial</div>
                <h2 class="section-title">What Our Clients Say</h2>
            </div>

            <a href="#home-testimonials" class="front-btn front-btn-dark">View More <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>

        @if($reviews->isNotEmpty())
            <div
                id="testimonialCarousel"
                class="carousel slide carousel-fade reveal"
                data-ride="carousel"
                data-interval="5500"
                data-pause="false"
                data-wrap="true"
                data-keyboard="true"
                data-touch="true"
            >
                <div class="carousel-inner">
                    @foreach($reviews as $review)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="testimonial-card text-center mx-auto">
                                @if($review->avatar_url)
                                    <img class="testimonial-avatar" src="{{ $review->avatar_url }}" alt="{{ $review->reviewer_name }}" loading="lazy">
                                @endif

                                @if($review->rating)
                                    <div class="testimonial-rating mb-2" aria-label="{{ $review->rating }} out of 5 stars">
                                        @for($star = 1; $star <= 5; $star++)
                                            <i class="{{ $star <= round($review->rating) ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                @endif

                                <blockquote>{{ $review->review_text }}</blockquote>
                                <h6>{{ $review->reviewer_name }}</h6>

                                @if($review->reviewer_title)
                                    <small>{{ $review->reviewer_title }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($reviews->count() > 1)
                    <a class="carousel-control-prev testimonial-control" href="#testimonialCarousel" role="button" data-slide="prev" aria-label="Previous testimonial">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a class="carousel-control-next testimonial-control" href="#testimonialCarousel" role="button" data-slide="next" aria-label="Next testimonial">
                        <i class="fas fa-chevron-right"></i>
                    </a>

                    <ol class="carousel-indicators testimonial-indicators">
                        @foreach($reviews as $review)
                            <li data-target="#testimonialCarousel" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                @endif
            </div>
        @else
            <div class="testimonial-card text-center mx-auto reveal">
                <blockquote>Team was very flexible with booking a day for installation which was much appreciated while dealing renovation delays. Flooring looks fantastic.</blockquote>
                <h6>Meagan Van Renen</h6>
            </div>
        @endif
    </div>
</section>
