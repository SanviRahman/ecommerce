@forelse($products as $product)
    @php
        $productImage = $product->featured_image_url
            ?: asset('frontend/images/home/product-spc.webp');

        $delayIndex = (($offset ?? 0) + $loop->index) % 7;
    @endphp

    <article
        class="product-grid-card reveal"
        data-product-item
        data-product-category="{{ $product->category?->slug }}"
        style="transition-delay: {{ $delayIndex * 55 }}ms"
    >
        <a
            class="product-grid-link"
            href="{{ route('products.show', ['product' => $product->slug]) }}"
            aria-label="View {{ $product->name }}"
        >
            <div class="product-grid-media">
            <img
                src="{{ $productImage }}"
                alt="{{ $product->name }}"
                loading="lazy"
            >

            <div class="product-card-overlay">
                <div class="product-card-meta">
                    <small>{{ $product->category?->name }}</small>
                    <h3>{{ $product->name }}</h3>

                    @if($product->short_description)
                        <p>{{ \Illuminate\Support\Str::limit($product->short_description, 90) }}</p>
                    @endif
                </div>
            </div>
        </div>
        </a>
    </article>
@empty
@endforelse
