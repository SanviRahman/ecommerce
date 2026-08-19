<div class="text-center mb-4">
    <div class="d-inline-flex align-items-center justify-content-center p-2 mb-3 bg-light border rounded shadow-sm" style="min-width: 120px; min-height: 60px;">
        <img src="{{ $siteSetting->logo_url ?: asset('images/no-image.png') }}" alt="{{ $siteSetting->logo_alt ?: $siteSetting->site_name }}" style="max-height: 50px; max-width: 150px; object-fit: contain;">
    </div>
    <h4 class="font-weight-bold text-dark mb-1">{{ $siteSetting->site_name }}</h4>
    <p class="text-muted mb-0"><i class="fas fa-phone mr-1 text-primary"></i> {{ $siteSetting->contact_phone ?: 'N/A' }} | <i class="fas fa-envelope mr-1 text-primary"></i> {{ $siteSetting->contact_email ?: 'N/A' }}</p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <h6 class="font-weight-bold text-dark mb-2 border-bottom pb-2">
        <i class="fas fa-info-circle mr-2 text-info"></i> Configuration Details
    </h6>
    <div class="row small">
        <div class="col-6 mb-2"><strong>WhatsApp:</strong> {{ $siteSetting->whatsapp_url ?: 'N/A' }}</div>
        <div class="col-6 mb-2"><strong>Business Hours:</strong> {{ $siteSetting->business_hours ?: 'N/A' }}</div>
        <div class="col-12 mb-2"><strong>Address:</strong> {{ $siteSetting->address ?: 'N/A' }}</div>
        <div class="col-12"><strong>Map URL:</strong> <span class="text-break">{{ $siteSetting->map_embed_url ?: 'N/A' }}</span></div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $siteSetting->created_at ? $siteSetting->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $siteSetting->updated_at ? $siteSetting->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>