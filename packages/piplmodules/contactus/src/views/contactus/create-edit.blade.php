@php
$pageTitle = 'Contact Us';
$pageNameMode = trans('Core::operations.create');
$breadcrumbs[] = ['url' => url('/') . '/' . Lang::getLocale() . '/admin/banners', 'name' => trans('Banners::banners.banners')];
$action = action('\Piplmodules\Banners\Controllers\BannersController@store');
$method = '';
$backFieldLabel = trans('admin.add_new_after_save');
$submitButton = trans('admin.save');
if (Request::is('*/edit')) {
    $pageNameMode = trans('Core::operations.edit');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.edit') . ' ' . trans('Banners::banners.banner')];
    $action = action('\Piplmodules\Banners\Controllers\BannersController@update', $item->id);
    $method = 'PATCH';
    $backFieldLabel = trans('admin.back_after_update');
    $submitButton = trans('admin.update');
} else {
    $breadcrumbs[] = ['url' => '', 'name' => trans('Core::operations.create') . ' ' . trans('Banners::banners.banner')];
}
@endphp

@extends('layouts.admin-account-app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <!-- Include Media model -->
            @include('Media::modals.modal')
            <!-- end include Media model -->
            <!-- Include Media model -->
            @include('Media::modals.gallery-modal')
            <!--<link href="{{ asset('admin_assets/css/pages/tables-rtl.css') }}" rel="stylesheet" />-->

            <link href="{{ asset('media-dev.css') }}" rel="stylesheet" />
            <!-- end include Media model -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff"
                                    data-hc="#fff" data-loop="true"></i> {{ $pageNameMode }}
                                {{ trans('Pages::pages.page') }}</h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ $action }}" method="POST" role="form" enctype="multipart/form-data">
                                @if ($method === 'PATCH')
                                    <input type="hidden" name="_method" value="PATCH">
                                @endif
                                {{ csrf_field() }}
                                <div class="col-md-9">
                                    @include('Core::groups.languages', [
                                    'fields' => [
                                    0 => [
                                    'type' => 'input_text',
                                    'properties' => [
                                    'field_name' => 'name',
                                    'name' => trans('Core::operations.name'),
                                    'placeholder' => ''
                                    ]
                                    ]
                                    ]
                                    ])
                                    <div class="form-group ">
                                        <label for="section">{{ trans('Banners::banners.image') }}</label>
                                        @if (Request::is('*/edit'))
                                            <input type="file" name="banner_img" id="banner_img" />
                                        @else
                                            <input type="file" name="banner_img" id="banner_img" />
                                        @endif
                                        <input type="hidden" name="banner_img_old" id="banner_img_old"
                                            @if (isset($item)) value="{{ $item->trans->banner_img }}" @endif />
                                    </div>
                                    @if (isset($item) && file_exists(public_path('/uploads/banners') . '/' . $item->trans->banner_img))
                                        <img width="60" height="60"
                                            src="{{ url('/uploads/banners') }}/{{ $item->trans->banner_img }}" alt="">
                                    @else
                                        <img src="{{ asset('images/select_main_img.png') }}" width="60">
                                    @endif

                                    <div class="form-group">
                                        <label for="URL">URL</label>
                                        <input @if (isset($item->trans->url)) value="{{ $item->trans->url }}" @endif type="text" value="" id="banner_object_url"
                                            name="banner_object_url" class="form-control">
                                        For Example:- http:// |your domain|.com
                                    </div>

                                    @include('Core::fields.input_text', [
                                    'field_name' => 'start_date',
                                    'name' => trans('Banners::banners.start_at'),
                                    'placeholder' => trans('Banners::banners.start_at'),
                                    'value' => isset($item) ? old('start_date',$item->start_date) : ""
                                    ])
                                    @include('Core::fields.input_text', [
                                    'field_name' => 'end_date',
                                    'name' => trans('Banners::banners.end_at'),
                                    'placeholder' => trans('Banners::banners.end_at'),
                                    'value' => isset($item) ? old('end_date',$item->end_date) : ""
                                    ])
                                </div>
                                <div class="col-md-3 sidbare">
                                    <!-- Language field -->
                                    @include('Core::fields.languages')
                                    <!-- End Language field -->

                                    @include('Core::fields.checkbox', [
                                    'field_name' => 'active',
                                    'name' => trans('admin.active'),
                                    'placeholder' => ''
                                    ])
                                    <div class="checkbox">
                                        <label><input name="back" type="checkbox" value="1" class="minimal-blue"
                                                @if (old('back') == 1) checked @endif> {{ $backFieldLabel }}</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ $submitButton }}</button>
                                    <a class="btn btn-light" href="{{ route('admin.contactus') }}">Cancel</a>
                                </div>
                            </form>
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

    <!--Media -->
    @include('Media::scripts.scripts')
    <script>
        $('#banner_img').change(function() {
            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                case 'JPG':
                case 'JPEG':
                case 'PNG':
                case 'GIF':
                    break;
                default:
                    alert('الرجاء تحميل ملف فقط من النوع جبغ، ينغ، جيف، جبغ.');
                    this.value = '';
            }
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('jquery-timepicker-addon-master/jquery-ui-timepicker-addon.css') }}">
    <script src="{{ asset('jquery-timepicker-addon-master/jquery-ui-timepicker-addon.js') }}"></script>
    <script src="{{ asset('jquery-timepicker-addon-master/jquery-ui-sliderAccess.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var startDateTextBox = $('#start_date');
            var endDateTextBox = $('#end_date');
            startDateTextBox.datetimepicker({
                minDate: '+0d',
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss',
                //                minInterval: (1000*60*60), // 1hr
                onClose: function(dateText, inst) {
                    if (endDateTextBox.val() != '') {
                        var testStartDate = startDateTextBox.datetimepicker('getDate');
                        var testEndDate = endDateTextBox.datetimepicker('getDate');
                        if (testStartDate > testEndDate) {
                            endDateTextBox.datetimepicker('setDate', testStartDate);
                            //                            endDateTextBox.datetimepicker({
                            //                                minInterval: (1000 * 60 * 60), // 1hr
                            //                            });
                        }
                    } else {
                        endDateTextBox.val(dateText);
                    }
                },
                onSelect: function(selectedDateTime) {
                    endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker(
                        'getDate'));
                }
            });
            endDateTextBox.datetimepicker({
                minDate: '+0d',
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm:ss',
                //                minInterval: (1000*60*60), // 1hr
                onClose: function(dateText, inst) {
                    if (startDateTextBox.val() != '') {
                        var testStartDate = startDateTextBox.datetimepicker('getDate');
                        var testEndDate = endDateTextBox.datetimepicker('getDate');
                        if (testStartDate > testEndDate)
                            startDateTextBox.datetimepicker('setDate', testEndDate);
                    } else {
                        startDateTextBox.val(dateText);
                    }
                },
                onSelect: function(selectedDateTime) {
                    startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker(
                        'getDate'));
                }
            });

        });
    </script>

@endsection
