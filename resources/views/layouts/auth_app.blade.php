<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Appointment Booking') }}</title>

    <link rel="icon" href="{{ asset('public/img/fav-icon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/animated.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/payment-keyframes.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/dev.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('public/js/jquery.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/js/scrollIt.min.js') }}"></script>
    <script src="{{ asset('public/js/skrollr.min.js') }}"></script>
    <script src="{{ asset('public/js/wow.js') }}"></script>
    <script src="{{ asset('public/js/device.min.js') }}"></script>
    <script src="{{ asset('public/js/custom.js') }}"></script>
    <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
    <style type="text/css">
        .invalid-feedback {
            font-size: 14px;
            color: red;
        }

        .iti--separate-dial-code {
            width: 100%;
        }
    </style>
</head>

<body class="dashboard-page">
    <div id="app">
        <header>
            <div class="container">
                <div class="main-header">
                    <div class="logo"><a href="{{ url('/') }}"><img width="120" height="81"
                                src="{{ asset('public') }}/img/logo.jpg" alt="SITE_LOGO" /></a></div>
                    <div class="cust-nav-btns">
                        <ul class="clearfix">
                            @guest
                                <li class="sign-in-btn">
                                    <a href="{{ route('login') }}">Sign In</a>
                                </li>
                                <li class="sign-in-btn">
                                    <a href="{{ route('register') }}">Join
                                        Now</a>
                                </li>
                            @else
                                @if (Auth::user()->userRole->role_id == '1')
                                    <li><a href="{{ url('/admin/dashboard') }}">Welcome
                                            {{ Auth::user()->first_name }}!</a>
                                    </li>
                                @else
                                    <li><a href="{{ url('/dashboard') }}">Welcome {{ Auth::user()->first_name }}!</a>
                                    </li>
                                @endif
                                <li class="sign-in-btn">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="fa fa-sign-out"></i> Log Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')

        @include('layouts/footer')
    </div>

</body>
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/intlTelInput.css') }}">
<script src="{{ asset('public/js/intlTelInput.js') }}"></script>

<script type="text/javascript">



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function accept_terms() {
        $(".terms-condi").click();
    }

    var input = document.querySelector("#register_mobile_number");
    window.intlTelInput(input, {
        allowDropdown: true,
        hiddenInput: "full_number",
        initialCountry: "in",
        preferredCountries: ['in'],
        separateDialCode: true,
        utilsScript: "{{ asset('public/js/utils.js') }}",
    });
</script>

</html>
