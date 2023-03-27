@extends('layouts.auth')
@section('content')
    <section id="contact-us" class="contact-us section">
        @if (Session::has('message'))
            <div id="success" title="Success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @elseif (Session::has('error'))
            <div id="error" title="Error">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <main class="d-flex align-items-center w-auto  main-container">
            <div class="container">
                <div class="card login-card">
                    <div class="row no-gutters">
                        <div class="col-md-5">
                            <div class="card-body">
                                <div class="brand-wrapper">
                                    <a href="{{route('users.home')}}">
                                    <img src="{{ asset('assets/website/images/anticasting-logo.png') }}" alt="logo"
                                        class="logo">
                                    </a>
                                </div>
                                <p class="d-flex justify-content-center fs-4">Reset into your password</p>
                                <p class="d-flex justify-content-center text-muted">Enter a new password for</p>
                                <form action="{{ route('users.resetpasswordpost') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}" />
                                    <input type="hidden" name="email" value="{{ $email }}" />
                                    <div class="form-group">
                                        <label for="password" class="form-label text-muted">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter password">
                                        @error('password')
                                            <span class="text-danger"><b>{{ $message }}</b></span>
                                        @enderror

                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="confirm_password" class="form-label text-muted">Confirm Password</label>
                                        <div class="input-group">
                                            <input class="form-control password" id="confirm_password" class="block mt-1 w-full"
                                                type="password" name="confirm_password" placeholder="Enter confirm  password" />
                                            <span class="input-group-text togglePassword" id="">
                                                <i data-feather="eye" style="cursor: pointer"></i>
                                            </span>
                                        </div>
                                        @error('confirm_password')
                                            <span class="text-danger"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                    <div class="d-grid gap-2 mb-1 mt-3 col-6 mx-auto">
                                        <input type="submit" class="btn btn-dark form-control" type="button"
                                            value="Reset Password">
                                    </div>
                                </form>
                                
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
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script>
        /*Alert message success*/
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
        /*Alert message error*/
        $(function() {
            $("#error").dialog({
                autoOpen: true,
                modal: true,
                buttons: [{
                    text: "Cancle",
                    open: function() {
                        $(this).addClass('cancls')
                    },
                    click: function() {
                        $(this).dialog("close")
                    }
                }],
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
        /*Password Toggle*/
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
{{-- <div class="container">
    <div class="row justify-content-center  mt-5">
        <div class="col-lg-5 col-lg-5 col-md-5 col-sm-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">

                <div class="card-body">
                    <form action="{{ route('users.resetpasswordpost') }}" method="post">
                        <h3 class="text-center font-weight-light my-4 text-danger">Reset Your Password</h3>
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}" />
                        <input type="hidden" name="email" value="{{ $email }}" />
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password"
                                placeholder="Enter a password" />
                            @error('password')
                                <span class="text-danger"><b>{{ $message }}</b></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Confirm Password</label>
                            <div class="input-group" id="show_hide_password">

                                <input class="form-control  password block mt-0 w-full"
                                    placeholder="Enter a confirm password" type="password" name="confirm_password">
                                <span class="input-group-text togglePassword" id="">
                                    <i data-feather="eye" style="cursor: pointer"></i>
                                </span>
                            </div>

                            @error('confirm_password')
                                <span class="text-danger"><b>{{ $message }}</b></span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                            <button type="submit" class="form-control btn btn-danger">Reset Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div> --}}