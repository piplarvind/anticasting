@extends('layouts.auth')
@section('content')
    <section id="contact-us" class="contact-us section">
        @if (Session::has('message'))
            <div id="success" title="Success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @elseif (Session::has('error'))
            <div id="error" title="Error">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <div class="container">
            <div class="row justify-content-center  mt-5">
                <div class="col-lg-5 col-lg-5 col-md-5 col-sm-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">

                        <div class="card-body">
                            <form action="{{ route('users.resetpasswordpost') }}" method="post">
                                <h3 class="text-center font-weight-light my-4 text-danger">Reset Your Password</h3>
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}" />
                                <input type="hidden" name="email" value="{{ $email }}" />
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" id="password" name="password" type="password"
                                        placeholder="Enter a password" />
                                    @error('password')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email">Confirm Password</label>
                                    <div class="input-group" id="show_hide_password">

                                        <input class="form-control  password block mt-0 w-full"
                                            placeholder="Enter a confirm password" type="password" name="confirm_password">
                                        <span class="input-group-text togglePassword" id="">
                                            <i data-feather="eye" style="cursor: pointer"></i>
                                        </span>
                                    </div>

                                    @error('confirm_password')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                                    <button type="submit" class="form-control btn btn-danger">Reset Password</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script>
        /*Alert message success*/
        $(function() {
            $("#success").dialog({
                autoOpen: true,
                modal: true,
                buttons: [{
                        text: 'Yes, proceed!',
                        open: function() {
                            $(this).addClass('yescls')
                        },
                        click: function() {
                            $(this).dialog("close")
                        }
                    },

                ],
                show: {
                    effect: "bounce",
                    duration: 1500
                },
                hide: {
                    effect: "fade",
                    duration: 1000
                },
                open: function(event, ui) {
                    $(".ui-dialog-titlebar", $(this).parent())
                        .hide();
                }
            });
        });
        /*Alert message error*/
        $(function() {
            $("#error").dialog({
                autoOpen: true,
                modal: true,
                buttons: [{
                    text: "Cancle",
                    open: function() {
                        $(this).addClass('cancls')
                    },
                    click: function() {
                        $(this).dialog("close")
                    }
                }],
                show: {
                    effect: "bounce",
                    duration: 1500
                },
                hide: {
                    effect: "fade",
                    duration: 1000
                },
                open: function(event, ui) {
                    $(".ui-dialog-titlebar", $(this).parent())
                        .hide();
                }
            });
        });
        /*Password Toggle*/
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
