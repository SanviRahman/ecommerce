<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionPhoto;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with(['category', 'media'])
            ->where('status', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $offerGalleryPhotos = HomeSectionPhoto::query()
            ->with('media')
            ->where('status', true)
            ->where('section_key', 'after_what_we_offer')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $reviews = Review::query()
            ->with('media')
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(10)
            ->get();

        return view('frontend.pages.home.home', compact(
            'products',
            'offerGalleryPhotos',
            'reviews'
        ));
    }
}
