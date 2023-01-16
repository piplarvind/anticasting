@php
$pageTitle = 'Receiving Country';
$breadcrumbs = [['url' => '', 'name' => $pageTitle]];
$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
$dbTable = 'receiving_countries';
@endphp

@extends('layouts.admin-account-app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Receiving Country
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        @include('ReceivingCountry::receivingcountry.filter')
                        <div class="table-responsive essay-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Country Name</th>
                                        <th>Country ISO Code</th>
                                        <th>Currency</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($items) && $items->count())
                                        @foreach ($items as $k => $item)
                                            <tr class="@if ($k % 2 == 0) even @else odd @endif pointer" @if ($item) data-title="{{ $item->country_name }}" @endif>
                                            <td>{{ $item->id }}</td>
                                            <td class="
                                                user_name_col_{{ $item->id }}">@if ($item->flag) <img height="20" src="{{ asset('public') }}/country/{{ $item->flag }}">@endif
                                                {{ $item->country_name }}</td>
                                                <td>{{ $item->country_iso_code }}</td>
                                                <td>{{ $item->currency }}</td>
                                                <td>
                                                    <div id="enable_div{!! $item->id !!}" @if ($item->status == '1')  style="display:inline-block" @else style="display:none;" @endif>
                                                        <span
                                                            class="badge badge-success">{{ trans('Core::operations.active') }}</span>
                                                    </div>
                                                    <div id="disable_div{!! $item->id !!}" @if ($item->status == '0') style="display:inline-block" @else  style="display:none;" @endif>
                                                        <span
                                                            class="badge badge-danger">{{ trans('Core::operations.inactive') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="act-link">
                                                        <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                            href="{{ route('admin.country.receive.edit', $item->id) }}"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                                    </span>
                                                    <span class="act-link">
                                                        <a class="btn btn-danger shadow btn-xs sharp"
                                                            href="{{ route('admin.country.receive.delete', $item->id) }}"
                                                            onclick="return confirm('Do you really want to delete this record?')"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                                    </span>
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
        function changeTopicStatus(id, status) {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.id = id;
            obj_params.status = status;
            jQuery.get("{{ route('admin.country.receive.change-status') }}", obj_params, function(msg) {
                if (msg.error == "1") {
                    alert("Sorry, the operation failed");
                } else {
                    /* toogling the bloked and active div of user*/
                    if (status == 0) {
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
