@php
    $isEdit = isset($footerLink);
    $actionUrl = $isEdit ? route('admin.footer-links.update', $footerLink->id) : route('admin.footer-links.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Section Key -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Section Key <span class="text-danger">*</span></label>
            <select name="section_key" class="form-control" required>
                <option value="navigation" {{ ($isEdit && $footerLink->section_key == 'navigation') || !$isEdit ? 'selected' : '' }}>Navigation</option>
                <option value="products" {{ ($isEdit && $footerLink->section_key == 'products') ? 'selected' : '' }}>Products</option>
                <option value="social" {{ ($isEdit && $footerLink->section_key == 'social') ? 'selected' : '' }}>Social</option>
            </select>
            <div class="invalid-feedback error-section_key"></div>
        </div>

        <!-- Label -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Label <span class="text-danger">*</span></label>
            <input type="text" name="label" class="form-control" value="{{ $isEdit ? $footerLink->label : old('label') }}" required placeholder="e.g. Privacy Policy">
            <div class="invalid-feedback error-label"></div>
        </div>

        <!-- Sort Order -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Sort Order <span class="text-danger">*</span></label>
            <input type="number" name="sort_order" class="form-control" value="{{ $isEdit ? $footerLink->sort_order : old('sort_order', 0) }}" min="0" required>
            <div class="invalid-feedback error-sort_order"></div>
        </div>

        <!-- Status -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="1" {{ ($isEdit && $footerLink->status) || !$isEdit ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isEdit && !$footerLink->status) ? 'selected' : '' }}>Inactive</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>

        <!-- Route Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Route Name</label>
            <input type="text" name="route_name" class="form-control" value="{{ $isEdit ? $footerLink->route_name : old('route_name') }}" placeholder="e.g. privacy.index">
            <div class="invalid-feedback error-route_name"></div>
        </div>

        <!-- Custom URL -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Custom URL</label>
            <input type="url" name="custom_url" class="form-control" value="{{ $isEdit ? $footerLink->custom_url : old('custom_url') }}" placeholder="https://example.com/privacy">
            <div class="invalid-feedback error-custom_url"></div>
        </div>

        <div class="col-12"><small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Note: You must provide either a <strong>Route Name</strong> or a <strong>Custom URL</strong>.</small></div>

        <!-- Open New Tab -->
        <div class="col-md-6 mb-3 mt-3">
            <label class="font-weight-bold">Open in New Tab <span class="text-danger">*</span></label>
            <select name="open_new_tab" class="form-control" required>
                <option value="0" {{ ($isEdit && !$footerLink->open_new_tab) || !$isEdit ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($isEdit && $footerLink->open_new_tab) ? 'selected' : '' }}>Yes</option>
            </select>
            <div class="invalid-feedback error-open_new_tab"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Link' : 'Save Link' }}
        </button>
    </div>
</form>