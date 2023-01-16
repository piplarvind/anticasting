@php
$pageTitle = 'User recipients';
$itemTitle = 'User recipients';
$role = 'users';

$breadcrumbs = [['url' => '', 'name' => $pageTitle]];

$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
$dbTable = 'users';
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
                    <h3>User recipients</h3>
                    {{-- <span class="pull-right"><a class="btn btn-default" href="{{ route('admin.customers.create') }}">Create Sub Admin</a></span> --}}
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin/users"> <i class="fa fa-list"></i> Users</a>
                        </li>
                        <li class="breadcrumb-item active">
                            User recipients
                        </li>
                    </ol>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if (session('alert-success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="mr-2">
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
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="mr-2">
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
                            @if ($items->count() || $_GET)
                                @include('Users::users.filter')
                            @endif
                            <form method="POST" action="{{ route('admin.customers.bulk-operations') }}" id="bulk"
                                class="form-inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="table-responsive essay-table">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="check_all"
                                                            id="checkAll" required="">
                                                        <label class="custom-control-label" for="checkAll"></label>
                                                    </div>
                                                </th>
                                                <th>{{ trans('Core::operations.first_name') }}</th>
                                                <th>{{ trans('Core::operations.last_name') }}</th>
                                                <th>{{ trans('Core::operations.mobile') }}</th>
                                                <th>Reason</th>
                                                <th>{{ trans('Core::operations.operations') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($items) && $items->count())
                                                @foreach ($items as $k => $item)
                                                    <tr class="@if ($k % 2 == 0) even @else odd @endif pointer"
                                                        @if ($item->trans) data-title="{{ $item->trans->name }}" @endif>
                                                        <td>
                                                            <div
                                                                class="
                                                        custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="ids[]" id="customCheckBox{{ $item->id }}"
                                                                    value="{{ $item->id }}" required="">
                                                                <label class="custom-control-label"
                                                                    for="customCheckBox{{ $item->id }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="user_name_col_{{ $item->id }}"><a
                                                                href="{{ route('admin.customers.recipients.view', ['user_id' => $item->user_id, 'id' => $item->id]) }}">{{ $item->first_name }}</a>
                                                        </td>
                                                        <td class="user_name_col_{{ $item->id }}"><a
                                                                href="{{ route('admin.customers.recipients.view', ['user_id' => $item->user_id, 'id' => $item->id]) }}">{{ $item->last_name }}</a>
                                                        </td>
                                                        <td>+{{ $item->country_code }} {{ $item->phone_no }}</td>
                                                        <td>{{ $item->reason_for_sending }}</td>
                                                        <td>
                                                            <span class="act-link">
                                                                <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                                    href="{{ route('admin.customers.recipients.edit', ['user_id' => $item->user_id, 'id' => $item->id]) }}"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Edit" data-original-title="Edit"><i
                                                                        class="fa fa-pencil"></i></a>
                                                            </span>
                                                            <span class="act-link">
                                                                {{-- <a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $item->id }}" @if ($item->trans) data-title="{{ $item->trans->name }}" @endif href="#full-width"><i class="fa fa-trash"></i> {{ trans('Core::operations.delete') }}</a> --}}
                                                                <a class="btn btn-danger shadow btn-xs sharp"
                                                                    href="{{ route('admin.customers.recipients.delete', ['user_id' => $item->user_id, 'id' => $item->id]) }}"
                                                                    onclick="return confirm('Do you really want to delete this record?')"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Delete" data-original-title="Delete"><i
                                                                        class="fa fa-trash"></i></a>
                                                            </span>
                                                            <span class="act-link">
                                                                <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                                    href="{{ route('admin.customers.recipients.view', ['user_id' => $item->user_id, 'id' => $item->id]) }}"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="View Recipient"
                                                                    data-original-title="View Recipient"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8">No record found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="filter-sel" style="padding: 0 20px;">
                                        <div class="row">
                                            <div class="form-group">
                                                <label
                                                    for="operation">{{ trans('Core::operations.with_select') }}</label>
                                                <select name="operation" id="operation" class="form-control"
                                                    required="required">
                                                    <option value="">- {{ trans('Core::operations.select') }} -
                                                    </option>
                                                    <option value="activate">{{ trans('Core::operations.activate') }}
                                                    </option>
                                                    <option value="deactivate">
                                                        {{ trans('Core::operations.deactivate') }}
                                                    </option>
                                                    {{-- <option value="delete">{{ trans('Core::operations.delete') }}</option> --}}
                                                </select>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary">{{ trans('Core::operations.go') }}</button>
                                        </div>
                                        <div class="row">
                                            <div class="table-footer">
                                                <div class="count"><i class="fa fa-folder-o"></i>
                                                    {{ $items->total() }} {{ trans('Core::operations.item') }}</div>
                                                <div class="pagination-area"> {!! $items->render() !!} </div>
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
    </div>
@endsection
@section('footer-scripts')
    <script src="{{ asset('public/backend/js/index-operations.js') }}"></script>
    <script>
        function changeStatus(user_id, user_status) {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.user_id = user_id;
            obj_params.user_status = user_status;
            jQuery.get("{{ route('admin.user.change-status') }}", obj_params, function(msg) {
                if (msg.error == "1") {
                    alert("Sorry, the operation failed");
                } else {
                    /* toogling the bloked and active div of user*/
                    if (user_status == '0') {
                        $("#disable_div" + user_id).css('display', 'inline-block');
                        $("#enable_div" + user_id).css('display', 'none');
                    } else {
                        $("#enable_div" + user_id).css('display', 'inline-block');
                        $("#disable_div" + user_id).css('display', 'none');
                    }
                }

            }, "json");

        }
    </script>
@endsection
