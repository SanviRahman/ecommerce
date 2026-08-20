@php
    $currentRoute = request()->route()?->getName();
@endphp

@if($headerSetting->topbar_enabled)
    <div class="front-topbar">
        <div class="front-container">
            <div>
                {{ $headerSetting->topbar_text }}
            </div>

            <div class="front-topbar-contact">
                @if($headerSetting->show_phone && $siteSetting->contact_phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $siteSetting->contact_phone) }}">
                        <i class="fas fa-phone-alt mr-1"></i>
                        {{ $siteSetting->contact_phone }}
                    </a>
                @endif

                @if($headerSetting->show_email && $siteSetting->contact_email)
                    <a href="mailto:{{ $siteSetting->contact_email }}">
                        <i class="far fa-envelope mr-1"></i>
                        {{ $siteSetting->contact_email }}
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif

<header class="front-header">
    <div class="front-container">

        <nav class="navbar navbar-expand-lg navbar-dark front-navbar p-0">

            {{-- Logo --}}
            <a class="navbar-brand front-brand p-0 m-0" href="{{ route('home') }}">
                @if($siteSetting->logo_url)
                    <img
                        class="site-logo-img"
                        src="{{ $siteSetting->logo_url }}"
                        alt="{{ $siteSetting->logo_alt ?: $siteSetting->site_name }}"
                    >
                @else
                    <span class="brand-fallback">
                        {{ $siteSetting->site_name }}
                    </span>
                @endif
            </a>

            {{-- Mobile Toggle --}}
            <button
                class="navbar-toggler front-toggler ml-auto"
                type="button"
                data-toggle="collapse"
                data-target="#frontNavigation"
                aria-controls="frontNavigation"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="frontNavigation">

                <ul class="navbar-nav front-menu ml-auto align-items-lg-center">

                    @foreach($headerMenuItems as $item)

                        @php
                            $itemUrl = '#';

                            if (
                                $item->route_name &&
                                \Illuminate\Support\Facades\Route::has($item->route_name)
                            ) {
                                $itemUrl = route($item->route_name);
                            } elseif ($item->custom_url) {
                                $itemUrl = $item->custom_url;
                            }
                        @endphp

                        <li class="nav-item {{ $currentRoute === $item->route_name ? 'active' : '' }}">

                            <a
                                class="nav-link"
                                href="{{ $itemUrl }}"
                                @if($item->open_new_tab)
                                    target="_blank"
                                    rel="noopener"
                                @endif
                            >
                                {{ $item->label }}
                            </a>

                        </li>

                    @endforeach

                </ul>

                {{-- CTA --}}
                @if(
                    $headerSetting->cta_enabled &&
                    $headerSetting->cta_label &&
                    $headerSetting->cta_url
                )
                    <a
                        class="header-cta"
                        href="{{ $headerSetting->cta_url }}"
                    >
                        <span>{{ $headerSetting->cta_label }}</span>

                        <span class="header-cta-arrow">
                            <span class="header-cta-line"></span>
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span>
                    </a>
                @endif

            </div>

        </nav>

    </div>
</header>
