<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSettings('list');

        $query = ContactMessage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $messages = $query->latest()->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.contact-messages.partials.table', compact('messages'))->render(),
            ]);
        }

        $title = 'Contact Messages Management';
        $breadcrumb = [['text' => 'Contact Messages', 'url' => route('admin.contact-messages.index')]];

        return view('admin.contact-messages.index', compact('messages', 'title', 'breadcrumb'));
    }

    public function list(Request $request)
    {
        $this->authorizeSettings('list');

        $query = ContactMessage::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $messages = $query->select('id', 'name', 'email', 'status')->latest()->get();
        return response()->json(['success' => true, 'data' => $messages]);
    }

    public function create(Request $request)
    {
        $this->authorizeSettings('create');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.contact-messages.partials.form')->render()
            ]);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $this->authorizeSettings('create');

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'email'   => ['nullable', 'email', 'max:190'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string'],
            'status'  => ['required', 'string', 'in:new,read,replied,archived'],
        ]);

        ContactMessage::create($validated);

        return response()->json(['success' => true, 'message' => 'Contact message created successfully.']);
    }

    public function show(Request $request, ContactMessage $contactMessage)
    {
        $this->authorizeSettings('view');

        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read']);
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.contact-messages.partials.show', ['message' => $contactMessage])->render()
            ]);
        }
        abort(404);
    }

    public function edit(Request $request, ContactMessage $contactMessage)
    {
        $this->authorizeSettings('update');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.contact-messages.partials.form', ['message' => $contactMessage])->render()
            ]);
        }
        abort(404);
    }

    public function update(Request $request, ContactMessage $contactMessage)
    {
        $this->authorizeSettings('update');

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'email'   => ['nullable', 'email', 'max:190'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string'],
            'status'  => ['required', 'string', 'in:new,read,replied,archived'],
        ]);

        $contactMessage->update($validated);

        return response()->json(['success' => true, 'message' => 'Contact message updated successfully.']);
    }

    public function destroy(Request $request, ContactMessage $contactMessage)
    {
        $this->authorizeSettings('delete');

        $contactMessage->delete();
        return response()->json(['success' => true, 'message' => 'Contact message moved to trash.']);
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
                ContactMessage::whereIn('id', $ids)->delete();
                $msg = 'Selected messages moved to trash.';
                break;

            case 'restore':
                ContactMessage::onlyTrashed()->whereIn('id', $ids)->restore();
                $msg = 'Selected messages restored.';
                break;

            case 'force_delete':
                ContactMessage::onlyTrashed()->whereIn('id', $ids)->forceDelete();
                $msg = 'Selected messages permanently deleted.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function trash(Request $request)
    {
        $this->authorizeSettings('trash');

        $query = ContactMessage::onlyTrashed()->orderBy('deleted_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $messages = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.contact-messages.partials.table', ['messages' => $messages, 'isTrash' => true])->render()
            ]);
        }

        $title = 'Trashed Contact Messages';
        $breadcrumb = [['text' => 'Trashed Contact Messages', 'url' => route('admin.contact-messages.trashed')]];

        return view('admin.contact-messages.trash', compact('messages', 'title', 'breadcrumb'));
    }

    public function restore(Request $request, int $id)
    {
        $this->authorizeSettings('restore');

        ContactMessage::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true, 'message' => 'Contact message restored successfully.']);
    }

    public function forceDelete(Request $request, int $id)
    {
        $this->authorizeSettings('force_delete');

        ContactMessage::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['success' => true, 'message' => 'Contact message permanently deleted.']);
    }

    private function authorizeSettings(string $action = 'manage'): void
    {
        $user = auth('admin')->user();
        $permission = "contact_message_{$action}";

        abort_unless(
            $user?->can($permission) || 
            $user?->can('contact_message_manage') || 
            $user?->can('settings'),
            403
        );
    }
}