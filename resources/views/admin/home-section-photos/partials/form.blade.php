@php
    $isEdit = isset($photo);
    $actionUrl = $isEdit ? route('admin.home-section-photos.update', $photo->id) : route('admin.home-section-photos.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Section Key -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Section Key <span class="text-danger">*</span></label>
            <select name="section_key" class="form-control" required>
                <option value="our_products" {{ ($isEdit && $photo->section_key == 'our_products') || !$isEdit ? 'selected' : '' }}>Our Products</option>
                <option value="after_what_we_offer" {{ ($isEdit && $photo->section_key == 'after_what_we_offer') ? 'selected' : '' }}>After What We Offer</option>
            </select>
            <div class="invalid-feedback error-section_key"></div>
        </div>

        <!-- Title -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $isEdit ? $photo->title : old('title') }}" placeholder="Enter photo title">
            <div class="invalid-feedback error-title"></div>
        </div>

        <!-- Link URL -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Link URL</label>
            <input type="url" name="link_url" class="form-control" value="{{ $isEdit ? $photo->link_url : old('link_url') }}" placeholder="https://example.com">
            <div class="invalid-feedback error-link_url"></div>
        </div>

        <!-- Sort Order -->
        <div class="col-md-3 mb-3">
            <label class="font-weight-bold">Sort Order <span class="text-danger">*</span></label>
            <input type="number" name="sort_order" class="form-control" value="{{ $isEdit ? $photo->sort_order : old('sort_order', 0) }}" min="0" required>
            <div class="invalid-feedback error-sort_order"></div>
        </div>

        <!-- Status -->
        <div class="col-md-3 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="1" {{ ($isEdit && $photo->status) || !$isEdit ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isEdit && !$photo->status) ? 'selected' : '' }}>Inactive</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>

        <!-- Caption -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Caption</label>
            <textarea name="caption" class="form-control" rows="3" placeholder="Enter caption description">{{ $isEdit ? $photo->caption : old('caption') }}</textarea>
            <div class="invalid-feedback error-caption"></div>
        </div>

        <div class="col-md-12"><hr><h6 class="font-weight-bold text-primary mb-3">Section Image</h6></div>

        <!-- Image Upload Card -->
        <div class="col-md-12 mb-3">
            <div class="card border shadow-sm p-3 bg-white">
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center mb-3" style="height: 120px;">
                    <img id="image-preview" src="{{ ($isEdit && $photo->image_url) ? $photo->image_url : asset('images/no-image.png') }}" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block font-weight-bold text-uppercase" style="font-size: 10px;">Selected Image</span>
                        <span id="image-filename" class="text-dark small font-weight-bold">{{ ($isEdit && $photo->image_url) ? 'Current Image' : 'No image selected' }}</span>
                    </div>
                    <div>
                        <input type="file" name="image" id="image_input" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                        <button type="button" class="btn btn-primary btn-sm font-weight-bold px-3 shadow-sm" onclick="$('#image_input').click();">
                            <i class="fas fa-folder-open mr-1"></i> Choose
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm shadow-sm ml-1" id="btn-remove-image" title="Remove Image">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback error-image"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Photo' : 'Save Photo' }}
        </button>
    </div>
</form>

<script>
    $('#image_input').on('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onload = function (ev) { $('#image-preview').attr('src', ev.target.result); };
            reader.readAsDataURL(file);
            $('#image-filename').text(file.name);
            $('#remove_image').val(0);
        }
    });

    $('#btn-remove-image').on('click', function () {
        $('#image_input').val('');
        $('#image-preview').attr('src', "{{ asset('images/no-image.png') }}");
        $('#image-filename').text('No image selected');
        $('#remove_image').val(1);
    });
</script>