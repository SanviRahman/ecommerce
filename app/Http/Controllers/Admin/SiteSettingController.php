<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    private const MEDIA_COLLECTIONS = ['logo', 'favicon'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->authorizeSettings('list');

        $siteSettings = SiteSetting::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(fn($sub) => $sub->where('site_name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%")
                    ->orWhere('contact_phone', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.table', compact('siteSettings'))->render(),
            ]);
        }

        return view('admin.site-settings.index', [
            'siteSettings' => $siteSettings,
            'title'        => 'Site Settings Management',
            'breadcrumb'   => [['text' => 'Site Settings', 'url' => route('admin.site-settings.index')]],
        ]);
    }

    /**
     * JSON list for AJAX requests.
     */
    public function list(Request $request): JsonResponse
    {
        $this->authorizeSettings('list');

        $settings = SiteSetting::query()
            ->when($request->filled('search'), fn($q) => $q->where('site_name', 'like', "%{$request->search}%")
                ->orWhere('contact_email', 'like', "%{$request->search}%"))
            ->select('id', 'site_name', 'contact_email', 'contact_phone')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $settings,
        ]);
    }

    /**
     * Show form for create (AJAX).
     */
    public function create(Request $request): JsonResponse
    {
        $this->authorizeSettings('create');

        return $this->renderAjaxModal('admin.site-settings.partials.form');
    }

    /**
     * Store new resource.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorizeSettings('create');

        $validated = $this->validateRequest($request);
        $siteSetting = SiteSetting::create(Arr::except($validated, ['logo', 'favicon', 'remove_logo', 'remove_favicon']));

        $this->syncAllMedia($request, $siteSetting);

        return response()->json([
            'success' => true,
            'message' => 'Site setting record created successfully.',
        ]);
    }

    /**
     * Show details (AJAX).
     */
    public function show(Request $request, SiteSetting $siteSetting): JsonResponse
    {
        $this->authorizeSettings('view');

        return $this->renderAjaxModal('admin.site-settings.partials.show', compact('siteSetting'));
    }

    /**
     * Edit form (AJAX).
     */
    public function edit(Request $request, SiteSetting $siteSetting): JsonResponse
    {
        $this->authorizeSettings('update');

        return $this->renderAjaxModal('admin.site-settings.partials.form', compact('siteSetting'));
    }

    /**
     * Update resource.
     */
    public function update(Request $request, SiteSetting $siteSetting): JsonResponse
    {
        $this->authorizeSettings('update');

        $validated = $this->validateRequest($request);
        $siteSetting->update(Arr::except($validated, ['logo', 'favicon', 'remove_logo', 'remove_favicon']));

        $this->syncAllMedia($request, $siteSetting);

        return response()->json([
            'success' => true,
            'message' => 'Site settings updated successfully.',
        ]);
    }

    /**
     * Soft delete.
     */
    public function destroy(Request $request, SiteSetting $siteSetting): JsonResponse
    {
        $this->authorizeSettings('delete');

        $siteSetting->delete();

        return response()->json([
            'success' => true,
            'message' => 'Site setting moved to trash.',
        ]);
    }

    /**
     * Bulk actions.
     */
    public function multipleAction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:delete,restore,force_delete'],
            'ids'    => ['required', 'array'],
            'ids.*'  => ['integer'],
        ]);

        $action = $validated['action'];
        $ids    = $validated['ids'];

        $this->authorizeSettings(match ($action) {
            'restore'      => 'restore',
            'force_delete' => 'force_delete',
            default        => 'delete',
        });

        $msg = match ($action) {
            'delete' => tap('Selected settings moved to trash.', fn() => SiteSetting::whereIn('id', $ids)->delete()),
            'restore' => tap('Selected settings restored.', fn() => SiteSetting::onlyTrashed()->whereIn('id', $ids)->restore()),
            'force_delete' => tap('Selected settings permanently deleted.', function () use ($ids) {
                SiteSetting::onlyTrashed()->whereIn('id', $ids)->get()->each(function (SiteSetting $item) {
                    $this->clearAllMedia($item);
                    $item->forceDelete();
                });
            }),
        };

        return response()->json(['success' => true, 'message' => $msg]);
    }

    /**
     * Trash view.
     */
    public function trash(Request $request): View|JsonResponse
    {
        $this->authorizeSettings('trash');

        $siteSettings = SiteSetting::onlyTrashed()
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(fn($sub) => $sub->where('site_name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%"));
            })
            ->latest('deleted_at')
            ->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.site-settings.partials.table', [
                    'siteSettings' => $siteSettings,
                    'isTrash'      => true,
                ])->render(),
            ]);
        }

        return view('admin.site-settings.trash', [
            'siteSettings' => $siteSettings,
            'title'        => 'Trashed Site Settings',
            'breadcrumb'   => [['text' => 'Trashed Site Settings', 'url' => route('admin.site-settings.trashed')]],
        ]);
    }

    /**
     * Restore single.
     */
    public function restore(Request $request, int $id): JsonResponse
    {
        $this->authorizeSettings('restore');

        SiteSetting::onlyTrashed()->findOrFail($id)->restore();

        return response()->json([
            'success' => true,
            'message' => 'Site setting restored successfully.',
        ]);
    }

    /**
     * Force delete single.
     */
    public function forceDelete(Request $request, int $id): JsonResponse
    {
        $this->authorizeSettings('force_delete');

        $model = SiteSetting::onlyTrashed()->findOrFail($id);
        $this->clearAllMedia($model);
        $model->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Site setting permanently deleted.',
        ]);
    }

    /**
     * Validate and normalize site-setting input.
     */
    private function validateRequest(Request $request): array
    {
        $this->normalizeMapEmbedUrl($request);

        return $request->validate([
            'site_name'      => ['required', 'string', 'max:190'],
            'logo_alt'       => ['nullable', 'string', 'max:255'],
            'contact_phone'  => ['nullable', 'string', 'regex:/^(01[3-9]\d{8})$/'],
            'contact_email'  => ['nullable', 'email', 'max:190'],
            'whatsapp_url'   => ['nullable', 'url:http,https', 'max:2048'],
            'address'        => ['nullable', 'string'],
            'business_hours' => ['nullable', 'string', 'max:255'],
            'map_embed_url'  => ['nullable', 'url:http,https', 'max:2048'],
            'logo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'favicon'        => ['nullable', 'file', 'mimes:png,ico,jpg,jpeg,webp', 'max:1024'],
            'remove_logo'    => ['nullable', 'boolean'],
            'remove_favicon' => ['nullable', 'boolean'],
        ], [
            'contact_phone.regex' => 'ফোন নম্বরটি অবশ্যই ১১ ডিজিটের সঠিক বাংলাদেশি নম্বর হতে হবে (যেমন: 017XXXXXXXX)। +88 ব্যবহার করা যাবে না।',
            'map_embed_url.url'   => 'Please enter a valid map URL or paste the complete Google Maps iframe embed code.',
        ]);
    }

    /**
     * Convert a pasted Google Maps iframe into its src URL.
     */
    private function normalizeMapEmbedUrl(Request $request): void
    {
        $value = trim((string) $request->input('map_embed_url', ''));

        if ($value === '') {
            $request->merge(['map_embed_url' => null]);
            return;
        }

        if (stripos($value, '<iframe') !== false && preg_match('/\bsrc\s*=\s*(["\'])(.*?)\1/is', $value, $matches)) {
            $value = html_entity_decode(trim($matches[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        $request->merge(['map_embed_url' => $value]);
    }

    private function authorizeSettings(string $action = 'manage'): void
    {
        $user = auth('admin')->user();

        abort_unless(
            $user?->can("site_setting_{$action}")
            || $user?->can('site_setting_manage')
            || $user?->can('identity_settings')
            || $user?->can('settings'),
            403
        );
    }

    private function renderAjaxModal(string $view, array $data = []): JsonResponse
    {
        abort_unless(request()->ajax(), 404);

        return response()->json([
            'html' => view($view, $data)->render(),
        ]);
    }

    private function syncAllMedia(Request $request, SiteSetting $siteSetting): void
    {
        foreach (self::MEDIA_COLLECTIONS as $collection) {
            $this->syncMedia($request, $siteSetting, $collection);
        }
    }

    private function clearAllMedia(SiteSetting $siteSetting): void
    {
        foreach (self::MEDIA_COLLECTIONS as $collection) {
            $siteSetting->clearMediaCollection($collection);
        }
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