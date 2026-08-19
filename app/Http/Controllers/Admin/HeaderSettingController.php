<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;

class HeaderSettingController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings();

        $query = HeaderSetting::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('topbar_text', 'like', "%{$search}%")
                    ->orWhere('cta_label', 'like', "%{$search}%");
            });
        }

        $headerSettings = $query->latest()->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-settings.partials.table', compact('headerSettings'))->render(),
            ]);
        }

        $title = 'Header Settings Management';
        $breadcrumb = [['text' => 'Header Settings', 'url' => route('admin.header-settings.index')]];

        return view('admin.header-settings.index', compact('headerSettings', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings();
        $query = HeaderSetting::query();
        if ($request->filled('search')) {
            $query->where('topbar_text', 'like', "%{$request->search}%");
        }

        $settings = $query->select('id', 'topbar_text', 'cta_label')->latest()->get();
        return response()->json(['success' => true, 'data' => $settings]);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-settings.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);
        HeaderSetting::create($validated);
        return response()->json(['success' => true, 'message' => 'Header setting created successfully.']);
    }

    public function show(Request $request, HeaderSetting $headerSetting)
    {
        $this->authorizeSettings();
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-settings.partials.show', compact('headerSetting'))->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, HeaderSetting $headerSetting)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-settings.partials.form', compact('headerSetting'))->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, HeaderSetting $headerSetting)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        $headerSetting->update($validated);

        return response()->json(['success' => true, 'message' => 'Header settings updated successfully.']);
    }

    public function destroy(Request $request, HeaderSetting $headerSetting)
    {
        $this->authorizeSettings();

        $headerSetting->delete();
        return response()->json(['success' => true, 'message' => 'Header setting moved to trash.']);
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
                HeaderSetting::whereIn('id', $ids)->delete();
                $msg = 'Selected header settings moved to trash.';
                break;

            case 'restore':
                HeaderSetting::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected header settings restored.';
                break;

            case 'force_delete':
                HeaderSetting::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $msg = 'Selected header settings permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings();

        $query = HeaderSetting::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('topbar_text', 'like', "%{$search}%");
        }

        $headerSettings = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.header-settings.partials.table', ['headerSettings' => $headerSettings, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Header Settings';
        $breadcrumb = [['text' => 'Trashed Header Settings', 'url' => route('admin.header-settings.trashed')]];

        return view('admin.header-settings.trash', compact('headerSettings', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings();

        HeaderSetting::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Header setting restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings();

        HeaderSetting::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['success' => true, 'message' => 'Header setting permanently deleted.']);
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'topbar_enabled' => ['required', 'boolean'],
            'topbar_text'    => ['nullable', 'string', 'max:255'],
            'show_phone'     => ['required', 'boolean'],
            'show_email'     => ['required', 'boolean'],
            'cta_enabled'    => ['required', 'boolean'],
            'cta_label'      => ['nullable', 'string', 'max:80'],
            'cta_url'        => ['nullable', 'url:http,https', 'max:2048'],
        ]);
    }

    private function authorizeSettings(): void
    {
        abort_unless(
            auth('admin')->user()?->can('identity_settings') || auth('admin')->user()?->can('settings'),
            403
        );
    }
}