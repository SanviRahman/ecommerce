<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorizeSettings();

        $query = SiteSetting::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('site_name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%")
                    ->orWhere('contact_phone', 'like', "%{$search}%");
            });
        }

        $siteSettings = $query->latest()->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.table', compact('siteSettings'))->render(),
            ]);
        }

        $title = 'Site Settings Management';
        $breadcrumb = [['text' => 'Site Settings', 'url' => route('admin.site-settings.index')]];

        return view('admin.site-settings.index', compact('siteSettings', 'title', 'breadcrumb'));
    }

    /**
     * JSON list for AJAX requests.
     */
    public function list(Request $request)
    {
        $this->authorizeSettings();

        $query = SiteSetting::query();

        if ($request->filled('search')) {
            $query->where('site_name', 'like', "%{$request->search}%")
                ->orWhere('contact_email', 'like', "%{$request->search}%");
        }

        $settings = $query->select('id', 'site_name', 'contact_email', 'contact_phone')->latest()->get();
        return response()->json(['success' => true, 'data' => $settings]);
    }

    /**
     * Show form for create (AJAX).
     */
    public function create(Request $request)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.form')->render()
            ]);
        }
        abort(404);
    }

    /**
     * Store new resource.
     */
    public function store(Request $request)
    {
        $this->authorizeSettings();

        $validated = $this->validateRequest($request);

        $data = $validated;
        unset($data['logo'], $data['favicon'], $data['remove_logo'], $data['remove_favicon']);

        $siteSetting = SiteSetting::create($data);

        $this->syncMedia($request, $siteSetting, 'logo');
        $this->syncMedia($request, $siteSetting, 'favicon');

        return response()->json(['success' => true, 'message' => 'Site setting record created successfully.']);
    }

    /**
     * Show details (AJAX).
     */
    public function show(Request $request, SiteSetting $siteSetting)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.show', compact('siteSetting'))->render()
            ]);
        }
        abort(404);
    }

    /**
     * Edit form (AJAX).
     */
    public function edit(Request $request, SiteSetting $siteSetting)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.form', compact('siteSetting'))->render()
            ]);
        }
        abort(404);
    }

    /**
     * Update resource.
     */
    public function update(Request $request, SiteSetting $siteSetting)
    {
        $this->authorizeSettings();

        $validated = $this->validateRequest($request);

        $data = $validated;
        unset($data['logo'], $data['favicon'], $data['remove_logo'], $data['remove_favicon']);

        $siteSetting->update($data);

        $this->syncMedia($request, $siteSetting, 'logo');
        $this->syncMedia($request, $siteSetting, 'favicon');

        return response()->json(['success' => true, 'message' => 'Site settings updated successfully.']);
    }

    /**
     * Soft delete.
     */
    public function destroy(Request $request, SiteSetting $siteSetting)
    {
        $this->authorizeSettings();

        $siteSetting->delete();
        return response()->json(['success' => true, 'message' => 'Site setting moved to trash.']);
    }

    /**
     * Bulk actions.
     */
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
                SiteSetting::whereIn('id', $ids)->delete();
                $msg = 'Selected settings moved to trash.';
                break;

            case 'restore':
                SiteSetting::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected settings restored.';
                break;

            case 'force_delete':
                $items = SiteSetting::onlyTrashed()->whereIn('id', $ids)->get();
                foreach ($items as $item) {
                    $item->clearMediaCollection('logo');
                    $item->clearMediaCollection('favicon');
                    $item->forceDelete();
                }
                $msg = 'Selected settings permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    /**
     * Trash view.
     */
    public function trash(Request $request)
    {
        $this->authorizeSettings();

        $query = SiteSetting::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('site_name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        $siteSettings = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.table', ['siteSettings' => $siteSettings, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Site Settings';
        $breadcrumb = [['text' => 'Trashed Site Settings', 'url' => route('admin.site-settings.trashed')]];

        return view('admin.site-settings.trash', compact('siteSettings', 'title', 'breadcrumb'));
    }

    /**
     * Restore single.
     */
    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings();

        SiteSetting::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Site setting restored successfully.']);
    }

    /**
     * Force delete single.
     */
    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings();

        $model = SiteSetting::onlyTrashed()->findOrFail($id);
        $model->clearMediaCollection('logo');
        $model->clearMediaCollection('favicon');
        $model->forceDelete();

        return response()->json(['success' => true, 'message' => 'Site setting permanently deleted.']);
    }

    /**
     * Inline validation helper.
     */
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'site_name'      => ['required', 'string', 'max:190'],
            'logo_alt'       => ['nullable', 'string', 'max:255'],
            'contact_phone'  => ['nullable', 'string', 'regex:/^(01[3-9]\d{8})$/'],
            'contact_email'  => ['nullable', 'email', 'max:190'],
            'whatsapp_url'   => ['nullable', 'url:http,https', 'max:2048'],
            'address'        => ['nullable', 'string'],
            'business_hours' => ['nullable', 'string', 'max:255'],
            'map_embed_url'  => ['nullable', 'url:http,https'],
            'logo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'favicon'        => ['nullable', 'file', 'mimes:png,ico,jpg,jpeg,webp', 'max:1024'],
            'remove_logo'    => ['nullable', 'boolean'],
            'remove_favicon' => ['nullable', 'boolean'],
        ], [
            'contact_phone.regex' => 'ফোন নম্বরটি অবশ্যই ১১ ডিজিটের সঠিক বাংলাদেশি নম্বর হতে হবে (যেমন: 017XXXXXXXX)। +88 ব্যবহার করা যাবে না।',
        ]);
    }

    private function authorizeSettings(): void
    {
        abort_unless(
            auth('admin')->user()?->can('identity_settings'),
            403
        );
    }

    private function syncMedia(Request $request, SiteSetting $siteSetting, string $collection): void
    {
        if ($request->boolean("remove_{$collection}")) {
            $siteSetting->clearMediaCollection($collection);
        }

        if (!$request->hasFile($collection)) {
            return;
        }

        $file = $request->file($collection);
        $extension = strtolower($file->getClientOriginalExtension());

        $siteSetting->addMedia($file)
            ->usingFileName(Str::uuid() . '.' . $extension)
            ->toMediaCollection($collection, 'public');
    }
}