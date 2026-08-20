<div class="text-center mb-4">
    <div class="d-inline-flex align-items-center justify-content-center p-2 mb-3 bg-light border rounded-circle shadow-sm" style="width: 90px; height: 90px;">
        <img src="{{ $review->avatar_url ?: asset('images/no-image.png') }}" alt="{{ $review->reviewer_name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
    </div>
    <h4 class="font-weight-bold text-dark mb-1">{{ $review->reviewer_name }}</h4>
    <p class="text-muted mb-1">{{ $review->reviewer_title ?: 'N/A' }}</p>
    @if($review->rating)
        <span class="badge badge-warning text-dark px-3 py-1 font-weight-bold"><i class="fas fa-star mr-1"></i> {{ $review->rating }} / 5 Stars</span>
    @endif
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Sort Order:</strong><br>
            <span class="text-dark font-weight-bold">{{ $review->sort_order }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Status:</strong><br>
            <span class="badge badge-{{ $review->status ? 'success' : 'secondary' }} mt-1">
                {{ $review->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="col-12 mb-2">
            <strong>Review Text:</strong><br>
            <p class="text-muted mb-0 font-italic">"{{ $review->review_text }}"</p>
        </div>
    </div>
</div>

<div class="row text-center mt-3 bg-light rounded py-2 shadow-sm mx-0">
    <div class="col-6 border-right">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Created At</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $review->created_at ? $review->created_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
    <div class="col-6">
        <p class="text-muted small text-uppercase font-weight-bold mb-1">Last Updated</p>
        <h6 class="text-dark font-weight-bold mb-0">{{ $review->updated_at ? $review->updated_at->format('d M, Y') : 'N/A' }}</h6>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>