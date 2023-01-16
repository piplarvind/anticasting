@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Manage Passengers</title>

@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/select2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datepicker/jquery-ui.css')}}">
    
    <script type="text/javascript" src="{{url('public/media/backend/js/jquery-ui.min.js')}}"></script>
    <script>
        function changeStatus(user_id, user_status) {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.user_id = user_id;
            obj_params.user_status = user_status;
            if (user_status == 1) {
                if($("#active_div" + user_id).length)
                {
                    $("#active_div" + user_id).css('display', 'inline-block');
                }
                    //                $("#active_div_block" + user_id).css('display', 'inline-block');
                if($("#blocked_div" + user_id).length)
                {
                    $("#blocked_div" + user_id).css('display', 'none');
                }
                if($("#inactive_div" + user_id).length)
                {
                    $("#inactive_div" + user_id).css('display', 'none');

                }
                
                $("#suspended_div" + user_id).css('display', 'none');
//                $("#sus-user-" + user_id).css('aria-pressed', 'false');
//                $("#sus-user-" + user_id).removeClass('active');
//                $("#blocked_div_block" + user_id).css('display', 'none');
            }
            jQuery.post("{{url('admin/change_status')}}", obj_params, function (msg) {
                if (msg.error == "1") {
                    alert(msg.error_message);
                    $("#active_div" + user_id).css('display', 'none');
                    $("#inactive_div" + user_id).css('display', 'block');
                }
                else {
                    /* toogling the bloked and active div of user*/
                    if (user_status == 1) {
                        $("#active_div" + user_id).css('display', 'inline-block');
//                        $("#active_div_block" + user_id).css('display', 'inline-block');
                        $("#blocked_div" + user_id).css('display', 'none');
                        $("#suspended_div" + user_id).css('display', 'none');
                        /*if($("#sus-user-"+ user_id).length)
                        {
                            $("#sus-user-"+ user_id).prop('disabled', false);
                            $("#sus-user-" + user_id).removeClass('active');
                            $("#sus-user-" + user_id).css('aria-pressed','false');
                        }*/
//                        $("#blocked_div_block" + user_id).css('display', 'none');
                        $("#inactive_div" + user_id).css('display', 'none');
                        alert(msg.message);
                    }
                    else if (user_status == 0) {
                        $("#active_div" + user_id).css('display', 'inline-block');
//                        $("#active_div_block" + user_id).css('display', 'inline-block');
                        $("#blocked_div" + user_id).css('display', 'none');
                        /*if($("#sus-user-"+ user_id).length)
                        {
                            $("#sus-user-"+ user_id).prop('disabled', true);
                        }*/
//                        $("#blocked_div_block" + user_id).css('display', 'none');
                        $("#inactive_div" + user_id).css('display', 'none');

                    }
                    else if(user_status == 3){
                        $("#active_div" + user_id).css('display', 'none');
//                        $("#active_div_block" + user_id).css('display', 'none');
                        $("#suspended_div" + user_id).css('display', 'inline-block');
                       /* if($("#sus-user-"+ user_id).length)
                        {
                            $("#sus-user-"+ user_id).prop('disabled', false);
                            $("#sus-user-" + user_id).addClass('active');
                            $("#sus-user-" + user_id).css('aria-pressed','true');
                        }*/
                    }else {
                        $("#active_div" + user_id).css('display', 'none');
//                        $("#active_div_block" + user_id).css('display', 'none');
                        $("#blocked_div" + user_id).css('display', 'inline-block');
                       /* if($("#sus-user-"+ user_id).length)
                        {
                            $("#sus-user-"+ user_id).prop('disabled', true);
                        }*/
//                        $("#blocked_div_block" + user_id).css('display', 'inline-block');
                        $("#inactive_div" + user_id).css('display', 'none');
                    }
                }

            }, "json");

        }
        function changeSuspendedStatus(ele) {
            /* changing the user status*/
            var user_status = 0;
            var user_id = $(ele).attr('rel');
            $(ele).attr('data-toggle', 'false');
            var active_status = $(ele).hasClass('active');
            if (active_status == false) {
                var r = confirm("Do You really want to suspend this user?");
                if (r == true)
                {
                    $(ele).attr('aria-pressed', 'false');
                    $(ele).removeClass('active');
                    var modal = document.getElementById('myModal');
                    modal.style.display = "block";
                    $("#myModal #user_id").val(user_id);
                }
                else{
                    $(ele).attr('aria-pressed', 'false');
                    $(ele).removeClass('active');
                }
            }else{
                var r = confirm("Do You really want to active this user?");
                if (r == true) {
                    /* changing the user status*/
                    var obj_params = new Object();
                    obj_params.user_id = user_id;
                    obj_params.user_status = user_status;

                    jQuery.post("{{url('admin/change_suspended_status')}}", obj_params, function (msg) {
                        if (msg == "1") {
                            $("#suspended_div" + user_id).css('display', 'none');
                            $("#active_div" + user_id).css('display', 'block');
                            $("#sus-user-" + user_id).attr('aria-pressed', 'false');
                            $("#sus-user-" + user_id).removeClass('active');
                        }
                    }, "json");
                }
            }
        }

    </script>
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Manage Passengers</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashbard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Passengers</li>
                </ol>
            </div>
            @if (session('update-user-status'))
                <div class="alert alert-success">
                    {{ session('update-user-status') }}
                </div>
            @endif

            @if (session('delete-user-status'))
                <div class="alert alert-success">
                    {{ session('delete-user-status') }}
                </div>

            @endif
            @if (session('mobile_exist'))
                <div class="alert alert-danger">
                    {{ session('mobile_exist') }}
                </div>
            @endif
            @if (session('already_have_ride'))
                <div class="alert alert-danger">
                    {{ session('already_have_ride') }}
                </div>
            @endif
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="tcpart_filter">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a class="btn btn-theme btn-addnew" href="{{url('admin/create-registered-user')}}"
                                       id="sample_editable_1_new">Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
<!--                                <div class="col-sm-2" style="margin-left: 20px">
                                    <button onclick='javascript:deleteAll("{{url('/admin/delete-selected-user')}}")'
                                            name="delete" id="delete" class="btn btn-theme btn-delete" type="submit">
                                        Delete Selected
                                    </button>
                                </div>-->
                            <div class="col-sm-6">
                             <form id="passenger_detail" method="post" action="{{url('/download/passenger-users')}}">
                            <div class="row">
                                <input type="hidden" name="hid_status" id="hid_status">
                                <!--<label class="col-sm-2 col-form-label text-right">Filter By : </label>-->
                                <div class="col-sm-3">
                                    <div class="custom_select">
                                        <select name="filter_type" id="filter_type">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            {{--<option value="0">Inactive</option>--}}
                                            <option value="2">Blocked</option>
                                            <option value="3">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                                {{--<div class="col-sm-3">
                                    <div class="custom_select">
                                        @if(Request::segment(3)=="")
                                            <select id="order_country"  name="order_country">
                                                <option value="">--Select Country--</option>
                                                @foreach($all_countries as $key=>$name)
                                                    @if($name->id != 17)
                                                        <option value="{{str_replace("+","",$name->country_code)}}">{{$name->translate()->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>--}}
                                {{--<div class="col-sm-2">
                                    <div class="input-group mb-3 ">
                                        <input type="text" class="form-control-plaintext custom_input custom_date" id="drivert_date" name="drivert_date" placeholder="Star Date">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group mb-3 ">
                                        <input type="text" class="form-control-plaintext custom_input custom_date" id="end_date" name="end_date" placeholder="End Date">
                                    </div>
                                </div>--}}
                                {{--<div class="col-sm-2">
                                    <button type="button" class="btn btn-theme" id="btn_search" name="btn_search">
                                        Search
                                    </button>
                                </div>--}}
                                <div class="col-sm-2">
                                    <button type="reset" class="btn btn-theme" id="btn_reset" name="btn_reset">Reset</button>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group d-inline-block">
                                        <input type="hidden" value="excel" name="download">
                                        <a class="btn btn-theme btn-pdf" onclick="downloadExcel()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Export Report"><i class="fa fa-file-pdf-o"></i></a>
                                    </div>
                                </div>
                            </div>
                            </form>
                                </div> </div>
                        </div>
                        <div class="tcpart_table">
                            <table id="tbl_regusers" class="table table-bordered">
                                <thead class="table_head">
                                <tr>
                                    <th class="table_title">Id</th>
                                    <th class="table_title">Full Name</th>
                                    <th class="table_title">Email</th>
                                    <th class="table_title">Mobile</th>
                                    <!--<th>Civil ID</th>-->
                                    <th class="table_title">Location</th>
                                    <th class="table_title">Number Of Ride</th>
                                    <th class="table_title">Rating</th>
                                    <th class="table_title">Status</th>
                                    {{--<th class="table_title">Is Suspended?</th>--}}
                                    <th class="table_title">Platform</th>
                                {{--<th class="table_title">Rating</th>--}}
                                <!--<th class="table_title">Is Blocked?</th>-->
                                    <th class="table_title">Registered On</th>
                                    {{--<th class="table_title">Ratings</th>
                                    <th class="table_title">Wallet</th>--}}
                                    {{--<th class="table_title">Action</th>--}}
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .modal-header, h4, .close {
            background-color: #ac0860;
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
                        <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" style="font-size:24px;color:red"></i></button>
                    </div>
                    <input name="user_id" type="hidden" class="form-control" id="user_id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Reason:<sup>*</sup></label>
                                    <div class="col-sm-6">
                                        <textarea style="width:100%;" name="reason" class="form-control" id="reason">{{old('reason')}}</textarea>
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
    <style>
        #hearts {
            color: #ee8b2d;
        }

        #hearts-existing {
            color: #ee8b2d;
        }

        .glyphicon {
            display: inline-block;
            font-size: 20px;
            line-height: 14px;
            margin-left: 5px;
        }

        .help-block {
            margin-bottom: 10px;
            margin-top: 10px;
        }
    </style>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/jquery.dataTables.1.10.19.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/table-managed.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/select-all-delete.js')}}"></script>
    <script type="text/javascript">
        $("#close-modal").click(function () {
            var modal = document.getElementById('myModal');
            modal.style.display = "none";
        });
        $('#btn_reset').click(function () {
            $("#filter_type").val('');
            $("#hid_status").val('');
            initDatatable();
        });
        $("#filter_type").change(function () {
            $("#hid_status").val( $(this).val());
            initDatatable();
        });
        /*$("#btn_search").on("click", function () {
            initDatatable();
            $("#hid_status").val( $("#filter_type").val());
        });*/
        function initDatatable() {
//            $('#tbl_regusers').dataTable().fnClearTable();
            $("#tbl_regusers").dataTable().fnDestroy();
            $('#tbl_regusers').DataTable({
                processing: true,
                serverSide: true,
                aLengthMenu: [
                [25, 50, 100, 200, 500, 1000, 2000, -1],
                [25, 50, 100, 200, 500, 1000, 2000, "All"]
            ],
                order: [[0, 'desc']],
                ajax: {
                    "url": '{{url("/admin/list-registered-users-data")}}',
                    "complete": afterRequestComplete,
                    "data": function (d) {
                        d.order_filter_by = $("#filter_type").val();
                        d.order_country = $("#order_country").val();
                        d.drivert_date = $("#drivert_date").val();
                        d.end_date = $("#end_date").val();
                        d.country_name = '{{Request::segment(3)}}';
                    }
                },
                columnDefs: [{
        "defaultContent": "-",
        "targets": "_all"
                  }],
                columns: [
                    {data: 'id', name: 'user_informations.user_id'},
                    { data: 'full_name',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("/admin/view-registered-user")}}/'+ row.id +'" title="View">'+ row.full_name +'</a>';
                            }
                            return data;
                        },
                        name: 'user_informations.first_name', searchable: true
                    },
                    {data: 'email', name: 'users.email', searchable: true},
                    {data: 'mobile_number', name: 'user_informations.user_mobile', searchable: true},
                    {data: 'location', name: 'user_informations.mobile_code', searchable: true},
                    {data: 'no_of_ride', name: 'no_of_ride', searchable: false, sortable: false},
                    {data: 'avg_rating', name: 'avg_rating', searchable: false, sortable: false},
                    {data: 'status', name: 'user_informations.user_status'},
                    {data: 'device', name: 'user_informations.platform'},
                    {data: 'created_at', name: 'user_informations.created_at'}
                ]
            });
        }

        $(function () {
            initDatatable();
        });
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
            //For Start Date Calender:
            $("#drivert_date").datepicker({
                dateFormat: "yy-mm-dd",
                //minDate: 0,
                onSelect: function (date) {
                    var date2 = $('#drivert_date').datepicker('getDate');
                    date2.setDate(date2.getDate());
                    $('#end_date').datepicker('setDate', date2);
                    $('#end_date').datepicker('option', 'minDate', date2);
                }
            });
            //For End Date Calender:
            $('#end_date').datepicker({
                dateFormat: "yy-mm-dd",
                onClose: function () {
                    var dt1 = $('#drivert_date').datepicker('getDate');
                    console.log(dt1);
                    var dt2 = $('#end_date').datepicker('getDate');
                    if (dt2 <= dt1) {
                        var minDate = $('#end_date').datepicker('option', 'minDate');
                        $('#end_date').datepicker('setDate', minDate);
                    }
                }
            });
        });
        function confirmDelete(id) {
            if (confirm("Do you really want to delete this user?")) {

                $("#delete_user_" + id).submit();
            }
            return false;
        }
    </script>
     <script type="text/javascript">
        function  downloadExcel() {
            $('#passenger_detail').submit();
        }
        $('#myModal').appendTo('body');
    </script>
        <script>
        $(function () {        

    $("#frm_assign_target").validate({
     errorClass: 'text-danger',
    rules: {
            reason:
                {
                    required: true
                }
        },
        messages:
            {
                reason:
                    {
                        required: "Please enter reason"
                    }
            },
            submitHandler: function(form) {

            form.submit();
        }
    });
});
   </script>
@endsection
