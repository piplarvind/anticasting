@php
$itemTitle = $pageTitle = 'Receive Country';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => route('admin.country.receive'), 'name' => $pageTitle];
$action = route('admin.country.receive.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.country.receive.update', $item->id);
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
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.country.receive') }}">{{ $pageTitle }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pageNameMode }} {{ $itemTitle }}
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                            @if ($method === 'PATCH')
                                <input type="hidden" name="_method" value="PATCH">
                            @endif
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="country_name">Country Name <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control @error('country_name') is-invalid @enderror"
                                            id="country_name" name="country_name"
                                            value="{{ old('country_name', isset($item->country_name) ? $item->country_name : '') }}" />
                                        @error('country_name')
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
                                        <label for="country_name">Country ISO Code <span
                                                class="impot-star">*</span></label>
                                        <input type="text"
                                            class="form-control @error('country_iso_code') is-invalid @enderror"
                                            id="country_iso_code" name="country_iso_code"
                                            value="{{ old('country_iso_code', isset($item->country_iso_code) ? $item->country_iso_code : '') }}" />
                                        @error('country_iso_code')
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
                                        <label for="phone_code">Phone Code <span class="impot-star">*</span></label>
                                        <input type="tel" class="form-control @error('phone_code') is-invalid @enderror"
                                            id="phone_code" name="phone_code"
                                            value="{{ old('phone_code', isset($item->phone_code) ? $item->phone_code : '') }}" />
                                        @error('phone_code')
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
                                        <label for="country_name">Currency <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control @error('currency') is-invalid @enderror"
                                            id="currency" name="currency"
                                            value="{{ old('currency', isset($item->currency) ? $item->currency : '') }}" />
                                        @error('currency')
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
                                        <label for="flag">Country Flag <span class="impot-star">*</span></label>
                                        <input type="file" name="flag" id="flag" class="form-control" />
                                        @error('flag')
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
                                <a class="btn btn-light" href="{{ route('admin.country.receive') }}">Cancel</a>
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
