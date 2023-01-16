@php
$itemTitle = $pageTitle = 'Customer Reveiw';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => route('admin.testimonials'), 'name' => $pageTitle];
$action = route('admin.testimonials.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.testimonials.update', $item->id);
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
                            <a href="{{ route('admin.testimonials') }}">{{ $pageTitle }}</a>
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
                                        <label for="client_name">Customer Name <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control" id="client_name" name="client_name"
                                            value="{{ old('client_name', isset($item->client_name) ? $item->client_name : '') }}" />
                                        @error('client_name')
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
                                        <label for="testimonial">Review <span class="impot-star">*</span></label>
                                        <textarea class="form-control" id="testimonial"
                                            name="testimonial">{{ old('testimonial', isset($item->testimonial) ? $item->testimonial : '') }}</textarea>
                                        @error('testimonial')
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
                                        <label for="rating">Rating <span class="impot-star">*</span></label>
                                        <select class="form-control" id="rating" name="rating">
                                            <option value="1" @if( (isset($item->rating)?$item->rating:'') == 1 ) selected @endif>1</option>
                                            <option value="2" @if( (isset($item->rating)?$item->rating:'') == 2 ) selected @endif>2</option>
                                            <option value="3" @if( (isset($item->rating)?$item->rating:'') == 3 ) selected @endif>3</option>
                                            <option value="4" @if( (isset($item->rating)?$item->rating:'') == 4 ) selected @endif>4</option>
                                            <option value="5" @if( (isset($item->rating)?$item->rating:'') == 5 ) selected @endif>5</option>
                                        </select>
                                        @error('rating')
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
                                <a class="btn btn-light" href="{{ route('admin.testimonials') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
@endsection
