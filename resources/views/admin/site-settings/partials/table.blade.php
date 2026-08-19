<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th class="align-middle">Logo</th>
                <th class="align-middle">Site Name</th>
                <th class="align-middle">Contact Phone</th>
                <th class="align-middle">Contact Email</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siteSettings as $setting)
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $setting->id }}">
                    </td>
                    <td class="align-middle">
                        <img src="{{ $setting->logo_url ?: asset('images/no-image.png') }}" class="border rounded" width="50" height="30" style="object-fit: contain;">
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $setting->site_name }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $setting->contact_phone ?: 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $setting->contact_email ?: 'N/A' }}
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            @canany(['site_setting_restore', 'site_setting_manage'])
                                <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.site-settings.restore', $setting->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            @endcanany
                            @canany(['site_setting_force_delete', 'site_setting_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.site-settings.force_delete', $setting->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                            @endcanany
                        @else
                            @canany(['site_setting_view', 'site_setting_manage'])
                                <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.site-settings.show', $setting->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            @endcanany
                            @canany(['site_setting_update', 'site_setting_manage'])
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.site-settings.edit', $setting->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            @endcanany
                            @canany(['site_setting_delete', 'site_setting_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.site-settings.destroy', $setting->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                            @endcanany
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-cogs fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Settings Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($siteSettings->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $siteSettings->firstItem() ?? 0 }} to {{ $siteSettings->lastItem() ?? 0 }} of {{ $siteSettings->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $siteSettings->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif