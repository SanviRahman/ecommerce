<div class="text-center mb-4">
    <h4 class="font-weight-bold text-dark mb-1">Header Configuration</h4>
    <p class="text-muted mb-0"><i class="fas fa-info-circle mr-1 text-primary"></i> Detailed view of topbar and CTA options</p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Topbar Status:</strong><br>
            <span class="badge badge-{{ $headerSetting->topbar_enabled ? 'success' : 'secondary' }} mt-1">
                {{ $headerSetting->topbar_enabled ? 'Enabled' : 'Disabled' }}
            </span>
        </div>
        <div class="col-6 mb-3">
            <strong>Topbar Text:</strong><br>
            <span class="text-dark">{{ $headerSetting->topbar_text ?: 'N/A' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Show Phone:</strong><br>
            <span class="badge badge-{{ $headerSetting->show_phone ? 'info' : 'secondary' }} mt-1">
                {{ $headerSetting->show_phone ? 'Yes' : 'No' }}
            </span>
        </div>
        <div class="col-6 mb-3">
            <strong>Show Email:</strong><br>
            <span class="badge badge-{{ $headerSetting->show_email ? 'info' : 'secondary' }} mt-1">
                {{ $headerSetting->show_email ? 'Yes' : 'No' }}
            </span>
        </div>
        <div class="col-12 mb-2">
            <strong>CTA Status:</strong>
            <span class="badge badge-{{ $headerSetting->cta_enabled ? 'primary' : 'secondary' }} ml-2">
                {{ $headerSetting->cta_enabled ? 'Enabled' : 'Disabled' }}
            </span>
        </div>
        @if($headerSetting->cta_enabled)
            <div class="col-6 mb-2"><strong>CTA Label:</strong> {{ $headerSetting->cta_label }}</div>
            <div class="col-6 mb-2"><strong>CTA URL:</strong> <span class="text-break">{{ $headerSetting->cta_url }}</span></div>
        @endif
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $headerSetting->created_at ? $headerSetting->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $headerSetting->updated_at ? $headerSetting->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>