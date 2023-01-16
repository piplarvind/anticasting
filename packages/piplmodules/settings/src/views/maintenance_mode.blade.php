@php
    $pageNameMode = trans('Settings::settings.maintenance_mode');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Settings::settings.setting').' '.trans('Settings::settings.maintenance_mode')];
    $action = action('\Piplmodules\Settings\Controllers\SettingsController@updateMaintenanceMode');
    $submitButton = trans('admin.update');
@endphp

@extends('admin.master')
@section('page_title')
{{ trans('Settings::settings.settings') }}: {{ $pageNameMode }}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                    {{ trans('Settings::settings.setting') }} 
                    {{ $pageNameMode }}
                </h3>
            </div>
            <div class="panel-body">
                <form action="{{ $action }}" method="POST" role="form">
                    {{ csrf_field() }}
                    <div class="col-md-9">
                        @include('Core::fields.select', [
                            'field_name' => 'mode',
                            'name' => trans('Settings::settings.maintenance_mode'),
                            'options' => [
                                ['value' => 1, 'name' => trans('Settings::settings.activate_maintenance_mode')],
                                ['value' => 2, 'name' => trans('Settings::settings.inactivate_maintenance_mode')]
                            ]
                        ])
                    </div>
                    <div class="col-md-3 sidbare">
                        <button type="submit" class="btn btn-block btn-primary">{{ $submitButton }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection