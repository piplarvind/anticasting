@php
$pageTitle = 'Pages';
$itemTitle = 'Page';
$breadcrumbs = [['url' => '', 'name' => $pageTitle]];

$dbTable = '';
if ($items->count()) {
    $dbTable = $items[0]['table'];
}
$dbTable = 'pages';
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
                <!-- Include single delete confirmation model -->
                @include('Core::modals.confirm-delete')
                <!-- Include bulk delete confirmation model -->
                @include('Core::modals.bulk-confirm-delete')

                <div class="all-heads">
                    <h3>All Pages</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Pages
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
                        <form method="POST"
                            action="{{ action('\Piplmodules\Pages\Controllers\PagesController@bulkOperations') }}"
                            id="bulk" class="form-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>#</th>
                                            <th>{{ trans('Pages::pages.name') }}</th>
                                            <th>{{ trans('Pages::pages.url') }}</th>
                                            <th>{{ trans('Core::operations.operations') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr @if ($item->trans) data-title="{{ $item->trans->name }}" @endif>
                                                <td>{{ $item->id }}</td>
                                                <td>
                                                    @if ($item->trans)
                                                        {{ $item->trans->title }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->page_url)
                                                        <a href="javascript:void(0);"
                                                            onclick='return window.open("{{ url('/') }}/{{ $item->page_type }}/{{ $item->page_url }}" , "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=200,width=1024,height=600");'>{{ url('/') }}/{{ $item->page_type }}/{{ $item->page_url }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="act-link">
                                                        <a class="btn btn-primary shadow btn-xs sharp mr-1"
                                                            href="{{ route('admin.pages.edit', $item->id) }}"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-footer">
                                <div class="count"><i class="fa fa-folder-o"></i> {{ $items->total() }}
                                    {{ trans('Core::operations.item') }}</div>
                                <div class="pagination-area"> {!! $items->render() !!} </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
