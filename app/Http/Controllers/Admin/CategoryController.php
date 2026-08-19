<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings();

        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('sort_order')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.categories.partials.table', compact('categories'))->render(),
            ]);
        }

        $title = 'Category Management';
        $breadcrumb = [['text' => 'Categories', 'url' => route('admin.categories.index')]];

        return view('admin.categories.index', compact('categories', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings();

        $query = Category::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $categories = $query->select('id', 'name', 'slug')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function sort(Request $request)
    {
        $this->authorizeSettings();

        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            Category::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Categories reordered successfully.']);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.categories.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        
        $data = $validated;
        unset($data['image'], $data['remove_image']);

        $category = Category::create($data);
        $this->syncMedia($request, $category, 'image');

        return response()->json(['success' => true, 'message' => 'Category created successfully.']);
    }

    public function show(Request $request, Category $category)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.categories.partials.show', compact('category'))->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, Category $category)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.categories.partials.form', compact('category'))->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request, $category->id);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $data = $validated;
        unset($data['image'], $data['remove_image']);

        $category->update($data);
        $this->syncMedia($request, $category, 'image');

        return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
    }

    public function destroy(Request $request, Category $category)
    {
        $this->authorizeSettings();

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category moved to trash.']);
    }

    public function multipleAction(Request $request)
    {
        $this->authorizeSettings();

        $validated = $request->validate([
            'action' => ['required', 'in:delete,restore,force_delete'],
            'ids'    => ['required', 'array'],
            'ids.*'  => ['integer'],
        ]);

        $ids = $validated['ids'];
        $msg = '';

        switch ($validated['action']) {
            case 'delete':
                Category::whereIn('id', $ids)->delete();
                $msg = 'Selected categories moved to trash.';
                break;

            case 'restore':
                Category::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected categories restored.';
                break;

            case 'force_delete':
                $items = Category::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    $item->clearMediaCollection('image');
                    $item->forceDelete();
                }
                $msg = 'Selected categories permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings();

        $query = Category::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.categories.partials.table', ['categories' => $categories, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Categories';
        $breadcrumb = [['text' => 'Trashed Categories', 'url' => route('admin.categories.trashed')]];

        return view('admin.categories.trash', compact('categories', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings();

        Category::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Category restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings();

        $model = Category::onlyTrashed()->findOrFail($id);
        $model->clearMediaCollection('image');
        $model->forceDelete();

        return response()->json(['success' => true, 'message' => 'Category permanently deleted.']);
    }

    private function validateRequest(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'slug'        => ['nullable', 'string', 'max:180', 'unique:categories,slug,' . $id],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['required', 'integer', 'min:0'],
            'status'      => ['required', 'boolean'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image'=> ['nullable', 'boolean'],
        ]);
    }

    private function authorizeSettings(): void
    {
        abort_unless(
            auth('admin')->user()?->can('category_manage') || auth('admin')->user()?->can('settings'),
            403
        );
    }

    private function syncMedia(Request $request, Category $category, string $collection): void
    {
        if ($request->boolean("remove_{$collection}")) {
            $category->clearMediaCollection($collection);
        }

        if (!$request->hasFile($collection)) {
            return;
        }

        $file = $request->file($collection);
        $extension = strtolower($file->getClientOriginalExtension());

        $category->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $extension)
            ->toMediaCollection($collection, 'public');
    }
}