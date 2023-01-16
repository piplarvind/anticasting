@php
$pageTitle = 'Contact Us';
$itemTitle = 'Contact Us';
$breadcrumbs = [['url' => '', 'name' => $pageTitle]];

$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
$dbTable = 'contact_us';
@endphp

@extends('layouts.admin-account-app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <!-- Include single delete confirmation model -->
    @include('Core::modals.confirm-delete')
    <!-- Include bulk delete confirmation model -->
    @include('Core::modals.bulk-confirm-delete')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Contact Us</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Contact Us
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
                        <div class="table-responsive essay-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        {{-- <th>
                                        <input type="checkbox" name="check_all" id="checkall">
                                    </th> --}}
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Replied At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($items) && $items->count())
                                        @foreach ($items as $k => $item)
                                            <tr class="@if ($k % 2 == 0) even @else odd @endif pointer" @if ($item->trans) data-title="{{ $item->trans->name }}" @endif>
                                            {{-- <td>
                                                <input type="checkbox" name="ids[]" class="check_list" value="{{$item->id}}">
                                            </td> --}}
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->first_name }}</td>
                                            <td>{{ $item->last_name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if ($item->is_read == 1)
                                                    Active
                                                @else
                                                    Read
@endif
                                            </td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                @if ($item->replied_at)
{{ $item->replied_at }}
                                                @else
                                                    --
@endif
                                            </td>
                                            <td>
                                                <span class="
                                                act-link">
                                                <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                    href="{{ route('admin.contact-us.view-msg', $item->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Edit"><i class="fa fa-eye"></i></a>
                                                </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">No record</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="filter-sel" style="padding: 0 20px;">
                                <div class="row">
                                    <div class="table-footer">
                                        <div class="count"><i class="fa fa-folder-o"></i> {{ $items->total() }}
                                            {{ trans('Core::operations.item') }}</div>
                                        <div class="pagination-area"> {!! $items->render() !!} </div>
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
