@extends('layouts.auth_app')

@section('content')
    <section class="public-main">
        <div class="container">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 log-forms inputer all-pop-ups">
                <div class="log-forms inputer">
                    <form method="POST" role="form" action="{{ route('register') }}" class="form-disable">
                        @csrf

                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="">
                            <div class="log-header">
                                <h1>Submit <span>Profile</span></h1>
                            </div>
                            <div class="step-wizards">
                                <div class="wizard">
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1">
                                            <div class="inner-que">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Date of Birth<sup>*</sup></label>
                                                            <input type="date"
                                                                class="form-control @error('first_name') is-invalid @enderror"
                                                                id="first_name" name="first_name"
                                                                value="{{ old('first_name') }}" autocomplete="first_name"
                                                                autofocus>
                                                            @error('first_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Ethnicity <sup>*</sup></label>
                                                            <select class="form-control">
                                                                <option value="">--Select Ethnicity--</option>
                                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
					<option value="Andaman &amp; Nicobar">Andaman &amp; Nicobar </option>
					<option value="Arunachal Pradesh">Arunachal Pradesh</option>
					<option value="Assam">Assam</option>
					<option value="Bihar">Bihar</option>
					<option value="Chandigarh">Chandigarh</option>
					<option value="Chhattisgarh">Chhattisgarh</option>
					<option value="Dadar &amp; Nagar Haveli">Dadar &amp; Nagar Haveli</option>
					<option value="Daman &amp; Diu">Daman &amp; Diu</option>
					<option value="Delhi">Delhi</option>
					<option value="Lakshadweep">Lakshadweep</option>
					<option value="Puducherry">Puducherry</option>
					<option value="Goa">Goa</option>
					<option value="Gujarat">Gujarat</option>
					<option value="Haryana">Haryana</option>
					<option value="Himachal Pradesh">Himachal Pradesh</option>
					<option value="Jammu &amp; Kashmir">Jammu &amp; Kashmir</option>
					<option value="Jharkhand">Jharkhand</option>
					<option value="Karnataka">Karnataka</option>
					<option value="Kerala">Kerala</option>
					<option value="Madhya Pradesh">Madhya Pradesh</option>
					<option value="Maharashtra">Maharashtra</option>
					<option value="Manipur">Manipur</option>
					<option value="Meghalaya">Meghalaya</option>
					<option value="Mizoram">Mizoram</option>
					<option value="Nagaland">Nagaland</option>
					<option value="Odisha">Odisha</option>
					<option value="Other">Other</option>
					<option value="Punjab">Punjab</option>
					<option value="Rajasthan">Rajasthan</option>
					<option value="Sikkim">Sikkim</option>
					<option value="Tamil Nadu">Tamil Nadu</option>
					<option value="Telangana">Telangana</option>
					<option value="Tripura">Tripura</option>
					<option value="Uttar Pradesh">Uttar Pradesh</option>
					<option value="Uttarakhand">Uttarakhand</option>
					<option value="West Bengal">West Bengal</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="register_email">Gender<sup>*</sup></label>
                                                            <select class="form-control">
                                                            <option value="">--Select Gender--</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="prefernottosay">Prefer not to say</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="current_localtion">Current Location<sup>*</sup></label>
                                                            <input type="text"
                                                                class="form-control @error('current_localtion') is-invalid @enderror"
                                                                id="current_localtion" name="current_localtion"
                                                                value="{{ old('current_localtion') }}"
                                                                autocomplete="current_localtion">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="register_password">Headshot-Image<sup>*</sup></label>
                                                            <input id="register_password" type="file"
                                                                class="form-control @error('register_password') is-invalid @enderror"
                                                                name="register_password" autocomplete="new-password">

                                                            @error('register_password')
                                                                <p class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Introduction Video link<sup>*</sup></label>
                                                            <input id="register_password_confirmation" type="text"
                                                                class="form-control" name="register_password_confirmation"
                                                                autocomplete="new-password">
                                                            @error('register_password_confirmation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <error>{{ $message }}</error>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <ul class="list-inline clearfix none-block" style="padding-top: 15px;">

                                                <li class="pull-right">
                                                    {{-- <button type="submit" class="btn btn-primary scoler-details" data-toggle="modal" data-target="#otp-popup">Submit</button> --}}
                                                    <input type="submit" class="btn scoler-details" value="Submit"
                                                        data-submit-value="Please wait...">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </section>
@endsection
