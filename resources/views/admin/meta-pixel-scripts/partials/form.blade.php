@php
    $isEdit = isset($script);
    $actionUrl = $isEdit ? route('admin.meta-pixel-scripts.update', $script->id) : route('admin.meta-pixel-scripts.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Script Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Script Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $isEdit ? $script->name : old('name') }}" required placeholder="e.g. Meta Pixel Main Code">
            <div class="invalid-feedback error-name"></div>
        </div>

        <!-- Placement -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Placement <span class="text-danger">*</span></label>
            <select name="placement" class="form-control" required>
                <option value="head" {{ ($isEdit && $script->placement == 'head') || !$isEdit ? 'selected' : '' }}>Head (&lt;head&gt;)</option>
                <option value="body_start" {{ ($isEdit && $script->placement == 'body_start') ? 'selected' : '' }}>Body Start (&lt;body&gt; opening)</option>
                <option value="body_end" {{ ($isEdit && $script->placement == 'body_end') ? 'selected' : '' }}>Body End (&lt;/body&gt; closing)</option>
            </select>
            <div class="invalid-feedback error-placement"></div>
        </div>

        <!-- Sort Order -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Sort Order <span class="text-danger">*</span></label>
            <input type="number" name="sort_order" class="form-control" value="{{ $isEdit ? $script->sort_order : old('sort_order', 0) }}" min="0" required>
            <div class="invalid-feedback error-sort_order"></div>
        </div>

        <!-- Status -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="1" {{ ($isEdit && $script->status) || !$isEdit ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($isEdit && !$script->status) ? 'selected' : '' }}>Inactive</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>

        <!-- Script Code -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Script Code / Raw HTML <span class="text-danger">*</span></label>
            <textarea name="script_code" class="form-control font-monospace" rows="6" required placeholder="Paste raw HTML/JavaScript script here...">{{ $isEdit ? $script->script_code : old('script_code') }}</textarea>
            <small class="text-muted">This field stores raw executable tracking scripts. Ensure code validity.</small>
            <div class="invalid-feedback error-script_code"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Script' : 'Save Script' }}
        </button>
    </div>
</form>