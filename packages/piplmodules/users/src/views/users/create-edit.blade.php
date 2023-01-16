@php
$pageTitle = 'Users';
$itemTitle = 'User';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => url('/') . '/admin/users/', 'name' => $pageTitle];
$action = route('admin.customers.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.customers.update', $item->id);
    $method = 'PATCH';
    $backFieldLabel = 'Back After Update';
    $submitButton = 'Update';
} else {
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.create') . ' ' . $itemTitle];
}
@endphp
@extends('layouts.admin-account-app')
@section('title')
    {{ $pageTitle }}: {{ $pageNameMode }} {{ $itemTitle }}
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('public/media-dev.css') }}" />
@endsection
@section('content')
    @include('layouts.admin-header')
    <!-- Include Media model -->
    @include('Media::modals.modal')
    <!-- end include Media model -->
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>{{ $pageNameMode }} {{ $itemTitle }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.customers') }}"> Manage Users</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pageNameMode }} {{ $itemTitle }}
                        </li>
                    </ol>
                </div>
                <div class="default-tab">
                    User Profile
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="portlet-body">
                            <div class="">
                                <div class="tab-pane">
                                    <form id="frm_create_edit" action="{{ $action }}" method="POST" role="form">
                                        @if ($method === 'PATCH')
                                            <input type="hidden" name="_method" value="PATCH">
                                        @endif
                                        {{ csrf_field() }}

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label for="first_name">First Name<sup>*</sup></label>
                                                    <input type="text" class="form-control" id="first_name"
                                                        name="first_name"
                                                        value="{{ isset($item) ? $item->first_name : old('first_name') }}"
                                                        placeholder="">
                                                </div>
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label for="last_name">Last Name<sup>*</sup></label>
                                                    <input type="text" class="form-control" id="last_name"
                                                        name="last_name"
                                                        value="{{ isset($item) ? $item->last_name : old('last_name') }}"
                                                        placeholder="">
                                                </div>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label for="email">Email<sup>*</sup></label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        value="{{ isset($item) ? $item->email : old('email') }}"
                                                        placeholder="" autocomplete="new-email">
                                                </div>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group cun-code">
                                                    <label for="mobile_number">Mobile Number<sup>*</sup></label>
                                                    <input type="tel" class="form-control" id="mobile_number"
                                                        name="mobile_number"
                                                        value="{{ isset($item) ? $item->mobile_number : old('mobile_number') }}"
                                                        placeholder="">
                                                </div>
                                                @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" value="" placeholder="" autocomplete="new-password">
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label for="password">Confirm Password</label>
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation"
                                                        value="" placeholder="" autocomplete="new-password">
                                                </div>
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="account_status" id="account_status" value="1"
                                                        {{ isset($item->account_status) && $item->account_status == '1' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="account_status">Active</label>
                                                </div>
                                            </div>
                                            @if (request()->is('*/edit'))
                                                <input type="hidden" name="old_user_email"
                                                    value="{{ $item->email }}">
                                                <input type="hidden" name="old_user_phone"
                                                    value="{{ $item->mobile_number }}">
                                                <input type="hidden" name="old_user_name" value="{{ $item->name }}">
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group text-center">
                                                    <button type="submit" id="btn_create"
                                                        class="btn btn-primary scoler-details">{{ $submitButton }}</button>
                                                    <a class="btn btn-light"
                                                        href="{{ route('admin.customers') }}">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer-scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/backend/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#mobile_number").CcPicker();
            $("#mobile_number").CcPicker("setCountryByPhoneCode", "{{ $item->country_code }}");
        });
    </script>
@endsection
