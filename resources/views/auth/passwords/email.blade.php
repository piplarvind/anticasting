@extends('layouts.auth_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="public-main">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 log-forms inputer all-pop-ups">
                    <form method="POST" action="{{ route('password.email') }}" class="form-disable">
                        @csrf
                        <div class="log-header">
                            <h1>Reset your password</h1>
                        </div>
                        <div class="right-regi-step login-page">
                            <div class="vh-center text-center">
                                @if (session('alert-danger'))
                                    <div class="alert alert-danger">
                                        {{ session('alert-danger') }}
                                    </div>
                                @endif
                                @if (session('alert-success'))
                                    <div class="alert alert-success">
                                        {{ session('alert-success') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Please enter your email address.</label>
                                    <input type="email" name="forgot_email" id="forgot_email"
                                        class="form-control @error('forgot_email') is-invalid @enderror"
                                        value="{{ old('forgot_email') }}" placeholder="Email Address">
                                    @error('forgot_email')
                                        <p class="invalid-feedback" role="alert" style="text-align:left;">
                                            <error>{{ $message }}</error>
                                        </p>
                                    @enderror
                                    <span class="text-center">We will send you an email that will allow you to change
                                        your password.</span>
                                </div>
                                <div class="text-center" style="display: inline-block">
                                    <input type="submit" value="{{ __('Request Reset') }}"
                                        data-submit-value="Please wait..." class="btn bg-white text-primary btn-block">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section>
@endsection
