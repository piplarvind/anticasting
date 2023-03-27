@extends('layouts.auth')
@section('content')
    <section class="contact-us section">
        @if (Session::has('message'))
            <div id="success" title="Success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @elseif (Session::has('error'))
            <div id="error" title="Error">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <main class="d-flex align-items-center w-auto main-container">
            <div class="container">
                <div class="card login-card">
                    <div class="row no-gutters">
                        <div class="col-md-5">
                            <div class="card-body">
                                <div class="brand-wrapper">
                                    <a href="{{ route('users.home') }}">
                                        <img src="{{ asset('assets/website/images/anticasting-logo.png') }}" alt="logo"
                                            class="logo" width="100" height="100">
                                    </a>
                                </div>
                                <p class="d-flex justify-content-center fs-4">Login into your account</p>
                                <form action="{{ route('users.loginpost') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="form-label text-muted">
                                            <b>Email</b>&nbsp;<span style="color:red;"><b>*</b></span>
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Email address">
                                        @error('email')
                                            <span class="text-danger"><b>{{ $message }}</b></span>
                                        @enderror

                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label text-muted">
                                            <b>Password</b>&nbsp;<span style="color:red;"><b>*</b></span>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control password" id="password" class="block mt-1 w-full"
                                                type="password" name="password" placeholder="Enter  password" />
                                            <span class="input-group-text togglePassword" id="">
                                                <i data-feather="eye" style="cursor: pointer"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <span class="text-danger"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">

                                        <input type="checkbox" name="remeber_me" id="rember-me" />
                                        <label for="rember-me" class="form-label text-muted">&nbsp;<b>Remember
                                                Me</b></label>

                                    </div>

                                    <div class="d-grid gap-2 mb-1 mt-3 col-6 mx-auto">
                                        <input type="submit" class="btn btn-dark form-control" type="button"
                                            value="Login">
                                    </div>
                                </form>
                                <div class="mt-3">
                                    <a href="{{ route('users.forgot-password') }}" class="forgot-password-link"><b>Forgot
                                            password?</b></a>
                                    <p class="login-card-footer-text"><b>Don't have an account?</b><a
                                            href="{{ route('users.register') }}" class="text-reset text-muted">Register
                                            here</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <img src="{{ asset('assets/website/images/banner.jpg') }}" alt="login"
                                class="login-card-img">
                            {{-- <p
                                class="text-white font-weight-medium text-center flex-grow align-self-end footer-link text-small">
                                Free <a href="https://wordpress-923989-3206731.cloudwaysapps.com/" target="_blank"
                                    class="text-white">Bootstrap dashboard templates</a> from Bootstrapdash
                            </p> --}}
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </section>
@endsection
@section('footer')
    <script type="text/javascript">
        $(function() {
            $("#error").dialog({
                autoOpen: true,
                modal: true,
                buttons: [
                    // {
                    //     text: 'Yes, proceed!',
                    //     open: function() {
                    //         $(this).addClass('yescls')
                    //     },
                    //     click: function() {
                    //         $(this).dialog("close")
                    //     }
                    // },
                    {
                        text: "Cancle",
                        open: function() {
                            $(this).addClass('cancls')
                        },
                        click: function() {
                            $(this).dialog("close")
                        }
                    }
                ],
                show: {
                    effect: "bounce",
                    duration: 1500
                },
                hide: {
                    effect: "fade",
                    duration: 1000
                },
                open: function(event, ui) {
                    $(".ui-dialog-titlebar", $(this).parent())
                        .hide();
                }
            });
        });
        $(function() {
            $("#success").dialog({
                autoOpen: true,
                modal: true,
                buttons: [{
                        text: 'Yes, proceed!',
                        open: function() {
                            $(this).addClass('yescls')
                        },
                        click: function() {
                            $(this).dialog("close")
                        }
                    },

                ],
                show: {
                    effect: "bounce",
                    duration: 1500
                },
                hide: {
                    effect: "fade",
                    duration: 1000
                },
                open: function(event, ui) {
                    $(".ui-dialog-titlebar", $(this).parent())
                        .hide();
                }
            });
        });
        feather.replace({
            'aria-hidden': 'true'
        });
        $(".togglePassword").click(function(e) {
            e.preventDefault();
            var type = $(this).parent().parent().find(".password").attr("type");
            console.log(type);
            if (type == "password") {

                $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
                $(this).parent().parent().find(".password").attr("type", "text");
            } else if (type == "text") {
                $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
                $(this).parent().parent().find(".password").attr("type", "password");
            }
        });
    </script>
@endsection
