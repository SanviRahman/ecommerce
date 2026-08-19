@php
    $isEdit = isset($siteSetting);
    $actionUrl = $isEdit ? route('admin.site-settings.update', $siteSetting->id) : route('admin.site-settings.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Site Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Site Name <span class="text-danger">*</span></label>
            <input type="text" name="site_name" class="form-control" value="{{ $isEdit ? $siteSetting->site_name : old('site_name') }}" required placeholder="Enter site name">
            <div class="invalid-feedback error-site_name"></div>
        </div>

        <!-- Logo Alt -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Logo Alt Text</label>
            <input type="text" name="logo_alt" class="form-control" value="{{ $isEdit ? $siteSetting->logo_alt : old('logo_alt') }}" placeholder="Logo alternative text">
            <div class="invalid-feedback error-logo_alt"></div>
        </div>

        <!-- Contact Phone -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Contact Phone (11 digits, no +88)</label>
            <input type="text" name="contact_phone" class="form-control" value="{{ $isEdit ? $siteSetting->contact_phone : old('contact_phone') }}" placeholder="017XXXXXXXX">
            <div class="invalid-feedback error-contact_phone"></div>
        </div>

        <!-- Contact Email -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Contact Email</label>
            <input type="email" name="contact_email" class="form-control" value="{{ $isEdit ? $siteSetting->contact_email : old('contact_email') }}" placeholder="email@example.com">
            <div class="invalid-feedback error-contact_email"></div>
        </div>

        <!-- WhatsApp URL -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">WhatsApp URL</label>
            <input type="url" name="whatsapp_url" class="form-control" value="{{ $isEdit ? $siteSetting->whatsapp_url : old('whatsapp_url') }}" placeholder="https://whatsapp.com/...">
            <div class="invalid-feedback error-whatsapp_url"></div>
        </div>

        <!-- Business Hours -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Business Hours</label>
            <input type="text" name="business_hours" class="form-control" value="{{ $isEdit ? $siteSetting->business_hours : old('business_hours') }}" placeholder="Sat - Thu: 9 AM - 6 PM">
            <div class="invalid-feedback error-business_hours"></div>
        </div>

        <!-- Address -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="Enter company address">{{ $isEdit ? $siteSetting->address : old('address') }}</textarea>
            <div class="invalid-feedback error-address"></div>
        </div>

        <!-- Map Embed URL -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Map Embed URL</label>
            <textarea name="map_embed_url" class="form-control" rows="2" placeholder="Google map embed URL">{{ $isEdit ? $siteSetting->map_embed_url : old('map_embed_url') }}</textarea>
            <div class="invalid-feedback error-map_embed_url"></div>
        </div>

        <div class="col-md-12"><hr><h6 class="font-weight-bold text-primary mb-3">Media Settings</h6></div>

        <!-- Logo Upload Card -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Site Logo</label>
            <div class="card border shadow-sm p-3 bg-white">
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center mb-3" style="height: 120px;">
                    <img id="logo-preview" src="{{ ($isEdit && $siteSetting->logo_url) ? $siteSetting->logo_url : asset('images/no-image.png') }}" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block font-weight-bold text-uppercase" style="font-size: 10px;">Selected Image</span>
                        <span id="logo-filename" class="text-dark small font-weight-bold">{{ ($isEdit && $siteSetting->logo_url) ? 'Current Logo' : 'No image selected' }}</span>
                    </div>
                    <div>
                        <input type="file" name="logo" id="logo_input" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                        <button type="button" class="btn btn-primary btn-sm font-weight-bold px-3 shadow-sm" onclick="$('#logo_input').click();">
                            <i class="fas fa-folder-open mr-1"></i> Choose
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm shadow-sm ml-1" id="btn-remove-logo" title="Remove Logo">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback error-logo"></div>
        </div>

        <!-- Favicon Upload Card -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Favicon</label>
            <div class="card border shadow-sm p-3 bg-white">
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center mb-3" style="height: 120px;">
                    <img id="favicon-preview" src="{{ ($isEdit && $siteSetting->favicon_url) ? $siteSetting->favicon_url : asset('images/no-image.png') }}" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block font-weight-bold text-uppercase" style="font-size: 10px;">Selected Image</span>
                        <span id="favicon-filename" class="text-dark small font-weight-bold">{{ ($isEdit && $siteSetting->favicon_url) ? 'Current Favicon' : 'No image selected' }}</span>
                    </div>
                    <div>
                        <input type="file" name="favicon" id="favicon_input" class="d-none" accept="image/png,image/ico,image/jpg,image/jpeg,image/webp">
                        <input type="hidden" name="remove_favicon" id="remove_favicon" value="0">
                        <button type="button" class="btn btn-primary btn-sm font-weight-bold px-3 shadow-sm" onclick="$('#favicon_input').click();">
                            <i class="fas fa-folder-open mr-1"></i> Choose
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm shadow-sm ml-1" id="btn-remove-favicon" title="Remove Favicon">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback error-favicon"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Setting' : 'Save Setting' }}
        </button>
    </div>
</form>

<script>
    // Live preview and filename for Logo
    $('#logo_input').on('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onload = function (ev) { $('#logo-preview').attr('src', ev.target.result); };
            reader.readAsDataURL(file);
            $('#logo-filename').text(file.name);
            $('#remove_logo').val(0);
        }
    });

    // Remove Logo action
    $('#btn-remove-logo').on('click', function () {
        $('#logo_input').val('');
        $('#logo-preview').attr('src', "{{ asset('images/no-image.png') }}");
        $('#logo-filename').text('No image selected');
        $('#remove_logo').val(1);
    });

    // Live preview and filename for Favicon
    $('#favicon_input').on('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onload = function (ev) { $('#favicon-preview').attr('src', ev.target.result); };
            reader.readAsDataURL(file);
            $('#favicon-filename').text(file.name);
            $('#remove_favicon').val(0);
        }
    });

    // Remove Favicon action
    $('#btn-remove-favicon').on('click', function () {
        $('#favicon_input').val('');
        $('#favicon-preview').attr('src', "{{ asset('images/no-image.png') }}");
        $('#favicon-filename').text('No image selected');
        $('#remove_favicon').val(1);
    });
</script>