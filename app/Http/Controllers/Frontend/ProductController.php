<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    private const PRODUCTS_PER_BATCH = 7;

    public function index(Request $request): View
    {
        $categories = $this->activeCategories();

        $requestedCategory = trim((string) $request->query('category', ''));

        $selectedCategory = $requestedCategory !== ''
            ? $categories->firstWhere('slug', $requestedCategory)
            : null;

        $categorySlug = $selectedCategory?->slug;

        $productQuery = $this->productQuery($categorySlug);
        $totalProducts = (clone $productQuery)->count();

        $products = $productQuery
            ->limit(self::PRODUCTS_PER_BATCH)
            ->get();

        return view('frontend.pages.product.product', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $categorySlug,
            'totalProducts' => $totalProducts,
            'productsPerBatch' => self::PRODUCTS_PER_BATCH,
            'hasMoreProducts' => $products->count() < $totalProducts,
        ]);
    }

    public function loadMore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['nullable', 'string', 'max:190'],
            'offset' => ['nullable', 'integer', 'min:0'],
        ]);

        $categorySlug = isset($validated['category'])
            ? trim((string) $validated['category'])
            : null;

        $categorySlug = $categorySlug !== '' ? $categorySlug : null;

        if (
            $categorySlug &&
            ! Category::query()
                ->where('status', true)
                ->where('slug', $categorySlug)
                ->exists()
        ) {
            return response()->json([
                'message' => 'The selected category is not available.',
            ], 422);
        }

        $offset = (int) ($validated['offset'] ?? 0);

        $productQuery = $this->productQuery($categorySlug);
        $totalProducts = (clone $productQuery)->count();

        $products = $productQuery
            ->skip($offset)
            ->take(self::PRODUCTS_PER_BATCH)
            ->get();

        $nextOffset = $offset + $products->count();

        return response()->json([
            'html' => view('frontend.pages.product.partials.product_cards', [
                'products' => $products,
                'offset' => $offset,
            ])->render(),
            'next_offset' => $nextOffset,
            'has_more' => $nextOffset < $totalProducts,
            'total' => $totalProducts,
        ]);
    }

    private function activeCategories()
    {
        $activeProductCategoryIds = Product::query()
            ->where('status', true)
            ->whereNotNull('category_id')
            ->select('category_id')
            ->distinct();

        return Category::query()
            ->where('status', true)
            ->whereIn('id', $activeProductCategoryIds)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    private function productQuery(?string $categorySlug = null): Builder
    {
        return Product::query()
            ->with([
                'category',
                'media',
            ])
            ->where('status', true)
            ->whereHas('category', function (Builder $query) {
                $query->where('status', true);
            })
            ->when(
                $categorySlug,
                function (Builder $query, string $slug) {
                    $query->whereHas('category', function (Builder $categoryQuery) use ($slug) {
                        $categoryQuery->where('slug', $slug);
                    });
                }
            )
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
