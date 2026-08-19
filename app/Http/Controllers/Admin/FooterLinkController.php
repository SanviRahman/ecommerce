<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FooterLinkController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings();

        $query = FooterLink::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                    ->orWhere('section_key', 'like', "%{$search}%")
                    ->orWhere('route_name', 'like', "%{$search}%");
            });
        }

        $footerLinks = $query->orderBy('section_key')->orderBy('sort_order')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-links.partials.table', compact('footerLinks'))->render(),
            ]);
        }

        $title = 'Footer Links Management';
        $breadcrumb = [['text' => 'Footer Links', 'url' => route('admin.footer-links.index')]];

        return view('admin.footer-links.index', compact('footerLinks', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings();

        $query = FooterLink::query();

        if ($request->filled('search')) {
            $query->where('label', 'like', "%{$request->search}%");
        }

        $links = $query->select('id', 'label', 'section_key')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $links]);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-links.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        FooterLink::create($validated);

        return response()->json(['success' => true, 'message' => 'Footer link created successfully.']);
    }

    public function show(Request $request, FooterLink $footerLink)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-links.partials.show', compact('footerLink'))->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, FooterLink $footerLink)
    {
        $this->authorizeSettings();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-links.partials.form', compact('footerLink'))->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, FooterLink $footerLink)
    {
        $this->authorizeSettings();
        $validated = $this->validateRequest($request);

        $footerLink->update($validated);

        return response()->json(['success' => true, 'message' => 'Footer link updated successfully.']);
    }

    public function destroy(Request $request, FooterLink $footerLink)
    {
        $this->authorizeSettings();

        $footerLink->delete();
        return response()->json(['success' => true, 'message' => 'Footer link moved to trash.']);
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
                FooterLink::whereIn('id', $ids)->delete();
                $msg = 'Selected footer links moved to trash.';
                break;

            case 'restore':
                FooterLink::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected footer links restored.';
                break;

            case 'force_delete':
                FooterLink::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $msg = 'Selected footer links permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings();

        $query = FooterLink::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('label', 'like', "%{$search}%");
        }

        $footerLinks = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.footer-links.partials.table', ['footerLinks' => $footerLinks, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Footer Links';
        $breadcrumb = [['text' => 'Trashed Footer Links', 'url' => route('admin.footer-links.trashed')]];

        return view('admin.footer-links.trash', compact('footerLinks', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings();

        FooterLink::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Footer link restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings();

        FooterLink::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['success' => true, 'message' => 'Footer link permanently deleted.']);
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'section_key'  => ['required', 'string', 'in:navigation,products,social'],
            'label'        => ['required', 'string', 'max:120'],
            'route_name'   => ['nullable', 'string', 'max:150'],
            'custom_url'   => ['nullable', 'url:http,https', 'max:2048'],
            'sort_order'   => ['required', 'integer', 'min:0'],
            'open_new_tab' => ['required', 'boolean'],
            'status'       => ['required', 'boolean'],
        ]);

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
            auth('admin')->user()?->can('footer_links_manage') || auth('admin')->user()?->can('settings'),
            403
        );
    }
}