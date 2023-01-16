@extends('layouts.account_app')

@section('content')
    <section class="setting-page-sec">
        <div class="container">
            <div class="row">
                @include('layouts.account-left-nav')
                <div class="col-md-8">
                    @if (session('alert-danger'))
                        <div class="alert alert-danger">
                            {{ session('alert-danger') }}
                        </div>
                    @endif
                    @if (session('alert-class'))
                        <div class="alert alert-success">
                            {{ session('alert-class') }}
                        </div>
                    @endif
                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif
                    <div class="profile-info">
                        <h3>Profile information</h3>
                        <div class="panel-group" id="accordion">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4>Name</h4>
                                                <h4>{{ $user_data->first_name . ' ' . $user_data->last_name }}</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <h4>DOB</h4>
                                                <h4>{{ date('jS M, Y', strtotime($user_data->userInformation->dob)) }}</h4>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="Edit-btn">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapse1">Edit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse {{ $active_tab === 0 ? 'in' : '' }}">
                                    <div class="panel-body">
                                        <form action="{{ route('update-profile') }}" method="post" class="form-disable">
                                            @csrf
                                            <div class="form-group">
                                                <label for="first_name">First Name<sup>*</sup></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    value="{{ old('first_name') }}" placeholder="first name">
                                                @error('first_name')
                                                    <p class="invalid-feedback" role="alert">
                                                        <error>{{ $message }}</error>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name">Last Name<sup>*</sup></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    value="{{ old('last_name') }}" placeholder="last name">
                                                @error('last_name')
                                                    <p class="invalid-feedback" role="alert">
                                                        <error>{{ $message }}</error>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="dob">DOB<sup>*</sup></label>
                                                <input type="date" class="form-control" id="dob" name="dob"
                                                    value="{{ old('dob') }}">
                                                @error('dob')
                                                    <p class="invalid-feedback" role="alert">
                                                        <error>{{ $message }}</error>
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="text-right">
                                                <button type="cancel" class="normal-btn" data-toggle="collapse"
                                                    data-parent="#accordion" href="#collapse1">Cancel</button>
                                                <input type="submit" value="{{ __('Submit') }}"
                                                    data-submit-value="Please wait..." class="active-btn">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h4>Address</h4>
                                                    @if ($user_info->address_line_1)
                                                        <h4>{{ $user_info->address_line_1 . ' ' . $user_info->address_line_2 . ' ' . $user_info->city . ' ' . $user_info->state . ', ' . $user_info->zip_code }}
                                                        @else
                                                            <h5>Please add address</h5>
                                                    @endif
                                                    </h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="Edit-btn">
                                                        <a data-toggle="collapse" data-parent="#accordion"
                                                            href="#collapse2">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse {{ $active_tab == 1 ? 'in' : '' }}">
                                        <div class="panel-body">
                                            <form action="{{ route('update-address') }}" method="post"
                                                class="form-disable">
                                                @csrf
                                                <div class=" form-group">
                                                    <label for="address_line_1">Street address line 1<sup>*</sup></label>
                                                    <input type="text" class="form-control" id="address_line_1"
                                                        name="address_line_1" value="{{ old('address_line_1') }}"
                                                        placeholder="eg. Apt 74">
                                                    @error('address_line_1')
                                                        <p class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class=" form-group">
                                                    <label for="address_line_2">Apartment, suite, unit,
                                                        etc.</label>
                                                    <input type="text" class="form-control" id="address_line_2"
                                                        name="address_line_2" value="{{ old('address_line_2') }}"
                                                        placeholder="eg. Green apartment">
                                                    @error('address_line_2')
                                                        <p class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="city">City<sup>*</sup></label>
                                                    <input type="text" class="form-control" id="city"
                                                        name="city" value="{{ old('city') }}"
                                                        placeholder="Ashford">
                                                    @error('city')
                                                        <p class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="state">State<sup>*</sup></label>
                                                    <input type="text" class="form-control" id="state"
                                                        name="state" value="{{ old('state') }}"
                                                        placeholder="Ashford">
                                                    @error('state')
                                                        <p class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="zip_code">Zipcode<sup>*</sup></label>
                                                    <input type="text" class="form-control" id="zip_code"
                                                        name="zip_code" value="{{ old('zip_code') }}"
                                                        placeholder="412205">
                                                    @error('zip_code')
                                                        <p class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="text-right">
                                                    <button type="cancel" class="normal-btn" data-toggle="collapse"
                                                        data-parent="#accordion" href="#collapse2">Cancel</button>
                                                    <input type="submit" value="{{ __('Submit') }}"
                                                        data-submit-value="Please wait..." class="active-btn">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h4>Mobile Number</h4>
                                                    @if ($user_data->country_code)
                                                        <h4>{{ $user_data->country_code ? '+' . $user_data->country_code : '' }}
                                                            {{ $user_data->mobile_number }}
                                                        </h4>
                                                    @else
                                                        <h5>Please add mobile number</h5>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="Edit-btn">
                                                        <a data-toggle="collapse" data-parent="#accordion"
                                                            href="#collapse3">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse3"
                                        class="panel-collapse collapse {{ $active_tab == 2 ? 'in' : '' }}">
                                        <div class="panel-body">
                                            <form action="{{ route('update-phone-number') }}" method="post"
                                                class="form-disable">
                                                @csrf
                                                <div class="form-group cun-code">
                                                    <label for="mobile_number">Mobile Number<sup>*</sup></label>
                                                    <input type="let" class="form-control" id="mobile_number"
                                                        value="{{ old('mobile_number') }}" name="mobile_number"
                                                        placeholder="987654321">
                                                    @error('mobile_number')
                                                        <p class="invalid-feedback" role="alert">
                                                            <error>{{ $message }}</error>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="text-right">
                                                    <button type="cancel" class="normal-btn" data-toggle="collapse"
                                                        data-parent="#accordion" href="#collapse3">Cancel</button>
                                                    <input type="submit" value="{{ __('Submit') }}"
                                                        data-submit-value="Please wait..." class="active-btn">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h4>Email Address</h4>
                                                    <h4>{{ $user_data->email }}</h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="Edit-btn">
                                                        <a data-toggle="collapse" data-parent="#accordion"
                                                            href="#collapse4">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse4"
                                        class="panel-collapse collapse {{ $active_tab == 3 ? 'in' : '' }}">
                                        <div class="panel-body">
                                            <form action="{{ route('update-user-email') }}" method="post"
                                                class="form-disable">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="email">Email Address<sup>*</sup></label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="abc@domain.com">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback">
                                                            <error>{{ $errors->first('email') }}</error>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <button type="cancel" class="normal-btn" data-toggle="collapse"
                                                        data-parent="#accordion" href="#collapse4">Cancel</button>
                                                    <input type="submit" value="{{ __('Submit') }}"
                                                        data-submit-value="Please wait..." class="active-btn">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h4>Password</h4>
                                                    <h4>••••••••••••</h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="Edit-btn">
                                                        <a data-toggle="collapse" data-parent="#accordion"
                                                            href="#collapse5">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse5"
                                        class="panel-collapse collapse {{ $active_tab == 4 ? 'in' : '' }}">
                                        <div class="panel-body">
                                            <form action="{{ route('update-password') }}" method="post" role="form"
                                                class="form-disable">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="current_password">Current Password<sup>*</sup></label>
                                                    <input type="password" class="form-control" id="current_password"
                                                        name="current_password" placeholder="">
                                                    @if ($errors->has('current_password'))
                                                        <span class="invalid-feedback">
                                                            <error>{{ $errors->first('current_password') }}</error>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">New Password<sup>*</sup></label>
                                                    <input type="password" class="form-control" id="new_password"
                                                        name="new_password" placeholder="">
                                                    @if ($errors->has('new_password'))
                                                        <span class="invalid-feedback">
                                                            <error>{{ $errors->first('new_password') }}</error>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_confirm_password">New Confirm
                                                        Password<sup>*</sup></label>
                                                    <input type="password" class="form-control" id="new_confirm_password"
                                                        name="new_confirm_password" placeholder="">
                                                    @if ($errors->has('new_confirm_password'))
                                                        <span class="invalid-feedback">
                                                            <error>{{ $errors->first('new_confirm_password') }}</error>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <button type="cancel" class="normal-btn" data-toggle="collapse"
                                                        data-parent="#accordion" href="#collapse5">Cancel</button>
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
            </div>
    </section>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#mobile_number").CcPicker();
            $("#mobile_number").CcPicker("setCountryByPhoneCode", "{{ $user_data->country_code }}");
        });
    </script>
@endsection
