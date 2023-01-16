@extends('layouts.auth_app')

@section('content')
    <section class="public-main">
        <div class="container">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 log-forms inputer all-pop-ups">
                <div class="log-forms inputer">
                    <form method="POST" role="form" action="{{ route('register') }}" class="form-disable">
                        @csrf
                        <input type="hidden" name="referralCode" value="{{ $referralCode }}">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="">
                            <div class="log-header">
                                <h1>Create Your <span>Account</span></h1>
                            </div>
                            <div class="step-wizards">
                                <div class="wizard">
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1">
                                            <div class="inner-que">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">First Name<sup>*</sup></label>
                                                            <input type="text"
                                                                class="form-control @error('first_name') is-invalid @enderror"
                                                                id="first_name" name="first_name"
                                                                value="{{ old('first_name') }}" autocomplete="first_name"
                                                                autofocus>
                                                            @error('first_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Last Name<sup>*</sup></label>
                                                            <input type="text"
                                                                class="form-control @error('last_name') is-invalid @enderror"
                                                                id="last_name" name="last_name"
                                                                value="{{ old('last_name') }}" autocomplete="last_name"
                                                                autofocus>
                                                            @error('last_name')
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
                                                            <label for="register_email">Email Address<sup>*</sup></label>
                                                            <input type="email"
                                                                class="form-control @error('register_email') is-invalid @enderror"
                                                                id="register_email" name="register_email"
                                                                value="{{ old('email') }}" autocomplete="email">
                                                            @error('register_email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="register_mobile_number">Mobile
                                                                Number<sup>*</sup></label>
                                                            <input type="tel"
                                                                class="form-control @error('register_mobile_number') is-invalid @enderror"
                                                                id="register_mobile_number" name="register_mobile_number"
                                                                value="{{ old('register_mobile_number') }}"
                                                                autocomplete="register_mobile_number">
                                                            @error('register_mobile_number')
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
                                                            <label for="register_password">Password<sup>*</sup></label>
                                                            <input id="register_password" type="password"
                                                                class="form-control @error('register_password') is-invalid @enderror"
                                                                name="register_password" autocomplete="new-password">
                                                            <span style="font-size: 12px;">Password should be 8 characters
                                                                long.
                                                            </span>
                                                            @error('register_password')
                                                                <p class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Confirmed Password<sup>*</sup></label>
                                                            <input id="register_password_confirmation" type="password"
                                                                class="form-control" name="register_password_confirmation"
                                                                autocomplete="new-password">
                                                            @error('register_password_confirmation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    {{-- <div class="col-sm-12 reg-check-ak"> --}}
                                                    <div class="col-sm-12">
                                                        <div class="checkers">
                                                            <input id="terms" type="checkbox"
                                                                class="form-check-input @error('terms') is-invalid @enderror"
                                                                name="terms"> <label class="form-check-label" for="terms">
                                                                By clicking "Join Now", you agree to
                                                                {{ GlobalValues::get('site_title') }}'s
                                                                <a target="_blank"
                                                                    href="{{ route('pages', ['terms-conditions']) }}">
                                                                    terms &
                                                                    conditions<sup>*</sup></a>
                                                            </label>
                                                            @error('terms')
                                                                <p class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <ul class="list-inline clearfix none-block" style="padding-top: 15px;">
                                                <li class="pull-left dont-have-ac">Back To <a
                                                        href="{{ url('login') }}">Sign In</a></li>
                                                <li class="pull-right">
                                                    {{-- <button type="submit" class="btn btn-primary scoler-details" data-toggle="modal" data-target="#otp-popup">Submit</button> --}}
                                                    <input type="submit" class="btn scoler-details" value="Join Now"
                                                        data-submit-value="Please wait...">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </section>
@endsection
