@extends('layouts.submit-profile-new')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/website/css/image-gallery.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{asset('assets/website/css/alertbox.css')}}"/>
@endsection
@section('header')
    @include('include.submitprofile.image-header')
@endsection
@section('content')
 <section id="contact-us" class="contact-us section">

        @if (Session::has('message'))
            <div id="success" title="Success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <form id="profile-valdation" action="{{ route('users.submitProfile.store') }}" method="post">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h6 mb-4">Personal Information</h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">First name</label>
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="first_name" value="{{ old('first_name', $userInfo->first_name) }}" />
                                            @error('first_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Last name</label>
                                            <input type="text" class="form-control" placeholder="Last Name"
                                                name="last_name" value="{{ old('last_name', $userInfo->last_name) }}" />
                                            @error('last_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email"
                                                readonly value="{{ old('email', $userInfo->email) }}" />

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone number</label>
                                            <div class="input-group mb-3">
                                                <!--
                                                            <span class="input-group-text" style="width:10px;">+</span>
                                                            -->
                                                <input type="text" class="form-control" name="countryCode" readonly
                                                    style="width:15px;"
                                                    value="{{ old('countryCode', $userInfo->countryCode) }}" />
                                                <input type="text" class="form-control d-flex text-left" name="mobile_no"
                                                    readonly style="width:248px;"
                                                    value="{{ old('mobile_no', $userInfo->mobile_no) }}" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" placeholder="Date of Birth"
                                                name="date_of_birth"
                                                value="{{ old('date_of_birth', isset($userProfile->date_of_birth) ? $userProfile->date_of_birth : ' ') }}" />

                                            @error('date_of_birth')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="" selected="selected" class="0">
                                                    Gender
                                                </option>
                                                <option value="Male" @if (isset($userProfile->gender) && $userProfile->gender == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if (isset($userProfile->gender) && $userProfile->gender == 'Female') selected @endif>
                                                    Female</option>
                                                <option
                                                    value="prefernottosay"@if (isset($userProfile->gender) && $userProfile->gender == 'prefernottosay') selected @endif>
                                                    Prefer not to say</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Height (CM)</label>
                                            <input type="text" class="form-control" placeholder="Enter height"
                                                name="height"
                                                value="{{ old('height', isset($userProfile->height) ? $userProfile->height : ' ') }}" />
                                            @error('height')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Weight (KG)</label>
                                            <input type="text" class="form-control" placeholder="Enter weight"
                                                name="weight"
                                                value="{{ old('weight', isset($userProfile->weight) ? $userProfile->weight : ' ') }}" />
                                            @error('weight')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Current Location</label>
                                            <input type="text" class="form-control" name="current_location"
                                                placeholder="Enter current location"
                                                value="{{ old('current_location', isset($userProfile->current_location) ? $userProfile->current_location : ' ') }}" />
                                            @error('current_location')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ethnicity</label>
                                            <select name="ethnicity" id="ethnicity" class="form-control">
                                                <option value="" selected="selected" class="0">
                                                    Select Ethnicity
                                                </option>
                                                @if (isset($states))
                                                    @foreach ($states as $item)
                                                        <option value="{{ $item->value }}"
                                                            @if (isset($userProfile->ethnicity) && $userProfile->ethnicity == $item->value) selected @endif>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('ethnicity')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h6 mb-4">Work Reels</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="work_reel1"
                                                placeholder="Work Reel 1"
                                                value="{{ old('work_reel1', isset($userProfile->work_reel1) ? $userProfile->work_reel1 : ' ') }}" />
                                            @error('work_reel1')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="work_reel2"
                                                placeholder="Work Reel 2"
                                                value="{{ old('work_reel2', isset($userProfile->work_reel2) ? $userProfile->work_reel2 : ' ') }}" />
                                            @error('work_reel2')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="work_reel3"
                                                placeholder="Work Reel 3"
                                                value="{{ old('work_reel3', isset($userProfile->work_reel3) ? $userProfile->work_reel3 : ' ') }}" />
                                            @error('work_reel3')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" style="background-color: #ff5b00;" class="btn btn-sm" id="btn"
                            value="Submit" tabindex="75">
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    @include('submit-profile-new.right-section')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        var images = @json($userInfo?->images?->pluck('image')?->toArray());
    </script>
    <script src="{{ asset('assets/website/js/submit-profile/image-gallery.js') }}"></script>
    <script>
        $(function() {
            $("#success").dialog({
                autoOpen: true,
                modal: true,
                width: 350,
                height: 150,
                  buttons: [
                    // {
                    //     text: 'Yes, proceed!',
                    //     open: function() {
                    //         $(this).addClass('yescls')
                    //     },
                    //     click: function() {
                    //         $(this).dialog("close")
                    //     }
                    // },
                    {
                        text: "OK",
                        open: function() {
                            $(this).addClass('okcls')
                        },
                        click: function() {
                            $(this).dialog("close")
                        }
                    }
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
