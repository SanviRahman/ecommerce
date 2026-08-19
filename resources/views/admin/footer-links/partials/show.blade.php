<div class="text-center mb-4">
    <h4 class="font-weight-bold text-dark mb-1">{{ $footerLink->label }}</h4>
    <p class="text-muted mb-0"><i class="fas fa-link mr-1 text-primary"></i> Footer Link Details</p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Section Key:</strong><br>
            <span class="badge badge-primary text-uppercase mt-1">{{ $footerLink->section_key }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Sort Order:</strong><br>
            <span class="text-dark font-weight-bold">{{ $footerLink->sort_order }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Route Name:</strong><br>
            <span class="text-dark">{{ $footerLink->route_name ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Custom URL:</strong><br>
            <span class="text-dark text-break">{{ $footerLink->custom_url ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-2">
            <strong>Open in New Tab:</strong>
            <span class="badge badge-{{ $footerLink->open_new_tab ? 'primary' : 'secondary' }} ml-2">
                {{ $footerLink->open_new_tab ? 'Yes' : 'No' }}
            </span>
        </div>
        <div class="col-6 mb-2">
            <strong>Status:</strong>
            <span class="badge badge-{{ $footerLink->status ? 'success' : 'secondary' }} ml-2">
                {{ $footerLink->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $footerLink->created_at ? $footerLink->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $footerLink->updated_at ? $footerLink->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>