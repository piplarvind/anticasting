@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>view Role Permission</title>
@endsection

@section('content')
    <section class="tabcontent_area">
        <div class="container-fluid">
            <div class="tab_headings clearfix">
                <h3 class="float-left">view Role Permission</h3>
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/manage-roles') }}">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">view Role Permission</li>
                </ol>
            </div>
            @php
                $model_name_array = array();
                if(isset($permissions) && count($permissions)>0)
                {
                  $permissions = $permissions->toArray();
                  $admin_controller = new \App\PiplModules\admin\Controllers\AdminController();
                  $permissions = $admin_controller->arrayGroupBy($permissions,'model');
                }
            @endphp
            <div class="tabcontent_inner">
                <div class="tabcontent_part">
                    <div class="tcpart_inner">
                        <div class="update_forms set_permission">
                            <div class="form-group text-right">
                                <a type="button" class="btn btn-save" href="{{url('admin/update-role/'.$role->id)}}">
                                    Update Role
                                </a>
                            </div>
                            <form method="post" role="form">
                                @if(isset($permissions) && count($permissions)>0)
                                    @foreach($permissions as $perm_key => $perm_val)
                                        <div class="permission_parts">
                                            <h6 class="permission_name">{{ $perm_key }}</h6>
                                            <div class="manage_permissionss">
                                                @if(isset($perm_val) && count($perm_val)>0)
                                                    <ul class="clearfix list-unstyled perm_listingul">
                                                        @foreach($perm_val as $val)
                                                            <li class="perm_listing">
                                                                <div class="permli_inner perm_checkbox">
                                                                    <input type="checkbox" name="permission[]" value="{{$val['id'] }}"
                                                                           @if(isset($role_permissions) && count($role_permissions)>0 && $role_permissions->contains($val['id'])) checked @endif id="{{ str_replace('.','_',$val['slug']) }}" />
                                                                    <label for="{{ str_replace('.','_',$val['slug']) }}">{{ $val['name'] }}</label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-save">
                                            Update Permission
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $('.perm_checkbox input[name="permission[]"]').change(function () {
            var id = $(this).attr('id');
            var  split_arr = id.split('_');
            var  per_key = split_arr[0];
            var  split_key = split_arr[1];
            if((per_key != 'view') && (($('#view_'+split_key).length > 0) && ($('#view_'+ split_key +':checked').length == 0)))
            {
                if($(this).prop("checked", true))
                {
                    $('#view_'+ split_key).prop("checked", true);
                }
            }
        });
    </script>
@endsection