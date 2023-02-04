<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting @yield('title')</title>
    @include('include.head')
</head>

<body>
    <!-- ======= Header ======= -->
    @include('include.header')
    <!-- ======= End Header ======= -->
    <!-- ======= Hero ======= -->
    @include('include.hero')
    <!-- ======= End Hero ======= -->

    <!-- ======= Footer ======= -->
    @yield('content')
    @include('include.footer')
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/users/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/users/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/users/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/users/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/users/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/users/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/users/assets/js/main.js') }}"></script>

</body>

</html>
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting | Profile</title>
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/fonts/material.css') }}">
    <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/css/style.css') }}" id="main-style-link">
    @yield('header')
</head>
<body>
     @yield('content')
    <script src="{{ asset('assets/submitprofile/js/vendor-all.min.js') }}"></script>
    <script src="{{asset('assets/submitprofile/js/plugins/bootstrap.min.js')}}"></script>
    <script src=" {{asset('assets/submitprofile/js/plugins/feather.min.js')}}"></script>
    <script src=" {{asset('assets/submitprofile/js/pcoded.min.js')}}"></script>
    @yield('footer')
</body>
</html> --}}
