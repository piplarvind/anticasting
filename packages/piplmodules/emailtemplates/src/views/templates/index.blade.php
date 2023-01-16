@php
$pageTitle = 'Email Template';
$breadcrumbs = [
    [
        'url' => '',
        'name' => trans('Emailtemplates::emailtemplate.emailtemplates'),
    ],
];
$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
@endphp
@extends('layouts.admin-account-app')
@section('title')
    {{ trans('Emailtemplates::emailtemplate.emailtemplates') }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Email Templates </h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Email Templates
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (session('alert-success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                {{ session('alert-success') }}
                                <button type="button" class="close h-100" data-dismiss="alert"
                                    aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        @endif
                        @if (session('alert-danger'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polygon
                                        points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                    </polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                {{ session('alert-danger') }}
                                <button type="button" class="close h-100" data-dismiss="alert"
                                    aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        @endif
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">#</th>
                                    <th style="width: 200px;">Subject</th>
                                    <th style="width: 200px;">Modified</th>
                                    <th style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($items))
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if (isset($item->trans->subject))
                                                    {{ trim($item->trans->subject) }}
                                                @endif
                                            </td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>
                                                <span class="act-link">
                                                    <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                        href="{{ route('admin.emailtemplates.edit', $item->id) }}"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
