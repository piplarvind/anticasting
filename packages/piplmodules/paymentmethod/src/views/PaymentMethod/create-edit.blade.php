@php
$itemTitle = $pageTitle = 'Payment Method';

$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => route('admin.paymentmethod.list'), 'name' => $pageTitle];
$action = route('admin.paymentmethod.store');
$method = '';

$backFieldLabel = 'Add New After Save';
$submitButton = 'Submit';

if (request()->is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . $itemTitle];
    $action = route('admin.paymentmethod.update', $item->id);
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
                            <a href="{{ route('admin.paymentmethod.list') }}">{{ $pageTitle }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $pageNameMode }} {{ $itemTitle }}
                        </li>
                    </ol>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $action }}" method="POST">
                            @if ($method === 'PATCH')
                                <input type="hidden" name="_method" value="PATCH">
                            @endif
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="payment_method_name">Payment Method Name<span
                                                class="impot-star">*</span></label>
                                        <input type="text"
                                            class="form-control @error('payment_method_name') is-invalid @enderror"
                                            id="payment_method_name" name="payment_method_name"
                                            value="{{ old('payment_method_name', isset($item->payment_method_name) ? $item->payment_method_name : '') }}" />
                                        @error('payment_method_name')
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
@endsection
