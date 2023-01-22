@extends('admin.layouts.admin-auth-layouts')
@section('title')
    Login
@endsection
@section('content')
    <h4>Administratior Reset Password</h4>
    <form action="{{ route('admin.resetpasswordpost') }}" method="POST">
        @csrf
        <input type="hidden" name="email"
        value="{{ old('email',$email) }}" />
      
        <input type="hidden" name="token"
        value="{{ old('token',$token) }}" />
       
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
        <div class="form-group">
            <label>Confirm Password</label>
            <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                name="confirm_password"  autocomplete="current-password" />

            @error('confirm_password')
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
        <button type="submit" class="btn btn-primary btn-flat m-b-10 m-t-10">Reset password</button>
        {{-- 
            <div class="register-link m-t-10 text-center">
            <p><a href="{{ route('admin.forgot-password') }}"></a></p>
           </div> 
        --}}
       
    </form>
@endsection
