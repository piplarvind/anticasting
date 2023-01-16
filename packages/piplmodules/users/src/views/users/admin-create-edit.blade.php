@php
$pageTitle = $itemTitle = 'Admin';
$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => url('/') . '/' . Lang::getLocale() . '/admin/users/', 'name' => $pageTitle];
$action = route('admin.users.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.users.update', $item->id);
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
                        {{-- <li class="breadcrumb-item">
                            <a href="{{ route('admin.customers') }}"> Manage Admin Users</a>
                        </li> --}}
                        <li class="breadcrumb-item active">
                            {{ $pageNameMode }} {{ $itemTitle }}
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form id="frm_create_edit" action="{{ $action }}" method="POST" role="form">
                            @if ($method === 'PATCH')
                                <input type="hidden" name="_method" value="PATCH">
                            @endif
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        @include('Core::fields.input_text', [
                                            'field_name' => 'first_name',
                                            'name' => 'First Name',
                                            'placeholder' => '',
                                        ])
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        @include('Core::fields.input_text', [
                                            'field_name' => 'last_name',
                                            'name' => 'Last Name',
                                            'placeholder' => '',
                                        ])
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @include('Core::fields.input_text', [
                                            'field_name' => 'email',
                                            'name' => trans('Core::operations.email'),
                                            'placeholder' => '',
                                        ])
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group cun-code">
                                        <label for="mobile_number">Mobile Number<sup>*</sup></label>
                                        <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
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
                                    <div class="form-group">
                                        @include('Core::fields.input_text', [
                                            'field_name' => 'password',
                                            'name' => trans('Core::operations.password'),
                                            'placeholder' => '',
                                            'type' => 'password',
                                        ])
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @include('Core::fields.input_text', [
                                            'field_name' => 'password_confirmation',
                                            'name' => trans('Core::operations.password_confirmation'),
                                            'placeholder' => '',
                                            'type' => 'password',
                                        ])
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                                        <label for="role">{{ trans('Roles::roles.role') }} <span
                                                class="impot-star">*</span></label>
                                        <select id="role" name="role" class="form-control">
                                            <option value="">-
                                                {{ trans('Core::operations.select') . ' ' . ucfirst(trans('Roles::roles.role')) }}
                                                -</option>
                                            @if (count($roles))
                                                @foreach ($roles as $role)
                                                    <option @if (isset($item) && $item->userRole->role_id == $role->id) selected @endif
                                                        value="{{ $role->id }}">{{ $role->trans->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="display: none;">
                                            <input type="checkbox" id="account_status" name="account_status"
                                                class="minimal-blue" value="1"
                                                {{ isset($item->account_status) && $item->account_status == '1' ? 'checked' : '' }} />
                                            Active
                                        </label>
                                    </div>
                                    @if (request()->is('*/edit'))
                                        <input type="hidden" name="old_user_email" value="{{ $item->email }}">
                                        <input type="hidden" name="old_user_phone" value="{{ $item->mobile_number }}">
                                        <input type="hidden" name="old_user_first_name" value="{{ $item->first_name }}">
                                        <input type="hidden" name="old_user_last_name" value="{{ $item->last_name }}">
                                    @endif
                                    {{-- <div class="checkbox">
                                    <label><input name="back" type="checkbox" value="1" class="minimal-blue" @if (old('back') == 1) checked @endif> {{$backFieldLabel}}</label>
                                </div> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group text-center">
                                        <button type="submit" id="btn_create"
                                            class="btn btn-primary scoler-details">{{ $submitButton }}</button>
                                    </div>
                                </div>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer-scripts')
    <!--Language -->
    @include('Core::language.scripts.scripts')
    <!--end Language -->
    <!--Media -->
    <script src="{{ asset('public/media-dev.js') }}"></script>
    <!--end media -->

    <script src="{{ asset('public/admin-assets/js/pages/add_user.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend/css/jquery.ccpicker.css') }}">
    <script src="{{ asset('public/backend/js/jquery.ccpicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#mobile_number").CcPicker();
            $("#mobile_number").CcPicker("setCountryByPhoneCode", "{{ $item->country_code }}");
        });
    </script>
@endsection
