@php
$pageTitle = 'User Recipient';
$itemTitle = 'User Recipient';

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
                            <a href="{{ route('admin.customers') }}"> <i class="fa fa-list"></i> Manage Users</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.customers.recipients', $item->user_id) }}"><i class="fa fa-list"></i>
                                User Recipients</a>
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
                                    <h4>Recipient Information</h4>
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
                                        {{ $item->email ? $item->email : '-' }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Mobile No.: </label>
                                        +{{ $item->country_code }} {{ $item->phone_no }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Bank Account Number: </label>
                                        {{ $item->bank_account_no }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Reason: </label>
                                        {{ $item->reason_for_sending }}
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Address: </label>
                                        {{ $item->address }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">City: </label>
                                        {{ $item->city }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">State: </label>
                                        {{ $item->state }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <a href="{{ route('admin.customers.recipients', $item->user_id) }}"
                                            class="btn btn-light">Back</a> &nbsp;&nbsp;
                                        <a href="{{ route('admin.customers.recipients.edit', [$item->user_id, $item->id]) }}"
                                            class="btn btn-primary">Edit</a>
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
