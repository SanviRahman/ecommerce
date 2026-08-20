<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th style="width: 60px;" class="align-middle">Image</th>
                <th class="align-middle">Section Key</th>
                <th class="align-middle">Title</th>
                <th class="align-middle">Link URL</th>
                <th class="text-center align-middle">Status</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable-tbody">
            @forelse($photos as $photo)
                <tr data-id="{{ $photo->id }}" class="{{ !($isTrash ?? false) ? 'sortable-row' : '' }}">
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $photo->id }}">
                    </td>
                    <td class="align-middle">
                        <img src="{{ $photo->image_url ?: asset('images/no-image.png') }}" class="border rounded" width="40" height="30" style="object-fit: contain;">
                    </td>
                    <td class="align-middle font-weight-bold text-primary text-uppercase small">
                        {{ str_replace('_', ' ', $photo->section_key) }}
                    </td>
                    <td class="align-middle font-weight-bold text-dark">
                        {{ $photo->title ?: 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        <span class="text-truncate d-inline-block" style="max-width: 200px;">{{ $photo->link_url ?: 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge badge-{{ $photo->status ? 'success' : 'secondary' }}">
                            {{ $photo->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            @canany(['home_section_photo_restore', 'home_section_photo_manage'])
                                <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.home-section-photos.restore', $photo->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            @endcanany
                            @canany(['home_section_photo_force_delete', 'home_section_photo_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.home-section-photos.force_delete', $photo->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                            @endcanany
                        @else
                            @canany(['home_section_photo_view', 'home_section_photo_manage'])
                                <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.home-section-photos.show', $photo->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            @endcanany
                            @canany(['home_section_photo_update', 'home_section_photo_manage'])
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.home-section-photos.edit', $photo->id) }}" title="Edit"><i class="fas fa-pen"></i></button>
                            @endcanany
                            @canany(['home_section_photo_delete', 'home_section_photo_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.home-section-photos.destroy', $photo->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                            @endcanany
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-images fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Photos Found</h5>
                            <p class="mb-0 small">No data available in this section.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($photos->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $photos->firstItem() ?? 0 }} to {{ $photos->lastItem() ?? 0 }} of {{ $photos->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $photos->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif