<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th class="align-middle">Topbar Text</th>
                <th class="text-center align-middle">Topbar</th>
                <th class="text-center align-middle">Phone / Email</th>
                <th class="align-middle">CTA Label & URL</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($headerSettings as $setting)
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $setting->id }}">
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ Str::limit($setting->topbar_text, 40) ?: 'N/A' }}
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $setting->topbar_enabled ? 'success' : 'secondary' }}">
                            {{ $setting->topbar_enabled ? 'Enabled' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $setting->show_phone ? 'info' : 'light' }}" title="Show Phone">Phone</span>
                        <span class="badge badge-{{ $setting->show_email ? 'info' : 'light' }}" title="Show Email">Email</span>
                    </td>
                    <td class="align-middle">
                        @if($setting->cta_enabled)
                            <span class="badge badge-primary">CTA: {{ $setting->cta_label }}</span>
                            <br><small class="text-muted text-break">{{ $setting->cta_url }}</small>
                        @else
                            <span class="badge badge-secondary">CTA Disabled</span>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.header-settings.restore', $setting->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.header-settings.force_delete', $setting->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.header-settings.show', $setting->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.header-settings.edit', $setting->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.header-settings.destroy', $setting->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-heading fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Header Settings Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($headerSettings->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $headerSettings->firstItem() ?? 0 }} to {{ $headerSettings->lastItem() ?? 0 }} of {{ $headerSettings->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $headerSettings->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif