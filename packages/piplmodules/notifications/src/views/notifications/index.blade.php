@php
$breadcrumbs = [['url' => '', 'name' => trans('Notifications::notifications.notifications')]];
$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
@endphp
@extends('layouts.admin-account-app')
@section('title')
    {{ trans('Notifications::notifications.notifications') }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Notifications</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Notifications
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
                        {{-- @include(
                        'Notifications::notifications.filter'
                    ) --}}
                        <div class="table-responsive essay-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($items) && $items->count())
                                        @foreach ($items as $k => $item)
                                            <tr class="@if ($k % 2 == 0) even @else odd @endif pointer">
                                                <td>{{ $item->transaction_id }}</td>
                                                <td>{{ $item->subject }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <div id="enable_div{!! $item->id !!}"
                                                        @if ($item->status == '1') style="display:inline-block" @else style="display:none;" @endif>
                                                        <a class="badge badge-success" title=""
                                                            onClick="changeStatus({!! $item->id !!}, '0');"
                                                            href="javascript:void(0);"
                                                            id="status_{!! $item->id !!}">Read</a>
                                                    </div>
                                                    <div id="disable_div{!! $item->id !!}"
                                                        @if ($item->status == '0') style="display:inline-block" @else  style="display:none;" @endif>
                                                        <a class="badge badge-danger" title=""
                                                            onClick="changeStatus({!! $item->id !!}, '1');"
                                                            href="javascript:void(0);"
                                                            id="status_{!! $item->id !!}">Unread</a>
                                                    </div>
                                                </td>
                                                <td>{{ date('M jS, Y H:i:s A', strtotime($item->created_at)) }}</td>
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
                                        <div class="count"><i class="fa fa-folder-o"></i>
                                            {{ $items->total() }}
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
    <script>
        function changeStatus(id, status) {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.id = id;
            obj_params.status = status;
            jQuery.get("{{ route('admin.notifications.change-status') }}", obj_params, function(msg) {
                if (msg.error == "1") {
                    alert("Sorry, the operation failed");
                } else {
                    /* toogling the bloked and active div of user*/
                    if (status == '0') {
                        $("#disable_div" + id).css('display', 'inline-block');
                        $("#enable_div" + id).css('display', 'none');
                    } else {
                        $("#enable_div" + id).css('display', 'inline-block');
                        $("#disable_div" + id).css('display', 'none');
                    }
                }

            }, "json");

        }
    </script>
@endsection
