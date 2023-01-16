@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Update Sub Admin</title>
@endsection

@section('content')
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Update Sub Admin</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{url('admin/admin-users')}}">Manage Sub Admins</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Sub Admin</li>
                </ol>
            </div>
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
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="update_forms update_user modified_updateform ">
                            <form  name="frm_admin_update" enctype="multipart/form-data" id="frm_admin_update" role="form" method="POST" action="{{ url('/admin/update-admin-user/'.$user_info->id)}}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <input type="hidden" id="user_id" value="{{ $user_info->id }}">
                                    <div class="col-sm-6">
                                        <div class="form-group row{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">First Name:<sup style='color:red;'>*</sup></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control-plaintext custom_input onPasteAlphabetOnly" id=first_name name="first_name" value="{{old('first_name',$user_info->userInformation->first_name)}}">
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
                                                <input type="text" class="form-control-plaintext custom_input onPasteAlphabetOnly" id="last_name" name="last_name" value="{{old('last_name',$user_info->userInformation->last_name)}}">
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Email:<sup style='color:red;'>*</sup></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control-plaintext custom_input" id="email" name="email" value="{{old('email',$user_info->email)}}">
                                                <input type="hidden" class="form-control-plaintext custom_input" id="old_email" name="old_email" value="{{$user_info->email}}">

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('role') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Role:<sup style='color:red;'>*</sup></label>
                                            <div class="col-sm-7">
                                                <div class="custom_select">
                                                    <select name="role" class="form-control" id="role">
                                                        @if(count($roles)>0)
                                                            @foreach($roles as $role)
                                                                @if($role->slug!='role.company' && $role->slug!='role.agent' && $role->slug!='role.agentmanager' && $role->slug!='role.free_toner')
                                                                    <option @if(isset($user_role) && $user_role->role_id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                @if ($errors->has('role'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('role') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('new_password') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Password:</label>
                                            <div class="col-sm-7">
                                                <input type="password" class="form-control-plaintext custom_input" id="new_password" name="new_password" value="{{old('new_password')}}">
                                                @if ($errors->has('new_password'))
                                                    <span class="help-block">
                                                             <strong>{{ $errors->first('new_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Confirm Password:</label>
                                            <div class="col-sm-7">
                                                <input type="password" class="form-control-plaintext custom_input" id="confirm_password" name="confirm_password" value="{{old('confirm_password')}}">
                                                @if ($errors->has('confirm_password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('country') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Country:<sup style='color:red;'>*</sup></label>
                                            <div class="col-sm-7">
                                                <div class="custom_select">
                                                    <select name="country" onchange="valCtryMobNo(this)"  id="country">
                                                        @foreach($countries as $country)
                                                            @if($country->id=='17')
                                                                <option value="{{$country->id}}" @if(isset($user_country)&&($user_country==$country->id)) selected @endif>--{{$country->name}}--</option>
                                                            @else
                                                                <option value="{{$country->id}}" @if(isset($user_country)&&($user_country==$country->id)) selected @endif>{{$country->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Mobile No:<sup style='color:red;'>*</sup></label>
                                            <div class="col-sm-7">
                                                <input type="tel" class="form-control-plaintext custom_input onPasteDigitsOnly" id="user_mobile" name="user_mobile" value="{{old('user_mobile',$user_info->userInformation->user_mobile)}}">
                                                <input type="hidden" class="form-control-plaintext custom_input" id="mobile_code" name="mobile_code" value="{{old('mobile_code')}}">
                                                @if ($errors->has('user_mobile'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_mobile') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row {{ $errors->has('gender') ? ' has-error' : '' }}">
                                            <label class="col-sm-5 col-form-label text-right">Gender:<sup style='color:red;'>*</sup> </label>
                                            <div class="col-sm-7">
                                                <div class="custom_select">
                                                    <select name="gender" id="gender">
                                                        <option value=""  >--Select--</option>
                                                        <option value="1" @if($user_info->userInformation->gender==1) selected=selected @endif >Male</option>
                                                        <option value="2" @if($user_info->userInformation->gender==2) selected=selected @endif >Female</option>
                                                    </select>
                                                </div>
                                                @if ($errors->has('gender'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('gender') }}</strong>
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
                                                        <option value="0" @if($user_info->userInformation->user_status==0) selected=selected @endif>Inactive</option>
                                                        <option value="1" @if($user_info->userInformation->user_status==1) selected=selected @endif>Active</option>
                                                        <option value="2" @if($user_info->userInformation->user_status==2) selected=selected @endif>Blocked</option>
                                                    </select>
                                                </div>
                                                @if ($errors->has('user_status'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_status') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-md-5 col-form-label text-right">Default Time Period:<sup style='color:red;'>*</sup></label>
                                            <div class="col-sm-7">
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
                                            <label class="col-md-5 col-form-label text-right">Default Region:<sup style='color:red;'>*</sup></label>
                                            <div class="col-md-7">
                                                <select class="form-control" name="region" id="region">
                                                    <option value="" >--Select--</option>
                                                    @foreach($cities as $state)
                                                    <optgroup label="{{ $state->name }}">
                                                        @foreach($state->cityInfo as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    @endforeach
                                                    {{--@foreach($all_zone as $zone)
                                                        <option @if(isset($dashboard_Detail) && count($dashboard_Detail)>0 && $dashboard_Detail->region == $zone->id) selected @endif value="{{$zone->id}}">{{$zone->zone_name}}</option>
                                                    @endforeach--}}
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
                                            <label class="col-sm-5 col-form-label text-right">Profile Image:</label>
                                            <div class="col-sm-7">
                                                <input type="file" placeholder="Choose profile image"
                                                       name="profile_picture"
                                                       @if(isset($user_info->userInformation->profile_picture) && $user_info->userInformation->profile_picture!='') value="{{ $user_info->userInformation->profile_picture }}"
                                                       @endif id="profile_picture"
                                                       class="form-control-plaintext custom_input">
                                                        <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png')  }}';" style="width: 50px;height: 50px; @if(isset($user_info->userInformation->profile_picture) && $user_info->userInformation->profile_picture!='') display: block; @else display: none; @endif"
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
    </section>
    <script>

        $(function () {
            $("#frm_admin_update").validate({

                errorClass: 'text-danger',
                rules: {
                    first_name:
                        {
                            required: true,
                            //  alphabetsonly:true,
                            minlength:3,
                            maxlength:128
                        },
                    last_name:
                        {
                            required: true,
                            // alphabetsonly:true,
                            minlength:3,
                            maxlength:128
                        },
                    email:
                        {
                            required: true,
                            email:true,
                            remote: {
                                url: javascript_site_path+'/check-subadmin-email-update',
                                type: "POST",
                                data:{
                                    id:'{{Request::segment(3)}}'
                                }
                            }
                        },
                    user_status:
                        {
                            required: true
                        },
                    new_password:
                        {
                            strongpassword:true,
                            minlength:7,
//                        remote: {
//                        url: javascript_site_path + 'admin/chk-current-password' + '/' + $('#user_id').val(),
//                         method: 'get'
//                        }
                    },
                    password_confirmation:
                        {
                            required:function(){
                                return $("#new_password").val()!='';
                            },
                            /*strongpassword:true,
                            minlength:7,*/
                            equalTo:"#new_password"
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
                        minlength:10,
                        maxlength:10,
                        remote: {
                            url: javascript_site_path+'/check-subadmin-mobile-update',
                            type: "POST",
                            data:{
                                id:'{{Request::segment(3)}}'
                            },
                        }
                        /*minlength:function()
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
                        }*/
                    },
                    role:{
                        required: true
                    }
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
                        minlength:"Please enter minimum 7 characters.",
                        remote:"This password is already taken"
                    },
                    password_confirmation: {
                        required: "Please enter confirm password.",
                        minlength:"Please enter minimum 7 characters.",
                        equalTo: "Password and Confirm Password not match."
                    },
                    country: {
                        required: "Please select country."
                    },
                    gender: {
                        required: "Please select gender."
                    },
                    user_mobile: {
                        required: "Please enter mobile number.",
                        remote:"Mobile number already exists.",
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
                            {   minlen = 8;
                                msg = "Please enter "+minlen+" digits mobile number for kuwait country.";
                            }
                            return msg;
                        }
                    },
                    role:{
                        required: "Please select user role."
                    }
                }
            });
        });


        var iti;
        var mobNoLen = "{{ isset($user_info->userInformation->user_mobile)?strlen($user_info->userInformation->user_mobile):'8' }}";
        var chkmobNo = "{{ isset($user_info->userInformation->user_mobile)?$user_info->userInformation->user_mobile:'' }}";
        var chkCtry = '';
        var cntryId = "{{ isset($user_country) && $user_country != ''?$user_country:'' }}";
        var input_user_mobile = document.querySelector("input[name='user_mobile']");
        var defInitCtry = 'in';
        /*var defOlyCtries = ['in', 'kw'];*/
        var defOlyCtries = ['in'];
        /*defInitCtry = mobNoLen >8 ? 'in' :'in';
        if(cntryId !='')
        {
            if(cntryId =='10')
            {
                defOlyCtries = ['in'];
            }
            else if(cntryId =='82')
            {
                defOlyCtries = ['kw'];
            }
        }*/
        $(function ()
        {
            iti = window.intlTelInput(input_user_mobile,
                {
                    initialCountry: defInitCtry,
                    onlyCountries: defOlyCtries,
                    utilsScript: javascript_site_path +"public/media/backend/js/utils.js?15"
                });

            var mobileCode = mobNoLen > 8?'+91':'+965';
            chkCtry = mobNoLen > 8?'+91':'+965';
            var mobileLen = mobNoLen > 8?'10':'8';
            $("#mobile_code").val(mobileCode);
            $("input[name='user_mobile']").val(chkmobNo);
        });
    </script>
    <script type="text/javascript">
        var selected_region = "{{ isset($dashboard_Detail->region)?$dashboard_Detail->region:'' }}";
        $("#region").val(selected_region);
        $("#user_mobile").on("countrychange", function (e, countryData)
        {
            var flagCode = iti.getSelectedCountryData().dialCode;
            $("#mobile_code").val("+" +flagCode);
            $("#user_mobile").val('');
            if(chkmobNo != '')
            {
                if(chkCtry == flagCode)
                {
                    $("#user_mobile").val(chkmobNo);
                }
            }
        });
        $('.nav-link').click(function ()
        {
            $("#ses-succ-msg").hide();
            $("#ses-err-msg").hide();
        });

        $(function () {
            $("#new_password, #confirm_password").on('change keyup paste', function ()
            {
                var isValid = false;
                var regex = /^[0-9-+()]*\d{10}$/;
                isValid = regex.test($(this).val());
                $("#spnError").css("display", !isValid ? "block" : "none");
                return isValid;
            });
        });

        $("#profile_picture").on("change", function (e) {
            var flag = '0';
            var fileName = e.target.files[0].name;
            var arr_file = new Array();
            arr_file = fileName.split('.');
            var file_ext = arr_file[1];
            if (file_ext == 'jpg' || file_ext == 'JPG' || file_ext == 'jpeg' || file_ext == 'JPEG' || file_ext == 'png' || file_ext == 'PNG' || file_ext == 'mpeg' || file_ext == 'MPEG' || file_ext == 'img' || file_ext == 'IMG' || file_ext == 'bpg' || file_ext == 'GIF' || file_ext == 'gif') {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("#imagePreview").show();
                        $("#imagePreview").attr("src", e.target.result);
                    });
                    fileReader.readAsDataURL(f);
                }
            }
            else {
                $("#profile_picture").val('');
                alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
                return false;
            }

        });
        function valCtryMobNo(e)
        {
            var initCtry = 'kw';
            var olyCtries = ['in', 'kw'];

            if($(e).val() == '10')
            {
                initCtry = 'in';
                olyCtries = ['in'];

            }
            else if($(e).val() == '82')
            {
                initCtry = 'kw';
                olyCtries = ['kw'];

            }
            iti = window.intlTelInput(input_user_mobile,
                {
                    initialCountry: initCtry,
                    onlyCountries: olyCtries,
                    utilsScript: javascript_site_path +"public/media/backend/js/utils.js?15"
                });

            $("input[name='user_mobile']").val('');

            if($(e).val() == '82')
            {
                $("#mobile_code").val('+965');
            }
            else{
                $("#mobile_code").val('+91');
            }
        }

    </script>
@endsection
