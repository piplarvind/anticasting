@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Manage Sub Admins</title>
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/select2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/dataTables.bootstrap4.min.css')}}"/>
    <script>
        function changeStatus(user_id, user_status)
        {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.user_id = user_id;
            obj_params.user_status = user_status;
            if (user_status == 1)
            {

                $("#active_div" + user_id).css('display', 'inline-block');
                $("#active_div_block" + user_id).css('display', 'inline-block');
                $("#blocked_div" + user_id).css('display', 'none');
                $("#blocked_div_block" + user_id).css('display', 'none');
                $("#inactive_div" + user_id).css('display', 'none');
            }
            jQuery.post("{{url('admin/change_status')}}", obj_params, function (msg) {
                if (msg.error == "1")
                {
                    alert(msg.error_message);
                    $("#active_div" + user_id).css('display', 'none');
                    $("#active_div_block" + user_id).css('display', 'none');
                    $("#inactive_div" + user_id).css('display', 'block');
                }
                else
                {
                    /* toogling the bloked and active div of user*/
                    if (user_status == 1)
                    {
                        alert(msg.message);
                        $("#active_div" + user_id).css('display', 'inline-block');
                        $("#active_div_block" + user_id).css('display', 'inline-block');
                        $("#blocked_div" + user_id).css('display', 'none');
                        $("#blocked_div_block" + user_id).css('display', 'none');
                        $("#inactive_div" + user_id).css('display', 'none');
                    }
                    else if(user_status == 0)
                    {
                        $("#active_div" + user_id).css('display', 'inline-block');
                        $("#active_div_block" + user_id).css('display', 'inline-block');
                        $("#blocked_div" + user_id).css('display', 'none');
                        $("#blocked_div_block" + user_id).css('display', 'none');
                        $("#inactive_div" + user_id).css('display', 'none');

                    }else{
                        $("#active_div" + user_id).css('display', 'none');
                        $("#active_div_block" + user_id).css('display', 'none');
                        $("#blocked_div" + user_id).css('display', 'inline-block');
                        $("#blocked_div_block" + user_id).css('display', 'inline-block');
                        $("#inactive_div" + user_id).css('display', 'none');
                    }
                }

            }, "json");

        }
    </script>
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Manage Sub Admins</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashbard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Sub Admins</li>
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
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="tcpart_filter">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group d-inline-block">
                                        <a class="btn btn-theme btn-addnew" href="{{url('admin/create-user')}}" id="sample_editable_1_new">Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="custom_select">
                                        <select name="filter_type" id="filter_type">
                                            <option value="">Select A Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            <option value="2">Blocked</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="reset" class="btn btn-theme" id="btn_reset" name="btn_reset">Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tcpart_table">
                            <table id="tbladminusers" class="table table-bordered">
                                <thead class="table_head">
                                <tr>
                                    <th class="table_title" style="width:70px">
                                        Id
                                    </th>
                                    <th class="table_title">Full Name</th>
                                    <th class="table_title">Email</th>
                                    <th class="table_title">Country</th>
                                    <th class="table_title">Role</th>
                                    <th class="table_title">Status</th>
                                    <th class="table_title">Registered On</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/jquery.dataTables.1.10.19.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/table-managed.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/select-all-delete.js')}}"></script>
    <script type="text/javascript">
        $('#btn_reset').click(function () {
            $("#filter_type").val('');
            initDatatable();
        });
        $('#filter_type').change(function () {
            initDatatable();
        });
        function initDatatable() {
            $("#tbladminusers").dataTable().fnDestroy();
            $('#tbladminusers').DataTable({
                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {
                    "url":'{{url("/admin/admin-users-data")}}',
                    "complete":afterRequestComplete,
                    "data": function (d) {
                        d.order_filter_by = $("#filter_type").val();
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    { data: 'user_id', name: 'user_id'},
                    { data: 'full_name',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("/admin/view-admin-user")}}/'+ row.user_id +'" title="View">'+ row.full_name +'</a>';
                            }
                            return data;
                        },
                        name: 'full_name', searchable: true
                    },
                    { data: 'email', name: 'user.email', searchable: true},
                    { data: 'country', name: 'country', searchable: true},
                    { data: 'role', name: 'roles.name', searchable: true},
                    { data: 'status', name: 'status'},
                    { data: 'created_at', name: 'created_at' },
                ]
            });
        }
        $(function()
        {
            initDatatable();
        });
        function confirmDelete(id)
        {
            if (confirm("Do you really want to delete this user?"))
            {

                $("#delete_user_" + id).submit();
            }
            return false;
        }

    </script>
@endsection