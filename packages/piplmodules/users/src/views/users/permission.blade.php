@php
$breadcrumbs[] =  ['url' => url('/').'/'.Lang::getLocale().'/admin/users/admin', 'name' => trans('Users::users.user_permission')];
@endphp
@extends('admin.master')
@section('page_title')
{{trans('Users::users.user_permission')}}
@endsection
@section('header')
<link rel="stylesheet" href="{{asset('public/media-dev.css')}}" />
@endsection
@section('content')
<!-- Include Media model -->
@include('Media::modals.modal')

<!-- end include Media model -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{trans('Users::users.user_permission')}} </h3>
            </div>
            <div class="panel-body">
                <form action="" method="POST" role="form">
                    {{ csrf_field() }}
                    <div class="col-md-9">

                        @if(isset($permissions) && count($permissions)>0)
                        <input type="checkbox" name="check_all" id="checkall">
                        {{trans('Core::operations.select_all')}}
                        @foreach($permissions as $per)

                        @if($per->id == 20 || $per->id == 21)
                        <div class="checkbox">
                            <label><input name="permission_id[]" checked type="checkbox" value="{{ $per->id }}" class="check_list" @if(isset($arr_user_permission) && count($arr_user_permission) > 0) @if(in_array($per->id,$arr_user_permission)) checked @endif  @endif> {{   $per->name   }}</label>
                        </div>
                        @else
                        <div class="checkbox">
                            <label><input name="permission_id[]" type="checkbox" value="{{ $per->id }}" class="check_list" @if(isset($arr_user_permission) && count($arr_user_permission) > 0) @if(in_array($per->id,$arr_user_permission)) checked @endif  @endif> {{   $per->name   }}</label>
                        </div>
                         @endif

                        @endforeach
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-block btn-primary">{{trans('Core::operations.save_changes')}}</button>
                        </div>
                        @endif                      
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

<!--Media -->
<script src="{{asset('public/media-dev.js')}}"></script>
<!--end media -->
<script src="{{ asset('public/admin-assets/js/index-operations.js') }}"></script>
<!--jquery-dependency-fields -->
<script src="<?php url('/') ?>vendor/core/js/jquery-dependency-fields/scripts.js"></script>
<!--end jquery-dependency-fields -->
@endsection