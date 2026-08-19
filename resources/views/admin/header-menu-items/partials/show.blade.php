<div class="text-center mb-4">
    <h4 class="font-weight-bold text-dark mb-1">{{ $headerMenuItem->label }}</h4>
    <p class="text-muted mb-0"><i class="fas fa-list mr-1 text-primary"></i> Menu Item Details</p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Sort Order:</strong><br>
            <span class="text-dark font-weight-bold">{{ $headerMenuItem->sort_order }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Status:</strong><br>
            <span class="badge badge-{{ $headerMenuItem->status ? 'success' : 'secondary' }} mt-1">
                {{ $headerMenuItem->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="col-6 mb-3">
            <strong>Route Name:</strong><br>
            <span class="text-dark">{{ $headerMenuItem->route_name ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Custom URL:</strong><br>
            <span class="text-dark text-break">{{ $headerMenuItem->custom_url ?: 'N/A' }}</span>
        </div>
        <div class="col-12 mb-2">
            <strong>Open in New Tab:</strong>
            <span class="badge badge-{{ $headerMenuItem->open_new_tab ? 'primary' : 'secondary' }} ml-2">
                {{ $headerMenuItem->open_new_tab ? 'Yes' : 'No' }}
            </span>
        </div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $headerMenuItem->created_at ? $headerMenuItem->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $headerMenuItem->updated_at ? $headerMenuItem->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>