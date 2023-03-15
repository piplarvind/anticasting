<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting | Dashboard</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('assets/front-dashboard/css/style.css') }}">
</head>

<body>
    <div class="layer"></div>
    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        <!-- ! Sidebar -->
        @include('front-dashboard.include.siderbar')
        <!--Sidebar End-->
       
        <div class="main-wrapper">
         <!--Navbar-->
               @include('front-dashboard.include.navbar')
         <!-- Navbar end -->
         <!--Main -->
         <main class="main users chart-page" id="skip-target">
            <div class="container">
                @yield('content')
            </div>   
         </main>       
         <!--Main End -->
           
         <!--Footer-->
              @include('front-dashboard.include.footer')
           <!--Footer End -->
        </div>
    </div>
        <script src="{{ asset('assets/front-dashboard/plugins/chart.min.js') }}"></script>
        <!-- Icons library -->
        <script src="{{ asset('assets/front-dashboard/plugins/feather.min.js') }}"></script>
        <!-- Custom scripts -->
        <script src="{{ asset('assets/front-dashboard/js/script.js') }}"></script>
</body>

</html>
