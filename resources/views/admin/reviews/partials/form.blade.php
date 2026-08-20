@php
    $isEdit = isset($review);
    $actionUrl = $isEdit ? route('admin.reviews.update', $review->id) : route('admin.reviews.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Reviewer Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Reviewer Name <span class="text-danger">*</span></label>
            <input type="text" name="reviewer_name" class="form-control" value="{{ $isEdit ? $review->reviewer_name : old('reviewer_name') }}" required placeholder="e.g. John Doe">
            <div class="invalid-feedback error-reviewer_name"></div>
        </div>

        <!-- Reviewer Title -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Reviewer Title / Company</label>
            <input type="text" name="reviewer_title" class="form-control" value="{{ $isEdit ? $review->reviewer_title : old('reviewer_title') }}" placeholder="e.g. CEO, TechCorp">
            <div class="invalid-feedback error-reviewer_title"></div>
        </div>

        <!-- Rating -->
        <div class="col-md-4 mb-3">
            <label class="font-weight-bold">Rating <span class="text-danger">*</span></label>
            <select name="rating" class="form-control" required>
                <option value="5.0" {{ ($isEdit && $review->rating == 5.0) || !$isEdit ? 'selected' : '' }}>5.0 - Excellent</option>
                <option value="4.0" {{ ($isEdit && $review->rating == 4.0) ? 'selected' : '' }}>4.0 - Very Good</option>
                <option value="3.0" {{ ($isEdit && $review->rating == 3.0) ? 'selected' : '' }}>3.0 - Average</option>
                <option value="2.0" {{ ($isEdit && $review->rating == 2.0) ? 'selected' : '' }}>2.0 - Poor</option>
                <option value="1.0" {{ ($isEdit && $review->rating == 1.0) ? 'selected' : '' }}>1.0 - Terrible</option>
            </select>
            <div class="invalid-feedback error-rating"></div>
        </div>

        <!-- Sort Order -->
        <div class="col-md-4 mb-3">
            <label class="font-weight-bold">Sort Order <span class="text-danger">*</span></label>
            <input type="number" name="sort_order" class="form-control" value="{{ $isEdit ? $review->sort_order : old('sort_order', 0) }}" min="0" required>
            <div class="invalid-feedback error-sort_order"></div>
        </div>

        <!-- Status -->
        <div class="col-md-4 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="1" {{ ($isEdit && $review->status) || !$isEdit ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isEdit && !$review->status) ? 'selected' : '' }}>Inactive</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>

        <!-- Review Text -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Review Text <span class="text-danger">*</span></label>
            <textarea name="review_text" class="form-control" rows="4" required placeholder="Enter review description">{{ $isEdit ? $review->review_text : old('review_text') }}</textarea>
            <div class="invalid-feedback error-review_text"></div>
        </div>

        <div class="col-md-12"><hr><h6 class="font-weight-bold text-primary mb-3">Reviewer Avatar</h6></div>

        <!-- Avatar Upload Card -->
        <div class="col-md-12 mb-3">
            <div class="card border shadow-sm p-3 bg-white">
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center mb-3" style="height: 120px;">
                    <img id="image-preview" src="{{ ($isEdit && $review->avatar_url) ? $review->avatar_url : asset('images/no-image.png') }}" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block font-weight-bold text-uppercase" style="font-size: 10px;">Selected Avatar</span>
                        <span id="image-filename" class="text-dark small font-weight-bold">{{ ($isEdit && $review->avatar_url) ? 'Current Avatar' : 'No avatar selected' }}</span>
                    </div>
                    <div>
                        <input type="file" name="avatar" id="image_input" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <input type="hidden" name="remove_avatar" id="remove_image" value="0">
                        <button type="button" class="btn btn-primary btn-sm font-weight-bold px-3 shadow-sm" onclick="$('#image_input').click();">
                            <i class="fas fa-folder-open mr-1"></i> Choose
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm shadow-sm ml-1" id="btn-remove-image" title="Remove Avatar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback error-avatar"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Review' : 'Save Review' }}
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
        $('#image-filename').text('No avatar selected');
        $('#remove_image').val(1);
    });
</script>