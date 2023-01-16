@php
$pageTitle = 'Banners';
$itemTitle = 'Banner';
$breadcrumbs = [['url' => '', 'name' => trans('Banners::banners.banners')]];

$dbTable = '';
if (isset($items[0]) && $items[0]->getTable() !== null) {
    $dbTable = $items[0]->getTable();
}
@endphp
@extends('admin.master')
@section('title')
    {{ trans('Banners::banners.banners') }}
@endsection
@section('content')
    <!-- Include single delete confirmation model -->
    @include('Core::modals.confirm-delete')
    <!-- Include bulk delete confirmation model -->
    @include('Core::modals.bulk-confirm-delete')

    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>{{ $pageTitle }}</h3>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="active">
                            {{ $pageTitle }}
                        </li>
                    </ol>
                    {{-- <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6> --}}
                </div>
                <div class="card-body">
                    @if (session('alert-success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <polyline points="9 11 12 14 22 4"></polyline>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                            {{ session('alert-success') }}
                            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                        class="mdi mdi-close"></i></span>
                            </button>
                        </div>
                    @endif
                    @if (session('alert-danger'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            {{ session('alert-danger') }}
                            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i
                                        class="mdi mdi-close"></i></span>
                            </button>
                        </div>
                    @endif
                    @if ($items->count() || $_GET)
                        @include('Banners::banners.filter')
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.banners.bulk-operations') }}" id="bulk"
                    class="form-inline">
                    @csrf
                    <div class="table-responsive essay-table">
                        <a class="btn btn-success pull-right" style="margin-bottom: 5px;"
                            href="{{ route('admin.banners.create') }}">Create New Banner</a>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="check_all" id="checkall">
                                    </th>
                                    <th>Title</th>
                                    {{-- <th>{{trans('Banners::banners.image')}}</th> --}}
                                    <th>{{ trans('Banners::banners.name') }}</th>
                                    <th>{{ trans('Core::operations.status') }}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($items) && $items->count())
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="ids[]" class="check_list"
                                                    value="{{ $item->id }}">
                                            </td>
                                            <td class="user_name_col_{{ $item->id }}">
                                                @if ($item->trans)
                                                    {{ $item->trans->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($item->trans->banner_img) && file_exists(public_path('/img/banners') . '/' . $item->trans->banner_img))
                                                    <img width="60" height="60"
                                                        src="{{ asset('public/img/banners') }}/{{ $item->trans->banner_img }}"
                                                        alt="">
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            {{-- <td>{{ $item->trans->name }}</td> --}}
                                            {{-- <td>
                                    @if ($item->active == true)
                                        <label class="badge badge-success">{{ trans('Core::operations.active') }}</label>
                                    @else
                                        <label class="badge badge-danger" >{{ trans('Core::operations.inactive') }}</label>
                                    @endif
                                </td> --}}
                                            <td>
                                                <div id="enable_div{{ $item->id }}" @if ($item->active == 1)  style="display:inline-block" @else style="display:none;" @endif>
                                                    <a class="label label-success" title=""
                                                        onClick="changeBannerStatus('{{ $item->id }}', 0);"
                                                        href="javascript:void(0);"
                                                        id="status_{!! $item->id !!}">{{ trans('Core::operations.active') }}</a>
                                                </div>
                                                <div id="disable_div{{ $item->id }}" @if ($item->active == 0) style="display:inline-block" @else  style="display:none;" @endif>
                                                    <a class="label label-danger" title=""
                                                        onClick="changeBannerStatus('{{ $item->id }}', 1);"
                                                        href="javascript:void(0);"
                                                        id="status_{!! $item->id !!}">{{ trans('Core::operations.inactive') }}</a>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="act-link">
                                                    <a href="{{ route('admin.banners.edit', $item->id) }}"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Edit Banner"><i class="fa fa-edit"></i>
                                                        {{ trans('Core::operations.edit') }}</a>
                                                </span>
                                                <span class="act-link">
                                                    <a href="{{ route('admin.banners.delete', $item->id) }}"
                                                        onclick="return confirm('Do you really want to delete this record?')"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Delete Banner"><i class="fa fa-trash"></i>
                                                        {{ trans('Core::operations.delete') }}</a>
                                                </span>
                                            </td>
                                            {{-- <td>
                                    <a href="{{ route('admin.emailtemplates.edit', $item->id) }}"><i class="fa fa-edit"></i> {{ trans('Core::operations.edit') }}</a>
                                </td> --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="filter-sel" style="padding: 0 20px;">
                            <div class="row">
                                <div class="form-group">
                                    <label for="operation">{{ trans('Core::operations.with_select') }}</label>
                                    <select name="operation" id="operation" class="form-control" required="required">
                                        <option value="">- {{ trans('Core::operations.select') }} -</option>
                                        <option value="activate">{{ trans('Core::operations.activate') }}</option>
                                        <option value="deactivate">{{ trans('Core::operations.deactivate') }}</option>
                                        {{-- <option value="delete">{{ trans('Core::operations.delete') }}</option> --}}
                                    </select>
                                    <button type="submit" class="btn btn-primary">Go</button>
                                </div>

                                <div class="table-footer">
                                    <div class="count"><i class="fa fa-folder-o"></i> {{ $items->total() }}
                                        {{ trans('Core::operations.item') }}</div>
                                    <div class="pagination-area"> {!! $items->render() !!} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('public/backend/js/index-operations.js') }}"></script>
    <script>
        function changeBannerStatus(banner_id, status) {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.banner_id = banner_id;
            obj_params.status = status;
            jQuery.get("{{ route('admin.banners.change-status') }}", obj_params, function(msg) {
                if (msg.error == "1") {
                    alert("Sorry, the operation failed");
                } else {
                    /* toogling the bloked and active div of user*/
                    if (status == 0) {
                        $("#disable_div" + banner_id).css('display', 'inline-block');
                        $("#enable_div" + banner_id).css('display', 'none');
                    } else {
                        $("#enable_div" + banner_id).css('display', 'inline-block');
                        $("#disable_div" + banner_id).css('display', 'none');
                    }
                }

            }, "json");

        }
    </script>
@endsection
