@php
    $isEdit = isset($message);
    $actionUrl = $isEdit ? route('admin.contact-messages.update', $message->id) : route('admin.contact-messages.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Sender Name -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Sender Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $isEdit ? $message->name : old('name') }}" required placeholder="e.g. John Doe">
            <div class="invalid-feedback error-name"></div>
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ $isEdit ? $message->email : old('email') }}" placeholder="e.g. john@example.com">
            <div class="invalid-feedback error-email"></div>
        </div>

        <!-- Phone -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="{{ $isEdit ? $message->phone : old('phone') }}" placeholder="e.g. 01711223344">
            <div class="invalid-feedback error-phone"></div>
        </div>

        <!-- Status -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control" required>
                <option value="new" {{ ($isEdit && $message->status == 'new') || !$isEdit ? 'selected' : '' }}>New</option>
                <option value="read" {{ ($isEdit && $message->status == 'read') ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ ($isEdit && $message->status == 'replied') ? 'selected' : '' }}>Replied</option>
                <option value="archived" {{ ($isEdit && $message->status == 'archived') ? 'selected' : '' }}>Archived</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>

        <!-- Subject -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Subject</label>
            <input type="text" name="subject" class="form-control" value="{{ $isEdit ? $message->subject : old('subject') }}" placeholder="Inquiry subject">
            <div class="invalid-feedback error-subject"></div>
        </div>

        <!-- Message -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Message Content <span class="text-danger">*</span></label>
            <textarea name="message" class="form-control" rows="4" required placeholder="Write message description here...">{{ $isEdit ? $message->message : old('message') }}</textarea>
            <div class="invalid-feedback error-message"></div>
        </div>
    </div>

    <!-- Actions -->
    <div class="text-right border-top pt-3 mt-2 bg-white rounded-bottom">
        <button type="button" class="btn btn-light border font-weight-bold px-4 mr-2 shadow-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary font-weight-bold px-5 shadow-sm">
            <i class="fas fa-save mr-2"></i> {{ $isEdit ? 'Update Message' : 'Save Message' }}
        </button>
    </div>
</form>