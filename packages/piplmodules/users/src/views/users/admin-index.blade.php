@php
    $pageTitle = $itemTitle = 'Sub Admin';

    $role = 'admin';
    $breadcrumbs = [
                        ['url' => '', 'name' => $pageTitle]
    ];
    $dbTable = '';
    if($items->count()){
        $dbTable = $items[0]['table'];
    }

@endphp

@extends('admin.master')
@section('title')
    {{ $pageTitle }}
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
            <h3>All Sub Admin</h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li class="active">
                    Sub Admin
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        @if($items->count() || $_GET)
            @include('Users::users.admin-filter')
        @endif
        <form method="POST" action="{{ route('admin.users.bulk-operations') }}" id="bulk" class="form-inline">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="table-responsive essay-table">
                <a class="btn btn-success pull-right" style="margin-bottom: 5px;" href="{{ route('admin.users.create') }}">Create Sub Admin</a>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="check_all" id="checkall">
                        </th>
                        {{--<th>{{ trans('Core::operations.image') }}</th>--}}
                        <th>{{ trans('Core::operations.name') }}</th>
                        <th>{{ trans('Core::operations.mobile') }}</th>
                        <th>{{ trans('Core::operations.email') }}</th>
                        <th>{{ trans('Core::operations.created_at') }}</th>
                        <th>{{ trans('Core::operations.updated_at') }}</th>
                        <th>{{ trans('Core::operations.status') }}</th>
                        <th>{{ trans('Core::operations.operations') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($items) && count($items))
                        @foreach($items as $k => $item)
                            <tr class="@if($k % 2 == 0) even @else odd @endif pointer" @if($item->trans) data-title="{{ $item->trans->name }}" @endif>
                                <td>
                                    <input type="checkbox" name="ids[]" class="check_list" value="{{$item->id}}">
                                </td>
                                {{--<td>
                                    @if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']))
                                        <img width="60" height="60" src="{{url('/')}}/public/{{ $item->media->main_image->styles['thumbnail'] }}" alt="">
                                    @else
                                        <img src="{{ asset('public/images/select_main_img.png') }}" width="60">
                                    @endif
                                </td>--}}
                                <td class="user_name_col_{{$item->id}}">{{ $item->name }}</td>
                                <td>+{{ $item->country_code }} {{ $item->mobile_number }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if($item->updated_at)
                                        {{ $item->updated_at }}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    <div id="enable_div{{ $item->id }}"  @if ($item->account_status == '1')  style="display:inline-block" @else style="display:none;" @endif >
                                        <a class="label label-success" title="" onClick="changeStatus('{{ $item->id }}', '0');" href="javascript:void(0);" id="status_{!! $item->id !!}">{{ trans('Core::operations.active') }}</a>
                                    </div>
                                    <div id="disable_div{{ $item->id }}" @if ($item->account_status == '0') style="display:inline-block" @else  style="display:none;" @endif >
                                        <a class="label label-danger" title="" onClick="changeStatus('{{ $item->id }}', '1');" href="javascript:void(0);" id="status_{!! $item->id !!}">{{ trans('Core::operations.inactive') }}</a>
                                    </div>
                                </td>
                                <td>
                                    <span class="act-link">
                                        <a href="{{ route('admin.users.edit', $item->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i> {{ trans('Core::operations.edit') }}</a>
                                    </span>
                                    <span class="act-link">
                                        {{--<a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $item->id }}" @if($item->trans) data-title="{{ $item->trans->name }}" @endif href="#full-width"><i class="fa fa-trash"></i> {{ trans('Core::operations.delete') }}</a>--}}
                                        <a href="{{ route('admin.users.delete', $item->id) }}" onclick="return confirm('Do you really want to delete this record?')"
                                           data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ><i class="fa fa-trash"></i> {{ trans('Core::operations.delete') }}</a>
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
                    <div class="row" >
                        <div class="form-group">
                            <label for="operation">{{ trans('Core::operations.with_select') }}</label>
                            <select name="operation" id="operation" class="form-control" required="required">
                                <option value="">- {{ trans('Core::operations.select') }} -</option>
                                <option value="activate">{{ trans('Core::operations.activate') }}</option>
                                <option value="deactivate">{{ trans('Core::operations.deactivate') }}</option>
                                {{--                                <option value="delete">{{ trans('Core::operations.delete') }}</option>--}}
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('Core::operations.go') }}</button>

                        <div class="table-footer">
                            <div class="count"><i class="fa fa-folder-o"></i> {{ $items->total() }} {{ trans('Core::operations.item') }}</div>
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
        function changeStatus(user_id, user_status)
        {
            /* changing the user status*/
            var obj_params = new Object();
            obj_params.user_id = user_id;
            obj_params.user_status = user_status;
            jQuery.get("{{ route('admin.user.change-status') }}", obj_params, function (msg) {
                if (msg.error == "1")
                {
                    alert("Sorry, the operation failed");
                }
                else
                {
                    /* toogling the bloked and active div of user*/
                    if (user_status == '0')
                    {
                        $("#disable_div" + user_id).css('display', 'inline-block');
                        $("#enable_div" + user_id).css('display', 'none');
                    }
                    else
                    {
                        $("#enable_div" + user_id).css('display', 'inline-block');
                        $("#disable_div" + user_id).css('display', 'none');
                    }
                }

            }, "json");

        }
    </script>
@endsection
