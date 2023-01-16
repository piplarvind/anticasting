@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>My Account</title>
@endsection

@section('content')
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">My Account</h3>
            </div>
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="update_forms update_user modified_updateform">
                            <div class="driverview_custtab">
                                <ul class="nav nav-pills cust_nav">
                                    <li class="nav-item">
                                        <a class="nav-link @if(!($errors->has('email') || $errors->has('new_password') || $errors->has('confirm_password') || $errors->has('confirm_email') || session('password-update-fail') || session('password-update-success'))) active @endif" data-toggle="pill" href="#pers_info">Personal Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($errors->has('email') || $errors->has('confirm_email') || session('register-success')|| session('issue-profile')) active @endif" data-toggle="pill" href="#email_info">Change Email</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail') || session('password-update-success')) active @endif" data-toggle="pill" href="#pwd_info">Change Password</a>
                                    </li>
                                </ul>
                            </div>
                            @if (session('profile-updated'))
                                <div class="alert alert-success">
                                    {{ session('profile-updated') }}
                                </div>
                            @endif
                            @if (session('password-update-success'))
                                <div class="alert alert-success">
                                    {{ session('password-update-success') }}
                                </div>
                            @endif
                            @if (session('password-update-fail'))
                                <div class="alert alert-danger">
                                    {{ session('password-update-fail') }}
                                </div>
                            @endif

                            <div class="form_tabcontent">
                                <div class="tab-content">
                                    <div class="tab-pane container @if(!($errors->has('email') || $errors->has('new_password') || $errors->has('confirm_password') || $errors->has('confirm_email') || session('password-update-fail') || session('password-update-success'))) active @endif" id="pers_info">
                                        <form name="update_profile"  id="update_profile" role="form" method="POST" @if(Auth::user()->userInformation->user_type == '1') action="{{ url('/admin/update-profile-post') }}" @else action="{{ url('/agent/update-profile-post') }}" @endif enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group row{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">First Name :<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext custom_input" placeholder="Enter First Name" value="{{old('first_name',$user_info->userInformation->first_name)}}" name="first_name">
                                                            @if ($errors->has('first_name'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Last Name :<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control-plaintext custom_input" placeholder="Enter Last Name" value="{{old('last_name',$user_info->userInformation->last_name)}}" name="last_name">
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
                                                        <label class="col-sm-4 col-form-label">Mobile:<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">

                                                            <input type="tel" placeholder="Enter mobile number" class="form-control-plaintext custom_input onPasteDigitsOnly" id="user_mobile" name="user_mobile" value="{{old('user_mobile',$user_info->userInformation->user_mobile)}}">
                                                            @if ($errors->has('user_mobile'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('user_mobile') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="mobile_code" name="mobile_code">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row{{ $errors->has('gender') ? ' has-error' : '' }}">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Gender :<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">
                                                            <div class="custom_select">
                                                                <select name="gender" id="gender">
                                                                    <option value=""  >--Select--</option>
                                                                    <option value="1" @if($user_info->userInformation->gender==1) selected=selected @endif >Male</option>
                                                                    <option value="2" @if($user_info->userInformation->gender==2) selected=selected @endif >Female</option>

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
                                                    <div class="form-group row">
                                                        <label class="col-md-4 control-label">Default Time Period:<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">
                                                            <div class="custom_select">
                                                                <select  class="form-control" name="default_time_period" id="default_time_period">
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->default_time_period == '') selected @endif value="">Type</option>
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->default_time_period == '1') selected @endif value="1">Today</option>
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->default_time_period == '2') selected @endif value="2">Weekly</option>
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->default_time_period == '3') selected @endif value="3">Monthly</option>
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->default_time_period == '4') selected @endif value="4">Quarterly</option>
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->default_time_period == '5') selected @endif value="5">Annualy</option>
                                                                </select>
                                                                @if ($errors->has('default_time_period'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('default_time_period') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-4 control-label">Default City:<sup style="color: red">*</sup></label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="city" id="city">
                                                                <option value="">Select City</option>
                                                                {{--@foreach($all_zone as $zone)
                                                                    <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->region == $zone->id) selected @endif value="{{$zone->id}}">{{$zone->zone_name}}</option>
                                                                @endforeach--}}
                                                                @foreach($cities as $city)
                                                                    <option @if(isset($dashboard_Detail) && $dashboard_Detail->region == $city['id']) selected @endif  value="{{$city['id']}}">{{$city['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('region'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('region') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Profile Image</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" class="form-control-plaintext custom_input" name="profile_image" id="profile_image">
                                                            @if(isset($user_info->userInformation)&& count($user_info->userInformation)>0 && $user_info->userInformation->profile_picture !='' && isset($user_info->userInformation->profile_picture))
                                                                @if(Auth::user()->userInformation->user_type == '1' || Auth::user()->userInformation->user_type == '2')
                                                                    <div id="image-holder" class="thumb-image"><img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png') }}';"  style="border-radius:50%;" src="{{asset("storage/app/public/user-image/".$user_info->userInformation->profile_picture)}}" class="thumb-image" width="50" height="50"></div>
                                                                @else
                                                                    <div id="image-holder" class="thumb-image"><img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png') }}';"  style="border-radius:50%;" src="{{asset("storage/app/public/agent-image/".$user_info->userInformation->profile_picture)}}" class="thumb-image" width="50" height="50"></div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="submit" class="btn btn-theme">Update</button>
                                                    <a href="{{url('admin/dashboard')}}" class="btn btn-theme">
                                                        Cancel
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane container @if($errors->has('email') || $errors->has('confirm_email') || session('register-success')|| session('issue-profile')) active @endif" id="email_info">
                                        <form name="admin-update-email-form"  id="admin-update-email-form" role="form" method="POST" @if(Auth::user()->userInformation->user_type == '1') action="{{ url('/admin/update-admin-email') }}" @else action="{{ url('/agent/update-admin-email') }}" @endif>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Current Email: </label>
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">{{$user_info->email}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">New Email :</label>
                                                        <div class="col-sm-8">
                                                            <input name="email" id="email" type="email" class="form-control-plaintext custom_input" placeholder="Enter new email" value="{{old('email')}}">
                                                            @if ($errors->has('email'))
                                                                <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Confirm Email :</label>
                                                        <div class="col-sm-8{{ $errors->has('confirm_email') ? ' has-error' : '' }}">
                                                            <input id="confirm_email" name="confirm_email" type="email" class="form-control-plaintext custom_input" placeholder="Confirm email" value="{{old('confirm_email')}}">
                                                            @if ($errors->has('confirm_email'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('confirm_email') }}</strong>
                                                                </span>
                                                            @endif
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
                                    <div class="tab-pane container @if($errors->has('new_password') || $errors->has('confirm_password') || session('password-update-fail') || session('password-update-success')) active @endif" id="pwd_info">
                                        <form name="update_password"  id="update_password" role="form" method="POST" @if(Auth::user()->userInformation->user_type == '1') action="{{ url('/admin/change-password-post') }}" @else action="{{ url('/agent/change-password-post') }}" @endif>
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group row{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">New Password :<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">
                                                            <input id="new_password" name="new_password" type="password" class="form-control-plaintext custom_input" placeholder="Password" value="{{old('new_password')}}">
                                                            @if ($errors->has('new_password'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Confirm Password :<sup style="color: red">*</sup></label>
                                                        <div class="col-sm-8">
                                                            <input id="confirm_password" name="confirm_password" type="password" class="form-control-plaintext custom_input" placeholder="Confirm Password" value="{{old('confirm_password')}}">
                                                            @if ($errors->has('confirm_password'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                                                </span>
                                                            @endif
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
            var mobileCode = mobNoLen > 10 ? '+91' : '+965';
            chkCtry = mobNoLen > 10 ? '+91' : '+965';
            var mobileLen = mobNoLen > 10 ? '10' : '10';
            $("#mobile_code").val(mobileCode);
            $("#user_mobile").val(chkmobNo);

            $('#admin-update-email-form').validate({
                errorClass: 'text-danger',
                rules:{
                    email:{
                        required:true,
                        email:true,
                        remote: {
                            url: javascript_site_path+"/check-admin-email-before-update",
                            type: "get",
                            data: {},
                            }
                    },
                    confirm_email:{
                        required:true,
                        email:true,
                        equalTo:"#email"
                    },

                },
                messages:{
                    email:{
                        required:"Please enter new email.",
                        email:"Please enter valid email.",
                        remote: "Email id already exist."
                    },
                    confirm_email:{
                        required:"Please confirm email.",
                        email:"Please enter valid email.",
                    },
                },
                submitHandler:function (form) {
                    form.submit();
                }
            });

            $('#update_password').validate({
                errorClass: 'text-danger',
                rules:{
                    new_password:{
                        required:true,
                    },
                    confirm_password:{
                        required:true,
                        equalTo:"#new_password"
                    },

                },
                messages:{
                    new_password:{
                        required:"Please enter new password.",
                        minlength:"The new password must be at least 7 characters"
                    },
                    confirm_password:{
                        required:"Please confirm password.",
                        equalTo:"Confirm password should be same as password"
                    },
                },
                submitHandler:function (form) {
                    form.submit();
                }
            });

            jQuery("#update_profile").validate({

                errorClass: 'text-danger',
                rules: {
                    first_name:
                        {
                            required: true,
                            alphabetsonly: true,
                            minlength:3,
                            maxlength:128

                        },
                    last_name:
                        {
                            required: true,
                            alphabetsonly: true,
                            minlength:3,
                            maxlength:128
                        },
                    user_mobile:{
                        required:true,
                        digits:true,
                        minlength:10,
                        maxlength:10

                    },
                    gender:
                        {
                            required: true
                        },
                    default_time_period:{
                        required:true,
                    },
                    city:{
                        required:true,
                    }

                },
                messages: {
                    first_name:{
                        required: "Please enter first name.",
                        minlength:"Please enter minimum 3 characters",
                        maxlength:"Please enter maximum 128 characters",
                        alphabetsonly:"Please enter alphabets only"
                    },
                    last_name:{
                        required: "Please enter last name.",
                        minlength:"Please enter minimum 3 characters",
                        maxlength:"Please enter maximum 128 characters",
                        alphabetsonly:"Please enter alphabets only"
                    },
                    user_mobile:{
                        required:"Please enter mobile number",
                        digits:"Please enter valid mobile number",
                        minlength:"Mobile number should not be less than 10 digit",
                        maxlength:"Mobile number should not be more than 10 digit"

                    },
                    gender: {
                        required: "Please select gender"
                    },
                    default_time_period:{
                        required:"Please select default time period",
                    },
                    region:{
                        required:"Please select city",
                    }


                },
                submitHandler: function(form) {

                    form.submit();
                }
            });

        });
        $("#user_mobile").on("countrychange", function (e, countryData) {
            var flagCode = iti.getSelectedCountryData().dialCode;
            console.log(flagCode);
            $("#mobile_code").val("+" + flagCode);
            $(this).val('');
            if (chkmobNo != '') {
                if (chkCtry == flagCode) {
                    $("#user_mobile").val(chkmobNo);
                }
            }
        });

        $("#profile_image").change(function () {
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $(this).val('');
                alert("Only formats are allowed : " + fileExtension.join(', '));
            } else {
                if (typeof (FileReader) != "undefined") {
                    var image_holder = $("#image-holder");
                    image_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img />", {
                            "src": e.target.result,
                            "width": '50',
                            "hight": '50',
                            "class": "thumb-image"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                    $(this).prev().css('display', 'none')
                } else {
                    alert("This browser does not support FileReader.");
                }
            }
        });
    </script>

@endsection
