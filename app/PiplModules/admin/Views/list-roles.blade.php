@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Manage Roles</title>
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/select2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/dataTables.bootstrap4.min.css')}}"/>
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Manage Roles</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Roles</li>
                </ol>
            </div>
            @if (session('update-role-status'))
                <div class="alert alert-success">
                    {{ session('update-role-status') }}
                </div>
            @endif
            @if (session('role-status'))
                <div class="alert alert-success">
                    {{ session('role-status') }}
                </div>
            @endif
            @if (session('set-permission-status'))
                <div class="alert alert-success">
                    {{ session('set-permission-status') }}
                </div>
            @endif
            @if (session('delete-role-status'))
                <div class="alert alert-success">
                    {{ session('delete-role-status') }}
                </div>
            @endif
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="tcpart_filter">
                            <div class="row">
                                <div class="col-sm-5">
                                    <form>
                                        <div class="form-group d-inline-block">
                                            <a class="btn btn-theme btn-addnew" href="{{url('admin/roles/create')}}" id="sample_editable_1_new">Add New <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                        <div class="form-group d-inline-block" style="margin-left:10px;">
                                            <button onclick='javascript:deleteAll("{{url('/admin/delete-role-select-all')}}")' name="delete" id="delete" class="btn btn-theme btn-delete" type="submit">
                                                Delete Selected
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tcpart_table">
                            <form>
                                <table class="table table-bordered" id="tbl_role">
                                    <thead class="table_head">
                                    <tr>
                                        <th class="table_title">
                                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                                        </th>
                                        <th class="table_title">Id</th>
                                        <th class="table_title">Role</th>
                                        <th class="table_title">Description</th>
                                        <th class="table_title">Created On</th>
                                        <th class="table_title">Last Updated On</th>
                                    </tr>
                                    </thead>
                                </table>
                            </form>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
        </div>
    </section>
    <!-- END CONTENT -->
    </section>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/jquery.dataTables.1.10.19.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/datatable/table-managed.js')}}"></script>
    <script type="text/javascript" src="{{url('public/media/backend/js/select-all-delete.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#tbl_role').DataTable({
                processing: true,
                order: [[1, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {"url": '{{url("/admin/manage-roles-data")}}', "complete": afterRequestComplete},
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    {data:   "id",
                        render: function (data, type, row) {

                            if (type === 'display') {
                                if(row.id != 2 && row.id != 3){
                                    return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete' + row.id + '" name="delete' + row.id + '" value="' + row.id + '"><label for="delete' + row.id + '"></label> </p></div>';
                                }else{
                                    return "";
                                }
                            }
                            return data;
                        },
                        "orderable": false
                    },
                    {data: 'id', name: 'role.id'},
                    { data: 'name',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("/admin/roles/permissions")}}/'+ row.id +'" title="View">'+ row.name +'</a>';
                            }
                            return data;
                        },
                        name: 'role.name'},
                    {data: 'description', name: 'role.description'},
                    {data: 'created_at', name: 'role.created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                ]
            });
        });
        function confirmDelete(id)
        {
            if (confirm("Do you really want to delete this role?"))
            {
                $("#delete_role_" + id).submit();
            }
            return false;
        }
    </script>
@endsection