<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Anticasting | @yield('title', 'Admin Login')</title>
    <link href="{{ asset('assets/admin/css/lib/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/lib/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/lib/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/lib/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
    
  
</head>

<body class="bg-primary">
<div class="unix-login">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login-content">
              
                    <div class="login-logo">
                        <a href="{{ url('/') }}"><span>Anticasting</span></a>
                    </div>
                    <div class="login-form">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- 
    @include('includes.message')
     --}}

</body>
</html>
