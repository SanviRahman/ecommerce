<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSectionPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeSectionPhotoController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings('list');

        $query = HomeSectionPhoto::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('caption', 'like', "%{$search}%")
                    ->orWhere('section_key', 'like', "%{$search}%");
            });
        }

        if ($request->filled('section_key')) {
            $query->where('section_key', $request->section_key);
        }

        $photos = $query->orderBy('section_key')->orderBy('sort_order')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.home-section-photos.partials.table', compact('photos'))->render(),
            ]);
        }

        $title = 'Homepage Section Photos Management';
        $breadcrumb = [['text' => 'Home Section Photos', 'url' => route('admin.home-section-photos.index')]];

        return view('admin.home-section-photos.index', compact('photos', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings('list');

        $query = HomeSectionPhoto::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $photos = $query->select('id', 'title', 'section_key')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $photos]);
    }

    public function sort(Request $request)
    {
        $this->authorizeSettings('update');

        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            HomeSectionPhoto::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Photos reordered successfully.']);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings('create');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.home-section-photos.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings('create');
        $validated = $this->validateRequest($request);

        $data = $validated;
        unset($data['image'], $data['remove_image']);

        $photo = HomeSectionPhoto::create($data);
        $this->syncMedia($request, $photo, 'image');

        return response()->json(['success' => true, 'message' => 'Home section photo created successfully.']);
    }

    public function show(Request $request, HomeSectionPhoto $homeSectionPhoto)
    {
        $this->authorizeSettings('view');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.home-section-photos.partials.show', ['photo' => $homeSectionPhoto])->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, HomeSectionPhoto $homeSectionPhoto)
    {
        $this->authorizeSettings('update');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.home-section-photos.partials.form', ['photo' => $homeSectionPhoto])->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, HomeSectionPhoto $homeSectionPhoto)
    {
        $this->authorizeSettings('update');
        $validated = $this->validateRequest($request);

        $data = $validated;
        unset($data['image'], $data['remove_image']);

        $homeSectionPhoto->update($data);
        $this->syncMedia($request, $homeSectionPhoto, 'image');

        return response()->json(['success' => true, 'message' => 'Home section photo updated successfully.']);
    }

    public function destroy(Request $request, HomeSectionPhoto $homeSectionPhoto)
    {
        $this->authorizeSettings('delete');

        $homeSectionPhoto->delete();
        return response()->json(['success' => true, 'message' => 'Home section photo moved to trash.']);
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
                HomeSectionPhoto::whereIn('id', $ids)->delete();
                $msg = 'Selected photos moved to trash.';
                break;

            case 'restore':
                HomeSectionPhoto::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected photos restored.';
                break;

            case 'force_delete':
                $items = HomeSectionPhoto::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    $item->clearMediaCollection('image');
                    $item->forceDelete();
                }
                $msg = 'Selected photos permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings('trash');

        $query = HomeSectionPhoto::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $photos = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.home-section-photos.partials.table', ['photos' => $photos, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Home Section Photos';
        $breadcrumb = [['text' => 'Trashed Home Section Photos', 'url' => route('admin.home-section-photos.trashed')]];

        return view('admin.home-section-photos.trash', compact('photos', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings('restore');

        HomeSectionPhoto::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Home section photo restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings('force_delete');

        $model = HomeSectionPhoto::onlyTrashed()->findOrFail($id);
        $model->clearMediaCollection('image');
        $model->forceDelete();

        return response()->json(['success' => true, 'message' => 'Home section photo permanently deleted.']);
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'section_key'  => ['required', 'string', 'in:our_products,after_what_we_offer'],
            'title'        => ['nullable', 'string', 'max:190'],
            'caption'      => ['nullable', 'string'],
            'link_url'     => ['nullable', 'url:http,https', 'max:2048'],
            'sort_order'   => ['required', 'integer', 'min:0'],
            'status'       => ['required', 'boolean'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }

    private function authorizeSettings(string $action = 'manage'): void
    {
        $user = auth('admin')->user();
        $permission = "home_section_photo_{$action}";

        abort_unless(
            $user?->can($permission) || 
            $user?->can('home_section_photo_manage') || 
            $user?->can('settings'),
            403
        );
    }

    private function syncMedia(Request $request, HomeSectionPhoto $photo, string $collection): void
    {
        if ($request->boolean("remove_{$collection}")) {
            $photo->clearMediaCollection($collection);
        }

        if (!$request->hasFile($collection)) {
            return;
        }

        $file = $request->file($collection);
        $extension = strtolower($file->getClientOriginalExtension());

        $photo->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $extension)
            ->toMediaCollection($collection, 'public');
    }
}