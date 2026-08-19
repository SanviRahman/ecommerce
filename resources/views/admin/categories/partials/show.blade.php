<div class="text-center mb-4">
    <div class="d-inline-flex align-items-center justify-content-center p-2 mb-3 bg-light border rounded shadow-sm" style="min-width: 100px; min-height: 60px;">
        <img src="{{ $category->image_url ?: asset('images/no-image.png') }}" alt="{{ $category->name }}" style="max-height: 60px; max-width: 150px; object-fit: contain;">
    </div>
    <h4 class="font-weight-bold text-dark mb-1">{{ $category->name }}</h4>
    <p class="text-muted mb-0"><i class="fas fa-link mr-1 text-primary"></i> Slug: {{ $category->slug }}</p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Sort Order:</strong><br>
            <span class="text-dark font-weight-bold">{{ $category->sort_order }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Status:</strong><br>
            <span class="badge badge-{{ $category->status ? 'success' : 'secondary' }} mt-1">
                {{ $category->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="col-12 mb-2">
            <strong>Description:</strong><br>
            <p class="text-muted mb-0">{{ $category->description ?: 'N/A' }}</p>
        </div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $category->created_at ? $category->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $category->updated_at ? $category->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>