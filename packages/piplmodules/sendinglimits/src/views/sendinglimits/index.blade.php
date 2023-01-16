@php
$pageTitle = 'Sending Limit';
$breadcrumbs = [['url' => '', 'name' => $pageTitle]];
$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
$dbTable = 'sending_limits';
@endphp
@section('title')
    {{ $pageTitle }}
@endsection
@extends('layouts.admin-account-app')

@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Sending Limits</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Sending Limits
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
                        @include('Sendinglimits::sendinglimits.filter')
                        <div class="table-responsive essay-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Information Needed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($items) && $items->count())
                                        @foreach ($items as $k => $item)
                                            <tr class="@if ($k % 2 == 0) even @else odd @endif pointer"
                                                @if ($item) data-title="{{ $item->client_name }}" @endif>
                                                <td>{{ $item->id }}</td>
                                                <td class="user_name_col_{{ $item->id }}">
                                                    {{ $item->name }}</td>
                                                <td>{!! $item->information_needed !!}</td>
                                                <td><a href="javascript:void(0);"
                                                        onclick="changeStatus({{ $item->id }}, {{ $item->status }})">
                                                        <div id="enable_div{!! $item->id !!}"
                                                            @if ($item->status == '1') style="display:inline-block" @else style="display:none;" @endif>
                                                            <span
                                                                class="badge badge-success">{{ trans('Core::operations.active') }}</span>
                                                        </div>
                                                        <div id="disable_div{!! $item->id !!}"
                                                            @if ($item->status == '0') style="display:inline-block" @else  style="display:none;" @endif>
                                                            <span
                                                                class="badge badge-danger">{{ trans('Core::operations.inactive') }}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="act-link">
                                                        <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                            href="{{ route('admin.sendlimits.edit', $item->id) }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Edit information" data-original-title="Edit"><i
                                                                class="fa fa-pencil"></i></a>
                                                    </span>
                                                    <span class="act-link">
                                                        <a class="btn btn-success shadow btn-xs sharp mr-1"
                                                            href="{{ route('admin.sendlimits.attributes', $item->id) }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Edit attribute information"
                                                            data-original-title="Attributes"><i
                                                                class="fa fa-list"></i></a>
                                                    </span>
                                                    {{-- <span class="act-link">
                                                        <a class="btn btn-danger shadow btn-xs sharp"
                                                            href="{{ route('admin.sendlimits.delete', $item->id) }}"
                                                            onclick="return confirm('Do you really want to delete this record?')"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                                    </span> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No record found</td>
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
@section('footer-scripts')
    <script src="{{ asset('public/backend/js/index-operations.js') }}"></script>
    <script>
        function changeStatus(sending_limit_id, status) {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.sending_limit_id = sending_limit_id;
            obj_params.status = status;
            jQuery.get("{{ route('admin.sendlimits.change-status') }}", obj_params, function(msg) {
                if (msg.error == "1") {
                    alert("Sorry, the operation failed");
                } else {
                    /* toogling the bloked and active div of user*/
                    if (status == 1) {
                        $("#disable_div" + sending_limit_id).css('display', 'inline-block');
                        $("#enable_div" + sending_limit_id).css('display', 'none');
                    } else {
                        $("#enable_div" + sending_limit_id).css('display', 'inline-block');
                        $("#disable_div" + sending_limit_id).css('display', 'none');
                    }
                    document.location.reload();
                }

            }, "json");
        }
    </script>
@endsection
