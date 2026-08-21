@extends('frontend.layouts.master')

@section('body_class', 'product-page')
@section('title', 'Our Products | '.($siteSetting->site_name ?? config('app.name')))
@section('meta_description', 'Browse premium flooring and surface materials by category.')

@section('content')
{{-- Reference-style Products hero / breadcrumb --}}
<section class="product-page-hero">
    <div class="container product-hero-inner">
        <div class="product-hero-content reveal">
            <h1>Our Products</h1>

            <nav class="product-breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <i class="fas fa-chevron-right product-breadcrumb-separator"></i>
                <span>Our Products</span>
            </nav>
        </div>
    </div>
</section>

<section
    id="product-catalog"
    class="product-catalog-section"
    data-load-url="{{ route('products.load-more') }}"
    data-batch-size="{{ $productsPerBatch }}"
>
    <div class="container">
        <div class="product-heading reveal">
            <div class="section-eyebrow">Our Products</div>
            <h2 class="section-title">Premium Flooring &amp; Surface<br>Materials In Dubai</h2>
        </div>

        <div class="product-heading-line"></div>

        <nav class="product-filter-tabs reveal" aria-label="Product category filter">
            <a
                href="{{ route('products.index') }}"
                class="product-filter-tab {{ $selectedCategory ? '' : 'is-active' }}"
                data-product-filter=""
                aria-pressed="{{ $selectedCategory ? 'false' : 'true' }}"
            >
                All
            </a>

            @foreach($categories as $category)
                <a
                    href="{{ route('products.index', ['category' => $category->slug]) }}"
                    class="product-filter-tab {{ $selectedCategory === $category->slug ? 'is-active' : '' }}"
                    data-product-filter="{{ $category->slug }}"
                    aria-pressed="{{ $selectedCategory === $category->slug ? 'true' : 'false' }}"
                >
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>

        <div
            id="productGrid"
            class="product-grid"
            data-product-grid
            aria-live="polite"
        >
            @include('frontend.pages.product.partials.product_cards', [
                'products' => $products,
                'offset' => 0,
            ])
        </div>

        <div
            class="product-empty-state {{ $products->isEmpty() ? '' : 'd-none' }}"
            data-product-empty
        >
            <i class="fas fa-layer-group"></i>
            <p>No products are available in this category.</p>
        </div>

        <div class="product-more-wrap {{ $hasMoreProducts ? '' : 'd-none' }}" data-product-more-wrap>
            <button
                type="button"
                class="product-more-btn"
                data-product-more
                data-offset="{{ $products->count() }}"
                data-category="{{ $selectedCategory ?? '' }}"
            >
                <span data-more-text>More</span>
                <i class="fas fa-long-arrow-alt-down"></i>
            </button>
        </div>
    </div>
</section>

{{-- Existing reusable TMC section used by Home + Products --}}
@include('frontend.partials.tmc-section')
@endsection

@include('frontend.pages.product.product_css')
@include('frontend.pages.product.product_script')
