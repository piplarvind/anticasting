@extends('layouts.auth')
@section('content')
    <style>
        .w-75 {
            width: 94% !important;
        }
    </style>
    <section id="contact-us" class="contact-us section">
        @if (Session::has('message'))
            <script></script>

            <div id="dialog" title="Error">
                <p>{{ Session::get('message') }}</p>
            </div>
        @elseif (Session::has('error'))
            <div id="dialog" title="Error">
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
                                <p class="d-flex justify-content-center fs-4">Forgot into your password</p>
                                <div class="border-0">
                                    <span class="text-muted">
                                        Please enter your email address. You will receive an email message with instructions
                                        on
                                        how to reset your password.
                                    </span>
                                </div>
                                <form action="{{ route('users.forgotpassword-post') }}" method="post">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <label for="email" class="form-label text-muted">
                                            <b>Email</b>&nbsp;<span style="color:red;"><b>*</b></span>
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control w-75"
                                            placeholder="Email address">
                                        @error('email')
                                            <span class="text-danger"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                    <div class="d-grid gap-2 mb-1 mt-4 col-6 mx-auto">
                                        <input type="submit" class="btn btn-dark form-control" type="button"
                                            value="Get New Password">
                                    </div>
                                </form>
                                <br />
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
    <script>
        $(function() {
            $("#dialog").dialog({
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
                    // {
                    //     text: "Cancle",
                    //     open: function() {
                    //         $(this).addClass('cancls')
                    //     },
                    //     click: function() {
                    //         $(this).dialog("close")
                    //     }
                    // }
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
    </script>
@endsection
{{-- <div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-5 col-lg-5 col-md-5 col-sm-5 from-card">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-body">
                    <div class="border-0">
                        <span class="lead text-muted">
                            Please enter your email address. You will receive an email message with instructions on
                            how to reset your password.
                        </span>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border-0 rounded-lg mt-3">

                <div class="card-body">
                    <form action="{{ route('users.forgotpassword-post') }}" method="post">
                        @csrf
                        <div class="form mb-3">
                            <label for="email" class="text-muted">Email Address</label>
                            <br />
                            <input class="form-control" id="Email" name="email" type="email"
                                placeholder="Enter a email" />

                            @error('email')
                                <span class="text-danger"><b>{{ $message }}</b></span>
                            @enderror
                        </div>


                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0 ms-2">

                            <button type="submit" class="btn-sm btn btn-primary active">Get New Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div> --}}
