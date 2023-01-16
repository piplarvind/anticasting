@php
    $breadcrumbs = [
                        ['url' => '', 'name' => trans('Pages::pages.pages')]
    ];

    $dbTable = '';
    if($items->count()){
        $dbTable = $items[0]['table'];
    }

@endphp

@extends('admin.master')
@section('page_title')
{{ trans('Pages::pages.pages') }}
@endsection
@section('content')

<!-- Include single delete confirmation model -->
@include('Core::modals.confirm-delete')
<!-- Include bulk delete confirmation model -->
@include('Core::modals.bulk-confirm-delete')

<div class="row">
    <div class="col-md-12">

        {{--<div class="admin-top-operation">--}}
            {{--<a class="btn btn-default" href="{{ action('\Piplmodules\Pages\Controllers\PagesController@create')}}">{{ trans('Pages::pages.create') }} {{ trans('Pages::pages.page') }}</a>--}}
        {{--</div>--}}

        @if($items->count())
            <form method="POST" action="{{ action('\Piplmodules\Pages\Controllers\PagesController@bulkOperations')}}" id="bulk" class="form-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                {{--<th>--}}
                                    {{--<input type="checkbox" name="check_all" id="checkall">--}}
                                {{--</th>--}}
                                <th>{{ trans('Core::operations.id') }}</th>
                                <th>{{ trans('Pages::pages.name') }}</th>
                                <th>{{ trans('Pages::pages.url') }}</th>
                                <th>{{ trans('Core::operations.status') }}</th>
                                <th>{{ trans('Core::operations.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr @if($item->trans) data-title="{{ $item->trans->name }}" @endif>
                                    {{--<td>--}}
                                        {{--<input type="checkbox" name="ids[]" class="check_list" value="{{$item->id}}">--}}
                                    {{--</td>--}}
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if($item->trans)
                                            {{ $item->trans->title }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->page_url)
                                            <a href="javascript:void(0);" onclick='return window.open("{{url('/')}}/{{ Lang::getLocale() }}/pages/{{$item->page_url}}" , "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=200,width=1024,height=600");' >{{url('/')}}/{{ Lang::getLocale() }}/pages/{{$item->page_url}}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->published == 1)
                                            {{ trans('Core::operations.active') }}
                                        @else
                                            {{ trans('Core::operations.inactive') }}
                                        @endif
                                    <td>
                                       <a href="{{ action('\Piplmodules\Pages\Controllers\PagesController@edit', $item->id) }}"><i class="fa fa-edit"></i> {{ trans('Core::operations.edit') }}</a>
                                      
                                       @if($item->id > 4)
                                       <a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $item->id }}" @if($item->trans) data-title="{{ $item->trans->name }}" @endif href="#full-width"><i class="fa fa-trash"></i> {{ trans('Core::operations.delete') }}</a>
                                       @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{--<div class="form-group">--}}
                    {{--<label for="operation">{{ trans('Core::operations.with_select') }}</label>--}}
                     {{--<select name="operation" id="operation" class="form-control" required="required">--}}
                        {{--<option value="">- {{ trans('Core::operations.select') }} -</option>--}}
                        {{--<option value="activate">{{ trans('Core::operations.activate') }}</option>--}}
                        {{--<option value="deactivate">{{ trans('Core::operations.deactivate') }}</option>--}}
                        {{--<option value="delete">{{ trans('Core::operations.delete') }}</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<button type="submit" class="btn btn-primary">{{ trans('Core::operations.go') }}</button>--}}

                <div class="table-footer">
                    <div class="count"><i class="fa fa-folder-o"></i> {{ $items->total() }} {{ trans('Core::operations.item') }}</div>
                    <div class="pagination-area"> {!! $items->render() !!} </div>
                </div>   
            </form>
        @else
            <div class="text-center">
                @if($_GET)
                    <h1>{{ trans('admin.no_results_found') }} <a href="{{ action('\Piplmodules\Pages\Controllers\PagesController@index')}}">{{ trans('admin.back') }}</a></h1>
                @else
                    <h1> لا توجد بيانات للعرض<a href="{{ action('\Piplmodules\Pages\Controllers\PagesController@create')}}">{{ trans('Ads::ads.create') }} {{ trans('Ads::ads.ad') }}</a></h1>
                @endif
             </div>
        @endif
    </div>
</div>
@endsection
@section('footer')
    <!--jquery-dependency-fields -->
    <script src="/vendor/core/js/jquery-dependency-fields/scripts.js"></script>
    <!--end jquery-dependency-fields -->
    <script src="{{ asset('public/admin_assets/js/index-operations.js') }}"></script>
@endsection