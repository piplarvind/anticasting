@php
    $pageNameMode = trans('Core::operations.create');
    $breadcrumbs[] =  ['url' => url('/').'/'.Lang::getLocale().'/admin/permissions', 'name' => trans('Permissions::permissions.permissions')];
    $action = action('\Piplmodules\Permissions\Controllers\PermissionsController@store');
    $method = '';
    $backFieldLabel = trans('admin.add_new_after_save');
    $submitButton = trans('admin.save');
    if(Request::is('*/edit')){
        $pageNameMode = trans('Core::operations.edit');
        $breadcrumbs[] =  ['url' => '', 'name' => trans('Core::operations.edit').' '.trans('Permissions::permissions.role')];
        $action = action('\Piplmodules\Permissions\Controllers\PermissionsController@update', $item->id);
        $method = 'PATCH';
        $backFieldLabel = trans('admin.back_after_update');
        $submitButton = trans('admin.update');
    }else{
        $breadcrumbs[] =  ['url' => '', 'name' => trans('Core::operations.create').' '.trans('Permissions::permissions.role')];
    }
@endphp

@extends('admin.master')
@section('page_title')
    {{ trans('Permissions::permissions.permissions') }}: {{ $pageNameMode }} {{ trans('Permissions::permissions.role') }}
@endsection
@section('content')
    <!-- Include Media model -->
    @include('Media::modals.modal')
    <!-- end include Media model -->

    <!-- Include Media model -->
    @include('Media::modals.gallery-modal')
    <!-- end include Media model -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ $pageNameMode }} {{ trans('Permissions::permissions.role') }}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ $action }}" method="POST" role="form" >
                        @if($method === 'PATCH')
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        {{ csrf_field() }}
                        <div class="col-md-9">
                            @include('Core::groups.languages', [
                                'fields' => [
                                    0 => [
                                        'type' => 'input_text',
                                        'properties' => [
                                            'field_name' => 'name',
                                            'name' => trans('Core::operations.name'),
                                            'placeholder' => ''
                                        ]
                                    ]
                                ]
                            ])
                            <hr/>
                            <h4><i>{{trans('Permissions::permissions.all_permissions')}}</i></h4>

                            @if(isset($permissions) && count($permissions)>0)
                                <input type="checkbox" name="check_all" id="checkall">
                                {{trans('Core::operations.select_all')}}
                                @foreach($permissions as $per)
                                    @if($per->id == 20 || $per->id == 21)
                                        <div class="checkbox">
                                            <label><input name="permissions[]" checked type="checkbox" value="{{ $per->id }}" class="check_list" @if(isset($arr_role_permission) && count($arr_role_permission) > 0) @if(in_array($per->id,$arr_role_permission)) checked @endif  @endif> {{ $per->name }}</label>
                                        </div>
                                    @else
                                        <div class="checkbox">
                                            <label><input name="permissions[]" type="checkbox" value="{{ $per->id }}" class="check_list" @if(isset($arr_role_permission) && count($arr_role_permission) > 0) @if(in_array($per->id,$arr_role_permission)) checked @endif  @endif> {{ $per->name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                                {{--<div class="col-md-3">--}}
                                {{--<button type="submit" class="btn btn-block btn-primary">{{trans('Core::operations.save_changes')}}</button>--}}
                                {{--</div>--}}
                            @endif
                            <hr/>
                        </div>
                        <div class="col-md-3 sidbare">
                            <!-- Language field -->
                        @include('Core::fields.languages')
                        <!-- End Language field -->

                            @include('Core::fields.checkbox', [
                                'field_name' => 'active',
                                'name' => trans('admin.active'),
                                'placeholder' => ''
                            ])
                            <div class="checkbox">
                                <label><input name="back" type="checkbox" value="1" class="minimal-blue" @if(old('back') == 1) checked @endif> {{$backFieldLabel}}</label>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">{{ $submitButton }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <!--Language -->
    @include('Core::language.scripts.scripts')
    <!--end Language -->
    <script src="{{asset('public/media-dev.js')}}"></script>
    <!--jquery-dependency-fields -->
    <script src="{{ asset('public/admin-assets/js/index-operations.js') }}"></script>
    <!--end jquery-dependency-fields -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#lang-en').attr('onClick','return false');
            $('#lang-ar').attr('onClick','return false');
        });
    </script>
@endsection