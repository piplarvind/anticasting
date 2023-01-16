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
    <style type="text/css">
        .error-msg {
            padding: 20px 0px;
            position: absolute;
            top: 15%;
            left: 45%;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px;
            color: #fff;
        }

        .error-msg a {
            color: #fff;
        }

        .error-msg a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="dashboard-page">
    <div id="app">
        <header>
            <div class="container">
                <div class="main-header">
                    <div class="logo"><a href="{{ url('/') }}"><img
                                src="{{ asset('public') }}/img/logo.png" alt="SITE_LOGO" /></a></div>
                    <div class="cust-nav-btns">
                        <ul class="clearfix">
                            @guest
                                <li class="sign-in-btn">
                                    <a href="{{ route('login') }}" data-toggle="modal">Sign In</a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" data-toggle="modal">Join
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

        @include('layouts.payment-dropdown')
        <section class="public-main">
            <div class="container">
                <section class="contact-us-page">
                    <div class="top-cont-info  text-center" style="padding:20px 0px;">
                        <div class="container">
                            <div class="text-center" style="position:relative;">
                                <img src="{{ asset('public') }}/img/transfer-history-bg.jpg">
                                <div class="text-center error-msg">
                                    <h4>@yield('code') | @yield('message')</h4>
                                    <a href="{{ route('home') }}">Go To Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        @include('layouts/footer')
    </div>
</body>

</html>
