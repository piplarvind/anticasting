@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
	<title>Manage General Configurations</title>
@endsection

@section('content')
	<link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/jquery.dataTables.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/dataTables.bootstrap4.min.css')}}"/>
	<section class="tabcontent_area">
		<div class="container-fluid">
			<div class="tab_headings clearfix">
				<h3 class="float-left">Manage General Configurations</h3>
				<ol class="breadcrumb float-right">
					<li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Manage General Configurations</li>
				</ol>
			</div>
			@if (session('global-setting-status'))
				<div class="alert alert-success">
					{{ session('global-setting-status') }}
				</div>
			@endif
			@if (session('update-setting-status'))
				<div class="alert alert-success">
					{{ session('update-setting-status') }}
				</div>
			@endif
			<div class="tabcontent_inner">
				<div class="tabcontent_part">
					<div class="tcpart_inner">
						<div class="tcpart_table">
							<form>
								<table id="dt_global_settings" class="table table-bordered">
									<thead class="table_head">
									<tr>
										<th class="table_title">
											Name
										</th>
										<th class="table_title">
											Value
										</th>
										<th class="table_title">
											Modified at
										</th>
									</tr>
									</thead>
								</table>
							</form>
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
        $(function() {
            $('#dt_global_settings').DataTable({
                processing: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: '{{url("/admin/global-settings-data")}}',
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [
                    { data: 'name',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("admin/update-global-setting")}}/'+ row.id +'" title="Edit">'+ row.name +'</a>';
                            }
                            return data;
                        },
                        name: 'name'},
                    {data:   "value",name:'value'},
                    { data: 'updated_at', name: 'updated_at' },
                ]
            });
            setTimeout(function () {
                $("#dt_global_settings tbody").addClass('table_body');
                $("#dt_global_settings tbody.table_body").find('td').addClass('td_content');
            },200);
        });
        function confirmDelete()
        {
            if(confirm("Do you really want to delete this role?"))
            {
                $("#delete_role").submit();
            }
            return false;
        }
	</script>
@endsection
