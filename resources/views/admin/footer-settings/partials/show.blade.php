<div class="text-center mb-4">
    <h4 class="font-weight-bold text-dark mb-1">Footer Configuration</h4>
    <p class="text-muted mb-0"><i class="fas fa-info-circle mr-1 text-primary"></i> Detailed view of footer headings and content</p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>About Heading:</strong><br>
            <span class="text-dark font-weight-bold">{{ $footerSetting->about_heading ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Navigation Heading:</strong><br>
            <span class="text-dark font-weight-bold">{{ $footerSetting->navigation_heading ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Products Heading:</strong><br>
            <span class="text-dark font-weight-bold">{{ $footerSetting->products_heading ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Contact Heading:</strong><br>
            <span class="text-dark font-weight-bold">{{ $footerSetting->contact_heading ?: 'N/A' }}</span>
        </div>
        <div class="col-12 mb-3">
            <strong>Copyright Text:</strong><br>
            <span class="text-dark">{{ $footerSetting->copyright_text ?: 'N/A' }}</span>
        </div>
        <div class="col-12 mb-2">
            <strong>About Text:</strong><br>
            <p class="text-muted mb-0">{{ $footerSetting->about_text ?: 'N/A' }}</p>
        </div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $footerSetting->created_at ? $footerSetting->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $footerSetting->updated_at ? $footerSetting->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>