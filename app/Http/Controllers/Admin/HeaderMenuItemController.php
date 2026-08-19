<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderMenuItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HeaderMenuItemController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings();

        $query = HeaderMenuItem::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                    ->orWhere('route_name', 'like', "%{$search}%")
                    ->orWhere('custom_url', 'like', "%{$search}%");
            });
        }

        $headerMenuItems = $query->orderBy('sort_order')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-menu-items.partials.table', compact('headerMenuItems'))->render(),
            ]);
        }

        $title = 'Header Menu Management';
        $breadcrumb = [['text' => 'Header Menu Items', 'url' => route('admin.header-menu-items.index')]];

        return view('admin.header-menu-items.index', compact('headerMenuItems', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings();

        $query = HeaderMenuItem::query();

        if ($request->filled('search')) {
            $query->where('label', 'like', "%{$request->search}%");
        }

        $items = $query->select('id', 'label', 'route_name')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-menu-items.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        HeaderMenuItem::create($validated);

        return response()->json(['success' => true, 'message' => 'Menu item created successfully.']);
    }

    public function show(Request $request, HeaderMenuItem $headerMenuItem)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-menu-items.partials.show', compact('headerMenuItem'))->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, HeaderMenuItem $headerMenuItem)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-menu-items.partials.form', compact('headerMenuItem'))->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, HeaderMenuItem $headerMenuItem)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        $headerMenuItem->update($validated);

        return response()->json(['success' => true, 'message' => 'Menu item updated successfully.']);
    }

    public function destroy(Request $request, HeaderMenuItem $headerMenuItem)
    {
        $this->authorizeSettings();

        $headerMenuItem->delete();
        return response()->json(['success' => true, 'message' => 'Menu item moved to trash.']);
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
                HeaderMenuItem::whereIn('id', $ids)->delete();
                $msg = 'Selected menu items moved to trash.';
                break;

            case 'restore':
                HeaderMenuItem::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected menu items restored.';
                break;

            case 'force_delete':
                HeaderMenuItem::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $msg = 'Selected menu items permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings();

        $query = HeaderMenuItem::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('label', 'like', "%{$search}%");
        }

        $headerMenuItems = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-menu-items.partials.table', ['headerMenuItems' => $headerMenuItems, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Header Menu Items';
        $breadcrumb = [['text' => 'Trashed Menu Items', 'url' => route('admin.header-menu-items.trashed')]];

        return view('admin.header-menu-items.trash', compact('headerMenuItems', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings();

        HeaderMenuItem::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Menu item restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings();

        HeaderMenuItem::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['success' => true, 'message' => 'Menu item permanently deleted.']);
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'label'        => ['required', 'string', 'max:100'],
            'route_name'   => ['nullable', 'string', 'max:150'],
            'custom_url'   => ['nullable', 'url:http,https', 'max:2048'],
            'sort_order'   => ['required', 'integer', 'min:0'],
            'open_new_tab' => ['required', 'boolean'],
            'status'       => ['required', 'boolean'],
        ]);

        // Validation rule: require at least one of route_name or custom_url
        if (empty($request->route_name) && empty($request->custom_url)) {
            throw ValidationException::withMessages([
                'route_name' => ['At least one of Route Name or Custom URL must be provided.'],
                'custom_url' => ['At least one of Route Name or Custom URL must be provided.'],
            ]);
        }

        return $validated;
    }

    private function authorizeSettings(): void
    {
        abort_unless(
            auth('admin')->user()?->can('header_menu_manage') || auth('admin')->user()?->can('settings'),
            403
        );
    }
}