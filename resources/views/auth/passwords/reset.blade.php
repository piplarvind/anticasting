@extends('layouts.auth_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="public-main">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 log-forms inputer all-pop-ups">
                    <h4 class="text-center mb-4">Reset Password</h4>
                    <form method="POST" action="{{ route('password.update') }}" class="form-disable">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="right-regi-step login-page">
                            <div class="vh-center">
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
                                    <label class="mb-1">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" readonly
                                        value="{{ $email ?? old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="mb-1"><strong>Password<sup>*</sup></strong></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control  @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="mb-1"><strong>Confirm Password<sup>*</sup></strong></label>
                                    <input type="password" name="password_confirmation" id="password-confirm"
                                        class="form-control  @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="text-center" style="display: inline-block">
                                    <input type="submit" value="{{ __('Reset Password') }}"
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
