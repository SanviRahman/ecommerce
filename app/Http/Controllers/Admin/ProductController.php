<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings('list');

        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('sort_order')->paginate(15);
        $categories = Category::where('status', true)->orderBy('sort_order')->pluck('name', 'id');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.products.partials.table', compact('products'))->render(),
            ]);
        }

        $title = 'Product Management';
        $breadcrumb = [['text' => 'Products', 'url' => route('admin.products.index')]];

        return view('admin.products.index', compact('products', 'categories', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings('list');

        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->select('id', 'name', 'sku')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $products]);
    }

    public function sort(Request $request)
    {
        $this->authorizeSettings('update');

        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            Product::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Products reordered successfully.']);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings('create');

        $categories = Category::where('status', true)->orderBy('sort_order')->pluck('name', 'id');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.products.partials.form', compact('categories'))->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings('create');
        $validated = $this->validateRequest($request);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        
        $data = $validated;
        unset($data['featured_image'], $data['gallery'], $data['data_sheet'], $data['remove_featured_image'], $data['remove_data_sheet']);

        $product = Product::create($data);

        $this->syncMedia($request, $product, 'featured_image');
        $this->syncMedia($request, $product, 'gallery');
        $this->syncMedia($request, $product, 'data_sheet');

        return response()->json(['success' => true, 'message' => 'Product created successfully.']);
    }

    public function show(Request $request, Product $product)
    {
        $this->authorizeSettings('view');
        $product->load('category');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.products.partials.show', compact('product'))->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, Product $product)
    {
        $this->authorizeSettings('update');

        $categories = Category::where('status', true)->orderBy('sort_order')->pluck('name', 'id');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.products.partials.form', compact('product', 'categories'))->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeSettings('update');
        $validated = $this->validateRequest($request, $product->id);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $data = $validated;
        unset($data['featured_image'], $data['gallery'], $data['data_sheet'], $data['remove_featured_image'], $data['remove_data_sheet']);

        $product->update($data);

        $this->syncMedia($request, $product, 'featured_image');
        $this->syncMedia($request, $product, 'gallery');
        $this->syncMedia($request, $product, 'data_sheet');

        return response()->json(['success' => true, 'message' => 'Product updated successfully.']);
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeSettings('delete');

        $product->delete();
        return response()->json(['success' => true, 'message' => 'Product moved to trash.']);
    }

    public function multipleAction(Request $request)
    {
        $this->authorizeSettings('delete');

        $validated = $request->validate([
            'action' => ['required', 'in:delete,restore,force_delete'],
            'ids'    => ['required', 'array'],
            'ids.*'  => ['integer'],
        ]);

        $ids = $validated['ids'];
        $msg = '';

        switch ($validated['action']) {
            case 'delete':
                Product::whereIn('id', $ids)->delete();
                $msg = 'Selected products moved to trash.';
                break;

            case 'restore':
                $this->authorizeSettings('restore');
                Product::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected products restored.';
                break;

            case 'force_delete':
                $this->authorizeSettings('force_delete');
                $items = Product::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    $item->clearMediaCollection('featured_image');
                    $item->clearMediaCollection('gallery');
                    $item->clearMediaCollection('data_sheet');
                    $item->forceDelete();
                }
                $msg = 'Selected products permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings('trash');

        $query = Product::onlyTrashed()->with('category')->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.products.partials.table', ['products' => $products, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Products';
        $breadcrumb = [['text' => 'Trashed Products', 'url' => route('admin.products.trashed')]];

        return view('admin.products.trash', compact('products', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings('restore');

        Product::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Product restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings('force_delete');

        $model = Product::onlyTrashed()->findOrFail($id);
        $model->clearMediaCollection('featured_image');
        $model->clearMediaCollection('gallery');
        $model->clearMediaCollection('data_sheet');
        $model->forceDelete();

        return response()->json(['success' => true, 'message' => 'Product permanently deleted.']);
    }

    private function validateRequest(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'category_id'       => ['required', 'exists:categories,id'],
            'name'              => ['required', 'string', 'max:180'],
            'slug'              => ['nullable', 'string', 'max:220', 'unique:products,slug,' . $id],
            'sku'               => ['nullable', 'string', 'max:120', 'unique:products,sku,' . $id],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'specifications'    => ['nullable', 'array'],
            'is_featured'       => ['required', 'boolean'],
            'sort_order'        => ['required', 'integer', 'min:0'],
            'status'            => ['required', 'boolean'],
            'featured_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery.*'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'data_sheet'        => ['nullable', 'mimes:pdf', 'max:10240'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'remove_data_sheet'     => ['nullable', 'boolean'],
        ]);
    }

    private function authorizeSettings(string $action = 'manage'): void
    {
        $user = auth('admin')->user();
        $permission = "product_{$action}";

        abort_unless(
            $user?->can($permission) || $user?->can('product_manage') || $user?->can('settings'),
            403
        );
    }

    private function syncMedia(Request $request, Product $product, string $collection): void
    {
        if ($request->boolean("remove_{$collection}")) {
            $product->clearMediaCollection($collection);
        }

        if ($collection === 'gallery' && $request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                $product->addMedia($file)
                    ->usingFileName(Str::uuid() . '.' . $extension)
                    ->toMediaCollection($collection, 'public');
            }
            return;
        }

        if (!$request->hasFile($collection)) {
            return;
        }

        $file = $request->file($collection);
        $extension = strtolower($file->getClientOriginalExtension());

        $product->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $extension)
            ->toMediaCollection($collection, 'public');
    }
}