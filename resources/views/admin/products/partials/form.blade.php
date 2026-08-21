@php
    $isEdit = isset($product);
    $actionUrl = $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Category ID -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Category <span class="text-danger">*</span></label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ ($isEdit && $product->category_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback error-category_id"></div>
        </div>

        <!-- Product Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $isEdit ? $product->name : old('name') }}" required placeholder="e.g. SPC Flooring">
            <div class="invalid-feedback error-name"></div>
        </div>

        <!-- Slug -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Slug (Optional)</label>
            <input type="text" name="slug" class="form-control" value="{{ $isEdit ? $product->slug : old('slug') }}" placeholder="auto-generated if empty">
            <div class="invalid-feedback error-slug"></div>
        </div>

        <!-- SKU -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ $isEdit ? $product->sku : old('sku') }}" placeholder="e.g. SPC-FLR-001">
            <div class="invalid-feedback error-sku"></div>
        </div>

        <!-- Sort Order -->
        <div class="col-md-4 mb-3">
            <label class="font-weight-bold">Sort Order <span class="text-danger">*</span></label>
            <input type="number" name="sort_order" class="form-control" value="{{ $isEdit ? $product->sort_order : old('sort_order', 0) }}" min="0" required>
            <div class="invalid-feedback error-sort_order"></div>
        </div>

        <!-- Is Featured -->
        <div class="col-md-4 mb-3">
            <label class="font-weight-bold">Is Featured <span class="text-danger">*</span></label>
            <select name="is_featured" class="form-control" required>
                <option value="0" {{ ($isEdit && !$product->is_featured) || !$isEdit ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($isEdit && $product->is_featured) ? 'selected' : '' }}>Yes</option>
            </select>
            <div class="invalid-feedback error-is_featured"></div>
        </div>

        <!-- Status -->
        <div class="col-md-4 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="1" {{ ($isEdit && $product->status) || !$isEdit ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isEdit && !$product->status) ? 'selected' : '' }}>Inactive</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>

        <!-- Short Description -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Short Description</label>
            <input type="text" name="short_description" class="form-control" value="{{ $isEdit ? $product->short_description : old('short_description') }}" placeholder="Brief summary (max 500 chars)">
            <div class="invalid-feedback error-short_description"></div>
        </div>

        <!-- Description -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Detailed product description">{{ $isEdit ? $product->description : old('description') }}</textarea>
            <div class="invalid-feedback error-description"></div>
        </div>

        <!-- Specifications (JSON Builder) -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Specifications (JSON Key-Value Pairs)</label>
            <div id="specs-container">
                @php
                    $specs = $isEdit && is_array($product->specifications) ? $product->specifications : [];
                @endphp
                @forelse($specs as $key => $val)
                    <div class="row mb-2 spec-row">
                        <div class="col-5">
                            <input type="text" class="form-control form-control-sm spec-key" placeholder="Key (e.g. Wear Layer)" value="{{ $key }}">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm spec-val" placeholder="Value (e.g. 0.3mm)" value="{{ $val }}">
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-danger btn-sm btn-block remove-spec"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                @empty
                    <div class="row mb-2 spec-row">
                        <div class="col-5">
                            <input type="text" class="form-control form-control-sm spec-key" placeholder="Key (e.g. Wear Layer)">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm spec-val" placeholder="Value (e.g. 0.3mm)">
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-danger btn-sm btn-block remove-spec"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                @endforelse
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm mt-1" id="add-spec-row"><i class="fas fa-plus mr-1"></i> Add Specification</button>
            <!-- Hidden input to hold compiled JSON -->
            <input type="hidden" name="specifications_json" id="specifications_json">
            <div class="invalid-feedback error-specifications"></div>
        </div>

        <div class="col-md-12"><hr><h6 class="font-weight-bold text-primary mb-3">Media Files</h6></div>

        <!-- Featured Image -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Featured Image</label>
            <div class="card border shadow-sm p-3 bg-white">
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center mb-3" style="height: 100px;">
                    <img id="featured-preview" src="{{ ($isEdit && $product->featured_image_url) ? $product->featured_image_url : asset('images/no-image.png') }}" style="max-height: 80px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span id="featured-filename" class="text-dark small font-weight-bold">{{ ($isEdit && $product->featured_image_url) ? 'Current Image' : 'No image selected' }}</span>
                    <div>
                        <input type="file" name="featured_image" id="featured_input" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <button type="button" class="btn btn-primary btn-sm px-3" onclick="$('#featured_input').click();">Choose</button>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback error-featured_image"></div>
        </div>

        <!-- Data Sheet PDF -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Data Sheet (PDF)</label>
            <div class="card border shadow-sm p-3 bg-white">
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center mb-3" style="height: 100px;">
                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span id="pdf-filename" class="text-dark small font-weight-bold">{{ ($isEdit && $product->data_sheet_url) ? 'Current PDF Available' : 'No PDF selected' }}</span>
                    <div>
                        <input type="file" name="data_sheet" id="pdf_input" class="d-none" accept="application/pdf">
                        <button type="button" class="btn btn-primary btn-sm px-3" onclick="$('#pdf_input').click();">Choose PDF</button>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback error-data_sheet"></div>
        </div>

        <!-- Gallery (Multiple Images) -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Gallery Images (Multiple)</label>
            <input type="file" name="gallery[]" class="form-control-file" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
            <div class="invalid-feedback error-gallery"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm" id="btn-submit-form">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Product' : 'Save Product' }}
        </button>
    </div>
</form>

<script>
    $('#featured_input').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onload = function(ev) { $('#featured-preview').attr('src', ev.target.result); };
            reader.readAsDataURL(file);
            $('#featured-filename').text(file.name);
        }
    });

    $('#pdf_input').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            $('#pdf-filename').text(e.target.files[0].name);
        }
    });

    $('#add-spec-row').on('click', function() {
        let row = `<div class="row mb-2 spec-row">
            <div class="col-5"><input type="text" class="form-control form-control-sm spec-key" placeholder="Key"></div>
            <div class="col-6"><input type="text" class="form-control form-control-sm spec-val" placeholder="Value"></div>
            <div class="col-1"><button type="button" class="btn btn-danger btn-sm btn-block remove-spec"><i class="fas fa-times"></i></button></div>
        </div>`;
        $('#specs-container').append(row);
    });

    $(document).on('click', '.remove-spec', function() {
        $(this).closest('.spec-row').remove();
    });

    // Compile specification rows into Laravel's specifications[key] array.
    $('#ajax-form').on('submit', function() {
        const form = $(this);

        form.find('.compiled-specification-input').remove();

        $('.spec-row').each(function() {
            const key = $(this).find('.spec-key').val().trim();
            const value = $(this).find('.spec-val').val().trim();

            if (!key) {
                return;
            }

            $('<input>', {
                type: 'hidden',
                class: 'compiled-specification-input',
                name: `specifications[${key}]`,
                value: value
            }).appendTo(form);
        });
    });
</script>