<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Appointment Booking') }} {{ isset($pageTitle) ? ' :: ' . $pageTitle : '' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('public/backend/images') }}/favicon.png" />

    <link href="{{ asset('public/backend') }}/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/backend') }}/vendor/chartist/css/chartist.min.css">
    <!-- Vectormap -->
    <link href="{{ asset('public/backend') }}/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="{{ asset('public/backend') }}/vendor/bootstrap-select/dist/css/bootstrap-select.min.css"
        rel="stylesheet">
    <link href="{{ asset('public/backend') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('public/backend') }}/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <style type="text/css">
        .nav-header, .header{
            background-color:#fff;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div id="main-wrapper">
        @yield('content')
    </div>
    <script src="{{ asset('public/backend') }}/vendor/global/global.min.js"></script>
    <script src="{{ asset('public/backend') }}/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('public/backend') }}/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="{{ asset('public/backend') }}/js/custom.min.js"></script>
    <script src="{{ asset('public/backend') }}/js/deznav-init.js"></script>
    <script src="{{ asset('public/backend') }}/vendor/owl-carousel/owl.carousel.js"></script>

    <!-- Chart piety plugin files -->
    <script src="{{ asset('public/backend') }}/vendor/peity/jquery.peity.min.js"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('public/backend') }}/vendor/apexchart/apexchart.js"></script>
    @yield('footer-scripts')
</body>

</html>
