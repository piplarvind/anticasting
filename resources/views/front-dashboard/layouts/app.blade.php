<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anticasting | Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/front-dashboard/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/front-dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        {{-- Sidebar --}}
        @include('front-dashboard.include.siderbar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('front-dashboard.include.navbar')
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('front-dashboard.include.footer')
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
 
    <script src="{{ asset('assets/front-dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/front-dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/front-dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/front-dashboard/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('assets/front-dashboard/js/jquery.easing.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('assets/front-dashboard/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/front-dashboard/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/front-dashboard/js/demo/chart-pie-demo.js') }}"></script>
</body>

</html>
