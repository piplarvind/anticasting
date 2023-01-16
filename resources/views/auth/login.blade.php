@extends('layouts.auth_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="public-main">
        <div class="container">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 log-forms inputer all-pop-ups">
                <div class="log-forms inputer">
                    <form method="POST" action="{{ route('login') }}" class="form-disable">
                        @csrf
                        <div class="log-header">
                            <h1>Login into your account</h1>
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
                        <div class="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email Address') }}<sup>*</sup></label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" autocomplete="email" autofocus>

                                        @error('email')
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
                                        <label for="password">{{ __('Password') }}<sup>*</sup></label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <div class="checkers">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-right">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <ul class="log-btn-main clearfix">
                                <li class="pull-left dont-have-ac">Don't have an account ? <a
                                        href="{{ url('register') }}">Join Now </a></li>

                                <li class="pull-right">
                                    <input type="submit" value="{{ __('Sign In') }}" data-submit-value="Please wait..."
                                        class="btn btn-primary">
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="banner-cont fb-login">
                                        <a href="{{ route('facebook.login') }}" class="btn btn-primary">
                                            <i class="fab fa-facebook-f fa-fw"></i>
                                            Facebook Login
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="banner-cont google-login">
                                        <a href="{{ route('google.login') }}" class="btn btn-primary">
                                            <i class="fa fa-google"></i>
                                            Google Login
                                        </a>
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
