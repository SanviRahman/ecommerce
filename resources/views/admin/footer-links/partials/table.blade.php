<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th style="width: 60px;" class="text-center align-middle">Order</th>
                <th class="align-middle">Section Key</th>
                <th class="align-middle">Label</th>
                <th class="align-middle">Route / URL</th>
                <th class="text-center align-middle">New Tab</th>
                <th class="text-center align-middle">Status</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($footerLinks as $link)
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $link->id }}">
                    </td>
                    <td class="text-center align-middle font-weight-bold text-secondary">
                        {{ $link->sort_order }}
                    </td>
                    <td class="align-middle font-weight-bold text-primary text-uppercase small">
                        {{ $link->section_key }}
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $link->label }}
                    </td>
                    <td class="align-middle text-muted">
                        @if($link->route_name)
                            <span class="badge badge-info">{{ $link->route_name }}</span>
                        @else
                            <span class="badge badge-secondary text-break" style="max-width: 250px;">{{ $link->custom_url }}</span>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $link->open_new_tab ? 'primary' : 'light' }}">
                            {{ $link->open_new_tab ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $link->status ? 'success' : 'secondary' }}">
                            {{ $link->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.footer-links.restore', $link->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.footer-links.force_delete', $link->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.footer-links.show', $link->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.footer-links.edit', $link->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.footer-links.destroy', $link->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-link fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Footer Links Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($footerLinks->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $footerLinks->firstItem() ?? 0 }} to {{ $footerLinks->lastItem() ?? 0 }} of {{ $footerLinks->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $footerLinks->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif