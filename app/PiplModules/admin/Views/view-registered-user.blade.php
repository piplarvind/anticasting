@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Passenger View</title>
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datepicker/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/jquery.rateyo.min.css')}}">
    <script type="text/javascript" src="{{url('public/media/backend/js/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/select2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/dataTables.bootstrap4.min.css')}}"/>
    <style>
        .btn.btn-active {
            width: 80px;
            max-width: 100px;
        }
    </style>
    <section class="driver_view tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Passenger View</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{url('admin/manage-users')}}">Manage Passengers</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Passenger View</li>
                </ol>
            </div>
            <div class="tabcontent_inner">
                <div class="tcpart_inner">
                    @if (session('profile-updated'))
                        <div id="ses-succ-msg" class="alert alert-success">
                            {{ session('profile-updated') }}
                        </div>
                    @endif
                    @if (session('refund-amount-success'))
                        <div id="ses-succ-msg" class="alert alert-success">
                            {{ session('refund-amount-success') }}
                        </div>
                    @endif
                    <div class="tab_headings clearfix">
                        <h3>
                        <span style="margin-right: 5px">
                            @if($user_info->count() > 0 && isset($user_info->userInformation))#{{ $user_info->userInformation->user_id}}@endif
                        </span>
                            @if($user_info->count() > 0 && isset($user_info->userInformation)){{ $user_info->userInformation->first_name.' '.$user_info->userInformation->last_name }}
                            @endif
                            <a style="margin-left: 10px; display: inline-block;" href="{{url("/").'/'.Request::segment(1).'/update-registered-user/'. Request::segment(3)}}" data-toggle="tooltip" data-placement="top" title="Edit"><img src="{{url('public/media/backend/images/edit-icon.png')}}" alt="Edit"></a>
                            <form style="display:inline-block;" id="delete_user_{{Request::segment(3)}}" method="post" action="{{url("/admin/delete-user").'/'. Request::segment(3)}}">{{ method_field("DELETE") }} {!! csrf_field() !!}<img class="text-right" onclick="confirmDelete({{Request::segment(3)}})" src="{{url('public/media/backend/images/delete-icon.png')}}" alt="Delete"></form>
                            @if($user_info->userInformation->user_status=='1'  || $user_info->userInformation->user_status=='3')
                                <label style="margin-left:20px;">Is Suspended ?</label>
                                <div style="display: inline-block;margin-left:20px;" class="td_content">
                                    <div class="is_blocked">
                                        <button type="button" rel="{{ $user_info->id }}" onclick="changeSuspendedStatus(this)" class="btn btn-toggle @if($user_info->userInformation->user_status == '3') active @endif" data-toggle="button" @if($user_info->userInformation->user_status == '3') aria-pressed="true" @else aria-pressed="false" @endif autocomplete="off">
                                            <div class="handle"></div>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </h3>
                    </div>
                    <div class="driverview_tabs">
                        <div class="driverview_custtab">
                            <ul class="nav nav-pills cust_nav">
                                <li class="nav-item">
                                    <a class="nav-link @if(!(session('refund-amount-success'))) active @endif" data-toggle="pill" href="#driver_tab1">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" id="ride_details" href="#driver_tab3">Rides</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" id="support_details" href="#driver_tab4">Complaints</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if((session('refund-amount-success'))) active @endif" data-toggle="pill" id="cust_wallet" href="#driver_tab5">Wallet</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" id="membership_plan" href="#membership_tab">Membership Plan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" id="communication" href="#driver_tab7">Communication</a>
                                </li>
                            </ul>
                        </div>
                        <div class="driverview_custtabContent">
                            <div class="tab-content">
                                <div class="tab-pane @if(!( session('refund-amount-success'))) active @endif" id="driver_tab1">
                                    <div class="container-fluid">
                                        <div class="profile_nninfo">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="profile_picture text-center">
                                                        <div class="PDImage">
                                                            @if(isset($user_info->userInformation->profile_picture) && $user_info->userInformation->profile_picture!='')
                                                                <img onerror="this.onerror=null;this.src='{{ url('public/media/backend/images/profilew.png')  }}';" style="width: 100px;height: 100px;" src="{{url("storage/app/public/user-image/".$user_info->userInformation->profile_picture)}}">
                                                            @else
                                                                <img style="width: 100px;height: 100px;" src="{{ url('public/media/backend/images/profilew.png')  }}">
                                                            @endif
                                                        </div>
                                                        <div class="profile_driver_meta text-center">
                                                            <div class="ratings_dr mb_10">
                                                                <div class="all_ssstar mb_10">
                                                                    @if(isset($avg_rating))
                                                                        <span style="margin-left: 85px" class="rateYoData" id="avg_ratng" rel="{{ $avg_rating }}">
                                                                </span>
                                                                    @endif
                                                                </div>
                                                                <div class="number_rate">
                                                                    {{ $avg_rating }} /5.0
                                                                </div>
                                                                <div id="dvr-usr-status" class="driverstatus_dr mb_10">@if($user_info->count() > 0 && isset($user_info->userInformation))
                                                                        @if($user_info->userInformation->user_status == '0')
                                                                            Inactive
                                                                        @elseif($user_info->userInformation->user_status == '1')
                                                                            Active
                                                                        @elseif($user_info->userInformation->user_status == '2')
                                                                            Blocked
                                                                        @elseif($user_info->userInformation->user_status == '3')
                                                                            Suspended
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Name</label>
                                                        <div class="driverinfodata_shown">@if($user_info->count() > 0 && isset($user_info->userInformation)){{ $user_info->userInformation->first_name.' '.$user_info->userInformation->last_name }}@endif</div>
                                                    </div>
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Platform</label>
                                                        <div class="driverinfodata_shown"> @if($user_info->count() > 0)
                                                                @if ($user_info->userInformation->platform == '0')
                                                                    Android
                                                                @elseif ($user_info->userInformation->platform == '1')
                                                                    IOS
                                                                @else
                                                                    Web
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Preferred Language</label>
                                                        <div class="driverinfodata_shown">
                                                            @if(isset($user_info->langInfo))
                                                                @if($user_info->langInfo->spoken_language_id == '1')
                                                                    English
                                                                @else
                                                                    Arebic
                                                                @endif
                                                            @else
                                                                English
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Email</label>
                                                        <div class="driverinfodata_shown">@if($user_info->count() > 0){{ $user_info->email }}@endif</div>
                                                    </div>

                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Total Amount For Ride</label>
                                                        {{--<div class="driverinfodata_shown">Rs 0/-</div>--}}
                                                        <div class="driverinfodata_shown">{{'INR'}} {{ count($total_amount_for_ride)>0?$total_amount_for_ride:'0.000' }}</div>
                                                    </div>
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Wallet Balance</label>
                                                        <div class="driverinfodata_shown">{{'INR'}} {{ isset($all_wallet_data) && count($all_wallet_data)>0?number_format($all_wallet_data['balance'],3,'.',','):'0.000' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="driver_infodata">
                                                        <label class="driverinfodata_label">Active Mobile No.</label>
                                                        <div class="driverinfodata_shown"> @if($user_info->count() > 0 && isset($user_info->userInformation)) +{{ str_replace("+", "", $user_info->userInformation->mobile_code) }} {{ $user_info->userInformation->user_mobile }}@endif</div>
                                                    </div>
                                                    <div class="driver_infodata">
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
                                            </div>
                                        </div>



                                        {{--Ride detail start here--}}
                                        <div class="car_nninfo ridelist_nninfo">
                                            <div class="tab_inner_heading">
                                                <h3>Latest Ride</h3>
                                            </div>
                                            <div class="tab_inner_custtable">
                                                <table class="table table-bordered" style="width:100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Ride No</th>
                                                        <th>Driver Name</th>
                                                        <th>City</th>
                                                        {{--<th>Route Name</th>--}}
                                                        <th>Service Type</th>
                                                        <th>Ride Type</th>
                                                        <th>Ride Status</th>
                                                        <th>Total Amount</th>
                                                        <th>Posted Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($last_order_details) && $last_order_details->count() > 0)
                                                        <tr>
                                                            <td>
                                                                {{--<a href="{{url("admin/order-view")}}/{{$last_order_details->id}}"> @if($last_order_details->count() > 0){{$last_order_details->order_unique_id}} @endif</a>--}}
                                                                <a> @if($last_order_details->count() > 0){{$last_order_details->order_unique_id}} @endif</a>
                                                            </td>
                                                            <td class="text-center">
                                                                {{(isset($last_order_details->getUserDriverInformation))?$last_order_details->getUserDriverInformation->first_name.' '.$last_order_details->getUserDriverInformation->last_name:'-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                @foreach($cities as $city)
                                                                    @if(($city->id == $last_order_details->city_id))
                                                                        {{$city->name}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td class="text-center">
                                                                @foreach($services as $serv)
                                                                    @if(($serv->id == $last_order_details->service_id))
                                                                        {{$serv->name}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td class="text-center">
                                                                @if(($last_order_details->order_type=='1'))
                                                                    Instant
                                                                @else
                                                                    Scheduled
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="status_nn text-center">
                                                                    <?php
                                                                    if ($last_order_details->count() > 0) {

                                                                        switch ($last_order_details->status) {
                                                                            case '0':
                                                                                echo 'Pending';
                                                                                break;
                                                                            case '1':
                                                                                echo 'Active';
                                                                                break;
                                                                            case '2':
                                                                                echo 'Completed';
                                                                                break;
                                                                            case '3':
                                                                                echo 'Cancelled';
                                                                                break;
                                                                            case '4':
                                                                                echo 'Expired';
                                                                                break;
                                                                            case '5':
                                                                                echo 'Pending Payment';
                                                                                break;
                                                                            case '6':
                                                                                echo 'No show by driver';
                                                                                break;
                                                                            case '7':
                                                                                echo 'No show by passenger';
                                                                                break;
                                                                            case '9':
                                                                                echo 'Terminated';
                                                                                break;
                                                                            default:
                                                                                echo 'Pending';
                                                                                break;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                {{"INR"}} {{(isset($last_order_details->total_amount) && $last_order_details->total_amount != '0.000')?number_format($last_order_details->total_amount,3,'.',','):'0.000'}}
                                                            </td>
                                                            <td class="text-center">
                                                                @if($last_order_details->count() > 0)
                                                                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($last_order_details->created_at))->format('m-d-Y H:i A')}}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @else
                                                        <tr><td colspan="9" class="text-center">No Record Found</td></tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        {{--suspension and ticket table start here--}}
                                        <div class="car_nninfo ridelist_nninfo">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="tab_inner_heading">
                                                        <h3>Suspension Details</h3>
                                                    </div>
                                                    <div class="tab_inner_custtable">
                                                        <table class="table table-bordered" style="width:100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>Description</th>
                                                                <th>Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($account_suspeded_list->count() > 0)
                                                                @foreach($account_suspeded_list as $suspension)
                                                                    <tr>
                                                                        <td>{{$suspension->reason}}</td>
                                                                        <td>{{\Carbon\Carbon::createFromTimeStamp(strtotime($suspension->created_at))->format('m-d-Y H:i A')}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="10" class="text-center">No Suspension Details Found</td>
                                                                </tr>
                                                            @endif

                                                            </tbody>
                                                            {{--<tbody>
                                                            <tr>
                                                                <td class="text-center" colspan="10">No Suspention data found</td>
                                                            </tr>

                                                            </tbody>--}}
                                                        </table>
                                                    </div>
                                                </div>


                                                <div class="col-sm-8">
                                                        <div class="tab_inner_heading">
                                                            <h3>Latest Complaint</h3>
                                                        </div>
                                                        <div class="tab_inner_custtable">
                                                            <table class="table table-bordered" style="width:100%;">
                                                                <thead>
                                                                <tr>
                                                                    <th>Ticket Id</th>
                                                                    <th>Ticket Category</th>
                                                                    <th>Ride Id</th>
                                                                    <th>Replied?</th>
                                                                    <th>Registered Date</th>
                                                                    <th style="width: 80px">Status</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($all_SupportTicket) && $all_SupportTicket->count() > 0)
                                                                        <tr>
                                                                            <td>
                                                                                {{$all_SupportTicket->ticket_unique_id}}
                                                                            </td>

                                                                            <td>
                                                                                @if(isset($all_SupportTicket->ticketCategory->getTranslationEnglish->name))
                                                                                    {{$all_SupportTicket->ticketCategory->getTranslationEnglish->name}}
                                                                                @else
                                                                                    {{'N/A'}}
                                                                                @endif
                                                                            </td>

                                                                            <td>
                                                                                @if(isset($all_SupportTicket->order_id) && $all_SupportTicket->order_id != '0')
                                                                                    {{$all_SupportTicket->orderInformation->order_unique_id}}
                                                                                @else
                                                                                    {{'N/A'}}
                                                                                @endif
                                                                            </td>

                                                                            <td>
                                                                                @php
                                                                                    $cng_replied_status = \App\PiplModules\supporttickets\Models\TicketDescription::where(['ticket_id' => $all_SupportTicket->id])->get();
                                                                                    if (isset($cng_replied_status) && $cng_replied_status->count() > 0 )
                                                                                    {
                                                                                        $ret = 'Replied';
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $ret = 'Not yet reply';
                                                                                    }
                                                                                @endphp
                                                                                {{$ret}}
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                    if(isset($all_SupportTicket->created_at))
                                                                                    {

                                                                                        $date = \Carbon\Carbon::createFromTimeStamp(strtotime($all_SupportTicket->created_at))->format('m-d-Y H:i A');
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $date = 'N/A';
                                                                                    }
                                                                                @endphp

                                                                                {{$date}}
                                                                            </td>
                                                                            <td>
                                                                                @if($all_SupportTicket->status == '0')
                                                                                    {{'Open'}}
                                                                                @elseif($all_SupportTicket->status == '1')
                                                                                    {{'Replied'}}
                                                                                @else
                                                                                    {{'Closed'}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                @else
                                                                    <tr>
                                                                        <td class="text-center" colspan="6">No Record Found</td>
                                                                    </tr>
                                                                @endif

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <div class="tab-pane fade" id="driver_tab3">
                                    <div class="container-fluid">
                                        <div class="tab_inner_custtable">
                                            <table id="MyTable" class="table table-bordered display" cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th  bgcolor="#e6dee2">Ride No</th>
                                                    <th bgcolor="#e6dee2">Driver Name</th>
                                                    <th bgcolor="#e6dee2">Region Name</th>
                                                    <th bgcolor="#e6dee2">Taxi Type</th>
                                                    <th  bgcolor="#e6dee2">Ride Type</th>
                                                    <th bgcolor="#e6dee2">Ride Status</th>
                                                    <th  bgcolor="#e6dee2">Total Amount</th>
                                                    <th bgcolor="#e6dee2">Posted Date</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="driver_tab4">
                                    <div class="container-fluid">
                                        <div class="tab_inner_custtable">
                                            <table id="ticket_details" class="table table-bordered display" cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th bgcolor="#e6dee2">Ticket Id</th>
                                                    <th  bgcolor="#e6dee2">Ticket Category</th>
                                                    <th bgcolor="#e6dee2">Ride Id</th>
                                                    <th  bgcolor="#e6dee2">Replied?</th>
                                                    <th bgcolor="#e6dee2">Registered Date</th>
                                                    <th bgcolor="#e6dee2">Status</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane @if((session('refund-amount-success'))) active @endif" id="driver_tab5">
                                    <div class="container-fluid">
                                        <div style="text-align:right;margin-bottom: 10px">
                                            <a id="payment_voucher" class="btn" style="background-color: #ee3900; color: white;">
                                                Refund
                                            </a>
                                        </div>
                                        <div class="tab_inner_custtable">
                                            <table id="wallet_detail" class="table table-bordered" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th bgcolor="#e6dee2">Date</th>
                                                    <th bgcolor="#e6dee2">Description</th>
                                                    <th bgcolor="#e6dee2">Wallet Credit</th>
                                                    <th bgcolor="#e6dee2">Cash Debit</th>
                                                    <th bgcolor="#e6dee2">Wallet Debit</th>
                                                    <th bgcolor="#e6dee2">Balance</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="driver_tab7">
                                    <div class="container-fluid">
                                        <div class="tab_inner_heading">
                                            <i class="fa fa-comments fa-lg" aria-hidden="true" style="color:#ee3900;"> Messages</i>
                                        </div>
                                        <div class="tab_inner_custtable">
                                            <table id="message_details" class="table table-bordered" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th bgcolor="#e6dee2">Ride Id</th>
                                                    <th bgcolor="#e6dee2">From Name</th>
                                                    <th  bgcolor="#e6dee2">To Name</th>
                                                    <th bgcolor="#e6dee2">Message Description</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    {{--<div class="container-fluid">
                                        <div class="tab_inner_heading">
                                            <i class="fa fa-phone fa-lg" aria-hidden="true" style="color:#ee3900;"> Calls</i>
                                        </div>
                                        <div class="tab_inner_custtable">
                                            <table id="call_details" class="table table-bordered" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e6dee2">Ride Id</th>
                                                    <th class="text-center" bgcolor="#e6dee2">From Name</th>
                                                    <th class="text-center" bgcolor="#e6dee2">To Name</th>
                                                    <th class="text-center" bgcolor="#e6dee2">Call Time</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($call_data) && count($call_data)>0)
                                                    @foreach($call_data as $call)
                                                        <tr>
                                                            <td>{{$call->order_id}}</td>
                                                            <td>{{$call->from_name}}</td>
                                                            <td>{{$call->to_name}}</td>
                                                            <td>
                                                                @if($call->duration<60)
                                                                    {{$call->duration}} sec
                                                                @else
                                                                    {{round($call->duration/60)}} min
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="tab-pane fade" id="membership_tab">
                                    <div class="container-fluid">
                                        {{--<div class="tab_inner_heading">
                                            <i class="fa fa-comments fa-lg" aria-hidden="true" style="color:#ee3900;"> Messages</i>
                                        </div>--}}
                                        <div class="tab_inner_custtable">
                                            <table id="membership_plan__details" class="table table-bordered" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th bgcolor="#e6dee2">Id</th>
                                                    <th bgcolor="#e6dee2">Recharge Amount</th>
                                                    <th  bgcolor="#e6dee2">Beneficiary Amount</th>
                                                    <th bgcolor="#e6dee2">Description</th>
                                                </tr>
                                                </thead>
                                            </table>
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
    <style>
        .modal-header, h4, .close {
            background-color: #ee3900;
            color:white !important;
            text-align: center;
            font-size: 30px;
        }
        .modal-footer {
            background-color: #f9f9f9;
        }
    </style>
    <div class="modal" id="myModal" role="dialog">
        <div class="modal-dialog">
            <form name="frm_assign_target" id="frm_assign_target" method="post" action="{{url('/admin/add-reason-for-passenger-user')}}">
                <div class="modal-content">
                    {{csrf_field()}}
                    <div class="modal-header text-center">
                        <h4 class="modal-title ">Add Reason</h4>
                        <button id="close-add-reason-modal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" style="font-size:24px;color:red"></i></button>
                    </div>
                    <input name="user_id" type="hidden" class="form-control" id="user_id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Reason:<sup>*</sup></label>
                                    <div class="col-sm-6">
                                        <textarea style="width:100%;" name="reason" class="form-control" id="reason" required="">{{old('reason')}}</textarea>
                                        @if ($errors->has('reason'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('reason') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <input type="hidden" name="ticket_id" id="ticket_id" value="">
                                <button type="submit" class="btn btn-inactive">Submit</button>
                                {{--<button type="reset" onclick="{{url('admin/driver-users')}}" class="btn btn-theme">Cancel</button>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="modal_voucher" role="dialog">
        <div class="modal-dialog">
            <form name="frm_refund_amount" id="frm_refund_amount" method="post" action="{{ url('/admin/add-passneger-refunded-amount')}}">
                <div class="modal-content">
                    {{csrf_field()}}
                    <div class="modal-header text-center">
                        <h4 class="modal-title ">Refund Amount</h4>
                        <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" style="font-size:24px;color:red"></i></button>
                    </div>
                    <input name="user_id" type="hidden" class="form-control" id="user_id" value="{{$user_info->id}}">
                    <div class="modal-body">
                        <div class="row" id="printThis">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Passenger Name:<sup style="color:red;">*</sup></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="name" name="name" value="{{$user_info->userInformation->first_name.' '.$user_info->userInformation->last_name}}" readonly="">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Date:<sup style="color:red;">*</sup></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()->format('m-d-Y')}}" readonly="">
                                        @if ($errors->has('date'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('date') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Amount:<sup style="color:red;">*</sup></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="amount" name="amount" value="" required="">
                                        @if ($errors->has('amount'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('amount') }}</strong>
                                      </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Description:<sup style="color:red;">*</sup></label>
                                    <div class="col-sm-6">
                                        <textarea style="width:100%;" name="description" class="form-control" id="description" required="">{{old('description')}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" style="font-size:15px;background-color: #ee3900; color: white;margin-bottom: 10px" class="btn btn-default">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{url('public/media/backend/js/jquery.rateyo.min.js') }}"></script>

    <script>
        $(function ()
        {
            window.setTimeout(function () {
                $("#rating .rateYoData").each(function (e) {
                    $(this).rateYo({
                        rating: $(this).attr('rel'),
                        spacing: "5px",
                        starWidth: "20px",
                        maxValue: 5,
                        ratedFill: "#ee3900",
                        readOnly: true
                    });
                });
                $('#avg_ratng.rateYoData').rateYo({
                    rating: $('#avg_ratng').attr('rel'),
                    spacing: "5px",
                    starWidth: "20px",
                    maxValue: 5,
                    ratedFill: "#ee3900",
                    readOnly: true
                });

            }, 400);

        });


    </script>
    <script type="text/javascript">
        $('#myModal').appendTo('body');
        $("#close-modal").click(function () {
            var modal = document.getElementById('myModal');
            modal.style.display = "none";
        });
        $(function () {
            $('#close-add-reason-modal').click(function () {
                console.log(111);
                $('#myModal').modal('hide');
            })
        })
    </script>
    <script type="text/javascript">
        function changeSuspendedStatus(ele) {
            /* changing the user status*/
            var user_status = 1;
            var user_id = $(ele).attr('rel');
            $(ele).attr('data-toggle', 'false');
            var active_status = $(ele).hasClass('active');
            if (active_status == false) {
                var r = confirm("Do You really want to suspend this user?");
                if (r == true)
                {
                    if (r == true)
                    {
                        $(ele).attr('aria-pressed', 'false');
                        $(ele).removeClass('active');
                        var modal = document.getElementById('myModal');
                        $('#myModal').modal('show');
                       /* modal.style.display = "block";*/
                        $("#myModal #user_id").val(user_id);
                    }
                    else{
                        $(ele).attr('aria-pressed', 'false');
                        $(ele).removeClass('active');
                    }
                }
            }else{
                var r = confirm("Do You really want to active this user?");
                if (r == true) {
                    /* changing the user status*/
                    var obj_params = new Object();
                    obj_params.user_id = user_id;
                    obj_params.user_status = user_status;

                    jQuery.post("{{url('admin/change_suspended_status')}}", obj_params, function (msg) {
                        if (msg == "1")
                        {
                            $(ele).css('aria-pressed', 'false');
                            $(ele).removeClass('active');
                            $("#dvr-usr-status").html('Active');
                        }
                    }, "json");
                }
            }
        }
    </script>
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
    </script>
    <script>
        var iti;
        var mobNoLen = "{{ isset($user_info->userInformation->user_mobile)?strlen($user_info->userInformation->user_mobile):'10' }}";
        var chkmobNo = "{{ isset($user_info->userInformation->user_mobile)?$user_info->userInformation->user_mobile:'' }}";
        var chkCtry = '';
        var input_user_mobile = document.querySelector("#user_mobile");
        var defInitCtry = 'in';
        /*var defOlyCtries = ['in', 'kw'];*/
        var defOlyCtries = ['kw'];
        $(function () {

            if (mobNoLen > 8) {
                defInitCtry = 'in';
            } else {
                defInitCtry = 'kw';
            }
            iti = window.intlTelInput(input_user_mobile,
                {
                    initialCountry: defInitCtry,
                    onlyCountries: defOlyCtries,
                    utilsScript: javascript_site_path + "public/media/backend/js/utils.js?15"
                });
            var mobileCode = mobNoLen > 8 ? '+91' : '+965';
            chkCtry = mobNoLen > 8 ? '+91' : '+965';
            var mobileLen = mobNoLen > 8 ? '10' : '8';
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
    <script type="text/javascript" src="{{url('public/media/backend/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/jquery.dataTables.1.10.19.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/table-managed.js')}}"></script>
    <script>                                                                                                                                  $(document).ready(function() {
            $(' #call_details').DataTable( {
                order: [[1, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                //to select and search from grid
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            } );
        } );
        function confirmDelete(id) {
            if (confirm("Do you really want to delete this passenger because data will not recovered?")) {

                $("#delete_user_" + id).submit();
            }
            return false;
        }
    </script>
    <script>

        $("#ride_details").click(function(){

            $("#MyTable").dataTable().fnDestroy();
            $('#MyTable').DataTable({

                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {"url": '{{url("/admin/order-data")}}',

                    "data": function (d)
                    {
                        d.customer_id = '{{$user_id}}';
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    { data: 'order_unique_id',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("admin/order-view")}}/'+ row.id +'" title="View">'+ row.order_unique_id +'</a>';
                            }
                            return data;
                        },
                        name: 'order_unique_id'},
                    {data: 'driver_name', name: 'driver_name'},
                    {data: 'order_zone_name', name: 'order_zone_name'},
                    {data: 'service_name', name: 'service_name'},
                    {data: 'ride_type', name: 'ride_type'},
                    {data: 'order_status', name: 'order_status'},
                    {data: 'fare_charge', name: 'fare_charge'},
                    {data: 'posted_date', name: 'posted_date'},
                ]
            });
        });
        $("#support_details").click(function(){
            $("#ticket_details").dataTable().fnDestroy();
            $('#ticket_details').DataTable({
                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {"url": '{{url("/admin/customer-support-ticket-data")}}',

                    "data": function (d)
                    {
                        d.user_id = '{{$user_id}}';
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    { data: 'id',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("admin/suppor-ticket-details")}}/'+ row.id +'" title="View">'+ row.id +'</a>';
                            }
                            return data;
                        },
                        name: 'id'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'order_unique_id', name: 'order_unique_id'},
                    {data: 'is_reply', name: 'is_reply'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status'}
                ]
            });
        });
        $("#cust_wallet").click(function(){
            cust_wallet();
        });
        function cust_wallet(){
            $("#wallet_detail").dataTable().fnDestroy();
            $('#wallet_detail').DataTable({
                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {"url": '{{url("/admin/customer-wallet-data")}}',

                    "data": function (d)
                    {
                        d.user_id = '{{$user_id}}';
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    {data: 'created_at', name: 'created_at'},
                    {data: 'trans_desc', name: 'trans_desc'},
                    {data: 'wallet_credit', name: 'wallet_credit'},
                    {data: 'cash_debit', name: 'cash_debit'},
                    {data: 'wallet_debit', name: 'wallet_debit'},
                    {data: 'balance', name: 'wallet_debit'}
                ]
            });
        }
        $("#communication").click(function(){
            $("#message_details").dataTable().fnDestroy();
            $('#message_details').DataTable({
                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {"url": '{{url("/admin/all-message-data")}}',

                    "data": function (d)
                    {
                        d.user_id = '{{$user_id}}';
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    {data: 'order_id', name: 'order_id'},
                    {data: 'from_name', name: 'from_name'},
                    {data: 'to_name', name: 'to_name'},
                    {data: 'message', name: 'message'},
                    //{data: 'status', name: 'status'}
                ]
            });
        });


        // membership plan
        $("#membership_plan").click(function(){
            $("#membership_plan__details").dataTable().fnDestroy();
            $('#membership_plan__details').DataTable({
                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {"url": '{{url("/admin/user/membership/plan")}}',

                    "data": function (d)
                    {
                        d.user_id = '{{$user_id}}';
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    {data: 'id', name: 'id'},
                   /* {data: 'membership_plan_id', name: 'membership_plan_id'},*/
                    {data: 'recharge_amount', name: 'recharge_amount'},
                    {data: 'beneficiary_amount', name: 'beneficiary_amount'},
                    {data: 'description', name: 'description'},
                    //{data: 'status', name: 'status'}
                ]
            });
        });

        @if((session('refund-amount-success')))
        cust_wallet();
        @endif
    </script>
    <script>
        $('#modal_voucher').appendTo('body');
        $(document).ready(function(){
            $('#payment_voucher').click(function(){
                $('#modal_voucher').modal('show')
            });
        });
        $(function() {
            var regExp = /[a-z]/i;
            $('#modal_voucher #amount').keypress(function (event) {
                var keycode = event.which;
                if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                    event.preventDefault();
                }
            });
        });
    </script>
    <style>
        .panel img {
            margin: 10px 10px;
        }
    </style>
    <style type="text/css">
        .container {
            max-width: 100%;
        }
    </style>
@endsection
