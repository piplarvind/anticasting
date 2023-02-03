@extends('admin.layouts.admin-auth-layouts')
@section('title')
    Change Password
@endsection
@section('content')
    <h4 class="text-danger">Administratior Change Password</h4>
    <form action="{{ route('admin.changePasswordPost') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Old Password</label>
            <input type="password" class="form-control @error('oldpassword') is-invalid @enderror" placeholder="Enter old password" name="oldpassword"
                value="{{ old('oldpassword') }}"  autocomplete="oldpassword"  />
            @error('oldpassword')
                <span class="invalid-feedback alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder=" Enter  password" autocomplete="password" />

            @error('password')
                <span class="invalid-feedback alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
         
        <div class="form-group">
            <label>Confirm Password</label>
            <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                name="confirm_password" placeholder=" Enter confirm password"  autocomplete="confirm_password" />

            @error('confirm_password')
                <span class="invalid-feedback alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-danger btn-flat m-b-10 m-t-10">Change Password</button>
     
    </form>
@endsection