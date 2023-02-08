@php
    $action = route('users.submitProfile.store');
    $method = '';
    $submitButton = 'Submit';
    
    if (request()->is('*/submitProfile/edit/*')) {
        $submitButton = 'Update';
        $method = 'PUT';
        $action = route('users.submitProfile.update', $userProfileUpdate->id);
    }
@endphp

@extends('layouts.submit-profile')
@section('header')
    <style>
        #contact_select {
            background: #FFF;
            color: #aaa;
        }

        #contact label {
            color: #000;
            font-size: 17px;
            font-family: "Roboto", Helvetica, Arial, sans-serif;
            font-weight: 500;
        }

        .card-size {
            margin-top: 275px;
        }

        .msgs li {
            list-style-type: none;
            padding: 2px;
            border-bottom: 1px dotted #ccc;
        }

        .show-image {
            margin-right: 200px;
            cursor: pointer;
            font-size: 22px;
            color: blue;
        }

        .card-header {
            background-color: #fff !important;
        }

        .submit-header {
            align-items: center;
            background: #FFF;
            justify-content: space-between;
            padding: 0;
        }

        .title {
            align-items: center;
            text-align: center;
            padding-top: 8px;
        }
        .text-countryCode{
            text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/submit-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/website/css/image-gallery.css') }}" />

    <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
    <script src="{{ asset('assets/auth/toastr.min.js') }}"></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/css/intlTelInput.css" /> --}}
    {{-- @laravelTelInputStyles --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css" rel="stylesheet" /> --}}
    {{-- ck editor  cdn link --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
@endsection
@section('content')
    <section id="contact" class="contact">
        <script>
            @if (Session::has('message'))
                toastr.success("{{ Session::get('message') }}");
            @elseif (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @elseif (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif
        </script>
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row gy-4">

                <div class="col-md-3">
                    @include('submit-profile.left-section')
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="submit-header" @if (!Request::is('*/edit/*')) style="display: flex;" @endif>
                                <div class="title">
                                    <h3 class="text-center" class="m-5" style="color: #bb99ff;">ACTOR PROFILE</h3>
                                </div>
                                @if (isset($userProfile) && $userProfile->id != null)
                                    <div class="edit-btn">
                                        <a href="{{ route('users.submitProfile.edit', $userProfile->id) }}"
                                            style="margin-left:12px;" class="text-right btn btn-secondary">
                                            <span class="fa fa-pencil" aria-hidden="true"></span>
                                            Edit
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ $action }}" enctype="multipart/form-data">
                                @csrf
                                @if ($method == 'PUT')
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="exampleInputName"><b>Firstname</b>&nbsp;<span
                                                    style="color:red;">*</span></label>
                                            <input type="text" name="first_name" class="form-control"
                                                id="exampleInputName" aria-describedby="emailHelp"
                                                placeholder="Enter firstname"
                                                value="{{ old('first_name', isset($userInfo->first_name) ? $userInfo->first_name : '') }}">
                                            @error('first_name')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="last_name"><b>Lastname</b>&nbsp;<span
                                                    style="color:red;">*</span></label>
                                            <input type="text" name="last_name" class="form-control"
                                                id="exampleInputName" aria-describedby="last_name"
                                                value="{{ old('last_name', isset($userInfo->last_name) ? $userInfo->last_name : '') }}"
                                                placeholder="Enter Lastname">
                                            @error('last_name')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label text-secondary text-gradient" id="contact"><b>Contact
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input 
                                            type="text" 
                                            id="code" 
                                            name="countryCode"
                                            class="text-countryCode form-control" 
                                            readonly
                                            value="{{ old('countryCode', isset($userInfo->countryCode) ? $userInfo->countryCode : '')}}"
                                            />
                                            {{-- <input type="text" class="form-control" name="mobile_no"
                                                placeholder="Mobile number" 
                                                value="{{ old('mobile_no', $userInfo->mobile_no) }}"> --}}
                                            {{-- <input type="tel" class="form-control" id="phone" name="mobile_no" placeholder="Mobile number" 
                                            value="{{ old('mobile_no', isset($userInfo->countryCode) ? $userInfo->countryCode : '91'+ $userInfo->mobile_no) }}" /> --}}
                                            <input type="text" class="form-control" name="mobile_no"
                                                placeholder="Mobile number"
                                                value="{{ old('mobile_no', isset($userInfo->mobile_no) ? $userInfo->mobile_no : '') }}"
                                                readonly />
                                            <br />
                                            @error('mobile_no')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                            <span id="mobile_status" style="color:red; font-size:14px"></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="exampleInputEmail"><b>Email-ID
                                                </b>&nbsp;<span style="color:red;">*</span></label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail"
                                                value="{{ old('email', $userInfo->email) }}" placeholder="Enter email"
                                                readonly />
                                            @error('email')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="ethnicity"><b>Ethnicity</b>&nbsp;<span
                                                    style="color:red;">*</span></label>
                                            <select name="ethnicity" class="form-control" id="ethnicity">
                                                <option selected>Please Select</option>

                                                <option value="Andhra Pradesh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Andhra Pradesh') selected
                                                     @elseif(isset($userProfile) && $userProfile->ethnicity == 'Andhra Pradesh')
                                                   
                                                      selected
                                                      @else @endif>
                                                    Andhra Pradesh
                                                </option>
                                                <option value="Andaman &amp; Nicobar"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Andaman & Nicobar') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Andaman & Nicobar')
                                               
                                                  selected @endif>
                                                    Andaman &amp;
                                                    Nicobar </option>
                                                <option value="Arunachal Pradesh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Arunachal Pradesh') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Arunachal Pradesh')
                                               
                                                  selected @endif>
                                                    Arunachal Pradesh
                                                </option>
                                                <option value="Assam"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Assam') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Assam')
                                               
                                                  selected @endif>
                                                    Assam
                                                </option>
                                                <option value="Bihar"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Bihar') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Bihar')
                                               
                                                  selected @endif>
                                                    Bihar
                                                </option>
                                                <option value="Chandigarh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Chandigarh') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Chandigarh')
                                               
                                                  selected @endif>
                                                    Chandigarh</option>
                                                <option value="Chhattisgarh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Chhattisgarh') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Chhattisgarh')
                                               
                                                  selected @endif>
                                                    Chhattisgarh
                                                </option>
                                                <option value="Dadar &amp; Nagar Haveli"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Dadar & Nagar Haveli') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Dadar & Nagar Haveli')
                                               
                                                  selected @endif>
                                                    Dadar &amp;
                                                    Nagar Haveli
                                                </option>
                                                <option value="Daman &amp; Diu"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Daman & Diu') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Daman & Diu')
                                               
                                                  selected @endif>
                                                    Daman &amp; Diu
                                                </option>
                                                <option value="Delhi"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Delhi') selected
                                                  @elseif(isset($userProfile) && $userProfile->ethnicity == 'Delhi')
                                               
                                                  selected @endif>
                                                    Delhi
                                                </option>
                                                <option value="Lakshadweep"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Lakshadweep') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Lakshadweep')
                                               
                                                  selected @endif>
                                                    Lakshadweep</option>
                                                <option value="Puducherry"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Puducherry') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Puducherry')
                                               
                                                  selected @endif>
                                                    Puducherry

                                                </option>
                                                <option value="Goa"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Goa') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Goa')
                                               
                                                  selected @endif>
                                                    Goa
                                                </option>
                                                <option value="Gujarat"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Gujarat') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Gujarat')
                                               
                                                  selected @endif>
                                                    Gujarat
                                                </option>
                                                <option value="Haryana"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Haryana') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Haryana')
                                               
                                                  selected @endif>
                                                    Haryana</option>
                                                <option value="Himachal Pradesh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Himachal Pradesh') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Himachal Pradesh')
                                               
                                                  selected @endif>
                                                    Himachal Pradesh
                                                </option>
                                                <option value="Jammu &amp; Kashmir"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Jammu & Kashmir') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Jammu & Kashmir')
                                               
                                                  selected @endif>
                                                    Jammu &amp; Kashmir
                                                </option>
                                                <option value="Jharkhand"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Jharkhand') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Jharkhand')
                                               
                                                  selected @endif>
                                                    Jharkhand</option>
                                                <option value="Karnataka"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Karnataka') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Karnataka')
                                               
                                                  selected @endif>
                                                    Karnataka</option>
                                                <option value="Kerala"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Kerala') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Kerala')
                                               
                                                  selected @endif>
                                                    Kerala</option>
                                                <option value="Madhya Pradesh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Madhya Pradesh') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Madhya Pradesh')
                                               
                                                  selected @endif>
                                                    Madhya Pradesh
                                                </option>
                                                <option value="Maharashtra"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Maharashtra') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Maharashtra')
                                               
                                                  selected @endif>
                                                    Maharashtra</option>
                                                <option value="Manipur"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Manipur') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Manipur')
                                               
                                                  selected @endif>
                                                    Manipur</option>
                                                <option value="Meghalaya"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Meghalaya') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Meghalaya')
                                               
                                                  selected @endif>
                                                    Meghalaya</option>
                                                <option value="Mizoram"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Mizoram') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Mizoram')
                                               
                                                  selected @endif>
                                                    Mizoram</option>
                                                <option value="Nagaland"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Nagaland') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Nagaland')
                                               
                                                  selected @endif>
                                                    Nagaland</option>
                                                <option value="Odisha"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Odisha') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Odisha')
                                               
                                                  selected @endif>
                                                    Odisha</option>
                                                <option value="Other"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Other') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Other')
                                               
                                                  selected @endif>
                                                    Other
                                                </option>
                                                <option value="Punjab"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Punjab') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Punjab')
                                               
                                                  selected @endif>
                                                    Punjab</option>
                                                <option value="Rajasthan"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Rajasthan') selected
                                                     @elseif(isset($userProfile) && $userProfile->ethnicity == 'Rajasthan')
                                                   
                                                      selected @endif>
                                                    Rajasthan</option>
                                                <option value="Sikkim"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Sikkim') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Sikkim')
                                               
                                                  selected @endif>
                                                    Sikkim</option>
                                                <option value="Tamil Nadu"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Tamil Nadu') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Tamil Nadu')
                                               
                                                  selected @endif>
                                                    Tamil Nadu</option>
                                                <option value="Telangana"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Telangana') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Telangana')
                                               
                                                  selected @endif>
                                                    Telangana</option>
                                                <option value="Tripura"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Tripura') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Tripura')
                                               
                                                  selected @endif>
                                                    Tripura</option>
                                                <option value="Uttar Pradesh"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Uttar Pradesh') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Uttar Pradesh')
                                               
                                                  selected @endif>
                                                    Uttar Pradesh
                                                </option>
                                                <option value="Uttarakhand"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'Uttarakhand') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'Uttarakhand')
                                               
                                                  selected @endif>
                                                    Uttarakhand</option>
                                                <option value="West Bengal"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->ethnicity == 'West Bengal') selected
                                                 @elseif(isset($userProfile) && $userProfile->ethnicity == 'West Bengal')
                                               
                                                  selected @endif>
                                                    West Bengal</option>
                                            </select>
                                            @error('ethnicity')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="gender"><b>Gender
                                                </b>&nbsp;<span style="color:red;">*</span></label>
                                            <select name="gender" class="form-control" id="">
                                                <option value="">Please Select</option>
                                                <option value="male"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->gender == 'male') selected 
                                                      @elseif(isset($userProfile) && $userProfile->gender == 'male')
                                                     
                                                      selected @endif>
                                                    Male</option>
                                                <option value="female"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->gender == 'female') selected 
                                                 @elseif(isset($userProfile) && $userProfile->gender == 'female')
                                                
                                                 selected @endif>
                                                    Female
                                                </option>
                                                <option value="prefernottosay"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->gender == 'prefernottosay') selected 
                                                 @elseif(isset($userProfile) && $userProfile->gender == 'prefernottosay')
                                                 selected @endif>
                                                    Prefer not to say
                                                </option>
                                            </select>
                                            @error('gender')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="exampleDateOfBirth"><b>Date Of
                                                    Birth</b>&nbsp;<span style="color:red;">*</span></label>
                                            @if (isset($userProfile->date_of_birth) != null)
                                                <input type="date" id="date_of_birth" name="date_of_birth"
                                                    class="form-control"
                                                    value="{{ old('date_of_birth', isset($userProfile->date_of_birth) ? $userProfile->date_of_birth : '') }}">
                                            @elseif(isset($userProfileUpdate->date_of_birth) != null)
                                                <input type="date" id="date_of_birth" name="date_of_birth"
                                                    class="form-control"
                                                    value="{{ old('date_of_birth', isset($userProfileUpdate->date_of_birth) ? $userProfileUpdate->date_of_birth : '') }}">
                                            @else
                                                <input type="date" id="date_of_birth" name="date_of_birth"
                                                    class="form-control" value="{{ old('date_of_birth') }}">
                                            @endif
                                            @error('date_of_birth')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="LocationInput"><b>Current Location
                                                </b>&nbsp;<span style="color:red;">*</span></label>
                                            @if (isset($userProfile->current_location) != null)
                                                <input type="text" id="current_location" name="current_location"
                                                    class="form-control" placeholder="Enter a current loaction"
                                                    value="{{ old('current_location', isset($userProfile->current_location) ? $userProfile->current_location : '') }}">
                                            @elseif(isset($userProfileUpdate->current_location) != null)
                                                <input type="text" id="current_location" name="current_location"
                                                    class="form-control" placeholder="Enter a current loaction"
                                                    value="{{ old('current_location', isset($userProfileUpdate->current_location) ? $userProfileUpdate->current_location : '') }}">
                                            @else
                                                <input type="text" id="current_location" name="current_location"
                                                    class="form-control" value="{{ old('current_location') }}"
                                                    placeholder="Enter a current loaction">
                                            @endif
                                            @error('current_location')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="exampleDateOfBirth"><b>Height
                                                </b>&nbsp;<span style="color:red;">*</span></label>
                                            @if (isset($userProfile->height) != null)
                                                <input type="text" id="height" name="height" class="form-control"
                                                    placeholder="Enter your height"
                                                    value="{{ old('height', isset($userProfile->height) ? $userProfile->height : '') }}">
                                            @elseif(isset($userProfileUpdate->current_location) != null)
                                                <input type="text" id="height" name="height" class="form-control"
                                                    placeholder="Enter your height"
                                                    value="{{ old('height', isset($userProfileUpdate->height) ? $userProfileUpdate->height : '') }}">
                                            @else
                                                <input type="text" id="height" name="height"
                                                    placeholder="Enter your height" class="form-control"
                                                    value="{{ old('height') }}">
                                            @endif
                                            @error('height')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="complexions"><b>Complexions
                                                </b>&nbsp;<span style="color:red;">*</span></label>
                                            <select name="complexions" class="form-control" id="">
                                                <option value="">Please Select</option>
                                                <option value="fair"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->complexions == 'fair') selected 
                                                 @elseif(isset($userProfile) && $userProfile->complexions == 'fair')
                                                
                                                 selected @endif>
                                                    Fair
                                                </option>
                                                <option value="medium"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->complexions == 'medium') selected 
                                                 @elseif(isset($userProfile) && $userProfile->complexions == 'medium')
                                                
                                                 selected @endif>
                                                    Medium
                                                </option>
                                                <option value="olive"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->complexions == 'olive') selected 
                                                 @elseif(isset($userProfile) && $userProfile->complexions == 'olive')
                                                
                                                 selected @endif>
                                                    Olive</option>
                                                <option value="brown"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->complexions == 'brown') selected 
                                                 @elseif(isset($userProfile) && $userProfile->complexions == 'brown')
                                                
                                                 selected @endif>
                                                    Brown
                                                </option>
                                                <option value="black"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->complexions == 'black') selected 
                                                 @elseif(isset($userProfile) && $userProfile->complexions == 'black')
                                                 selected @endif>
                                                    Black
                                                </option>
                                                <option value="extremely &amp; fair"
                                                    @if (isset($userProfileUpdate) && $userProfileUpdate->complexions == 'extremely & fair') selected 
                                                 @elseif(isset($userProfile) && $userProfile->complexions == 'extremely & fair')
                                                
                                                 selected @endif>
                                                    Extremely & Fair
                                                </option>
                                            </select>

                                            @error('complexions')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- 
                                 <div class="row">
                                     <div class="col-md-12 col-lg-12 col-sm-12">
                                         <div class="form-group">
                                             <label class="form-label" for="LocationInput"><b>Headshot-Image
                                                 </b>&nbsp;<span style="color:red;">*</span> <b> &nbsp; : &nbsp;Refer
                                                     sample headshot image</b></label>
                                             @if (isset($user->images[0]))
                                                 <div id="sample_headshot">
                                                     <div>
                                                         <img src="{{ asset('upload/profile/' . $user->images[0]->profile_images) }}"
                                                             style="max-width:30%;max-height:30%;"><br>
                                                     </div>
                                                  
                                                    @forelse ($user->images as $image)
                                                        <div>
                                                            <img src="{{ asset('upload/profile/' . $image->profile_images) }}"
                                                                style="max-width:30%;max-height:30%;"><br>
                                                        </div>
                                                    @empty
                                                        <p style="color:red;">No Image</p>
                                                    @endforelse

                                               
                                                 </div>
                                             @endif
                                             <div class="user-image mb-3 text-center">
                                                 <div class="imgPreview"> </div>
                                             </div>

                                             <input type="file" id="select-image" name="headshot_image[]"
                                                 class="" style="color:red;" maxlength="3" multiple="multiple"
                                                 accept="image/*" />
                                             <span style="color:red;"><b>Extension
                                                     (gif,png,jpg,jpeg) size 5kb to 2mb</b>
                                             </span>
                                             @error('headshot_image')
                                                 <span style="color:red;"><b>{{ $message }}</b></span>
                                             @enderror
                                             <output></output>


                                         </div>
                                     </div>

                                 </div>
                                 --}}
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="LocationInput"><b>Choose Language
                                                </b>&nbsp;<span style="color:red;">*</span></label>
                                            <br />

                                            <div class="hide1">
                                                <select name="choose_language" onchange="newSrc(this.value)"
                                                    class="form-control">
                                                    <option value=" ">Choose language</option>
                                                    <option value="videos/sample_video_english.mp4"
                                                        @if (isset($userProfileUpdate) && $userProfileUpdate->choose_language == 'videos/sample_video_english.mp4') selected 
                                                     @elseif(isset($userProfile) && $userProfile->choose_language == 'videos/sample_video_english.mp4')
                                                   
                                                     selected @endif>
                                                        Intro in English

                                                    </option>
                                                    <option value="videos/sample_video_hindi.mp4"
                                                        @if (isset($userProfileUpdate) && $userProfileUpdate->choose_language == 'videos/sample_video_hindi.mp4') selected 
                                                     @elseif(isset($userProfile) && $userProfile->choose_language == 'videos/sample_video_hindi.mp4')
                                                  
                                                     selected @endif>
                                                        Intro in Hindi
                                                    </option>
                                                </select>
                                                @error('choose_language')
                                                    <span style="color:red;"><b>{{ $message }}</b></span>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label text-secondary text-gradient"
                                                for="intro_video_link"><b>Youtube Video Link
                                                </b>&nbsp;<span style="color:red;">*</span></label>

                                            @if (isset($userProfile->intro_video_link) != null)
                                                <input type="text" id="intro_video_link" name="intro_video_link"
                                                    class="form-control" placeholder="Enter intro video link"
                                                    value="{{ old('intro_video_link', isset($userProfile->intro_video_link) ? $userProfile->intro_video_link : '') }}">
                                            @elseif(isset($userProfileUpdate->intro_video_link) != null)
                                                <input type="text" id="intro_video_link" name="intro_video_link"
                                                    class="form-control" placeholder="Enter intro video link"
                                                    value="{{ old('intro_video_link', isset($userProfileUpdate->intro_video_link) ? $userProfileUpdate->intro_video_link : '') }}">
                                            @else
                                                <input type="text" id="intro_video_link" name="intro_video_link"
                                                    class="form-control" placeholder="Enter intro video link"
                                                    value="{{ old('intro_video_link') }}">
                                            @endif
                                            @error('intro_video_link')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <div class="form-group text-secondary text-gradient">
                                            @if (isset($userProfile) && $userProfile->work_reel1 != null)
                                                <div id="" class="yt-video">
                                                    <iframe id="" style="max-width:100%;height:100%;"
                                                        type="video/mp4"
                                                        src="{{ $userProfile->work_reel1 }}?&autoplay=1"frameborder="0"
                                                        allowfullscreen>
                                                    </iframe>

                                                </div>
                                            @elseif (isset($userProfileUpdate) && $userProfileUpdate->work_reel1 != null)
                                                <div id="" class="yt-video">
                                                    <iframe id="" style="max-width:100%;height:100%;"
                                                        type="video/mp4"
                                                        src="{{ $userProfileUpdate->work_reel1 }}?&autoplay=1"frameborder="0"
                                                        allowfullscreen>
                                                    </iframe>

                                                </div>
                                                <label class="form-label text-secondary text-gradient"
                                                    for="WorkReels"><b>Work Reel 1</b></label>
                                                <input type="text" placeholder="Work Reel" class="form-control "
                                                    name="work_reel1" id="work_reel1"
                                                    value="{{ old('work_reel1', isset($userProfileUpdate->work_reel1) ? $userProfileUpdate->work_reel1 : ' ') }}">
                                            @else
                                                <img src="{{ asset('assets/website/images/stop_youtube_icon.jfif') }}"
                                                    style="max-width:50%;height:50%;" id="work_reel1_img"
                                                    alt="" />

                                                <label class="form-label text-secondary text-gradient"
                                                    for="WorkReels"><b>Work Reel 1</b></label>
                                                <input type="text" placeholder="Work Reel" class="form-control reel"
                                                    name="work_reel1" id="work_reel1"
                                                    value="{{ old('work_reel1', isset($userProfileUpdate->work_reel1) ? $userProfileUpdate->work_reel1 : '') }}">
                                                @error('work_reel1')
                                                    <span style="color:red;"><b>{{ $message }}</b></span>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            @if (isset($userProfile) && $userProfile->work_reel2 != null)
                                                <div id="" class="yt-video">
                                                    <iframe id="" style="max-width:100%;height:100%;"
                                                        type="video/mp4" src="{{ $userProfile->work_reel2 }}?&autoplay=1"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>

                                                </div>
                                            @elseif (isset($userProfileUpdate) && $userProfileUpdate->work_reel2 != null)
                                                <div id="" class="yt-video">
                                                    <iframe id="" style="max-width:100%;height:100%;"
                                                        type="video/mp4"
                                                        src="{{ $userProfileUpdate->work_reel2 }}?&autoplay=1"frameborder="0"
                                                        allowfullscreen>
                                                    </iframe>

                                                </div>
                                                <label class="form-label text-secondary text-gradient"
                                                    for="WorkReels"><b>Work Reel 2</b></label>
                                                <input placeholder="Work Reel" class="form-control " type="text"
                                                    name="work_reel2" id="work_reel2"
                                                    value="{{ old('work_reel2', isset($userProfileUpdate->work_reel2) ? $userProfileUpdate->work_reel2 : ' ') }}">
                                            @else
                                                <img src="{{ asset('assets/website/images/stop_youtube_icon.jfif') }}"
                                                    style="max-width:50%;height:50%;" id="work_reel2_img"
                                                    alt="" />

                                                <label class="form-label text-secondary text-gradient"
                                                    for="WorkReels"><b>Work Reel 2</b></label>
                                                <input placeholder="Work Reel" class="form-control reel" type="text"
                                                    name="work_reel2" id="work_reel2"
                                                    value="{{ old('work_reel2', isset($userProfileUpdate->work_reel2) ? $userProfileUpdate->work_reel2 : ' ') }}" />
                                                @error('work_reel2')
                                                    <span style="color:red;"><b>{{ $message }}</b></span>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <div class="form-group text-secondary text-gradient">
                                            @if (isset($userProfile) && $userProfile->work_reel3 != null)
                                                <div id="" class="yt-video">
                                                    <iframe id="" style="max-width:100%;height:100%;"
                                                        type="video/mp4" src="{{ $userProfile->work_reel3 }}?&autoplay=1"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>

                                                </div>
                                            @elseif (isset($userProfileUpdate) && $userProfileUpdate->work_reel3 != null)
                                                <div id="" class="yt-video">
                                                    <iframe id="" style="max-width:100%;height:100%;"
                                                        type="video/mp4"
                                                        src="{{ $userProfileUpdate->work_reel3 }}?&autoplay=1"frameborder="0"
                                                        allowfullscreen>
                                                    </iframe>

                                                </div>
                                                <label class="form-label text-secondary text-gradient"
                                                    for="WorkReels"><b>Work Reel 3</b></label>
                                                <input placeholder="Work Reel" class="form-control " type="text"
                                                    name="work_reel3" id="work_reel3"
                                                    value="{{ old('work_reel3', isset($userProfileUpdate->work_reel3) ? $userProfileUpdate->work_reel3 : ' ') }}">
                                            @else
                                                <img src="{{ asset('assets/website/images/stop_youtube_icon.jfif') }}"
                                                    style="max-width:50%;height:50%;" id="work_reel3_img"
                                                    alt="" />

                                                <label class="form-label text-secondary text-gradient"
                                                    for="WorkReels"><b>Work Reel 3</b></label>
                                                <input placeholder="Work Reel" class="form-control reel" type="text"
                                                    name="work_reel3" id="work_reel3"
                                                    value="{{ old('work_reel3', isset($userProfileUpdate->work_reel3) ? $userProfileUpdate->work_reel3 : ' ') }}" />
                                                @error('work_reel3')
                                                    <span style="color:red;"><b>{{ $message }}</b></span>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <br />
                                    @if ($submitButton == 'Submit' && $userProfile == null )
                                        <button type="submit" style="background:red;" class="btn btn-danger"
                                            id="btnPlay">{{ $submitButton }}</button>
                                    @elseif($submitButton == 'Update')
                                        <button type="submit" class="btn btn-success"
                                            id="btnPlay">{{ $submitButton }}</button>
                                    @endif

                                </center>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @include('submit-profile.right-section')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        var images = @json($userInfo?->images?->pluck('image')?->toArray());
    </script>
    {{-- @laravelTelInputScripts --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/intlTelInput.js"></script> --}}
    <script src="{{ asset('assets/website/js/submit-profile/submit-profile.js') }}"></script>
    <script async defer src="{{ asset('assets/website/js/submit-profile/image-gallery.js') }}"></script>
   
@endsection
