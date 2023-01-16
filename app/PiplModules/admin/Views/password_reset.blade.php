@extends(config("piplmodules.back-view-layout-login-location"))

@section("meta")
    <title>Reset your password</title>
@endsection

@section('content')
    <div class="login_bodywrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 pad_0">
                    <div class="inner_lwrapper login_inner">
                        <div class="login_form text-login">
                            <div class="login_wrapper">
                                <div class="logo_login">
                                    <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png') }}';"  onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png') }}';"  src="{{ asset('public/media/backend/images/etrio-logo-white.png') }}" alt="logo" />
                                </div>
                                @if (session('email'))
                                    <div class="alert alert-danger">
                                        {{ session('email') }}
                                    </div>
                                @endif
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form role="form" method="POST" action="{{ url('/password/email') }}">
                                    {!! csrf_field() !!}
                                    <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" autocomplete="off" placeholder="Enter the registered email address" autofocus="true" class="form-control" name="email" value="{{ old('email') }}">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12  text-right">
                                            <button type="submit" class="btn btn_theme text-login"><i class="fa fa-btn fa-envelope"></i> Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
