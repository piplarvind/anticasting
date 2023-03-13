@extends('admin.layouts.admin-auth-layouts')
@section('title')
    Login
@endsection
@section('content')
    <h4 class="text-danger">Administratior Login</h4>
    <form action="{{ route('admin.loginPost') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
                value="{{ old('email') }}" autocomplete="email" />
            @error('email')
                <span class="invalid-feedback alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-group" id="show_hide_password">

                <input class="form-control  password block mt-0 w-full    @error('password') is-invalid @enderror"
                    placeholder="Enter  password" type="password" name="password" id="password"
                    autocomplete="current-password" />
                <span class="input-group-text togglePassword" id="">
                    <i data-feather="eye" style="cursor: pointer"></i>
                </span>
            </div>
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
        <button type="submit" class="btn btn-danger btn-flat m-b-10 m-t-10">Sign in</button>
        <div class="register-link m-t-10 text-center">
            <b><a class="text-danger" href="{{ route('admin.forgot-password') }}">Forgot password</a></b>
        </div>
    </form>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script>
        feather.replace({
            'aria-hidden': 'true'
        });
        $(".togglePassword").click(function(e) {
            e.preventDefault();
            var type = $(this).parent().parent().find(".password").attr("type");
            console.log(type);
            if (type == "password") {

                $("svg.feather.feather-eye").replaceWith(feather.icons["eye-off"].toSvg());
                $(this).parent().parent().find(".password").attr("type", "text");
            } else if (type == "text") {
                $("svg.feather.feather-eye-off").replaceWith(feather.icons["eye"].toSvg());
                $(this).parent().parent().find(".password").attr("type", "password");
            }
        });
    </script>
@endsection
