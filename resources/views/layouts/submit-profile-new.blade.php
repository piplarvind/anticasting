<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting @yield('title')</title>
    @include('include.submitprofile.head')
    @yield('style')
    @include('include.submitprofile.header')
  
</head>

<body>
    <!-- ======= Header ======= -->
     @yield('header')
    <!-- ======= End Header ======= -->
     @yield('content')
     @yield('footer')
<script src="{{ asset('assets/submitprofile/assets/js/bootstrap.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

</body>
</html>
