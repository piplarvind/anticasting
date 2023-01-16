@php
$pageTitle = 'Contact Us';
$breadcrumbs = [['url' => '', 'name' => trans('Contactus::contactus.contactus')]];
$dbTable = 'contact_us_replies';
@endphp

@extends('layouts.admin-account-app')
@section('title')
    {{ trans('Contactus::contactus.contactus') }}
@endsection
@section('header')
    <!-- datetimepicker-->
    <link href="{{ asset('public/admin_assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet" media="screen" />
    <!-- End datetimepicker -->
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Contact Us</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.contact-us') }}"> Contact Us</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Contact Us Reply
                        </li>
                    </ol>
                </div>
                <div class="default-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab_1_1" data-toggle="tab">Contact Us Request</a>
                        </li>
                        <li class="nav-item @if ($errors->has('email') || $errors->has('subject') || $errors->has('message')) active @endif">
                            <a class="nav-link" href="#tab_1_3" data-toggle="tab">Post Reply</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab_1_2" data-toggle="tab">Your Replies</a>
                        </li>

                    </ul>
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
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane @if (!($errors->has('email') || $errors->has('subject') || $errors->has('message'))) active @endif" id="tab_1_1">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Name:</b></label>
                                            <div class="col-sm-5">
                                                <label class="control-label">@if (isset($item)){{ $item->first_name . ' ' . $item->last_name }}@endif</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="control-label col-sm-4"><b>{{ trans('Contactus::contactus.email') }}:</b></label>
                                            <div class="col-sm-5">
                                                <label class="control-label">@if (isset($item)){{ $item->email }}@endif</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-4"><b>Phone Number:</b></label>
                                            <div class="col-sm-5">
                                                <label class="control-label">@if (isset($item)){{ $item->phone_number }}@endif</label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="control-label col-sm-4"><b>{{ trans('Contactus::contactus.date') }}:</b></label>
                                            <div class="col-sm-5">
                                                <label class="control-label">@if (isset($item)){{ $item->created_at->format('d M, Y') }}@endif</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="control-label col-sm-4"><b>{{ trans('Contactus::contactus.message') }}:</b></label>
                                            <div class="col-sm-5">
                                                <label class="control-label">@if (isset($item)){!! $item->msg_content !!}@endif</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane @if ($errors->has('email') || $errors->has('subject') || $errors->has('message')) active @endif" id="tab_1_3">
                                    @if (isset($item))
                                        <form role="form" class="form-horizontal" method="post"
                                            action="{{ route('admin.contact-us.save-reply', $item->id) }}"
                                            enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="form-group @if ($errors->has('email')) has-error @endif">
                                                <label class="control-label col-sm-4"><b>Email From:</b></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" name="email"
                                                        value="{{ old('email', $item->email) }}" readonly="" />
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong
                                                                class="text-danger">{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('message')) has-error @endif">
                                                <label class="control-label col-sm-4"><b>Message:</b></label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="reply_message"
                                                        name="message">{{ old('message') }}</textarea>
                                                    @if ($errors->has('message'))
                                                        <span class="help-block">
                                                            <strong
                                                                class="text-danger">{{ $errors->first('message') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('message')) has-error @endif">
                                                <label class="control-label col-sm-4"></label>
                                                <div class="col-sm-5">
                                                    <button type="submit" class="btn btn-md btn-primary">Post Reply</button>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-center alert alert-danger">
                                            {{ trans('Core::operations.no_records') }}
                                        </div>
                                    @endif
                                </div>
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <div class="chat-blok ">
                                        @if (isset($item) && $item->is_reply == 1)
                                            <ul>
                                                @foreach ($item->replies()->orderBy('created_at', 'desc')->get()
        as $key => $reply)
                                                    <li>
                                                        <div class="cht-msg ">
                                                            {{-- <div class="media-left"> --}}
                                                            {{-- <span class="c-text-name">Joy J</span> --}}
                                                            {{-- </div> --}}
                                                            <div class="media-body">
                                                                <br />
                                                                <div class="c-text">{!! $reply->reply_msg !!}</div>
                                                                <div class="chat-info">
                                                                    <ul>
                                                                        <li>
                                                                            <span><i class="fa fa-calendar"></i>
                                                                                {{ $reply->created_at->format('d M, Y H:i:s a') }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <span><i class="fa fa-envelope "></i>
                                                                                {{ $item->email }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <hr>
                                                @endforeach
                                            </ul>
                                        @else
                                            <br />
                                            <div class="text-center alert alert-danger">
                                                {{ trans('Core::operations.no_records') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <a class="btn btn-light" href="{{ route('admin.contact-us') }}">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
    <!--Language -->
    @include('Core::language.scripts.scripts')
    <!--end Language -->

    <!--datetime picker for time filter-->
    <script type="text/javascript"
        src="{{ asset('public/admin_assets/vendors/datetimepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8">
    </script>
    <script src="{{ asset('public/admin_assets/js/pages/pickers.js') }}"></script>
    <!--end datetime picker for time filter-->
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('reply_message');
    </script>
@endsection
