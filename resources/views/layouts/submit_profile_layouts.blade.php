<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting | Profile</title>

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/fonts/material.css') }}">
    <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/submitprofile/css/style.css') }}" id="main-style-link">
    @yield('header')
</head>
    

<body>

     @yield('profileContent')
     
    <script src="{{ asset('assets/submitprofile/js/vendor-all.min.js') }}"></script>
    <script src="{{asset('assets/submitprofile/js/plugins/bootstrap.min.js')}}"></script>
    <script src=" {{asset('assets/submitprofile/js/plugins/feather.min.js')}}"></script>
    <script src=" {{asset('assets/submitprofile/js/pcoded.min.js')}}"></script>
    @yield('footer')
</body>

</html>
