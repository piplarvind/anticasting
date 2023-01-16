@php
$itemTitle = $pageTitle = 'FAQ';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => route('admin.faq'), 'name' => $pageTitle];
$action = route('admin.faq.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.faq.update', $item->id);
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
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.faq') }}">{{ $pageTitle }}</a>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="question">Question <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control" id="question" name="question"
                                            value="{{ old('question', isset($item->question) ? $item->question : '') }}" />
                                        @error('question')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Answer <span class="impot-star">*</span></label>
                                        <textarea class="form-control" id="answer"
                                            name="answer">{{ old('answer', isset($item->answer) ? $item->answer : '') }}</textarea>
                                        @error('answer')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="order">Order <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control" id="order" name="order"
                                            placeholder="Order"
                                            value="{{ old('order', isset($item->order) ? $item->order : '') }}" />
                                        @error('order')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="checkbox">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="status" id="status" value="1"
                                        {{ isset($item->status) && $item->status == '1' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary scoler-details">{{ $submitButton }}</button>
                                <a class="btn btn-light" href="{{ route('admin.faq') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('answer');
    </script>
@endsection
