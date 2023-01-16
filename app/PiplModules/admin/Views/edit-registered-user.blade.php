@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Update Passenger</title>
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datepicker/jquery-ui.css')}}">
    <script type="text/javascript" src="{{url('public/media/backend/js/jquery-ui.min.js')}}"></script>
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Update Passenger</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashbard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{url('admin/manage-users')}}">Manage Passenger</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Passenger</li>
                </ol>
            </div>
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="update_forms modified_updateform">
                            @if (session('profile-updated'))
                                <div id="ses-succ-msg" class="alert alert-success">
                                    {{ session('profile-updated') }}
                                </div>
                            @endif
                            @if (session('password-update-fail'))
                                <div id="ses-err-msg" class="alert alert-danger">
                                    {{ session('password-update-fail') }}
                                </div>
                            @endif
                            @if (session('email-update-fail'))
                                <div id="ses-err-msg" class="alert alert-danger">
                                    {{ session('email-update-fail') }}
                                </div>
                            @endif
                            <div class="form_tabcontent">
                                <div class="tab-content">
                                    <div id="pers_info">
                                        <form name="frm_regsitered_user_update" id="frm_regsitered_user_update"
                                              role="form" method="post"
                                              action="{{ url('/admin/update-registered-user/'.$user_info->id)}}" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <input type="hidden" id="user_id" name="user_id" value="{{ $user_info->id }}">
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">First Name:<sup style='color:red;'>*</sup></label>
                                                        <div class="col-sm-7">
                                                            <input type="text"
                                                                   class="form-control-plaintext custom_input onPasteAlphabetOnly"
                                                                   id="first_name" placeholder="Enter first name" name="first_name"
                                                                   value="{{old('first_name',$user_info->userInformation->first_name)}}">
                                                            @if ($errors->has('first_name'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Last Name:<sup style='color:red;'>*</sup></label>
                                                        <div class="col-sm-7">
                                                            <input type="text"
                                                                   class="form-control-plaintext custom_input onPasteAlphabetOnly"
                                                                   id="last_name" placeholder="Enter last name" name="last_name"
                                                                   value="{{old('last_name',$user_info->userInformation->last_name)}}">
                                                            @if ($errors->has('last_name'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Mobile:<sup style='color:red;'>*</sup></label>
                                                        <div class="col-sm-7">
                                                            <input type="tel"
                                                                   class="form-control-plaintext custom_input onPasteDigitsOnly"
                                                                   id="user_mobile" placeholder="Enter mobile number" name="user_mobile"
                                                                   value="{{old('user_mobile',$user_info->userInformation->user_mobile)}}">
                                                            <input type="hidden"
                                                                   class="form-control-plaintext custom_input"
                                                                   id="mobile_code" name="mobile_code"
                                                                   value="{{old('mobile_code')}}">
                                                            @if ($errors->has('user_mobile'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('user_mobile') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('user_status') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Status:<sup style='color:red;'>*</sup> </label>
                                                        <div class="col-sm-7">
                                                            <div class="custom_select">
                                                                <select name="user_status" id="user_status">
                                                                    <option value="">--Select Status--</option>
                                                                    <option value="1" @if($user_info->userInformation->user_status == 1) selected @endif>
                                                                        Active
                                                                    </option>
                                                                    <option value="2" @if($user_info->userInformation->user_status == 2) selected @endif>
                                                                        Blocked
                                                                    </option>
                                                                    <option value="3" @if($user_info->userInformation->user_status == 3) selected  @else disabled @endif>
                                                                        Suspended
                                                                    </option>
                                                                </select>
                                                                @if ($errors->has('user_status'))
                                                                    <span class="help-block">
                                                                            <strong>{{ $errors->first('user_status') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Email:</label>
                                                        <div class="col-sm-7">
                                                            <input type="hidden"  name="old_email" value="{{old('old_email',$user_info->email)}}">
                                                            <input type="text"
                                                                   class="form-control-plaintext custom_input" placeholder="Enter email address"
                                                                   id="email" name="email"
                                                                   value="{{old('email',$user_info->email)}}">
                                                            @if ($errors->has('email'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('gender') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Gender:<sup style='color:red;'>*</sup></label>
                                                        <div class="col-sm-7">
                                                            <div class="custom_select">
                                                                <select name="gender" id="gender">
                                                                    <option value="">--Select--</option>
                                                                    <option value="1"
                                                                            @if($user_info->userInformation->gender==1) selected=selected @endif >
                                                                        Male
                                                                    </option>
                                                                    <option value="2"
                                                                            @if($user_info->userInformation->gender==2) selected=selected @endif >
                                                                        Female
                                                                    </option>
                                                                </select>
                                                                @if ($errors->has('gender'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('new_password') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Password:</label>
                                                        <div class="col-sm-7">
                                                            <input type="password"
                                                                   class="form-control-plaintext custom_input" placeholder="Enter password"
                                                                   id="new_password" name="new_password"
                                                                   value="{{old('new_password')}}">
                                                            @if ($errors->has('new_password'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row {{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                                        <label class="col-sm-5 col-form-label text-right">Confirm Password:</label>
                                                        <div class="col-sm-7">
                                                            <input type="password"
                                                                   class="form-control-plaintext custom_input" placeholder="Enter confirm password"
                                                                   id="new_password_confirmation"
                                                                   name="new_password_confirmation"
                                                                   value="{{old('new_password_confirmation')}}">
                                                            @if ($errors->has('confirm_password'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label text-right">Profile
                                                            Image:</label>
                                                        <div class="col-sm-7">
                                                            <input accept=".jpg,.png,.jpeg" type="file" placeholder="Choose profile image"
                                                                   name="profile_picture" id="profile_picture"
                                                                   @if(isset($user_info->userInformation->profile_picture) && $user_info->userInformation->profile_picture!='') value="{{ $user_info->userInformation->profile_picture }}"
                                                                   @endif id="profile_picture"
                                                                   class="form-control-plaintext custom_input">
                                                            <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png') }}';" style="width: 50px;height: 50px; @if(isset($user_info->userInformation->profile_picture) && $user_info->userInformation->profile_picture!='') display: block; @else display: none; @endif"
                                                                 @if($user_info->userInformation->profile_picture) src="{{asset("storage/app/public/user-image/".$user_info->userInformation->profile_picture)}}"
                                                                 @endif id="imagePreview"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" class="btn btn-theme">Update</button>
                                                </div>
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
    <script>
        function getAllStates(country_id) {
            if (country_id != '' && country_id != 0) {
                $.ajax({
                    url: "{{url('/admin/states/getAllStates')}}/" + country_id,
                    method: 'get',
                    success: function (data) {
                        $("#state").html(data);

                    }

                });

            }
        }
        function getAllCities(state_id) {
            if (state_id != '' && state_id != 0) {
                var country_id = $("#country").val();
                $.ajax({
                    url: "{{url('/admin/cities/getAllCitiesDriver')}}/" + country_id + "/" + state_id,
                    method: 'get',
                    success: function (data) {

                        $("#city").html(data);

                    }

                });
            }
        }
        function checkForMax(value, id, control_val) {

            typed_value = ($("#" + id + "_" + control_val).val());
            if (typed_value > value) {
                alert("Max value you can enter is" + value);
                $("#" + id + "_" + control_val).val(value);

            }
        }

        $(function () {
            jQuery.browser = {};
            (function () {
                jQuery.browser.msie = false;
                jQuery.browser.version = 0;
                if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                    jQuery.browser.msie = true;
                    jQuery.browser.version = RegExp.$1;
                }
            })();
            //For Deliveryt Date Calender:
            $("#date_of_birth").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: '-1825',
                changeYear: true,
                yearRange: '-50:+0'
            });
        });
        $('.nav-link').click(function () {
            $("#ses-succ-msg").hide();
            $("#ses-err-msg").hide();
        });


        function resetFormData(id) {
            var validator = $("#" + id).validate();
            validator.resetForm();
        }

        var iti;
        var mobNoLen = "{{ isset($user_info->userInformation->user_mobile)?strlen($user_info->userInformation->user_mobile):'8' }}";
        var chkmobNo = "{{ isset($user_info->userInformation->user_mobile)?$user_info->userInformation->user_mobile:'' }}";
        var chkCtry = '';
        var input_user_mobile = document.querySelector("#user_mobile");
        var defInitCtry = 'in';
        /*var defOlyCtries = ['in', 'kw'];*/
        var defOlyCtries = ['in'];
        $(function () {

            jQuery.validator.addMethod("alphabetsonly", function (value, element) {
                return this.optional(element) || /^[a-zA-Z]+$/.test(value);
            }, "Please enter alphabets only");

            jQuery("#frm_regsitered_user_update").validate({

                errorClass: 'text-danger',
                rules: {
                    first_name:
                        {
                            required: true,
                            alphabetsonly:true,
                            minlength:3,
                            maxlength:128

                        },
                    last_name:
                        {
                            required: true,
                            alphabetsonly:true,
                            minlength:3,
                            maxlength:128
                        },
                    email:
                        {
                            required: true,
                            email:true,
                            remote: {
                                url: javascript_site_path+"/passenger-update-email-validation",
                                type: "post",
                                data:{
                                    id:'{{Request::segment(3)}}'
                                }
                            }

                        },
                    new_password:
                        {
                            strongpassword:true,
                            minlength:7,
//                            remote: {
//                                url: javascript_site_path + 'admin/chk-current-password' + '/' + $('#user_id').val(),
//                                method: 'get'
//                            }

                    },
                    new_password_confirmation:
                        {
                            strongpassword:true,
                            minlength:7,
                            equalTo:"#new_password"
                        },
                    user_status:
                        {
                            required: true
                        },
                    country: {
                        required: true
                    },

                    gender: {
                        required: true
                    },

                    user_mobile: {
                        required: true,
                        digits:true,
                        minlength:function()
                        {
                            var minlen = 10;
                            if($("#mobile_code").val() == '+965')
                            {
                                minlen =  8;
                            }
                            return minlen;
                        },
                        maxlength:function()
                        {
                            var minlen = 10;
                            if($("#mobile_code").val() == '+965')
                            {
                                minlen =  8;
                            }
                            return minlen;
                        },
                        remote: {
                            url: javascript_site_path+"/passenger-update-mobile-validation",
                            type: "post",
                            data:{
                                id:'{{Request::segment(3)}}'
                            }
                        }
                    },

                },
                messages: {

                    first_name: {
                        required: "Please enter first name.",
                        minlength:"Please enter minimum 3 characters",
                        maxlength:"Please enter maximum 128 characters"
                    },
                    last_name: {
                        required: "Please enter last name.",
                        minlength:"Please enter minimum 3 characters",
                        maxlength:"Please enter maximum 128 characters"
                    },
                    email:{
                        required: "Please enter email.",
                        email: "Please enter valid email.",
                        remote:"This email is already taken"
                    },
                    user_status:{
                        required: "Please select status."
                    },
                    new_password: {
                        required: "Please enter password.",
                        minlength: "Please enter minimum 7 characters.",
                        remote:"This password is already taken"
                    },
                    new_password_confirmation: {
                        required: "Please enter confirm password.",
                        minlength: "Please enter minimum 7 characters.",
                        equalTo: "Password and Confirm Password not match."
                    },
                    country: {
                        required: "Please select country."
                    },
                    state: {
                        required: "Please select state."
                    },
                    city: {
                        required: "Please select city."
                    },

                    gender: {
                        required: "Please select gender.",
                    },
                    user_mobile: {
                        required: "Please enter mobile number.",
                        minlength:function()
                        {
                            var minlen = 10;
                            var msg = "Please enter "+minlen+" digits mobile number for india country.";
                            if($("#mobile_code").val() == '+965')
                            {
                                minlen = 8;
                                msg = "Please enter "+minlen+" digits mobile number for kuwait country.";
                            }
                            return msg;
                        },
                        maxlength:function()
                        {
                            var minlen = 10;
                            var msg = "Please enter "+minlen+" digits mobile number for india country.";
                            if($("#mobile_code").val() == '+965')
                            {
                                minlen = 8;
                                msg = "Please enter "+minlen+" digits mobile number for kuwait country.";
                            }
                            return msg;
                        },
                        remote:"Mobile number already exist"
                    }

                }
            });

            if (mobNoLen > 8) {
                defInitCtry = 'in';
            }
            else {
                defInitCtry = 'in';
            }
            iti = window.intlTelInput(input_user_mobile,
                {
                    initialCountry: defInitCtry,
                    onlyCountries: defOlyCtries,
                    utilsScript: javascript_site_path + "public/media/backend/js/utils.js?15"
                });
            var mobileCode = mobNoLen >= 10 ? '+91' : '+965';
            chkCtry = mobNoLen >= 10 ? '+91' : '+965';
            var mobileLen = mobNoLen > 10 ? '10' : '10';
            $("#mobile_code").val(mobileCode);
            $("#user_mobile").val(chkmobNo);
        });
        $("#user_mobile").on("countrychange", function (e, countryData) {
            var flagCode = iti.getSelectedCountryData().dialCode;
            $("#mobile_code").val("+" + flagCode);
            $(this).val('');
            if (chkmobNo != '') {
                if (chkCtry == flagCode) {
                    $("#user_mobile").val(chkmobNo);
                }
            }
        });
    </script>
    <style>
        input[type="file"] {
            display: block;
        }
        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }
        .remove {
            text-align: left;
        }
        .remove:hover {
            background: white;
            color: black;
        }
        .panel img {
            margin: 10px 10px;
        }
        .panel img {
            margin: 10px 10px;
        }
    </style>
@endsection
