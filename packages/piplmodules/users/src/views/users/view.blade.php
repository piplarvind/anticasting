@php
$pageTitle = 'Users';
$itemTitle = 'User';

$pageNameMode = 'View';
$breadcrumbs[] = ['url' => url('/') . '/admin/users/', 'name' => $pageTitle];
$action = route('admin.customers.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

$breadcrumbs[] = ['url' => '', 'name' => 'View ' . $itemTitle];

@endphp

@extends('admin.master')
@section('title')
    {{ $pageTitle }}: {{ $pageNameMode }} {{ $itemTitle }}
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('public/media-dev.css') }}" />
@endsection
@section('content')
    @include('layouts.admin-header')
    <!-- Include Media model -->
    @include('layouts.admin-header')
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
                    {{-- <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6> --}}
                </div>
                <div class="card">
                    <div class="card-body">
                        <form id="frm_create_edit" action="{{ $action }}" method="POST" role="form">
                            @if ($method === 'PATCH')
                                <input type="hidden" name="_method" value="PATCH">
                            @endif
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>User Account Information</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">First Name: </label>
                                        {{ $item->first_name }}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Last Name: </label>
                                        {{ $item->last_name }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email: </label>
                                        {{ $item->email }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Mobile No.: </label>
                                        +{{ $item->country_code }} {{ $item->mobile_number }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Status: </label>
                                        <span
                                            class="badge @if ($item->account_status == 1) badge-success @else badge-danger @endif">
                                            {{ isset($item->account_status) && $item->account_status == '1' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <a href="{{ route('admin.customers') }}" class="btn btn-light">Back</a>
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
@section('footer')
@endsection
