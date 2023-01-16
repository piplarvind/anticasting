<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('public/backend/images') }}/favicon.png" />
    <link href="{{ asset('public/backend/css/style.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('public/backend') }}/vendor/global/global.min.js"></script>
    <script src="{{ asset('public/backend') }}/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('public/backend') }}/js/custom.min.js"></script>
    <script src="{{ asset('public/backend') }}/js/deznav-init.js"></script>
    <style type="text/css">
        .text-white {
            color: #000; !important;
        }
        .text-primary {
            color: #000 !important;
        }
    </style>
</head>
<body class="h-100" style="background-color:#fff">
    <div id="app" class="authincation h-100">
        <div class="container h-100">
            @yield('content')
        </div>
    </div>
</body>
</html>
