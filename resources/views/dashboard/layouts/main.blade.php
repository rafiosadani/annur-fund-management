<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Masjid An Nur Politeknik Negeri Malang
    </title>
    {{-- Fonts and icons --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>

    {{-- Nucleo Icons --}}
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet"/>

    {{-- Font Awesome Icons --}}
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet"/>

    {{-- CSS Files --}}
    <link id="pagestyle" href="{{ asset('css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet"/>

    {{--  My CSS --}}
    <link id="pagestyle" href="{{ asset('css/style.css') }}" rel="stylesheet"/>
    <link id="pagestyle" href="{{ asset('css/style2.css') }}" rel="stylesheet"/>
</head>

<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-primary position-absolute w-100"></div>
@include('dashboard.layouts.sidebar')
<main class="main-content position-relative border-radius-lg ">
    @include('dashboard.layouts.header')
    <div class="container-fluid pt-4 pb-6">
        @yield('content')
        @include('dashboard.layouts.footer')
        @include('dashboard.layouts.setting-configurator')
{{--        @include('dashboard.layouts.footer-large')--}}
    </div>
</main>
@include('dashboard.layouts.script')
@yield('scripts')
</body>

</html>
