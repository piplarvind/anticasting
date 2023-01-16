@php
    $itemTitle = 'Role';
    $pageNameMode = trans('Core::operations.create');
    $breadcrumbs[] =  ['url' => url('/').'/'.app()->getLocale().'/admin/roles', 'name' => trans('Roles::roles.roles')];
    $action = route('admin.roles.store');
    $method = '';
    $backFieldLabel = 'Add New After Save';
    $submitButton = 'Submit';
    if(request()->is('*/edit')){
        $itemTitle = 'Role';
        $pageNameMode = trans('Core::operations.edit');
        $breadcrumbs[] =  ['url' => '', 'name' => trans('Core::operations.edit').' '.trans('Roles::roles.role')];
        $action = route('admin.roles.update', $item->id);
        $method = 'PATCH';
        $backFieldLabel = 'Back After Update';
        $submitButton = 'Update';
    }else{
        $breadcrumbs[] =  ['url' => '', 'name' => trans('Core::operations.create').' '.trans('Roles::roles.role')];
    }
@endphp

@extends('admin.master')
@section('title')
    {{ trans('Roles::roles.roles') }}: {{ $pageNameMode }} {{ trans('Roles::roles.role') }}
@endsection
@section('content')
    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
        <div class="all-heads">
            <h3>{{ $pageNameMode }} {{ $itemTitle }}</h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.roles') }}"> <i class="fa fa-table"></i> Manage Roles</a>
                </li>
                <li class="active">
                    {{ $pageNameMode }} {{ $itemTitle }}
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        <div class="editable-forms-users">
            <form id="frm_create_edit" action="{{ $action }}" method="POST" role="form">
                @if($method === 'PATCH')
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-12">
                            {{--@include('Core::groups.languages', [
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
                            ])--}}
                            <div class="form-group">
                                <label for="name">Name <span class="impot-star">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Role Name" value="{{ old('name', isset($item->trans->name) ? $item->trans->name : '') }}"/>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr/>
                    <h4><i>{{trans('Roles::roles.all_permissions')}}</i> <span class="impot-star">*</span></h4>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                @if(isset($permissions))
                                    <input type="checkbox" name="check_all" id="checkall">
                                    {{trans('Core::operations.select_all')}}
                                    @foreach($permissions as $per)
                                        @if($per->id == 20 || $per->id == 21)
                                            <div class="checkbox">
                                                <label><input name="permissions[]" checked type="checkbox" value="{{ $per->id }}" class="check_list" @if(isset($arr_role_permission) && count($arr_role_permission) > 0) @if(in_array($per->id,$arr_role_permission)) checked @endif  @endif> {{ $per->trans->name }}</label>
                                            </div>
                                        @else
                                            <div class="checkbox">
                                                <label><input name="permissions[]" type="checkbox" value="{{ $per->id }}" class="check_list" @if(isset($arr_role_permission) && count($arr_role_permission) > 0) @if(in_array($per->id,$arr_role_permission)) checked @endif  @endif> {{ $per->trans->name }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @error('permissions')
                                <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr/>

                <div class="col-md-3">
                    @include('Core::fields.checkbox', [
                                'field_name' => 'active',
                                'name' => 'Active',
                                'placeholder' => ''
                            ])
                    {{--<div class="checkbox">--}}
                        {{--<label><input name="back" type="checkbox" value="1" class="minimal-blue" @if(old('back') == 1) checked @endif> {{$backFieldLabel}}</label>--}}
                    {{--</div>--}}
                    <div class="text-center">
                        {{--<button type="submit" class="btn btn-primary scoler-details" onclick="window.location.href='sub-admin.html';">Create</button>--}}
                        <button type="submit" id="btn_create" class="btn btn-block btn-primary">{{ $submitButton }}</button>
                    </div>
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
    <script src="{{ asset('public/backend/js/index-operations.js') }}"></script>
    <!--end jquery-dependency-fields -->
@endsection