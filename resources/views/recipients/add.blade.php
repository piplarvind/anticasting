@extends('layouts.account_app')

@section('content')
    <section class="setting-page-sec">
        <div class="container">
            <div class="row">
                @include('layouts.account-left-nav')
                <div class="col-md-8">
                    <div class="profile-info">
                        <h3>{{ isset($recipient_info) ? 'Edit Recipient' : 'Add New Recipient' }}</h3>
                        <div class="dashboard-right">
                            <div class="dashboard-heading">
                                <h4>Recipient Contact Details</h4>
                            </div>
                            <div class="dashboard-body">
                                <div class="receipient-form">
                                    <form method="post" action="{{ route('save-recipient') }}" class="form-disable">
                                        <input type="hidden" name="recipient_id"
                                            value="{{ isset($recipient_info) ? $recipient_info->id : null }}">
                                        @csrf
                                        <div class="form-group">
                                            <label>Bank account no</label>
                                            <input type="text" class="form-control" id="bank_account_no"
                                                name="bank_account_no" placeholder="6546 5465 4587 8795"
                                                value="{{ isset($recipient_info) ? $recipient_info->bank_account_no : old('bank_account_no') }}">
                                            @error('bank_account_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>First Name<sup>*</sup></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                placeholder="John"
                                                value="{{ isset($recipient_info) ? $recipient_info->first_name : old('first_name') }}">
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
                                                value="{{ isset($recipient_info) ? $recipient_info->last_name : old('last_name') }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group cun-code">
                                            <label>Phone Number<sup>*</sup></label>
                                            <input type="text" class="form-control" id="phone_no" name="phone_no"
                                                placeholder="(888) 888-8888"
                                                value="{{ isset($recipient_info) ? $recipient_info->phone_no : old('phone_no') }}">
                                            @error('phone_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <br>
                                        <div class="dashboard-heading">
                                            <h4>Recipient email address</h4>
                                        </div>
                                        <div class="form-group">
                                            <label>Email address (optional)</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="abc@domain.com"
                                                value="{{ isset($recipient_info) ? $recipient_info->email : old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <br>
                                        <div class="dashboard-heading">
                                            <h4>Recipient Address</h4>
                                        </div>
                                        <div class="form-group">
                                            <label>Address<sup>*</sup></label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                value="{{ isset($recipient_info) ? $recipient_info->address : old('address') }}">
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>City<sup>*</sup></label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ isset($recipient_info) ? $recipient_info->city : old('city') }}">
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>State<sup>*</sup></label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                value="{{ isset($recipient_info) ? $recipient_info->state : old('state') }}">
                                            @error('state')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Select Reason for Sending<sup>*</sup></label>
                                            <select class="form-control" name="reason_for_sending" id="reason_for_sending">
                                                <option value="">Select an Option</option>
                                                <option value="FAMILY_SUPPORT"
                                                    @if (isset($recipient_info) && $recipient_info->reason_for_sending == 'FAMILY_SUPPORT') selected @endif>Family Support
                                                </option>
                                                <option value="EDUCATION" @if (isset($recipient_info) && $recipient_info->reason_for_sending == 'EDUCATION') selected @endif>
                                                    Education</option>
                                                <option value="TAX_PAYMENT"
                                                    @if (isset($recipient_info) && $recipient_info->reason_for_sending == 'TAX_PAYMENT') selected @endif>Tax payment</option>
                                                <option value="OTHER" @if (isset($recipient_info) && $recipient_info->reason_for_sending == 'OTHER') selected @endif>
                                                    Other</option>
                                            </select>
                                            @error('reason_for_sending')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="dashboard-footer receipient-form-footer clearfix">
                                            <a class="normal-btn" href="{{ route('recipients') }}">Cancel</a>
                                            <input type="submit" value="{{ __('Submit') }}"
                                                data-submit-value="Please wait..." class="active-btn">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtIy78fIJEFicaUhXBJ0uAFGgsontlwKg&libraries=places"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            google.maps.event.addDomListener(window, 'load', initialize);
            $("#phone_no").CcPicker();
            $("#phone_no").CcPicker("setCountryByPhoneCode",
                "{{ isset($recipient_info) ? $recipient_info->country_code : $country_detail->phone_code }}");
            $("#phone_no").CcPicker("readOnly");
        });

        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }
    </script>
@endsection
