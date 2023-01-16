@extends('layouts.account_app')

@section('content')
    @include('layouts.payment-dropdown')

    <section class="dashboard-main">
        <div class="container">
            <div class="col-sm-4">
                @include('layouts.account-left-steps-nav')
            </div>
            <div class="col-sm-8">
                <div class="dashboard-right">
                    <div class="dashboard-heading">
                        <h4>Sender contact information</h4>
                        <p>(Please enter your full legal name as it appear on a valid ID.)</p>
                    </div>
                    <div class="dashboard-body">
                        <div class="receipient-form">
                            <form action="{{ url('save-sender-details') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>First name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="John"
                                        value="{{ old('first_name') ? old('first_name') : $user_sender_details->user->first_name }}">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Last Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Smith"
                                        value="{{ old('last_name') ? old('last_name') : $user_sender_details->user->last_name }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group cun-code">
                                    <label>Phone Number<sup>*</sup></label>
                                    <input type="tel" class="form-control" id="phone_no" name="phone_no"
                                        placeholder="(888) 888-8888"
                                        value="{{ old('phone_no') ? old('phone_no') : $user_sender_details->user->mobile_number }}">
                                    @error('phone_no')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <br>
                                <div class="dashboard-heading">
                                    <h4>Sender Address</h4>
                                    <p>Please enter your current home address. Misspellings or abbreviations cause delay.
                                    </p>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Street address line 1<sup>*</sup></label>
                                        <input type="text" class="form-control" id="address_line_1" name="address_line_1"
                                            placeholder="eg. 301 Abc Street"
                                            value="{{ old('address_line_1') ? old('address_line_1') : $user_sender_details->address_line_1 }}">
                                        @error('address_line_1')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Apartment, suite, unit, etc(optional)</label>
                                        <input type="text" class="form-control" id="address_line_2" name="address_line_2"
                                            placeholder="eg. Lake vista apartment"
                                            value="{{ old('address_line_2') ? old('address_line_2') : $user_sender_details->address_line_2 }}">
                                        @error('address_line_2')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>City<sup>*</sup></label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city') ? old('city') : $user_sender_details->city }}">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>State<sup>*</sup></label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ old('state') ? old('state') : $user_sender_details->state }}">
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Zip Code<sup>*</sup></label>
                                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                                            placeholder="eg. 10000"
                                            value="{{ old('zip_code') ? old('zip_code') : $user_sender_details->zip_code }}">
                                        @error('zip_code')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="dashboard-heading">
                                    <h4>Sender security details</h4>
                                    <p>We use this information to confirm your identity, as required by federal banking
                                        laws.Please note any information you provide us will be stored securely and in
                                        accordance with our privacy policy.</p>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Date of Birth<sup>*</sup></label>
                                        <input type="text" class="form-control" id="dob" name="dob"
                                            value="{{ old('dob') ? old('dob') : date('m-d-Y', strtotime($user_sender_details->dob)) }}">
                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <error>{{ $message }}</error>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="dashboard-footer receipient-form-footer clearfix">
                                    <a class="normal-btn" href="{{ route('start-over') }}">Start Over</a>
                                    <a class="normal-btn" href="{{ route('recipient-details') }}">Back</a>
                                    <input type="submit" class="active-btn" value="Continue to send money">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/js/jquery.ccpicker.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#phone_no").CcPicker();
            $("#phone_no").CcPicker("setCountryByCode", "US");
            $("#phone_no").CcPicker("readOnly");
            $("#dob").datepicker({
                format: 'mm/dd/yyyy',
                endDate: '-18y'
            });
            $('#dob').on('changeDate', function(ev) {
                $(this).datepicker('hide');
            });
        });
    </script>
@endsection
