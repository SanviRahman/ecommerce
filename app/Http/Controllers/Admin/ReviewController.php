<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings('list');

        $query = Review::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                    ->orWhere('reviewer_title', 'like', "%{$search}%")
                    ->orWhere('review_text', 'like', "%{$search}%");
            });
        }

        $reviews = $query->orderBy('sort_order')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.reviews.partials.table', compact('reviews'))->render(),
            ]);
        }

        $title      = 'Review Management';
        $breadcrumb = [['text' => 'Reviews', 'url' => route('admin.reviews.index')]];

        return view('admin.reviews.index', compact('reviews', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings('list');

        $query = Review::query();

        if ($request->filled('search')) {
            $query->where('reviewer_name', 'like', "%{$request->search}%");
        }

        $reviews = $query->select('id', 'reviewer_name', 'rating')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $reviews]);
    }

    public function sort(Request $request)
    {
        $this->authorizeSettings('update');

        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            Review::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Reviews reordered successfully.']);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings('create');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.reviews.partials.form')->render(),
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings('create');
        $validated = $this->validateRequest($request);

        $data = $validated;
        unset($data['avatar'], $data['remove_avatar']);

        $review = Review::create($data);
        $this->syncMedia($request, $review, 'avatar');

        return response()->json(['success' => true, 'message' => 'Review created successfully.']);
    }

    public function show(Request $request, Review $review)
    {
        $this->authorizeSettings('view');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.reviews.partials.show', compact('review'))->render(),
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, Review $review)
    {
        $this->authorizeSettings('update');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.reviews.partials.form', compact('review'))->render(),
            ]);
        }
        abort(404);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorizeSettings('update');
        $validated = $this->validateRequest($request);

        $data = $validated;
        unset($data['avatar'], $data['remove_avatar']);

        $review->update($data);
        $this->syncMedia($request, $review, 'avatar');

        return response()->json(['success' => true, 'message' => 'Review updated successfully.']);
    }

    public function destroy(Request $request, Review $review)
    {
        $this->authorizeSettings('delete');

        $review->delete();
        return response()->json(['success' => true, 'message' => 'Review moved to trash.']);
    }

    public function multipleAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:delete,restore,force_delete'],
            'ids'    => ['required', 'array'],
            'ids.*'  => ['integer'],
        ]);

        if ($validated['action'] === 'restore') {
            $this->authorizeSettings('restore');
        } elseif ($validated['action'] === 'force_delete') {
            $this->authorizeSettings('force_delete');
        } else {
            $this->authorizeSettings('delete');
        }

        $ids = $validated['ids'];
        $msg = '';

        switch ($validated['action']) {
            case 'delete':
                Review::whereIn('id', $ids)->delete();
                $msg = 'Selected reviews moved to trash.';
                break;

            case 'restore':
                Review::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected reviews restored.';
                break;

            case 'force_delete':
                $items = Review::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    $item->clearMediaCollection('avatar');
                    $item->forceDelete();
                }
                $msg = 'Selected reviews permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings('trash');

        $query = Review::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('reviewer_name', 'like', "%{$search}%");
        }

        $reviews = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.reviews.partials.table', ['reviews' => $reviews, 'isTrash' => true])->render(),
            ]);
        }

        $title      = 'Trashed Reviews';
        $breadcrumb = [['text' => 'Trashed Reviews', 'url' => route('admin.reviews.trashed')]];

        return view('admin.reviews.trash', compact('reviews', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings('restore');

        Review::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Review restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings('force_delete');

        $model = Review::onlyTrashed()->findOrFail($id);
        $model->clearMediaCollection('avatar');
        $model->forceDelete();

        return response()->json(['success' => true, 'message' => 'Review permanently deleted.']);
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'reviewer_name'  => ['required', 'string', 'max:150'],
            'reviewer_title' => ['nullable', 'string', 'max:150'],
            'review_text'    => ['required', 'string'],
            'rating'         => ['required', 'numeric', 'between:1.0,5.0'],
            'sort_order'     => ['required', 'integer', 'min:0'],
            'status'         => ['required', 'boolean'],
            'avatar'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_avatar'  => ['nullable', 'boolean'],
        ]);
    }

    private function authorizeSettings(string $action = 'manage'): void
    {
        $user       = auth('admin')->user();
        $permission = "review_{$action}";

        abort_unless(
            $user?->can($permission) ||
            $user?->can('review_manage') ||
            $user?->can('settings'),
            403
        );
    }

    private function syncMedia(Request $request, Review $review, string $collection): void
    {
        if ($request->boolean("remove_{$collection}")) {
            $review->clearMediaCollection($collection);
        }

        if (! $request->hasFile($collection)) {
            return;
        }

        $file      = $request->file($collection);
        $extension = strtolower($file->getClientOriginalExtension());

        $review->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $extension)
            ->toMediaCollection($collection, 'public');
    }
}
