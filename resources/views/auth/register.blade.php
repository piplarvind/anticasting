@extends('layouts.auth')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css" rel="stylesheet" />
@endsection
@section('content')
    <section class="contact-us section register-card">
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
                                <p class="d-flex justify-content-center fs-4">Register into your account</p>
                                <form method="post" id="frm_register" action="{{ route('users.registerpost') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputFirstName" class="form-label text-muted"><b>First
                                                    name</b>&nbsp;<span style="color:red;"><b>*</b></span>
                                                </label>
                                                <input type="text" name="first_name" id="inputFirstName"
                                                    class="form-control" placeholder="First name">
                                                @error('first_name')
                                                    <span class="text-danger"><b>{{ $message }}</b></span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group  mb-1">
                                                <label for="inputLastName" class="form-label text-muted"><b>Last
                                                    name</b>&nbsp;<span style="color:red;"><b>*</b></span>
                                                </label>
                                                <input type="text" name="last_name" id="inputLastName"
                                                    class="form-control" placeholder="Last name">
                                                @error('last_name')
                                                    <span class="text-danger"><b>{{ $message }}</b></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label for="email" class="form-label text-muted"><b>Email</b>&nbsp;<span
                                                        style="color:red;"><b>*</b></span>
                                                </label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Email address">
                                                @error('email')
                                                    <span class="text-danger"><b>{{ $message }}</b></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group  mb-1">
                                                <label for="password" class="form-label text-muted"><b>Password</b>&nbsp;<span
                                                        style="color:red;"><b>*</b></span>
                                                </label>
                                                <input class="form-control" id="password" class="block mt-1 w-full"
                                                    type="password" name="password" placeholder="Enter a password" />
                                                @error('password')
                                                    <span class="text-danger"><b>{{ $message }}</b></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label for="confirm_password" class="form-label text-muted"><b>Confiram
                                                    Password</b>&nbsp;<span style="color:red;"><b>*</b></span></label>
                                                <div class="input-group">
                                                    <input class="form-control password" id="confirm_password"
                                                        class="block mt-1 w-full" type="password" name="confirm_password"
                                                        placeholder="Enter confirm password" />
                                                    <span class="input-group-text toggleConfirmPassword" id="">
                                                        <i data-feather="eye" style="cursor: pointer"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group  mb-1">
                                                <label for="inputmobileNumber" class="form-label text-muted"><b>Moblile
                                                    Number</b>&nbsp;<span style="color:red;"><b>*</b></span></label>
                                                <div class="input-group input-span mb-3">
                                                    <input type="hidden" id="code" name="countryCode" />
                                                    <input type="text" class="form-control" id="mobile_number"
                                                        name="mobile_no" placeholder="Mobile number" />
                                                </div>
                                                <input type="hidden" name="iso2" id="phone_country_code"
                                                    value="+91" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <input type="submit" class="btn btn-dark form-control" type="button"
                                            value="Register" />
                                    </div>

                                </form>
                                <div class="d-flex justify-content-center mt-2">
                                    <p class="login-card-footer-text"><b>Have an account?</b><a
                                            href="{{ route('users.login') }}" class="text-reset">Login here</a></p>
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
    <!--Footer of Submit profile css -->
    {{--  
@include('include.submitprofile.footer')
--}}
    <script src="{{ asset('assets/website/js/jquery.validate.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('assets/intl-telephone/css/intlTelInput.css') }}">
    <script src="{{ asset('assets/intl-telephone/js/intlTelInput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/website/js/validations/auth/register.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script>
        var selectedFlag = 'in'
        $("#mobile_number").intlTelInput({
            //preferredCountries: ['in','ae', 'us'],
            preferredCountries: ['in', 'ae', 'us'],
            autoPlaceholder: true,
            // onlyCountries: ['in','ae', 'us'],
            initialCountry: selectedFlag,
            utilsScript: '{{ asset('assets/intl-telephone/js/utils.js') }}'
        });
        $("#mobile_number").on("countrychange", function(e, countryData) {
            $("#phone_country_code").val(countryData.dialCode);
        });

        /*
         * toggle password
         */
        feather.replace({
            'aria-hidden': 'true'
        });
        // $(".togglePassword").click(function(e) {
        //     e.preventDefault();
        //     var type = $(this).parent().parent().find(".password").attr("type");
        //     console.log(type);
        //     if (type == "password") {
        //         $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
        //         $(this).parent().parent().find(".password").attr("type", "text");
        //     } else if (type == "text") {
        //         $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
        //         $(this).parent().parent().find(".password").attr("type", "password");
        //     }
        // });
        $(".toggleConfirmPassword").click(function(e) {
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
