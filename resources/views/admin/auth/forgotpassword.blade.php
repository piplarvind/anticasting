@extends('admin.layouts.admin-auth-layouts')
@section('title')
    Forgotpassword
@endsection
<br/>
<br/>
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
<script src="{{ asset('assets/auth/toastr.min.js') }}" defer ></script>
<script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
 <script>
    @if(Session::has('message'))
       toastr.success("{{ Session::get('message') }}");
       @elseif (Session::has('error'))
         toastr.error("{{ Session::get('error') }}");
     @endif
  </script>
    <h4 class="text-danger">Administratior Forgot Password</h4>
    <form action="{{ route('admin.forgotpassword-post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
                value="{{ old('email') }}"  autocomplete="email" autofocus />
            @error('email')
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
        <button type="submit" class="btn-sm btn btn-danger">Get Reset Link</button>
        {{-- 
        <div class="register-link m-t-10 text-center">
            <p><a href="">Forgot password</a></p>
         </div> 
         --}}
    </form>
@endsection
