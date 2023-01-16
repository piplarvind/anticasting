@php
$itemTitle = $pageTitle = 'Sending Limit';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => route('admin.sendlimits'), 'name' => $pageTitle];
$action = route('admin.sendlimits.attributes.store', [$id]);
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.sendlimits.attributes.update', [$id, $item->id]);
    $method = 'PATCH';
    $backFieldLabel = 'Back After Update';
    $submitButton = 'Update';
} else {
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.create') . ' ' . $itemTitle];
}
@endphp
@extends('layouts.admin-account-app')
@section('title')
    {{ $pageTitle }}: {{ $pageNameMode }} {{ $itemTitle }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <link href="{{ asset('public/vendor/sendlimits/css/summernote-bs4.min.css') }}" rel="stylesheet" media="print"
        onload="this.media='all'" />
    <style>
        ul,
        ol {
            padding: 20px;
        }

        ul li,
        ol li {
            list-style: auto;
            display: list-item;
            text-align: -webkit-match-parent;
        }

        ::marker {
            unicode-bidi: isolate;
            font-variant-numeric: tabular-nums;
            text-transform: none;
            text-indent: 0px !important;
            text-align: start !important;
            text-align-last: start !important;
        }

    </style>

    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>{{ $pageNameMode }} {{ $itemTitle }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.sendlimits') }}">{{ $pageTitle }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.sendlimits.attributes', [$id]) }}">{{ $pageTitle }}
                                Attributes</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pageNameMode }} {{ $itemTitle }}
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $action }}" method="POST" role="form">
                            @if ($method === 'PATCH')
                                <input type="hidden" name="_method" value="PATCH">
                            @endif
                            {!! csrf_field() !!}
                            <input type="hidden" name="sending_limit_id" id="sending_limit_id"
                                value="{{ $id }}" />

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name <span class="impot-star">*</span></label>
                                        <input type="text" readonly class="form-control" id="name" name="name"
                                            value="{{ old('name', isset($tier->name) ? $tier->name : '') }}" />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="one_day">24 Hours <span class="impot-star">*</span></label>
                                        <input class="form-control" id="one_day" name="one_day"
                                            value="{{ old('one_day', isset($item->one_day) ? $item->one_day : '24 Hours') }}" />
                                        @error('one_day')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="one_day_price">24 Hours Price <span
                                                class="impot-star">*</span></label>
                                        <input class="form-control" id="one_day_price" name="one_day_price"
                                            value="{{ old('one_day_price', isset($item->one_day_price) ? $item->one_day_price : '') }}" />
                                        @error('one_day_price')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="thirty_day">30 Days <span class="impot-star">*</span></label>
                                        <input class="form-control" id="thirty_day" name="thirty_day"
                                            value="{{ old('thirty_day', isset($item->thirty_day) ? $item->thirty_day : '30 Days') }}" />
                                        @error('thirty_day')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="thirty_day_price">30 Days Price <span
                                                class="impot-star">*</span></label>
                                        <input class="form-control" id="thirty_day_price" name="thirty_day_price"
                                            value="{{ old('thirty_day_price', isset($item->thirty_day_price) ? $item->thirty_day_price : '') }}" />
                                        @error('thirty_day_price')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="half_yearly">180 Days <span class="impot-star">*</span></label>
                                        <input class="form-control" id="half_yearly" name="half_yearly"
                                            value="{{ old('half_yearly', isset($item->half_yearly) ? $item->half_yearly : '180 Days') }}" />
                                        @error('half_yearly')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="half_yearly_price">180 Days Price <span
                                                class="impot-star">*</span></label>
                                        <input class="form-control" id="half_yearly_price" name="half_yearly_price"
                                            value="{{ old('half_yearly_price', isset($item->half_yearly_price) ? $item->half_yearly_price : '') }}" />
                                        @error('half_yearly_price')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary scoler-details">{{ $submitButton }}</button>
                                <a class="btn btn-light" href="{{ route('admin.sendlimits') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script src="{{ asset('public/vendor/sendinglimits/js/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#information_needed').summernote({
                placeholder: 'Enter policy',
                // tabsize: 2,
                height: 300,
                // followingToolbar: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                }

            })
        });
    </script>
@endsection
