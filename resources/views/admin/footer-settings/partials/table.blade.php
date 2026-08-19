<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th class="align-middle">About Heading</th>
                <th class="align-middle">Navigation Heading</th>
                <th class="align-middle">Products Heading</th>
                <th class="align-middle">Contact Heading</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($footerSettings as $setting)
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $setting->id }}">
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $setting->about_heading ?: 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $setting->navigation_heading ?: 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $setting->products_heading ?: 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $setting->contact_heading ?: 'N/A' }}
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.footer-settings.restore', $setting->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.footer-settings.force_delete', $setting->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.footer-settings.show', $setting->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.footer-settings.edit', $setting->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.footer-settings.destroy', $setting->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-shoe-prints fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Footer Settings Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($footerSettings->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $footerSettings->firstItem() ?? 0 }} to {{ $footerSettings->lastItem() ?? 0 }} of {{ $footerSettings->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $footerSettings->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif