@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>View Sub-Admin</title>
@endsection

@section('content')
    <section class="driver_view tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">View Sub Admin</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{url('admin/admin-users')}}">Manage Sub Admin</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">View Sub Admin</li>
                </ol>
            </div>@if (session('update-user-status'))
                <div class="alert alert-success">
                    {{ session('update-user-status') }}
                </div>
            @endif
            <div class="tabcontent_inner">
                <div class="tcpart_inner">
                    <div class="tab_headings clearfix">
                        <h3 class="float-left"><span style="margin-right: 5px">#@if(count($user_info)>0) {{ $user_info->id }} @endif</span>@if(count($user_info)>0 && isset($user_info->userInformation)){{ $user_info->userInformation->first_name.' '.$user_info->userInformation->last_name }}@endif</h3>
                        <a class="text-right" style="margin-left:20px" href="{{url("/admin/update-admin-user").'/'. Request::segment(3)}}" data-toggle="tooltip" data-placement="top" title="Edit"><img class="text-right" src="{{url('public/media/backend/images/edit-icon.png')}}" alt="Edit"></a>
                        <form style="display:inline-block;" id="delete_user_{{Request::segment(3)}}" method="post" action="{{url("/admin/delete-admin-user").'/'. Request::segment(3)}}">{{ method_field("DELETE") }} {!! csrf_field() !!}<img class="text-right" onclick="confirmDelete({{Request::segment(3)}})" src="{{url('public/media/backend/images/delete-icon.png')}}" alt="Delete"></form>
                    </div>
                    <div class="driverview_tabs">
                        <div class="driverview_custtab">
                            <ul class="nav nav-pills cust_nav">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#driver_tab1">Details</a>
                                </li><div class="col-sm-1">
                                    <a href="{{url('admin/view-admin-print-count').'/'.Request::segment(3)}}">
                                        <i class="fa fa-print fa-2x" aria-hidden="true" style="color:#ee3900;"></i>
                                    </a>
                                </div>
                            </ul>
                        </div>
                        <div class="driverview_custtabContent">
                            <div class="tab-content">
                                <div class="tab-pane active" id="driver_tab1">
                                    <div class="container-fluid">
                                        <div class="profile_nninfo">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="profile_picture text-center">
                                                        <div class="PDImage">
                                                            @if(isset($user_info->userInformation->profile_picture) && $user_info->userInformation->profile_picture!='')
                                                                <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png')  }}';"  style="width: 100px;height: 100px;"
                                                                     @if($user_info->userInformation->profile_picture) src="{{asset("storage/app/public/user-image/".$user_info->userInformation->profile_picture)}}"
                                                                     @endif id="imagePreview"/>
                                                            @else
                                                                <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png')  }}';"  style="width: 100px;height: 100px;" src="{{ url('public/media/backend/images/profilew.png')  }}">
                                                            @endif
                                                        </div>
                                                        <div class="profile_driver_meta text-center">
                                                            <div class="driverstatus_dr mb_10">
                                                                @if(count($user_info)>0 && isset($user_info->userInformation))
                                                                    @if($user_info->userInformation->user_status== 1)
                                                                        Active
                                                                    @elseif($user_info->userInformation->user_status== 2)
                                                                        Blocked
                                                                    @else
                                                                        Inactive
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Name</label>
                                                        <div class="driverinfodata_shown">@if(count($user_info)>0 && isset($user_info->userInformation)){{ $user_info->userInformation->first_name.' '.$user_info->userInformation->last_name }}@endif</div>
                                                    </div>
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Role</label>
                                                        {{--<div class="driverinfodata_shown">
                                                            @if(count($roles)>0)
                                                                @foreach($roles as $role)
                                                                    @if($role->slug!='role.company' && $role->slug!='role.agent' && $role->slug!='role.agentmanager' && $role->slug!='role.free_toner')
                                                                        @if(isset($user_role) && $user_role->role_id == $role->id)
                                                                            {{$role->name}}
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>--}}
                                                        <div class="driverinfodata_shown">{{$roles->name}}</div>
                                                    </div><div class="driver_infodata">
                                                        <label class="driverinfodata_label">Gender</label>
                                                        <div class="driverinfodata_shown">
                                                            @php
                                                                $gender = '-';
                                                                    if (isset($user_info->userInformation->gender) && $user_info->userInformation->gender == "1")
                                                                        $gender = "Male";
                                                                    elseif (isset($user_info->userInformation->gender) && $user_info->userInformation->gender == "2")
                                                                        $gender = "Female"
                                                            @endphp
                                                            {{ $gender }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Email</label>
                                                        <div class="driverinfodata_shown">@if(count($user_info)>0) {{ $user_info->email }} @endif</div>
                                                    </div>
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Country</label>
                                                        <div class="driverinfodata_shown">@if(count($countries)>0)
                                                                @foreach($countries as $country)
                                                                    @if($country->id !='17')
                                                                        @if(isset($user_country) && ($user_country == $country->id))
                                                                            {{ $country->name }}
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>  <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Default Time Period</label>
                                                        <div class="driverinfodata_shown">
                                                            @if(isset($dashboard_detail) && count($dashboard_detail)>0)
                                                                @if(isset($dashboard_detail->default_time_period) && $dashboard_detail->default_time_period == '1')
                                                                    Today
                                                                @elseif(isset($dashboard_detail->default_time_period) && $dashboard_detail->default_time_period == '2')
                                                                    Weekly
                                                                @elseif(isset($dashboard_detail->default_time_period) && $dashboard_detail->default_time_period == '3')
                                                                    Monthly
                                                                @elseif(isset($dashboard_detail->default_time_period) && $dashboard_detail->default_time_period == '4')
                                                                    Quarterly
                                                                @elseif(isset($dashboard_detail->default_time_period) && $dashboard_detail->default_time_period == '5')
                                                                    Annualy
                                                                @else
                                                                    -
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Mobile</label>
                                                        <div class="driverinfodata_shown">@if(count($user_info)>0 && isset($user_info->userInformation))+{{ $user_info->userInformation->mobile_code.' '.$user_info->userInformation->user_mobile }}@endif</div>
                                                    </div>
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Default Region</label>
                                                        {{--<div class="driverinfodata_shown">@if(count($dashboard_detail)>0)
                                                                @if(isset($dashboard_detail->zone) && count($dashboard_detail->zone)>0)
                                                                    {{ $dashboard_detail->zone->zone_name }}
                                                                @else
                                                                    -
                                                                @endif
                                                            @endif
                                                        </div>--}}
                                                        <div class="driverinfodata_shown">{{ $city }}</div>
                                                    </div><div class="driver_infodata">
                                                        <label class="driverinfodata_label">Registered on</label>
                                                        <div class="driverinfodata_shown">@if(count($user_info)>0){{ \Carbon\Carbon::createFromTimeStamp(strtotime($user_info->created_at))->format('m-d-Y H:i A')}}@endif</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        function confirmDelete(id) {
            if (confirm("Do you really want to delete this user?")) {

                $("#delete_user_" + id).submit();
            }
            return false;
        }
    </script>
@endsection