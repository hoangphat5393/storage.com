<!DOCTYPE html>
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    {{-- <title>{{ setting_option('company_name') }}</title> --}}
    {{-- <meta name="description" content="description"> --}}

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ get_image(setting_option('favicon')) }}" />

    {{-- SEO meta --}}
    @yield('seo')

    {{-- Google Web Fonts --}}

    {{-- Customized Bootstrap Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-4.6.2/css/bootstrap.min.css') }}">

    {{-- Boostrap Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">

    {{-- Font Awesome 6.4.2 --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome_pro/css/all.min.css') }}">

    {{-- Libraries Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('assets/plugin/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugin/swiper@11/swiper-bundle.min.css') }}">

    {{-- Main Style CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?ver=' . random_int(0, 100)) }}">

    {!! htmlspecialchars_decode(setting_option('header')) !!}

    @stack('head-style')

    @stack('head-script')
</head>

<body>

    {{-- @include($templateFile . '.layouts.spinner') --}}
    @include('frontend.layouts.header')

    @yield('content')

    <a href="https://zalo.me/{{ setting_option('zalo') }}" target="_blank" class="call-zalo" title="{{ setting_option('webtitle') }}">
        <img src="{{ asset('assets/images/icon/icon-zalo.webp') }}" class="img-fluid" alt="zalo" />
    </a>

    <a href="tel:{{ setting_option('phone') }}" class="call-now" rel="nofollow" title="{{ setting_option('webtitle') }}">
        <div class="mh-contact">
            <div class="animated infinite zoomIn mh-alo-ph-circle"></div>
            <div class="animated infinite pulse mh-alo-ph-circle-fill"></div>
            <div class="animated infinite tada mh-img-circle">
                <i class="fa-solid fa-phone"></i>
            </div>
        </div>
    </a>

    @include('frontend.layouts.footer')

    {{-- Including Jquery --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-4.6.2/js/bootstrap.bundle.min.js') }} "></script>
    <script src="{{ asset('assets/plugin/axios@1.7.2/axios.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/lodash@4.17.21/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugin/swiper@11/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugin/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/plugin/wow/wow.min.js') }}"></script>
    {{-- <script src="{{ asset('plugin/counterup/counterup.min.js') }}"></script> --}}
    <script src="{{ asset('assets/plugin/sweetalert2@11/sweetalert2.all.min.js') }}"></script>

    {{-- <script src="{{ asset('js/main.js?ver=' . random_int(0, 100)) }}"></script> --}}
    <script src="{{ asset('assets/js/custom.js?ver=' . random_int(0, 100)) }}"></script>

    @stack('scripts')

</body>

</html>
