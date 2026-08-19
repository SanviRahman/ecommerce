@php
    $isEdit = isset($footerSetting);
    $actionUrl = $isEdit ? route('admin.footer-settings.update', $footerSetting->id) : route('admin.footer-settings.store');
@endphp

<form id="ajax-form" action="{{ $actionUrl }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">
        <!-- About Heading -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">About Heading</label>
            <input type="text" name="about_heading" class="form-control" value="{{ $isEdit ? $footerSetting->about_heading : old('about_heading', 'About Us') }}" placeholder="About Us">
            <div class="invalid-feedback error-about_heading"></div>
        </div>

        <!-- Navigation Heading -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Navigation Heading</label>
            <input type="text" name="navigation_heading" class="form-control" value="{{ $isEdit ? $footerSetting->navigation_heading : old('navigation_heading', 'Navigate') }}" placeholder="Navigate">
            <div class="invalid-feedback error-navigation_heading"></div>
        </div>

        <!-- Products Heading -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Products Heading</label>
            <input type="text" name="products_heading" class="form-control" value="{{ $isEdit ? $footerSetting->products_heading : old('products_heading', 'Our Products') }}" placeholder="Our Products">
            <div class="invalid-feedback error-products_heading"></div>
        </div>

        <!-- Contact Heading -->
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Contact Heading</label>
            <input type="text" name="contact_heading" class="form-control" value="{{ $isEdit ? $footerSetting->contact_heading : old('contact_heading', 'Our Showroom') }}" placeholder="Our Showroom">
            <div class="invalid-feedback error-contact_heading"></div>
        </div>

        <!-- Copyright Text -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">Copyright Text</label>
            <input type="text" name="copyright_text" class="form-control" value="{{ $isEdit ? $footerSetting->copyright_text : old('copyright_text') }}" placeholder="e.g. © 2026 ShantoGiftShop. All rights reserved.">
            <div class="invalid-feedback error-copyright_text"></div>
        </div>

        <!-- About Text -->
        <div class="col-md-12 mb-3">
            <label class="font-weight-bold">About Text</label>
            <textarea name="about_text" class="form-control" rows="3" placeholder="Enter about us description for footer">{{ $isEdit ? $footerSetting->about_text : old('about_text') }}</textarea>
            <div class="invalid-feedback error-about_text"></div>
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