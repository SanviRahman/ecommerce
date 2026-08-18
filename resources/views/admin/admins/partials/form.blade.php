@php
    $isEdit = isset($admin);
    $actionUrl = $isEdit ? route('admin.admins.update', $admin->id) : route('admin.admins.store');
@endphp

@php
    $currentPhotoUrl = ($isEdit && $admin->photo) ? asset('uploads/' . $admin->photo) : null;
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control " value="{{ $isEdit ? $admin->name : old('name') }}" required placeholder="Enter full name">
            <div class="invalid-feedback error-name"></div>
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control " value="{{ $isEdit ? $admin->email : old('email') }}" required placeholder="email@example.com">
            <div class="invalid-feedback error-email"></div>
        </div>

        <!-- Photo -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Profile Photo</label>
            <div class="d-flex align-items-center" style="gap: 10px;">
                <img id="admin-photo-preview" src="{{ $currentPhotoUrl ?: asset('images/no-image.png') }}" class="rounded-circle border" width="48" height="48" style="object-fit: cover;">
                <div class="flex-grow-1">
                    <input type="file" name="photo" id="admin_photo" class="form-control-file" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <button type="button" class="btn btn-outline-primary btn-sm mt-1 btn-choose-media" data-target="admin_photo">
                        <i class="fas fa-photo-video mr-1"></i> Choose from Media
                    </button>
                </div>
            </div>
            <input type="hidden" name="photo_media_id" id="photo_media_id" value="">
            <div class="invalid-feedback error-photo"></div>
        </div>

        <!-- Roles Selection (Select2) -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Assign Roles</label>
            <select name="roles[]" class="form-control select2 " multiple data-placeholder="Select roles for this admin">
                @if(isset($roles))
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ ($isEdit && $admin->hasRole($role)) ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                @endif
            </select>
            <div class="invalid-feedback error-roles"></div>
            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>Leave empty if you don't want to assign any specific roles right now.</small>
        </div>

        <!-- Status -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control " required>
                <option value="1" {{ ($isEdit && $admin->status == 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isEdit && $admin->status == 0) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="col-md-12">
            <hr>
            <h6 class="font-weight-bold text-primary mb-3">Security</h6>
        </div>

        <!-- Password -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Password @if(!$isEdit) <span class="text-danger">*</span> @endif</label>
            <input type="password" name="password" class="form-control " placeholder="{{ $isEdit ? 'Leave blank to keep current password' : 'Enter strong password' }}" {{ !$isEdit ? 'required' : '' }}>
            <div class="invalid-feedback error-password"></div>
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Confirm Password @if(!$isEdit) <span class="text-danger">*</span> @endif</label>
            <input type="password" name="password_confirmation" class="form-control " placeholder="Confirm password" {{ !$isEdit ? 'required' : '' }}>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Admin' : 'Save Admin' }}
        </button>
    </div>
</form>

<!-- Initialize Select2 for modal -->
<script>
    if ($('.select2').length) {
        $('.select2').select2({
            width: '100%',
            dropdownParent: $('#ajaxModal') // Fixes Select2 focus issue inside Bootstrap Modals
        });
    }

    // Live preview for a freshly chosen photo file
    $('#admin_photo').on('change', function (e) {
        $('#photo_media_id').val('');
        if (e.target.files && e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function (ev) { $('#admin-photo-preview').attr('src', ev.target.result); };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Choose from Media
    $('.btn-choose-media[data-target="admin_photo"]').on('click', function () {
        MediaPicker.open(function (media) {
            $('#admin_photo').val('');
            $('#photo_media_id').val(media.id);
            $('#admin-photo-preview').attr('src', media.url);
        }, { type: 'image' });
    });
</script>
