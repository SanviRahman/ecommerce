<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings();

        $query = FooterSetting::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('about_heading', 'like', "%{$search}%")
                    ->orWhere('copyright_text', 'like', "%{$search}%");
            });
        }

        $footerSettings = $query->latest()->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-settings.partials.table', compact('footerSettings'))->render(),
            ]);
        }

        $title = 'Footer Settings Management';
        $breadcrumb = [['text' => 'Footer Settings', 'url' => route('admin.footer-settings.index')]];

        return view('admin.footer-settings.index', compact('footerSettings', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings();

        $query = FooterSetting::query();

        if ($request->filled('search')) {
            $query->where('about_heading', 'like', "%{$request->search}%");
        }

        $settings = $query->select('id', 'about_heading', 'copyright_text')->latest()->get();
        return response()->json(['success' => true, 'data' => $settings]);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-settings.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        FooterSetting::create($validated);

        return response()->json(['success' => true, 'message' => 'Footer setting created successfully.']);
    }

    public function show(Request $request, FooterSetting $footerSetting)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-settings.partials.show', compact('footerSetting'))->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, FooterSetting $footerSetting)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-settings.partials.form', compact('footerSetting'))->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, FooterSetting $footerSetting)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        $footerSetting->update($validated);

        return response()->json(['success' => true, 'message' => 'Footer settings updated successfully.']);
    }

    public function destroy(Request $request, FooterSetting $footerSetting)
    {
        $this->authorizeSettings();

        $footerSetting->delete();
        return response()->json(['success' => true, 'message' => 'Footer setting moved to trash.']);
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
                FooterSetting::whereIn('id', $ids)->delete();
                $msg = 'Selected footer settings moved to trash.';
                break;

            case 'restore':
                FooterSetting::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected footer settings restored.';
                break;

            case 'force_delete':
                FooterSetting::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $msg = 'Selected footer settings permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings();

        $query = FooterSetting::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('about_heading', 'like', "%{$search}%");
        }

        $footerSettings = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-settings.partials.table', ['footerSettings' => $footerSettings, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Footer Settings';
        $breadcrumb = [['text' => 'Trashed Footer Settings', 'url' => route('admin.footer-settings.trashed')]];

        return view('admin.footer-settings.trash', compact('footerSettings', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings();

        FooterSetting::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Footer setting restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings();

        FooterSetting::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['success' => true, 'message' => 'Footer setting permanently deleted.']);
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'about_heading'      => ['nullable', 'string', 'max:120'],
            'about_text'         => ['nullable', 'string'],
            'navigation_heading' => ['nullable', 'string', 'max:120'],
            'products_heading'   => ['nullable', 'string', 'max:120'],
            'contact_heading'    => ['nullable', 'string', 'max:120'],
            'copyright_text'     => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function authorizeSettings(): void
    {
        abort_unless(
            auth('admin')->user()?->can('footer_settings') || auth('admin')->user()?->can('settings'),
            403
        );
    }
}