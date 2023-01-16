@extends('layouts.admin-login')
@section('content')
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
            <div class="">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <a href="{{ url('admin/login') }}"><img
                                        src="{{ asset('public/backend/images') }}/logo.jpg" alt="logo"
                                        width="200"></a>
                            </div>
                            <h4 class="text-center mb-4">Sign in your account</h4>
                            @if (session('alert-class'))
                                <div class="alert alert-danger">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session('register-success'))
                                <div class="alert alert-success">
                                    {{ session('register-success') }} {{ Session::forget('register-success') }}
                                </div>
                            @endif
                            <form id='admin_login' name='admin_login' role="form" method="POST"
                                action="{{ route('admin.submit-login') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="mb-1"><strong>Email</strong></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="mb-1"><strong>Password</strong></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control  @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox ml-1">
                                            <input type="checkbox" class="custom-control-input" id="remember"
                                                name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">Remember my
                                                preference</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{ url('password/reset') }}">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-primary text-white btn-block">Sign Me In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
