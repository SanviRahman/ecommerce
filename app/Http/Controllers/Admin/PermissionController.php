<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('group_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('guard_name')) {
            $query->byGuard((string) $request->guard_name);
        }

        if ($request->filled('group_name')) {
            $query->byGroup((string) $request->group_name);
        }

        $permissions = $query->latest('id')
            ->paginate(15)
            ->withQueryString();

        $guards = Permission::query()
            ->select('guard_name')
            ->distinct()
            ->orderBy('guard_name')
            ->pluck('guard_name');

        $groups = Permission::query()
            ->select('group_name')
            ->distinct()
            ->whereNotNull('group_name')
            ->orderBy('group_name')
            ->pluck('group_name');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.permissions.partials.table', [
                    'permissions' => $permissions,
                    'isTrash' => false,
                ])->render(),
            ]);
        }

        $title = 'Permissions Management';

        $breadcrumb = [
            ['text' => 'Permissions List', 'url' => route('admin.permissions.index')],
        ];

        return view('admin.permissions.index', compact(
            'permissions',
            'guards',
            'groups',
            'title',
            'breadcrumb'
        ));
    }

    public function list(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . trim((string) $request->search) . '%'
            );
        }

        if ($request->filled('guard_name')) {
            $query->byGuard((string) $request->guard_name);
        }

        return response()->json([
            'success' => true,
            'data' => $query
                ->orderBy('group_name')
                ->orderBy('name')
                ->limit(100)
                ->get([
                    'id',
                    'name',
                    'guard_name',
                    'group_name',
                ]),
        ]);
    }

    public function create(Request $request)
    {
        abort_unless($request->ajax(), 404);

        $groups = Permission::query()
            ->select('group_name')
            ->distinct()
            ->whereNotNull('group_name')
            ->orderBy('group_name')
            ->pluck('group_name');

        return response()->json([
            'html' => view('admin.permissions.partials.form', compact('groups'))->render(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePermission($request);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
            'group_name' => $validated['group_name'] ?: 'General',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully.',
        ]);
    }

    public function show(Request $request, Permission $permission)
    {
        abort_unless($request->ajax(), 404);

        return response()->json([
            'html' => view('admin.permissions.partials.show', compact('permission'))->render(),
        ]);
    }

    public function edit(Request $request, Permission $permission)
    {
        abort_unless($request->ajax(), 404);

        $groups = Permission::query()
            ->select('group_name')
            ->distinct()
            ->whereNotNull('group_name')
            ->orderBy('group_name')
            ->pluck('group_name');

        return response()->json([
            'html' => view('admin.permissions.partials.form', compact(
                'permission',
                'groups'
            ))->render(),
        ]);
    }

    public function update(
        Request $request,
        Permission $permission
    ) {
        $validated = $this->validatePermission(
            $request,
            $permission
        );

        $permission->update([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
            'group_name' => $validated['group_name'] ?: 'General',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully.',
        ]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission moved to trash.',
        ]);
    }

    public function multipleAction(Request $request)
    {
        $validated = $request->validate([
            'action' => [
                'required',
                Rule::in([
                    'delete',
                    'restore',
                    'force_delete',
                ]),
            ],

            'ids' => [
                'required',
                'array',
                'min:1',
            ],

            'ids.*' => [
                'required',
                'integer',
                'distinct',
            ],
        ]);

        $ids = array_values(
            array_unique(
                array_map('intval', $validated['ids'])
            )
        );

        $message = match ($validated['action']) {
            'delete' => $this->bulkDelete($ids),
            'restore' => $this->bulkRestore($ids),
            'force_delete' => $this->bulkForceDelete($ids),
        };

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function trash(Request $request)
    {
        $query = Permission::onlyTrashed()
            ->latest('deleted_at');

        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('group_name', 'like', "%{$search}%");
            });
        }

        $permissions = $query->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.permissions.partials.table', [
                    'permissions' => $permissions,
                    'isTrash' => true,
                ])->render(),
            ]);
        }

        $title = 'Trashed Permissions';

        $breadcrumb = [
            ['text' => 'Permissions', 'url' => route('admin.permissions.index')],
            ['text' => 'Trash', 'url' => null],
        ];

        return view('admin.permissions.trash', compact(
            'permissions',
            'title',
            'breadcrumb'
        ));
    }

    public function restore(int $permission)
    {
        Permission::onlyTrashed()
            ->findOrFail($permission)
            ->restore();

        return response()->json([
            'success' => true,
            'message' => 'Permission restored successfully.',
        ]);
    }

    public function forceDelete(int $permission)
    {
        Permission::onlyTrashed()
            ->findOrFail($permission)
            ->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Permission permanently deleted.',
        ]);
    }

    private function validatePermission(
        Request $request,
        ?Permission $permission = null
    ): array {
        $guardName = (string) $request->input(
            'guard_name',
            'admin'
        );

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique('permissions', 'name')
                    ->where(
                        fn ($query) =>
                            $query->where(
                                'guard_name',
                                $guardName
                            )
                    )
                    ->ignore($permission?->id),
            ],

            'guard_name' => [
                'required',
                'string',
                'max:255',
            ],

            'group_name' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);
    }

    private function bulkDelete(array $ids): string
    {
        Permission::whereIn('id', $ids)->delete();

        return 'Selected permissions moved to trash.';
    }

    private function bulkRestore(array $ids): string
    {
        Permission::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();

        return 'Selected permissions restored.';
    }

    private function bulkForceDelete(array $ids): string
    {
        Permission::onlyTrashed()
            ->whereIn('id', $ids)
            ->forceDelete();

        return 'Selected permissions permanently deleted.';
    }
}