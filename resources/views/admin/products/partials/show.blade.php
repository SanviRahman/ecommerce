<div class="text-center mb-4">
    <img src="{{ $product->featured_image_url ?: asset('images/no-image.png') }}" class="border rounded mb-3 shadow-sm" style="max-height: 120px; object-fit: contain;">
    <h4 class="font-weight-bold text-dark mb-1">{{ $product->name }}</h4>
    <p class="text-muted mb-0"><span class="badge badge-info mr-2">SKU: {{ $product->sku ?: 'N/A' }}</span> <span class="badge badge-secondary">Category: {{ $product->category->name ?? 'N/A' }}</span></p>
</div>

<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-6 mb-3">
            <strong>Slug:</strong><br><span class="text-dark">{{ $product->slug }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Is Featured:</strong><br>
            <span class="badge badge-{{ $product->is_featured ? 'warning' : 'secondary' }} mt-1">{{ $product->is_featured ? 'Yes' : 'No' }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Sort Order:</strong><br><span class="text-dark font-weight-bold">{{ $product->sort_order }}</span>
        </div>
        <div class="col-6 mb-3">
            <strong>Status:</strong><br>
            <span class="badge badge-{{ $product->status ? 'success' : 'secondary' }} mt-1">{{ $product->status ? 'Active' : 'Inactive' }}</span>
        </div>
        <div class="col-12 mb-3">
            <strong>Short Description:</strong><br><span class="text-muted">{{ $product->short_description ?: 'N/A' }}</span>
        </div>
        <div class="col-12 mb-3">
            <strong>Description:</strong><br><p class="text-muted mb-0">{{ $product->description ?: 'N/A' }}</p>
        </div>
        @if(!empty($product->specifications))
            <div class="col-12 mb-2">
                <strong>Specifications:</strong>
                <ul class="list-unstyled mt-1">
                    @foreach($product->specifications as $k => $v)
                        <li><strong>{{ $k }}:</strong> {{ $v }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>