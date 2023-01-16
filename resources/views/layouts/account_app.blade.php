<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '') }} {{ isset($pageTitle) ? ' :: ' . $pageTitle : '' }}</title>

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
</head>

<body class="dashboard-page" id="myDIV">
    <div id="app">
        <header>
            <div class="container">
                <div class="main-header">
                    <div class="logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('public') }}/img/logo.jpg"
                                alt="SITE_LOGO" /></a>
                    </div>
                    <div class="mobile-nav" onclick="myFunction()">
                        <span></span>
                    </div>
                    <div class="cust-nav">
                        <ul>
                            @guest
                                <li class="sign-in-btn"><a id="signin-link" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#login-modal">Sign In</a></li>
                                <li><a id="joinnow-link" href="javascript:void(0)" data-toggle="modal"
                                        data-target="#register-modal">Join Now</a></li>
                            @else
                                @if (Auth::user()->userRole->role_id == '1')
                                    <li><a href="{{ url('/admin/dashboard') }}">Welcome {{ Auth::user()->name }}!</a></li>
                                @else
                                    <li class="welcome-btn">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                                            Welcome {{ Auth::user()->first_name }}! <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('dashboard') }}"><i class="fas fa-cog"></i>
                                                    Dashboard</a></li>
                                            <li><a href="{{ route('edit-profile') }}"><i class="fas fa-cog"></i>
                                                    Edit Profile</a></li>
                                            {{-- <li><a href="#"><i class="fas fa-box"></i> Redeem Offer</a></li>
									<li><a href="#"><i class="far fa-question-circle"></i> Help</a></li> --}}
                                            <li><a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                        class="fas fa-sign-out-alt"></i> Log Out</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">@csrf</form>
                                            </li>
                                        </ul>
                                    </li>
                                @endif @endguest
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content') @include('layouts/footer')
        </div>
    </body>
    <script>
        function myFunction() {
            var element = document.getElementById("myDIV");
            element.classList.toggle("mystyle");
        }
    </script>

    </html>
