@extends('layouts.auth_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="public-main">
        <div class="container">

            <section class="inner-page-banner text-center">
                <div class="container">
                    <h1>Get in touch with us!</h1>
                </div>
            </section>

            <section class="contact-us-page">
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
                <div class="top-cont-info  text-center" style="padding:20px 0px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="num-add-details">
                                    <i class="fas fa-mobile"></i>
                                    <span>{{ GlobalValues::get('phone') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="num-add-details">
                                    <i class="fas fa-envelope-open-text"></i>
                                    <span><a
                                            href="mailto:{{ GlobalValues::get('contact_email') }}">{{ GlobalValues::get('contact_email') }}</a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="num-add-details">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ GlobalValues::get('address') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" style="padding: 20px 0px;">
                            <h3>For any grievance please contact to <a
                                    href="mailto:{{ GlobalValues::get('contact_email') }}">{{ GlobalValues::get('contact_email') }}</a>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-md-center">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 log-forms inputer">
                        <form id="frm_contact_submit" class="form-disable" method="post"
                            action="{{ route('submit-contact') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_first_name">First Name<sup>*</sup></label>
                                        <input type="text" class="form-control" id="contact_first_name"
                                            name="contact_first_name" value="{{ old('contact_first_name') }}" />
                                        @error('contact_first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_last_name">Last Name<sup>*</sup></label>
                                        <input type="text" class="form-control" id="contact_last_name"
                                            name="contact_last_name" value="{{ old('contact_last_name') }}" />
                                        @error('contact_last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_email">E-Mail<sup>*</sup></label>
                                        <input type="text" class="form-control" id="contact_email" name="contact_email"
                                            value="{{ old('contact_email') }}" />
                                        @error('contact_email')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group cun-code">
                                        <label for="phone_number">Phone Number<sup>*</sup></label>
                                        <input type="text" class="form-control" id="contact_phone_number"
                                            name="contact_phone_number" value="{{ old('contact_phone_number') }}" />
                                        @error('contact_phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="msg_content">Your Text<sup>*</sup></label>
                                        <textarea class="form-control" name="contact_msg_content">{{ old('contact_msg_content') }}</textarea>
                                        @error('contact_msg_content')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="captcha">Captcha</label>
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        @error('g-recaptcha-response')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" style="display: inline-block">
                                <input type="submit" value="{{ __('Submit') }}" data-submit-value="Please wait..."
                                    class="btn scoler-details">
                            </div>
                        </form>
                        <div class="col-sm-3"></div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#contact_phone_number").CcPicker();
            $("#contact_phone_number").CcPicker("setCountryByCode", "US");
        });
    </script>
@endsection
