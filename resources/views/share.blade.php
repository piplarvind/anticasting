@extends('layouts.account_app')
@section('content')
    @include('layouts.payment-dropdown')
    <section class="money-limit-sec">
        <div class="container">

            <div class="clearfix">
                <div class="ml-left">
                    <h3>Save money when you refer friends.</h3>
                    <p>Share your special {{ GlobalValues::get('site_title') }} link using email, text message, and or
                        social media. Make sure they sign
                        up using the link you sent.</p>
                </div>
                <div class="ml-right">
                    <div class="ml-right-inner">
                        <div class="ml-right-inner-top">
                            <h3>Give your friend $15, earn $15</h3>
                            <p> <a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal"> MORE DETAILS
                                </a> </p>
                        </div>
                        <div class="ml-right-inner-body">
                            @if (session('alert-danger'))
                                <div class="alert alert-danger">
                                    {{ session('alert-danger') }}
                                </div>
                            @endif
                            @if (session('alert-success'))
                                <div class="alert alert-success">
                                    {{ session('alert-success') }}
                                </div>
                            @endif
                            <form action="{{ route('mobile-share') }}" method="post">
                                @csrf()
                                <label>Enter mobile number and click send</label>
                                <div class="input-group  cun-code">
                                    <input type="let" style="margin-left:75px; width:48%;" name="refer_mobile_no"
                                        id="refer_mobile_no" class="form-control" placeholder="Enter friend mobile number">
                                    <div class="input-group-btn">
                                        <button class="btn share-btn" type="submit">Send</button>
                                    </div>
                                </div>
                                @error('refer_mobile_no')
                                    <p class="invalid-feedback" role="alert">
                                        <error>{{ $message }}</error>
                                    </p>
                                @enderror
                            </form>
                            <form action="{{ route('email-share') }}" method="post">
                                @csrf()
                                <br>
                                <label>Enter email addresses and click send</label>
                                <div class="input-group">
                                    <input type="email" name="refer_email" id="refer_email" class="form-control"
                                        placeholder="Type a friend email address">
                                    <div class="input-group-btn">
                                        <button class="btn share-btn" type="submit">Send</button>
                                    </div>
                                </div>
                                @error('refer_email')
                                    <p class="invalid-feedback" role="alert">
                                        <error>{{ $message }}</error>
                                    </p>
                                @enderror
                                <br>
                                <label>Copy your invite link</label>
                                <div class="input-group dotted-input">
                                    <input type="text" class="form-control" id="refrralCode" name="refrralCode"
                                        placeholder="https://payzz.com"
                                        value="{{ url('/') }}/register?referralCode={{ $referralCode }}">
                                    <div class="input-group-btn">
                                        <button class="btn share-btn" type="button"
                                            onclick="copyRefrralCode()">Copy</button>
                                    </div>
                                </div>
                            </form>
                            <div class="social-share">
                                <p>Other Ways to Share</p>
                                <ul>
                                    <li class="message-icon"><a
                                            href="sms:?&body={{ url('/') }}/register?referralCode={{ $referralCode }}"><span><i
                                                    class="fa fa-comment"></i></span></a></li>
                                    {!! $shareButtons !!}
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">HOW DOES THIS OFFER WORK?</h5>
                    <button type="button" class="close" style="margin-top:-30px;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        When one of the people you refer uses your share link to sign up and sends money with
                        {{ GlobalValues::get('site_title') }} for the
                        first time, they will get a special exchange rate and $20 off when they send $100 or more. And, you
                        will automatically get a $20 discount on your next transfer. The more people you give to, the more
                        you
                        earn. It's that easy.
                    </p>
                    <table class="table table-responsive">
                        <tr>
                            <td>
                                Share {{ GlobalValues::get('site_title') }} with your friends, family, co-workers and
                                more
                                using Email, Facebook, Twitter,
                                WhatsApp,
                                or sharing your personal link.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Your friend signs up from your link & successfully sends money using
                                {{ GlobalValues::get('site_title') }}.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                We automatically add $20 to your {{ GlobalValues::get('site_title') }} account. That's
                                it!
                            </td>
                        </tr>
                    </table>

                    <p>
                        Email: Choose the email contacts you want to share {{ GlobalValues::get('site_title') }} with,
                        preview and send the message.
                        Social Media: Click on the social media of your choice, preview the message, and post it so your
                        friends
                        can see it.
                    </p>

                    <h4>
                        Why should my friends use {{ GlobalValues::get('site_title') }}?
                    </h4>

                    <p>
                        Not only is {{ GlobalValues::get('site_title') }} easy and secure, but we always have competitive
                        rates. That's why more than 5 million customers trust {{ GlobalValues::get('site_title') }} to
                        send money home.

                    </p>
                    <h4> How do I get the $20?</h4>

                    <p>
                        {{ GlobalValues::get('site_title') }} will automatically credit your account with $20. Next time
                        you
                        send, this discount will be
                        directly applied to your transfer.
                    </p>

                    <h4>
                        What if I do not get my reward?
                    </h4>

                    <p>
                        No problem. Contact our 24/7 Customer Care team and let them know. The link is the only way to
                        automatically connect you and your friend. But if you tell us about your referral, we can also
                        manually
                        add the discount.

                    </p>
                    <h4>
                        How do I know if my friend sent with {{ GlobalValues::get('site_title') }}?
                    </h4>

                    <p>
                        For security reasons, we cannot tell you about your friend's transfer. But don't worry, if they
                        qualify
                        we will automatically give you your reward!

                    </p>
                    <h4> Are there any limits on the offer?</h4>
                    <p>
                        Referrals must not be existing {{ GlobalValues::get('site_title') }} users and must not live at
                        your
                        same address in order for the
                        rewards to apply.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.ccpicker.css') }}">
    <style type="text/css">
        .cun-code>.cc-picker-code-select-enabled {
            position: absolute;
            top: 20px;
            left: 6px;
        }

        .cun-code .form-control {
            padding-left: 5px;
        }
    </style>
    <script src="{{ asset('public/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#refer_mobile_no").CcPicker();
            $("#refer_mobile_no").CcPicker("setCountryByCode", "US");
        });

        function copyRefrralCode() {

            /* Get the text field */
            var copyText = document.getElementById("refrralCode");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection
