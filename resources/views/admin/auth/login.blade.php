@extends('admin.layouts.admin-auth-layouts')
@section('title')
    Login
@endsection
@section('content')
    <h4>Administratior Login</h4>
    <form action="{{ route('admin.loginPost') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
                value="{{ old('email') }}"  autocomplete="email"  />
            @error('email')
                <span class="invalid-feedback alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password"  autocomplete="current-password" />

            @error('password')
                <span class="invalid-feedback alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- <div class="checkbox">
            <label>
                <input type="checkbox"> Remember Me
            </label>
            <label class="pull-right">
                <a href="#">Forgotten Password?</a>
            </label>

        </div> --}}
        <button type="submit" class="btn btn-primary btn-flat m-b-10 m-t-10">Sign in</button>
       <div class="register-link m-t-10 text-center">
            <p><a href="{{ route('admin.forgot-password') }}">Forgot password</a></p>
        </div> 
    </form>
@endsection
