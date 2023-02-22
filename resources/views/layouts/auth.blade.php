<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting @yield('title')</title>
   
    @include('auth.include.head')
    @yield('style')
    @include('auth.include.header')
    <script>
        var url = "{{ url('/') }}";
    </script>
</head>

<body>
    <!-- ======= Header ======= -->
     @yield('header')
    <!-- ======= End Header ======= -->
    @yield('content')

    @include('auth.include.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('assets/submitprofile/assets/js/bootstrap.min.js')}}"></script>
   
    @yield('footer')

</body>
</html>
