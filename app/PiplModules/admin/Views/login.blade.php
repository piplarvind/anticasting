@extends('layouts.auth_app')

@section('content')
<section class="registration-page clearfix fullHt">
	<div class="left-regi" style="background-image: url({{ asset('public/img/banner-1.jpg')}});">
		<div class="vh-center">
			<div class="reg-logo"><a href="{{ url('/')}}"><img src="{{ asset('public/img/logo-main.png')}}" alt="SITE-LOGO"></a></div>
			<h1>WELCOME BACK!</h1>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
			<button type="button" class="btn" onclick="window.location.href='{{ url('/')}}'">Back to Home</button>
		</div>
	</div>
	<form id='admin_login' name='admin_login' role="form" method="POST" action="{{ url('/login') }}">
    @csrf
	<div class="right-regi-step login-page">
		<div class="vh-center">
			<h1>Admin <span>Login</span></h1>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
            @if (session('login-error'))
                <div class="alert alert-danger">
                    {{ session('login-error')}}
                </div>
            @endif
            @if (session('register-success'))
                <div class="alert alert-success">
                    {{ session('register-success') }} {{ Session::forget('register-success')}}
                </div>
            @endif
			<div class="inner-que">
            	<div class="row">
            		<div class="col-sm-12">
            			<div class="form-group">
						    <label for="email">{{ __('E-Mail Address') }}</label>
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
						</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-sm-12">
            			<div class="form-group">
						    <label for="password">{{ __('Password') }}</label>
						     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
						</div>
            		</div>
            	</div>

				<div class="row">
            		<div class="col-sm-7">
            			<div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
						<div class="col-sm-5 text-right">
							@if (Route::has('password.request'))
								<a href="{{ url('/admin/password/reset') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							@endif
                        </div>
				</div>

            	<ul class="log-btn-main clearfix">
                    <li class="pull-left dont-have-ac">Dont have an account ? <a href="{{ url('register')}}">Sign Up </a></li>

                    <li class="pull-right"><button type="submit" class="btn btn-primary">{{ __('Login') }}</button></li>
                </ul>
            </div>
		</div>
		<div class="ashok-chakra-animation" style="background-image: url({{ asset('public/img/ashok-chakra.png')}});"></div>
	</div>
	</form>
</section>
@endsection