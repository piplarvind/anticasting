@extends('layouts.auth_app')

@section('content')
    <section class="registration-page clearfix fullHt">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="left-regi" style="background-image: url({{ asset('public/img/banner-1.jpg') }});">
            <div class="vh-center">
                {{-- <div class="reg-logo"><a href="{{ url('/')}}"><img src="{{ asset('public/img/logo-main.png')}}" alt="SITE-LOGO"></a></div> --}}
                <div style="text-align: center;">
                    <h1>WELCOME BACK!</h1>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    @include('auth.welcome-note')
                    <button type="button" class="btn" onclick="window.location.href='{{ url('/') }}'">Back to
                        Home</button>
                </div>
            </div>
        </div>
        <div class="right-regi-step">
            <div class="vh-center">
                <h1>Create Your <span>Account</span></h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                <div class="step-wizards">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab">
                                        <span class="round-tab"> <span class="percents">Step 1</span></span>
                                    </a>
                                </li>

                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab">
                                        <span class="round-tab"> <span class="percents">Step 2</span></span>
                                    </a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab">
                                        <span class="round-tab"> <span class="percents">Step 3</span></span>
                                    </a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab">
                                        <span class="round-tab"> <span class="percents">Step 4</span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form method="POST" role="form" action="{{ route('register') }}" class="form-disable">
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <div class="inner-que">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="first_name">First Name<sup>*</sup></label>
                                                    <input type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        id="first_name" name="first_name" value="{{ old('first_name') }}"
                                                        autocomplete="first_name" autofocus>
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="middle_name">Middle Name</label>
                                                    <input type="text"
                                                        class="form-control @error('middle_name') is-invalid @enderror"
                                                        id="middle_name" name="middle_name"
                                                        value="{{ old('middle_name') }}">
                                                    @error('middle_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="last_name">Last Name<sup>*</sup></label>
                                                    <input type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        id="last_name" name="last_name" value="{{ old('last_name') }}">
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">E-Mail<sup>*</sup></label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                                        name="email" value="{{ old('email') }}" autocomplete="email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="user_mobile">Phone Number<sup>*</sup></label>
                                                    <input type="tel"
                                                        class="form-control @error('user_mobile') is-invalid @enderror"
                                                        id="user_mobile" name="user_mobile"
                                                        value="{{ old('user_mobile') }}">
                                                    @error('user_mobile')
                                                        <span class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Password<sup>*</sup></label>
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" autocomplete="new-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Confirmed Password</label>
                                                    <input id="password-confirm" type="password" class="form-control"
                                                        name="password_confirmation" autocomplete="new-password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline clearfix none-block">
                                        <li class="pull-left dont-have-ac">Back To <a href="{{ url('login') }}">Login</a>
                                        </li>
                                        <li class="pull-right"><button type="button"
                                                class="btn btn-primary next-step">Next <i
                                                    class="fas fa-angle-right"></i></button></li>
                                        <li class="pull-right">
                                            {{-- <button type="submit" class="btn btn-primary scoler-details" data-toggle="modal" data-target="#otp-popup">Submit</button> --}}
                                            <input type="submit" class="btn btn-primary scoler-details" value="Submit"
                                                data-toggle="modal" data-target="#otp-popup"
                                                data-submit-value="Please wait...">
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <div class="inner-que">
                                        <div class="scolersheeps-opt">
                                            <h4>Essay Registration Fee</h4>
                                            <h4 style="color: #fa5701;">Rs.149+<span>PM INDIA FUND</span> Rs.100=Rs.249
                                                <span>Pay by</span> PayPal</h4>
                                            <div class="paypal-logo"><img src="{{ asset('public/img/paypal.png') }}">
                                            </div>
                                            <button type="button" class="btn btn-primary scoler-details">Make Payment By
                                                Paypal</button>
                                        </div>
                                        <div class="row" style="margin: 20px 0;">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Invoice Number</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Date</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline clearfix">
                                        <li class="pull-left"><button type="button"
                                                class="btn btn-default prev-step"><i class="fas fa-angle-left"></i>
                                                Previous</button></li>
                                        <li class="pull-right"><button type="button"
                                                class="btn btn-primary next-step">Next <i
                                                    class="fas fa-angle-right"></i></button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <div class="inner-que">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Name of the School/College and address with Postal
                                                        Code/Zip Code</label>
                                                    <textarea class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Name of the Parents/Guardian</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Contact Phone Number</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Contact E-Mail Address</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Address for Correspondence with Postal Code/Zip
                                                        Code</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Applicant's Adhar Card Number</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Academic Qualification</label>
                                                    <input type="text" class="form-control" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline clearfix">
                                        <li class="pull-left"><button type="button"
                                                class="btn btn-default prev-step"><i class="fas fa-angle-left"></i>
                                                Previous</button></li>
                                        <li class="pull-right"><button type="button"
                                                class="btn btn-primary next-step">Next <i
                                                    class="fas fa-angle-right"></i></button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <div class="inner-que">
                                        <div class="scolersheeps-opt">
                                            <h4>Do you plan to apply for SCHOLARSHIP'S</h4>
                                            <div class="cust-redio">
                                                <label>
                                                    <input type="radio" name="radio1">
                                                    <span>Yes</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="radio1">
                                                    <span>No</span>
                                                </label>
                                            </div>
                                            <div class="infos-scl">
                                                <p style="font-size: 16px; font-weight: bold;"><span>*</span> Only Indian
                                                    Nationals in India are eligible to apply for these scholarships.</p>
                                                <p>INTERESTED PERSONS CAN APPLY FOR THIS SCHOLARSHIP'S ON OR AFTER 15TH
                                                    AUGUST 2021. PLEASE CHECK THE <a href="javascript:void(0)">UPDATES</a>
                                                    FOR COMPLETE INFORMATION.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline clearfix">
                                        <li class="pull-left"><button type="button"
                                                class="btn btn-default prev-step"><i class="fas fa-angle-left"></i>
                                                Previous</button></li>
                                        <li class="pull-right"><button type="button" class="btn btn-primary next-step"
                                                onclick="window.location.href='login.html';">Sign Up</button></li>
                                        <li class="pull-right"><button type="button"
                                                class="btn btn-primary scoler-details" data-toggle="modal"
                                                data-target="#scoler-popup">SCHOLARSHIP DETAILS</button></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="terms-and-conditions-page text-left">
                <span class="remove-t-c"><i class="fa fa-arrow-left"></i> Back to page</span>
                <h1>Please check <span>Rules / Regulation / T & C</span></h1>
                <h4>You can refer 5, 10 or more names of your family members, friends or relatives so you can become a
                    Silver Registrant, Gold Registrant or Platinum Registrant to claim as A Preferred Registrant for
                    Platinum India Scholarship-75</h4>
                <div class="add-member-btn">
                    <button type="button" class="btn" data-toggle="modal" data-target="#add-member-sliver">Add
                        Silver Member</button>
                    <button type="button" class="btn" data-toggle="modal" data-target="#add-member-gold">Add
                        Gold Member</button>
                    <button type="button" class="btn" data-toggle="modal" data-target="#add-member-platinum">Add
                        Platinum Member</button>
                </div>
                <div class="boxes boxes-high-light">
                    <input type="checkbox" id="box-1">
                    <label for="box-1">I hereby certify that, I am 18 years old and registering as an Adult participant in
                        the Platinum India-75 Global Essay's Competition's</label>
                </div>
                <div class="t-c-content">
                    <ul class="clearfix">
                        <li>I hereby certify that, I am 18 years old and registering as an Adult participant in the event.
                        </li>
                        <li>I am responsible for all the concerned activities.</li>
                        <li>I hereby agree to the terms and conditions of the (AIU) Platinum India-75. </li>
                        <li>I hereby agree that the paid Registration Fee of Rs.149=00 and the PM INDIA FUND of Rs.100=00
                            with total amount of Rs.249=00 is NON-REFUNDABLE.</li>
                        <li>In the event of any dispute or misunderstanding, I will request the interference of the
                            President of the {AIU} Platinum India-75 to resolve all the concerned issue's and will abide by
                            the Decision of the President.</li>
                        <li>I am hereby surrendering and forfeiting my legal right's to approach or appeal to the court of
                            law or any other institution in India or Abroad for the redressal of the grievances and the
                            Decision of the President will be final and binding on me.</li>
                    </ul>
                </div>
                <p class="email-sig">Electronic Signature of the Registrant: <span><input type="text"
                            class="form-control" id="" placeholder=""></span></p>
                <p class="email-sig">Date: <span><input type="text" class="form-control" id=""
                            placeholder=""></span>
                <div class="boxes boxes-high-light">
                    <input type="checkbox" id="box-2">
                    <label for="box-2">I, hereby certify that, I am under the age of 18 years and registering as a
                        participant in the Platinum India-75Global Essay's Competition's under the Guidance and
                        responsibilities of my parents/guardian</label>
                </div>
                <div class="boxes boxes-high-light">
                    <input type="checkbox" id="box-3">
                    <label for="box-3">I/We agree to the Terms and Conditions</label>
                </div>
                <div class="t-c-content">
                    <ul class="clearfix">
                        <li>We the Parents/Guardian hereby agree to the terms and conditions of the Platinum India-75 Global
                            Essay's Competition's. </li>
                        <li>I/We hereby agree that the paid Registration Fee of Rs.149=00 and the PM INDIA FUND of Rs.100=00
                            with total amount of Rs.249=00 is NON-REFUNDABLE.</li>
                        <li>In the event of any dispute or misunderstanding, I/ we will request the interference of the
                            President of {AIU} Platinum India-75 to resolve the concerned issue's and will abide by the
                            Decision of the President.</li>
                        <li>I/We hereby surrendering and forfeiting my/our legal rights to approach or appeal to the court
                            of law or any other institution in India or Abroad for the redressal of our grievances and the
                            Decision of the President will be final and binding on us.</li>
                    </ul>
                </div>
                <p class="email-sig">Electronic Signature of the Registrant: <span><input type="text"
                            class="form-control" id="" placeholder=""></span></p>
                <p class="email-sig">Date: <span><input type="text" class="form-control" id=""
                            placeholder=""></span>
                <p class="email-sig">Electronic Signature of the Father/Mother/Guardian: <span><input type="text"
                            class="form-control" id="" placeholder=""></p>
                <p class="email-sig">Date: <span><input type="text" class="form-control" id=""
                            placeholder=""></span>
                <h1>RULES & <span>REGULATIONS</span></h1>
                <div class="t-c-content">
                    <ul class="clearfix">
                        <li>The Registrant/Essay's Writer should complete the selected Essay's Topic's - Theme's and
                            submit/upload the same within 30 Days from the time of registration failing which the
                            registration will lapse.</li>
                        <li>The Registrant/Essay's Writer is advised to please keep your written essay's in CONFIDENTIAL
                            after submission.</li>
                        <li>Circulating your essay's to other friends or colleagues may result your chance to LOOSE the
                            First Prize.</li>
                        <li>The Registrant/Essay's writer can select any one of the above topics for writing an essay.</li>
                        <li>If the Registrant prefers to write essay's on more than one topic/theme, separate registration
                            is required for each topic/theme.</li>
                        <li>The written essay's shall be limited to 1000 words. However + or – 3% of the More or Less words
                            will be considered for awarding the Prize's.</li>
                        <li>The essay shall be written using MS Office with the following guidelines:</li>
                        <li>Double Line Spacing with a Margin of LHS 10, RHS 75, Top 10, Bottom 10 cms The essay should be
                            written only in ENLGISH language.</li>
                        <li>The completed essay's shall written online or uploaded or e-mailed to as a PDF attachment.
                            <b>(Please do not e-mail in the MS Word Form)</b></li>
                        <li>The AIU/Platinum India-75 is vested with the rights to alter/amend/increase/decrease the cash
                            prize award's and the number of the prizes depending upon the responses received.</li>
                    </ul>
                </div>
                <h1>COMPOSITION OF THE <span>ESSAY FOR EVALUATION</span></h1>
                <div class="t-c-content">
                    <ul class="clearfix">
                        <li>Essay Structure and Core Components: Total Marks/Points 100</li>
                        <li>Introduction to the selected topic-10 Marks/Points</li>
                        <li>Importance with Advantages and Disadvantages-20 Marks</li>
                        <li>Inventions, Innovations and Improvements for Betterment to eliminate the possible
                            disadvantages-20 Marks</li>
                        <li>Statistical Information with current Facts and Figures to the possible Extent-20 Marks</li>
                        <li>Constructive suggestions to improve the existing system-20 Marks</li>
                        <li>Conclusion with Benefits to the Community and Humanity-10 Marks</li>
                    </ul>
                </div>
                <h1>General <span>Guide Lines</span></h1>
                <div class="t-c-content" style="margin-bottom: 40px">
                    <ul class="clearfix">
                        <li>All the registered participants will be issued the (AIU)/Platinum India-75 Certificate for their
                            participation.</li>
                        <li>The winners NAME will be displayed on the website as well as contacted by Phone & E-mail to make
                            sure to reach the winner.</li>
                        <li>The winner will be responsible for the taxes if any on the Prize Money</li>
                        <li>The Registrants will be able to apply for the Platinum India-75 Scholarship's and General
                            Scholarship's on or after 15th AUGUST 2021.</li>
                    </ul>
                </div>
            </div>
            <div class="ashok-chakra-animation"
                style="background-image: url({{ asset('public/img/ashok-chakra.png') }});"></div>
        </div>
    </section>
    <div class="all-pop-ups">
        <div class="modal fade" id="otp-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Enter OTP</h4>
                    </div>
                    <div class="modal-body">
                        <div class="inner-que">
                            <h4><b>Verify Your Mobile Number</b></h4>
                            <p>OTP has been sent to you on your mobile number. Please enter it below</p>
                            <h1>{{ $otp }}</h1>
                            <div class="form-group">
                                <input type="tel" class="form-control" id="otp" name="otp" maxlength="4">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" id="btnOtpVerify" name="btnOtpVerify" class="btn btn-default otp-add-body"
                            value="Verify OTP">
                        {{-- <button type="button" class="btn btn-default otp-add-body" data-dismiss="modal">Verified</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#otp-popup").modal('show');

        $("#btnOtpVerify").on('click', function(event) {
            // Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            var input_data = {
                otp: $("#otp").val()
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('verify-otp') }}",
                type: "POST",
                data: input_data,
                success: function(response) {
                    $("#otp").val("");
                    alert(response.msg);
                    if (response.errorCode == '1') {
                        window.location.href = "{{ route('make-payment') }}";
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
