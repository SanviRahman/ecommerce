<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetaPixelScript;
use Illuminate\Http\Request;

class MetaPixelScriptController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings('list');

        $query = MetaPixelScript::with(['creator', 'updater']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('placement', 'like', "%{$search}%");
            });
        }

        if ($request->filled('placement')) {
            $query->where('placement', $request->placement);
        }

        $scripts = $query->orderBy('placement')->orderBy('sort_order')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.meta-pixel-scripts.partials.table', compact('scripts'))->render(),
            ]);
        }

        $title = 'Meta Pixel & Tracking Scripts Management';
        $breadcrumb = [['text' => 'Meta Pixel Scripts', 'url' => route('admin.meta-pixel-scripts.index')]];

        return view('admin.meta-pixel-scripts.index', compact('scripts', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings('list');

        $query = MetaPixelScript::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $scripts = $query->select('id', 'name', 'placement')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $scripts]);
    }

    public function sort(Request $request)
    {
        $this->authorizeSettings('update');

        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            MetaPixelScript::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Scripts reordered successfully.']);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings('create');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.meta-pixel-scripts.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings('create');
        $validated = $this->validateRequest($request);

        MetaPixelScript::create($validated);

        return response()->json(['success' => true, 'message' => 'Script created successfully.']);
    }

    public function show(Request $request, MetaPixelScript $metaPixelScript)
    {
        $this->authorizeSettings('view');
        $metaPixelScript->load(['creator', 'updater']);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.meta-pixel-scripts.partials.show', ['script' => $metaPixelScript])->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, MetaPixelScript $metaPixelScript)
    {
        $this->authorizeSettings('update');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.meta-pixel-scripts.partials.form', ['script' => $metaPixelScript])->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, MetaPixelScript $metaPixelScript)
    {
        $this->authorizeSettings('update');
        $validated = $this->validateRequest($request, $metaPixelScript->id);

        $metaPixelScript->update($validated);

        return response()->json(['success' => true, 'message' => 'Script updated successfully.']);
    }

    public function destroy(Request $request, MetaPixelScript $metaPixelScript)
    {
        $this->authorizeSettings('delete');

        $metaPixelScript->delete();
        return response()->json(['success' => true, 'message' => 'Script moved to trash.']);
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
                MetaPixelScript::whereIn('id', $ids)->delete();
                $msg = 'Selected scripts moved to trash.';
                break;

            case 'restore':
                MetaPixelScript::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected scripts restored.';
                break;

            case 'force_delete':
                MetaPixelScript::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $msg = 'Selected scripts permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings('trash');

        $query = MetaPixelScript::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $scripts = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.meta-pixel-scripts.partials.table', ['scripts' => $scripts, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Meta Pixel Scripts';
        $breadcrumb = [['text' => 'Trashed Meta Pixel Scripts', 'url' => route('admin.meta-pixel-scripts.trashed')]];

        return view('admin.meta-pixel-scripts.trash', compact('scripts', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings('restore');

        MetaPixelScript::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Script restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings('force_delete');

        MetaPixelScript::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['success' => true, 'message' => 'Script permanently deleted.']);
    }

    private function validateRequest(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'placement'   => ['required', 'string', 'in:head,body_start,body_end'],
            'script_code' => ['required', 'string'],
            'sort_order'  => ['required', 'integer', 'min:0'],
            'status'      => ['required', 'boolean'],
        ]);
    }

    private function authorizeSettings(string $action = 'manage'): void
    {
        $user = auth('admin')->user();
        $permission = "meta_pixel_script_{$action}";

        abort_unless(
            $user?->can($permission) || 
            $user?->can('meta_pixel_script_manage') || 
            $user?->can('settings') || 
            $user?->can('system_tools'),
            403
        );
    }
}