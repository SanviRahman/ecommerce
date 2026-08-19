<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th style="width: 60px;" class="text-center align-middle">Order</th>
                <th class="align-middle">Label</th>
                <th class="align-middle">Route / URL</th>
                <th class="text-center align-middle">New Tab</th>
                <th class="text-center align-middle">Status</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($headerMenuItems as $item)
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $item->id }}">
                    </td>
                    <td class="text-center align-middle font-weight-bold text-secondary">
                        {{ $item->sort_order }}
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $item->label }}
                    </td>
                    <td class="align-middle text-muted">
                        @if($item->route_name)
                            <span class="badge badge-info">{{ $item->route_name }}</span>
                        @else
                            <span class="badge badge-secondary text-break" style="max-width: 250px;">{{ $item->custom_url }}</span>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $item->open_new_tab ? 'primary' : 'light' }}">
                            {{ $item->open_new_tab ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $item->status ? 'success' : 'secondary' }}">
                            {{ $item->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.header-menu-items.restore', $item->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.header-menu-items.force_delete', $item->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.header-menu-items.show', $item->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.header-menu-items.edit', $item->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.header-menu-items.destroy', $item->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-list fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Menu Items Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($headerMenuItems->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $headerMenuItems->firstItem() ?? 0 }} to {{ $headerMenuItems->lastItem() ?? 0 }} of {{ $headerMenuItems->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $headerMenuItems->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif