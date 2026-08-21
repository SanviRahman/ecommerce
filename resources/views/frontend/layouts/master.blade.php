<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', $siteSetting->site_name ?? config('app.name'))
    </title>

    <meta
        name="description"
        content="@yield('meta_description', '')"
    >

    @if($siteSetting?->favicon_url)
        <link
            rel="icon"
            href="{{ $siteSetting->favicon_url }}?v={{ optional($siteSetting->updated_at)->timestamp }}"
        >
    @endif

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    {{-- Bootstrap --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    >

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    >

    {{-- Head Tracking --}}
    @include('frontend.partials.tracking-pixels', [
        'placement' => 'head'
    ])

    {{-- Global Frontend CSS --}}
    @include('frontend.layouts.master_css')

    {{-- Page Specific CSS --}}
    @stack('css')
</head>

<body class="@yield('body_class')">

    {{-- Body Start Tracking --}}
    @include('frontend.partials.tracking-pixels', [
        'placement' => 'body_start'
    ])

    {{-- Page Loader --}}
    @include('frontend.partials.page-loader')

    {{-- Header --}}
    @include('frontend.partials.header')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Floating Buttons --}}
    @include('frontend.partials.floating-actions')

    {{-- Body End Tracking --}}
    @include('frontend.partials.tracking-pixels', [
        'placement' => 'body_end'
    ])

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Global Frontend JS --}}
    @include('frontend.layouts.master_script')

    {{-- Page Specific JS --}}
    @stack('js')

</body>
</html>
