@php
$pageTitle = 'Email Template';
$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => url('/') . '/' . Lang::getLocale() . '/admin/emailtemplates', 'name' => trans('Emailtemplates::emailtemplate.emailtemplates')];
$action = action('\Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@store');
$method = '';
$backFieldLabel = trans('admin.add_new_after_save');
$submitButton = 'Submit';
if (Request::is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . trans('Emailtemplates::emailtemplate.emailtemplate')];
    $action = action('\Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@update', $item->id);
    $method = 'PATCH';
    $backFieldLabel = trans('admin.back_after_update');
    $submitButton = 'Update';
} else {
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.create') . ' ' . trans('Emailtemplates::emailtemplate.emailtemplate')];
}
@endphp

@extends('layouts.admin-account-app')
@section('title')
    {{ trans('Emailtemplates::emailtemplate.emailtemplates') }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Edit Email Template </h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin/emailtemplates"> Email Templates</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Edit Email Template
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
                                        <label for="subject">Subject <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control" id="subject" name="subject"
                                            placeholder="Subject" value="{{ $trans->subject }}" />
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Email <span class="impot-star">*</span></label>
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="html_content">Content <span class="impot-star">*</span></label>
                                        <textarea class="form-control" id="html_content"
                                            name="html_content">{{ $trans->html_content }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary scoler-details">{{ $submitButton }}</button>
                                <a class="btn btn-light" href="{{ route('admin.emailtemplates') }}">Cancel</a>
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
        CKEDITOR.replace('html_content');

        $(document).ready(function() {
            $('#lang-en').attr('onClick', 'return false');
        });
    </script>
@endsection
