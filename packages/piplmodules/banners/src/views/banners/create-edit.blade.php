@php
    $pageNameMode = trans('Core::operations.create');
    $breadcrumbs[] =  ['url' => route('admin.banners'), 'name' => trans('Banners::banners.banners')];
    $action = route('admin.banners.store');
    $method = '';
    $backFieldLabel = trans('admin.add_new_after_save');
    $submitButton = 'Submit';
    if(request()->is('*/edit')){
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] =  ['url' => '', 'name' => trans('Core::operations.edit').' '.trans('Banners::banners.banner')];
    $action = route('admin.banners.update', $item->id);
    $method = 'PATCH';
    $backFieldLabel = trans('admin.back_after_update');
    $submitButton = 'Update';
    }else{
    $breadcrumbs[] =  ['url' => '', 'name' => trans('Core::operations.create').' '.trans('Banners::banners.banner')];
    }
@endphp

@extends('admin.master')
@section('title')
    {{ trans('Banners::banners.banner') }}: {{ $pageNameMode }} {{ trans('Banners::banners.banner') }}
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-datetimepicker.css') }}" />
    <style>
        .dtp-btn-cancel {
            float: left;
        }
    </style>
@endsection
@section('content')
    {{--@include('Media::modals.modal')
    @include('Media::modals.gallery-modal')--}}

    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
        <div class="all-heads">
            <h3>{{ $pageNameMode }} Banner</h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.banners') }}"> <i class="fa fa-table"></i> Manage Banners</a>
                </li>
                <li class="active">
                    {{ $pageNameMode }} Banner
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        <div class="editable-forms-users">
            <form id="frm_create_edit" action="{{ $action }}" method="POST" role="form"
                  enctype="multipart/form-data">
                @if($method === 'PATCH')
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Title <span class="impot-star">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Banner Title" value="{{ old('name', isset($item->trans->name) ? $item->trans->name : '') }}"/>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="section">{{trans('Banners::banners.image')}}</label>
                                @if(request()->is('*/edit'))
                                    <input type="file" name="banner_img" id="banner_img"  />
                                @else
                                    <input type="file" name="banner_img" id="banner_img"   />
                                @endif
                                @error('banner_img')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <input type="hidden" name="banner_img_old" id="banner_img_old" @if(isset($item)) value="{{ $item->trans->banner_img }}" @endif />
                            </div>
                            @if(isset($item->trans->banner_img) && file_exists(public_path('/img/banners').'/'.$item->trans->banner_img))
                                <img width="60" height="60" src="{{ asset('public/img/banners')}}/{{ $item->trans->banner_img }}" alt="">
                            @endif

                        </div>
                    </div>

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

@endsection