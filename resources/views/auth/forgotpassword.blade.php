@extends('layouts.auth')
@section('content')
    <section id="contact-us" class="contact-us section">
        @if (Session::has('message'))
            <script></script>

            <div id="dialog" title="Error">
                <p>{{ Session::get('message') }}</p>
            </div>
        @elseif (Session::has('error'))
            <div id="dialog" title="Error">
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-5 col-lg-5 col-md-5 col-sm-5 ">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <div class="border-0">
                                <span class="lead text-muted">
                                    Please enter your email address. You will receive an email message with instructions on
                                    how to reset your password.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg border-0 rounded-lg mt-3">

                        <div class="card-body">
                            <form action="{{ route('users.forgotpassword-post') }}" method="post">
                                @csrf
                                <div class="form mb-3">
                                    <label for="email" class="text-muted">Email Address</label>
                                    <br />
                                    <input class="form-control" id="Email" name="email" type="email"
                                        placeholder="Enter a email" />

                                    @error('email')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>


                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0 ms-2">

                                    <button type="submit" class="btn-sm btn btn-primary active">Get New Password</button>
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
    <script>
        $(function() {
            $("#dialog").dialog({
                autoOpen: true,
                modal: true,
                buttons: [
                    {
                        text: 'Yes, proceed!',
                        open: function() {
                            $(this).addClass('yescls')
                        },
                        click: function() {
                            $(this).dialog("close")
                        }
                    },
                    // {
                    //     text: "Cancle",
                    //     open: function() {
                    //         $(this).addClass('cancls')
                    //     },
                    //     click: function() {
                    //         $(this).dialog("close")
                    //     }
                    // }
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
    </script>
@endsection
