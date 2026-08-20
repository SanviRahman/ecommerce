<div class="table-responsive">
    <table class="table table-hover border-bottom mb-0 text-nowrap">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center align-middle">
                    <input type="checkbox" id="checkAll">
                </th>
                <th class="align-middle">Sender Name</th>
                <th class="align-middle">Email</th>
                <th class="align-middle">Subject</th>
                <th class="text-center align-middle">Status</th>
                <th class="align-middle">Received Date</th>
                <th style="width: 150px;" class="text-center align-middle">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
                <tr>
                    <td class="text-center align-middle">
                        <input type="checkbox" class="row-checkbox" value="{{ $msg->id }}">
                    </td>
                    <td class="align-middle font-weight-bold {{ $msg->status === 'new' ? 'text-primary' : 'text-dark' }}">
                        {{ $msg->name }} {!! $msg->status === 'new' ? '<span class="badge badge-danger ml-1">New</span>' : '' !!}
                    </td>
                    <td class="align-middle text-muted">
                        {{ $msg->email ?: 'N/A' }}
                    </td>
                    <td class="align-middle text-muted">
                        {{ Str::limit($msg->subject ?: 'No Subject', 35) }}
                    </td>
                    <td class="text-center align-middle">
                        @php
                            $badgeColor = match($msg->status) {
                                'new' => 'danger',
                                'read' => 'info',
                                'replied' => 'success',
                                'archived' => 'secondary',
                                default => 'light'
                            };
                        @endphp
                        <span class="badge badge-{{ $badgeColor }} text-uppercase">{{ $msg->status }}</span>
                    </td>
                    <td class="align-middle text-muted small">
                        {{ $msg->created_at ? $msg->created_at->format('d M, Y h:i A') : 'N/A' }}
                    </td>
                    <td class="text-center align-middle">
                        @if($isTrash ?? false)
                            @canany(['contact_message_restore', 'contact_message_manage'])
                                <button type="button" class="btn btn-sm btn-outline-success btn-restore shadow-sm mx-1" data-url="{{ route('admin.contact-messages.restore', $msg->id) }}" title="Restore"><i class="fas fa-undo"></i></button>
                            @endcanany
                            @canany(['contact_message_force_delete', 'contact_message_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-force-delete shadow-sm mx-1" data-url="{{ route('admin.contact-messages.force_delete', $msg->id) }}" title="Permanent Delete"><i class="fas fa-trash-alt"></i></button>
                            @endcanany
                        @else
                            @canany(['contact_message_view', 'contact_message_manage'])
                                <button type="button" class="btn btn-sm btn-outline-info btn-show shadow-sm mx-1" data-url="{{ route('admin.contact-messages.show', $msg->id) }}" title="View"><i class="fas fa-eye"></i></button>
                            @endcanany
                            @canany(['contact_message_update', 'contact_message_manage'])
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit shadow-sm mx-1" data-url="{{ route('admin.contact-messages.edit', $msg->id) }}" title="Update Status"><i class="fas fa-pen"></i></button>
                            @endcanany
                            @canany(['contact_message_delete', 'contact_message_manage'])
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete shadow-sm mx-1" data-url="{{ route('admin.contact-messages.destroy', $msg->id) }}" title="Trash"><i class="fas fa-trash"></i></button>
                            @endcanany
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 text-light"></i>
                            <h5 class="font-weight-bold">No Messages Found</h5>
                            <p class="mb-0 small">No contact inquiries available.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($messages->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3 py-3 border-top bg-light">
        <div class="text-muted small font-weight-bold mb-2 mb-md-0">
            Showing {{ $messages->firstItem() ?? 0 }} to {{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }} entries
        </div>
        <div class="m-0 pagination-sm">
            {!! $messages->appends(request()->query())->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endif