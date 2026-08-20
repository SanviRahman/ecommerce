@php
    $navigationLinks = ($footerLinks ?? collect())->get('navigation', collect());
    $productLinks = ($footerLinks ?? collect())->get('products', collect());
    $socialLinks = ($footerLinks ?? collect())->get('social', collect());

    $resolveFooterUrl = static function ($link): string {
        if ($link->route_name && \Illuminate\Support\Facades\Route::has($link->route_name)) {
            return route($link->route_name);
        }

        return $link->custom_url ?: '#';
    };

    $socialIcons = [
        'facebook' => 'fab fa-facebook-f',
        'instagram' => 'fab fa-instagram',
        'youtube' => 'fab fa-youtube',
        'linkedin' => 'fab fa-linkedin-in',
        'twitter' => 'fab fa-twitter',
        'x' => 'fab fa-twitter',
    ];
@endphp

<footer class="front-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-title">{{ $footerSetting->about_heading }}</h5>
                <p class="footer-text mb-0">{{ $footerSetting->about_text }}</p>

                @if($socialLinks->isNotEmpty())
                    <div class="footer-socials">
                        @foreach($socialLinks as $link)
                            @php
                                $key = strtolower(trim($link->label));
                                $icon = $socialIcons[$key] ?? 'fas fa-link';
                            @endphp
                            <a
                                class="footer-social-link"
                                href="{{ $resolveFooterUrl($link) }}"
                                aria-label="{{ $link->label }}"
                                @if($link->open_new_tab) target="_blank" rel="noopener" @endif
                            >
                                <i class="{{ $icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-title">{{ $footerSetting->navigation_heading }}</h5>
                <ul class="footer-list">
                    @foreach($navigationLinks as $link)
                        <li>
                            <a href="{{ $resolveFooterUrl($link) }}" @if($link->open_new_tab) target="_blank" rel="noopener" @endif>
                                {{ $link->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-title">{{ $footerSetting->products_heading }}</h5>

                <ul class="footer-list">
                    @if(($footerProducts ?? collect())->isNotEmpty())
                        @foreach($footerProducts as $product)
                            @php
                                $productUrl = '#';

                                if (\Illuminate\Support\Facades\Route::has('products.show')) {
                                    $productUrl = route('products.show', ['product' => $product->slug]);
                                } elseif (\Illuminate\Support\Facades\Route::has('products.index')) {
                                    $productUrl = route('products.index');
                                }
                            @endphp

                            <li>
                                <a href="{{ $productUrl }}">
                                    {{ $product->name }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($productLinks as $link)
                            <li>
                                <a
                                    href="{{ $resolveFooterUrl($link) }}"
                                    @if($link->open_new_tab) target="_blank" rel="noopener" @endif
                                >
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">{{ $footerSetting->contact_heading }}</h5>

                @if($siteSetting->address)
                    <div class="footer-contact">{{ $siteSetting->address }}</div>
                @endif

                @if($siteSetting->contact_phone)
                    <div class="footer-contact">
                        <a href="tel:{{ preg_replace('/\s+/', '', $siteSetting->contact_phone) }}">{{ $siteSetting->contact_phone }}</a>
                    </div>
                @endif

                @if($siteSetting->contact_email)
                    <div class="footer-contact">
                        <a href="mailto:{{ $siteSetting->contact_email }}">{{ $siteSetting->contact_email }}</a>
                    </div>
                @endif

                @if($siteSetting->business_hours)
                    <div class="footer-contact">{{ $siteSetting->business_hours }}</div>
                @endif
            </div>
        </div>

        <div class="footer-bottom">
            {{ $footerSetting->copyright_text ?: 'Copyright '.date('Y').' '.$siteSetting->site_name.'. All Rights Reserved.' }}
        </div>
    </div>
</footer>
