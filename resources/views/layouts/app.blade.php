<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Payzz') }}</title>

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
        .invalid-feedback {
            font-size: 14px;
            color: red;
        }

        .iti--separate-dial-code {
            width: 100%;
        }
    </style>
</head>

<body>
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
                                    <li><a href="{{ url('send-receive-details') }}">Welcome
                                            {{ Auth::user()->first_name }}!</a></li>
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

    <div class="all-pop-ups logerin">
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" onclick="closeLogin()" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <div class="log-header">
                            <p>Welcome back</p>
                            <h1>Sign in to send money now</h1>
                        </div>
                        @if (session('alert-danger'))
                            <div class="alert alert-danger">
                                {{ session('alert-danger') }}
                            </div>
                        @endif
                        @if (session('alert-class'))
                            <div class="alert alert-success">
                                {{ session('alert-class') }}
                            </div>
                        @endif
                        @if (session('alert-success'))
                            <div class="alert alert-success">
                                {{ session('alert-success') }}
                            </div>
                        @endif
                        <div class="log-forms inputer">
                            <form method="POST" name="loginFrm" id="loginFrm" action="{{ route('login') }}"
                                class="form-disable">
                                @csrf
                                <div class="form-group">
                                    <label>Email<sup>*</sup></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password<sup>*</sup></label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    {{-- <span class="eye-icon"><img src="{{ asset('public') }}/img/visibility.png"
                                            alt="eye-icon"></span> --}}
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <input type="submit" value="{{ __('Sign In') }}"
                                    data-submit-value="Please wait..." class="btn btn-primary">

                                <div class="row rem-forg">
                                    <div class="col-sm-6">
                                        <div class="checkers">
                                            <input type="checkbox" name="remember" id="box-1"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label for="box-1">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><a href="{{ route('password.request') }}"
                                            class="trb-loger">Forgot your password?</a></div>
                                </div>

                                <p>&nbsp;</p>
                                <div class="banner-cont fb-login">
                                    <a href="{{ route('facebook.login') }}" class="btn btn-primary">
                                        <i class="fab fa-facebook-f fa-fw"></i>
                                        Facebook Login
                                    </a>
                                </div>
                                <p>&nbsp;</p>
                                <div class="banner-cont google-login">
                                    <a href="{{ route('google.login') }}" class="btn btn-primary">
                                        <i class="fa fa-google"></i>
                                        Google Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" onclick="closeRegister()" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <div class="log-header">
                            <p>Welcome to {{ GlobalValues::get('site_title') }}</p>
                            <h1>Sign up to send money now</h1>
                        </div>
                        <div class="log-forms inputer">
                            <form method="POST" role="form" name="registerFrm" id="registerFrm"
                                action="{{ route('register') }}" class="form-disable">
                                @csrf
                                <div class="form-group">
                                    <label>First Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" placeholder="First Name">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Last Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}" placeholder="Last Name">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="register_mobile_number">Mobile
                                        Number<sup>*</sup></label>
                                    <input type="tel"
                                        class="form-control @error('register_mobile_number') is-invalid @enderror"
                                        id="register_mobile_number" name="register_mobile_number"
                                        value="{{ old('register_mobile_number') }}"
                                        autocomplete="register_mobile_number">
                                    @error('register_mobile_number')
                                        <p class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </p>
                                    @enderror
                                    @error('full_number')
                                        <p class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email Address<sup>*</sup></label>
                                    <input type="email" class="form-control" id="register_email"
                                        name="register_email" value="{{ old('register_email') }}"
                                        placeholder="Email">
                                    @error('register_email')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password<sup>*</sup></label>
                                    <input type="password" class="form-control" id="register_password"
                                        name="register_password" placeholder="Password">
                                    {{-- <span class="eye-icon"><img src="{{ asset('public') }}/img/visibility.png"
                                            alt="eye-icon"></span> --}}
                                    @error('register_password')
                                        <p class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password<sup>*</sup></label>
                                    <input type="password" class="form-control" id="register_password_confirmation"
                                        name="register_password_confirmation" placeholder="Re-enter Password">
                                    {{-- <span class="eye-icon"><img src="{{ asset('public') }}/img/visibility.png"
                                            alt="eye-icon"></span> --}}
                                    @error('register_password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <input type="submit" value="{{ __('Join Now') }}"
                                    data-submit-value="Please wait..." class="btn btn-primary">
                                <p class="by-clicking">By clicking "Join Now", you agree to
                                    {{ GlobalValues::get('site_title') }}'s <a
                                        href="{{ url('pages/terms-conditions') }}"> <span>User
                                            Agreement</span></a> & <a
                                        href="{{ url('pages/privacy-policy') }}"><span>Privacy
                                            Policy</span></a></p>
                                <p class="already-acc">Already have an account? <a href="javascript:void(0)"
                                        data-toggle="modal" data-target="#loginModal">Sign In</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/intlTelInput.css') }}">
<script src="{{ asset('public/js/intlTelInput.js') }}"></script>
<script type="text/javascript">
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
