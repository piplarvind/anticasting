@extends('layouts.auth')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card shadow-lg border-0 rounded-lg mt-5">

                <div class="card-body">
                    <h3 class="text-center font-weight-light my-4 text-danger">Create Your Account</h3>
                    <form method="post" id="frm_register" action="{{ route('users.registerpost') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class=" mb-3 mb-md-0">
                                    <label for="inputFirstName">First name</label>
                                    <input class="form-control" name="first_name" id="inputFirstName" type="text"
                                        placeholder="Enter your first name" />

                                    @error('first_name')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" mb-3 mb-md-0">
                                    <label for="inputLastName">Last name</label>
                                    <input class="form-control" name="last_name" id="inputLastName" type="text"
                                        placeholder="Enter your last name" />
                                    @error('last_name')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 mb-3">
                                <label for="email">Email address</label>
                                <input class="form-control" id="inputEmail" name="email" type="email"
                                    placeholder="Enter email address" />
                                @error('email')
                                    <span class="text-danger"><b>{{ $message }}</b></span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-6 mb-3">
                                <label for="inputmobileNumber">Moblile Number</label>
                                <div class="input-group input-span mb-3">
                                    <input type="hidden" id="code" name="countryCode" />
                                    <input type="text" class="form-control" id="mobile_number" name="mobile_no"
                                        placeholder="Mobile number" />
                                </div>
                                <input type="hidden" name="iso2" id="phone_country_code" value="91" />
                                {{-- <span id="phone-error" style="display: none;" for="phone" class="text-danger"></span> --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">


                                <div class="mb-3 mb-md-0">
                                    <label for="inputPassword">Password</label>
                                    {{-- <input class="form-control" name="password" id="password" type="password"
                                        placeholder="Enter a password" /> --}}
                                    <div class="input-group">
                                        <input class="form-control password" id="password" class="block mt-1 w-full"
                                            type="password" name="password" placeholder="Enter a password" />
                                        {{-- <span class="input-group-text togglePassword" id="">
                                            <i data-feather="eye" style="cursor: pointer"></i>
                                        </span> --}}
                                    </div>

                                    @error('password')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>


                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="input-group">
                                        <input class="form-control password" id="confirm_password" class="block mt-1 w-full"
                                            type="password" name="confirm_password" placeholder="Enter confirm password" />
                                        <span class="input-group-text toggleConfirmPassword" id="">
                                            <i data-feather="eye" style="cursor: pointer"></i>
                                        </span>
                                    </div>
                                    {{-- <div class="input-group" id="show_hide_password">
                                        <input class="form-control" placeholder="Enter confirm password" type="password"
                                            id="confirm_password" name="confirm_password">
                                        <div class="input-group-addon">
                                            <i class="fas fa-eye-slash" aria-hidden="true" id="togglePassword"></i>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 mb-0">
                            <div class="d-grid"><button type="submit" class="btn btn-danger btn-block">Register
                                </button>
                            </div>
                        </div>
                    </form>
                    <br />
                    <div class="small"><a class="text-danger" href="{{ route('users.login') }}">
                            <b>Have an account? Go to login</b> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('assets/website/js/jquery.validate.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('assets/intl-telephone/css/intlTelInput.css') }}">
    <script src="{{ asset('assets/intl-telephone/js/intlTelInput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/website/js/validations/auth/register.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script>
        var selectedFlag = 'in'
        $("#mobile_number").intlTelInput({
            //        preferredCountries: ['in','ae', 'us'],
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
