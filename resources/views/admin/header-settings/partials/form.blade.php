@php
    $isEdit = isset($headerSetting);
    $actionUrl = $isEdit ? route('admin.header-settings.update', $headerSetting->id) : route('admin.header-settings.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Topbar Enabled -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Topbar Enabled <span class="text-danger">*</span></label>
            <select name="topbar_enabled" class="form-control" required>
                <option value="1" {{ ($isEdit && $headerSetting->topbar_enabled) || !$isEdit ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ ($isEdit && !$headerSetting->topbar_enabled) ? 'selected' : '' }}>No</option>
            </select>
            <div class="invalid-feedback error-topbar_enabled"></div>
        </div>

        <!-- Topbar Text -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Topbar Text</label>
            <input type="text" name="topbar_text" class="form-control" value="{{ $isEdit ? $headerSetting->topbar_text : old('topbar_text') }}" placeholder="e.g. Free shipping on orders over $50">
            <div class="invalid-feedback error-topbar_text"></div>
        </div>

        <!-- Show Phone -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Show Phone <span class="text-danger">*</span></label>
            <select name="show_phone" class="form-control" required>
                <option value="1" {{ ($isEdit && $headerSetting->show_phone) || !$isEdit ? 'selected' : '' }}>Show</option>
                <option value="0" {{ ($isEdit && !$headerSetting->show_phone) ? 'selected' : '' }}>Hide</option>
            </select>
            <div class="invalid-feedback error-show_phone"></div>
        </div>

        <!-- Show Email -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Show Email <span class="text-danger">*</span></label>
            <select name="show_email" class="form-control" required>
                <option value="1" {{ ($isEdit && $headerSetting->show_email) || !$isEdit ? 'selected' : '' }}>Show</option>
                <option value="0" {{ ($isEdit && !$headerSetting->show_email) ? 'selected' : '' }}>Hide</option>
            </select>
            <div class="invalid-feedback error-show_email"></div>
        </div>

        <!-- CTA Enabled -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">CTA Button Enabled <span class="text-danger">*</span></label>
            <select name="cta_enabled" id="cta_enabled" class="form-control" required>
                <option value="0" {{ ($isEdit && !$headerSetting->cta_enabled) || !$isEdit ? 'selected' : '' }}>Disabled</option>
                <option value="1" {{ ($isEdit && $headerSetting->cta_enabled) ? 'selected' : '' }}>Enabled</option>
            </select>
            <div class="invalid-feedback error-cta_enabled"></div>
        </div>

        <!-- CTA Label -->
        <div class="col-md-6 mb-3 cta-fields">
            <label class="font-weight-bold">CTA Label</label>
            <input type="text" name="cta_label" class="form-control" value="{{ $isEdit ? $headerSetting->cta_label : old('cta_label') }}" placeholder="e.g. Shop Now">
            <div class="invalid-feedback error-cta_label"></div>
        </div>

        <!-- CTA URL -->
        <div class="col-md-6 mb-3 cta-fields">
            <label class="font-weight-bold">CTA URL</label>
            <input type="url" name="cta_url" class="form-control" value="{{ $isEdit ? $headerSetting->cta_url : old('cta_url') }}" placeholder="https://example.com/shop">
            <div class="invalid-feedback error-cta_url"></div>
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
    function toggleCtaFields() {
        if ($('#cta_enabled').val() == '1') {
            $('.cta-fields').show();
        } else {
            $('.cta-fields').hide();
        }
    }
    toggleCtaFields();
    $('#cta_enabled').on('change', function() {
        toggleCtaFields();
    });
</script>