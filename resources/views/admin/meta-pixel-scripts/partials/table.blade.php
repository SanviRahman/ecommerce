<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th class="align-middle">Script Name</th>
                <th class="align-middle">Placement</th>
                <th class="align-middle">Code Hash (SHA-256)</th>
                <th class="text-center align-middle">Status</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable-tbody">
            @forelse($scripts as $script)
                <tr data-id="{{ $script->id }}" class="{{ !($isTrash ?? false) ? 'sortable-row' : '' }}">
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $script->id }}">
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $script->name }}
                    </td>
                    <td class="align-middle">
                        <span class="badge badge-info text-uppercase font-weight-bold">{{ str_replace('_', ' ', $script->placement) }}</span>
                    </td>
                    <td class="align-middle text-muted small font-italic">
                        <code>{{ substr($script->code_hash, 0, 16) }}...</code>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $script->status ? 'success' : 'secondary' }}">
                            {{ $script->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            @canany(['meta_pixel_script_restore', 'meta_pixel_script_manage'])
                                <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.meta-pixel-scripts.restore', $script->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            @endcanany
                            @canany(['meta_pixel_script_force_delete', 'meta_pixel_script_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.meta-pixel-scripts.force_delete', $script->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                            @endcanany
                        @else
                            @canany(['meta_pixel_script_view', 'meta_pixel_script_manage'])
                                <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.meta-pixel-scripts.show', $script->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            @endcanany
                            @canany(['meta_pixel_script_update', 'meta_pixel_script_manage'])
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.meta-pixel-scripts.edit', $script->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            @endcanany
                            @canany(['meta_pixel_script_delete', 'meta_pixel_script_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.meta-pixel-scripts.destroy', $script->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                            @endcanany
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-code fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Scripts Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($scripts->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $scripts->firstItem() ?? 0 }} to {{ $scripts->lastItem() ?? 0 }} of {{ $scripts->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $scripts->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif