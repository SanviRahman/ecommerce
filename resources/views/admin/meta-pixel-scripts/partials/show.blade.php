<div class="text-center mb-4">
    <div class="p-3 bg-light border rounded shadow-sm d-inline-block">
        <i class="fas fa-code fa-3x text-primary mb-2"></i>
        <h4 class="font-weight-bold text-dark mb-1">{{ $script->name }}</h4>
        <span class="badge badge-info text-uppercase font-weight-bold">{{ str_replace('_', ' ', $script->placement) }}</span>
    </div>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Sort Order:</strong><br>
            <span class="text-dark font-weight-bold">{{ $script->sort_order }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Status:</strong><br>
            <span class="badge badge-{{ $script->status ? 'success' : 'secondary' }} mt-1">
                {{ $script->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="col-12 mb-3">
            <strong>SHA-256 Code Hash:</strong><br>
            <code class="text-dark bg-white p-1 rounded d-block mt-1 font-monospace">{{ $script->code_hash }}</code>
        </div>
        <div class="col-12 mb-2">
            <strong>Raw Script Code:</strong><br>
            <pre class="bg-dark text-light p-3 rounded mt-1 mb-0" style="max-height: 200px; overflow-y: auto;"><code>{{ $script->script_code }}</code></pre>
        </div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0 small">
    <div class="col-6 border-right">
        <span class="text-muted d-block">Created By: <strong>{{ $script->creator->name ?? 'System' }}</strong></span>
    </div>
    <div class="col-6">
        <span class="text-muted d-block">Updated By: <strong>{{ $script->updater->name ?? 'N/A' }}</strong></span>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>