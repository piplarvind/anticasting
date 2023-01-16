@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Manage Nationalities</title>
@endsection

<link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/jquery.dataTables.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('public/media/backend/css/datatable/dataTables.bootstrap4.min.css')}}"/>

@section('content')
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">Manage Nationalities</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Nationalities</li>
                </ol>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="tcpart_table">
                            <form>
                                <table class="table table-bordered" id="cms_table">
                                    <thead class="table_head">
                                    <tr>                                      
                                        <th class="table_title">
                                            Country Name
                                        </th>
                                        <th class="table_title">
                                            Language
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
        $("#status_type").on("change", function() {
            initDatatable();
        });
        $("#btn_reset").on("click", function() {
            $("#status_type").val('');
            initDatatable();
        });
        $(function () {
            initDatatable();
        });
        function initDatatable()
        {
            var url = '{{ url("admin/nationality-details-pages-data")}}';
            $("#cms_table").dataTable().fnDestroy();
            $('#cms_table').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                ajax: {
                    "url": url,
                    "complete": afterRequestComplete,
                    "data": function(d)
                    {
                        d.status_type = $("#status_type").val();
                    }
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [                
                     { data: 'country_name',
                        render: function ( data, type, row ) {

                            if ( type === 'display' ) {
                                return '<a href="{{url("admin/nationalities-details/update")}}/'+ row.id +'" title="Edit">'+ row.country_name +'</a>';
                            }
                            return data;
                        },
                        name: 'country_name'},
                    {data: 'Language', name: 'Language'}
                ]
            });
        }
        function selectCountryLang(ele)
        {
            var locale = $(ele).children("option:selected").val();
            var countryId = $(ele).children("option:selected").attr('id');
            var url = '{{ url("admin/nationalities-details/update-language") }}' + '/' + countryId + '/' + locale;
            window.location.href = url;
        }
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

