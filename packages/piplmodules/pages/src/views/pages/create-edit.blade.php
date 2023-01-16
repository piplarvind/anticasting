@php
$pageTitle = 'CMS Pages';
$itemTitle = 'CMS Page';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => route('admin.pages'), 'name' => $pageTitle];
$action = route('admin.pages.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.pages.update', $item->id);
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
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>{{ $pageNameMode }} {{ $itemTitle }}</h3>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pages') }}"> <i class="fa fa-table"></i> {{ $pageTitle }}</a>
                        </li>
                        <li class="active">
                            {{ $pageNameMode }} {{ $itemTitle }}
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
                        <form action="{{ $action }}" method="POST" role="form" enctype="multipart/form-data">
                            @if ($method === 'PATCH')
                                <input type="hidden" name="_method" value="PATCH">
                            @endif
                            {{ csrf_field() }}
                            <!-- Language field -->
                            @include('Core::fields.languages')
                            <div class="col-md-12">

                                @include('Core::groups.languages', [
                                'fields' => [
                                0 => [
                                'type' => 'input_text',
                                'properties' => [
                                'field_name' => 'name',
                                'name' => trans('Core::operations.name'),
                                'required' => true,
                                'placeholder' => '',
                                'value' => (isset($item->trans->title)) ? $item->trans->title : ""
                                ]
                                ]
                                ]
                                ])
                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                @include('Core::groups.languages', [
                                'fields' => [
                                0 => [
                                'type' => 'textarea',
                                'properties' => [
                                'field_name' => 'description',
                                'name' => trans('Pages::pages.description'),
                                'placeholder' => '',
                                'required' => true,
                                'value' => (isset($item->trans->body)) ? $item->trans->body : ""
                                ]
                                ]
                                ]
                                ])
                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                @include('Core::groups.languages', [
                                'fields' => [
                                0 =>[
                                'type' => 'input_text',
                                'properties' => [
                                'field_name' => 'page_seo_title',
                                'name' => trans('Pages::pages.page_seo_title'),
                                'placeholder' => '',
                                'value' => (isset($item->trans->page_seo_title)) ? $item->trans->page_seo_title : ""
                                ]

                                ],
                                1 =>[
                                'type' => 'input_text',
                                'properties' => [
                                'field_name' => 'page_meta_keywords',
                                'name' => trans('Pages::pages.page_meta_keywords'),
                                'placeholder' => '',
                                'value' => (isset($item->trans->page_meta_keywords)) ? $item->trans->page_meta_keywords : ""
                                ]

                                ],
                                2 => [
                                'type' => 'textarea',
                                'properties' => [
                                'field_name' => 'page_meta_description',
                                'name' => trans('Pages::pages.page_meta_description'),
                                'placeholder' => '',
                                'value' => (isset($item->trans->page_meta_descriptions)) ?
                                $item->trans->page_meta_descriptions : ""
                                ]
                                ]
                                ]
                                ])

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="certification_award">Upload Image</label>
                                            <input type="file" name="top_image_en" id="top_image_en">
                                            @error('top_image_en')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if ($item->trans->top_image)
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="certification_award">Uploaded Image: </label>
                                                <img height="150"
                                                    src="{{ asset('public/img/cms-images/thumbnail/small') . '/' . $item->trans->top_image }}">
                                                <a href="{{ route('admin.pages.remove-cms-page-image', [$item->id]) }}">Remove
                                                    Image</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn scoler-details btn-primary">{{ $submitButton }}</button>
                                <a class="btn btn-light" href="{{ route('admin.pages') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    {{-- added for ckeditor start here --}}
    {{-- <script src="{{url('/')}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description_en');
    </script>
    {{-- added for ckeditor end here --}}
@endsection
