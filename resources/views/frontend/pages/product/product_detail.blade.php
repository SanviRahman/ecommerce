@extends('frontend.layouts.master')

@section('body_class', 'product-page product-detail-page')
@section('title', $product->name.' | '.($siteSetting->site_name ?? config('app.name')))
@section('meta_description', $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags((string) $product->description), 155))

@section('content')
@php
    $featuredImage = $product->featured_image_url
        ?: asset('frontend/images/home/product-spc.webp');

    $detailImages = collect([
        (object) [
            'url' => $featuredImage,
            'name' => $product->name,
        ],
    ]);

    foreach ($product->getMedia('gallery') as $media) {
        $url = $media->getUrl();

        if ($url !== $featuredImage) {
            $detailImages->push((object) [
                'url' => $url,
                'name' => $media->name ?: $product->name,
            ]);
        }
    }

    $specifications = is_array($product->specifications)
        ? collect($product->specifications)->filter(
            fn ($value, $key) => trim((string) $key) !== ''
        )
        : collect();

    $description = $product->description ?: $product->short_description;
    $dataSheetUrl = $product->data_sheet_url;
@endphp

<section class="product-detail-hero">
    <div class="container product-detail-hero-inner">
        <div class="product-detail-hero-content reveal">
            <h1>{{ $product->name }}</h1>

            <nav class="product-detail-breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>

                <i class="fas fa-chevron-right product-detail-breadcrumb-separator"></i>

                <a href="{{ route('products.index') }}">
                    <span>Products</span>
                </a>

                <i class="fas fa-chevron-right product-detail-breadcrumb-separator"></i>

                <span>{{ $product->name }}</span>
            </nav>
        </div>
    </div>
</section>

<section class="product-detail-section">
    <div class="container">
        <div class="row product-detail-row">
            <div class="col-lg-6">
                <div class="product-detail-image-column reveal from-left">
                    {{-- Product detail image gallery stays manual.
                         No auto-scroll and no indicator/progress bar here. --}}
                    <div
                        id="productDetailImageCarousel"
                        class="carousel slide carousel-fade product-detail-image-carousel"
                        data-interval="false"
                        data-pause="true"
                        data-wrap="true"
                        data-keyboard="true"
                        data-touch="true"
                    >
                        <div class="carousel-inner">
                            @foreach($detailImages as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="product-detail-image-frame">
                                        <img
                                            src="{{ $image->url }}"
                                            alt="{{ $image->name }}"
                                            @if(!$loop->first) loading="lazy" @endif
                                        >
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($detailImages->count() > 1)
                            <a
                                class="carousel-control-prev product-detail-image-control"
                                href="#productDetailImageCarousel"
                                role="button"
                                data-slide="prev"
                                aria-label="Previous product image"
                            >
                                <i class="fas fa-chevron-left"></i>
                            </a>

                            <a
                                class="carousel-control-next product-detail-image-control"
                                href="#productDetailImageCarousel"
                                role="button"
                                data-slide="next"
                                aria-label="Next product image"
                            >
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="product-detail-content">
                    <div class="product-detail-block reveal from-right">
                        <h2>Products Details:</h2>

                        @if($specifications->isNotEmpty())
                            <div class="product-specification-table">
                                @foreach($specifications as $label => $value)
                                    <div
                                        class="product-specification-row reveal"
                                        style="transition-delay: {{ min($loop->index * 55, 330) }}ms"
                                    >
                                        <div class="product-specification-label">
                                            {{ $label }}:
                                        </div>

                                        <div class="product-specification-value">
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($product->short_description)
                            <p class="product-detail-short-description">
                                {{ $product->short_description }}
                            </p>
                        @endif
                    </div>

                    @if($description)
                        <div class="product-detail-description reveal">
                            {!! nl2br(e($description)) !!}
                        </div>
                    @endif

                    @if($dataSheetUrl)
                        <div class="product-data-sheet reveal">
                            <h3>Data Sheet</h3>

                            <div class="product-data-sheet-preview">
                                <object
                                    data="{{ $dataSheetUrl }}#toolbar=0&navpanes=0&scrollbar=0"
                                    type="application/pdf"
                                    aria-label="{{ $product->name }} data sheet"
                                >
                                    <div class="product-data-sheet-fallback">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>PDF Data Sheet</span>
                                    </div>
                                </object>
                            </div>

                            <a
                                class="product-data-sheet-link"
                                href="{{ $dataSheetUrl }}"
                                target="_blank"
                                rel="noopener"
                            >
                                View Data Sheet
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedProducts->isNotEmpty())
    <section class="related-products-section">
        <div class="container">
            <div class="related-products-heading reveal">
                <div class="related-products-eyebrow">
                    <span></span>
                    <strong>Our Products</strong>
                    <span></span>
                </div>

                <h2>Explore Prestige Products</h2>
            </div>

            @php
                $relatedChunks = $relatedProducts->chunk(3);
            @endphp

            {{-- Auto-scroll belongs only to Our Products / related products. --}}
            <div
                id="relatedProductsCarousel"
                class="carousel slide related-products-carousel reveal"
                data-ride="carousel"
                data-interval="4600"
                data-pause="false"
                data-wrap="true"
                data-keyboard="true"
                data-touch="true"
            >
                <div class="carousel-inner">
                    @foreach($relatedChunks as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row related-products-row">
                                @foreach($chunk as $relatedProduct)
                                    @php
                                        $relatedImage = $relatedProduct->featured_image_url
                                            ?: asset('frontend/images/home/product-spc.webp');
                                    @endphp

                                    <div class="col-md-4 mb-4 mb-md-0">
                                        <a
                                            href="{{ route('products.show', ['product' => $relatedProduct->slug]) }}"
                                            class="related-product-card"
                                        >
                                            <div class="related-product-media">
                                                <img
                                                    src="{{ $relatedImage }}"
                                                    alt="{{ $relatedProduct->name }}"
                                                    loading="lazy"
                                                >

                                                <span class="related-product-overlay">
                                                    <strong>{{ $relatedProduct->name }}</strong>

                                                    @if($relatedProduct->category)
                                                        <small>{{ $relatedProduct->category->name }}</small>
                                                    @endif
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($relatedChunks->count() > 1)
                    <ol class="carousel-indicators related-product-indicators">
                        @foreach($relatedChunks as $chunk)
                            <li
                                data-target="#relatedProductsCarousel"
                                data-slide-to="{{ $loop->index }}"
                                class="{{ $loop->first ? 'active' : '' }}"
                                aria-label="Related products slide {{ $loop->iteration }}"
                            ></li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </section>
@endif
@endsection

@include('frontend.pages.product.product_detail_css')
@include('frontend.pages.product.product_detail_script')
