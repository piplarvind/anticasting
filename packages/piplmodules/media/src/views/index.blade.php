@extends('admin.master')
@section('title')
    Gallery
@endsection
@section('header')
    <link rel="stylesheet" href="{{asset('public/backend/css/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('public/backend/css/media-dev.css')}}" />
@endsection
@section('content')
    <!-- Include Media model -->
    @include('Media::modals.modal')
    <!-- end include Media model -->

    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
        <div class="all-heads">
            <h3>Gallery</h3>
            {{--<span class="pull-right"><a class="btn btn-default" href="{{ route('admin.customers.create') }}">Create Sub Admin</a></span>--}}
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li class="active">
                    Gallery
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        <!-- Media main image -->

                    <div class="row" style="margin: 0 0 0 5px; padding-bottom: 5px;">
        <div class="form-group {{ $errors->has('main_image_id') ? 'has-error': '' }}" style="text-align: center;">
            {{--<label style="display: block;">{{ trans('Users::users.avatar') }}</label>--}}
            <a data-toggle="modal" data-target="#pipl_media_modal" href="javascript:void(0)" media-data-button-name="{{ trans('Core::operations.select') }}ر{{ trans('Users::users.avatar') }}" media-data-field-name="main_image_id" media-data-required>
                <div class="media-item">
                    @if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']))
                        {{--<img src="{{url('/')}}/{{ $item->media->main_image->styles['thumbnail'] }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">--}}
                        <input type="hidden" name="main_image_id" value="{{$item->media->main_image->id}}">
                    @else
                        {{--<img src="{{ asset('public/images/select_main_img.png') }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">--}}
                        <button type="button" class="btn btn-success pull-right" id="upload_img" >Upload Image</button>
                    @endif
                </div>
            </a>
        </div>
                    </div>
        <!-- End Media main image -->
        {{--@if($items->count() || $_GET)
            @include('Essaytopics::essaytopics.filter')
        @endif--}}
                <div class="table-responsive essay-table">
        <form method="POST" action="{{ route('admin.essay-topics.bulk-operations') }}" id="bulk" class="form-inline">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="table-responsive essay-table">
                {{--<a class="btn btn-default" href="{{ route('admin.media.add') }}">Upload</a>--}}
                <table class="table table-hover">
                    <thead>
                    <tr>
                        {{--<th>
                            <input type="checkbox" name="check_all" id="checkall">
                        </th>--}}
                        <th>File</th>
                        <th>Name</th>
                        <th>Upload Date</th>
                        {{--<th>Last update</th>--}}
                        <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody id="pipl-gallery-list">
                    @if(isset($items))
                        @php
                            $files = ['jpg', 'png', 'gif','jpeg','JPG','PNG','GIF','JPEG'];
                        @endphp
                        @foreach($items as $file)
                            <tr data-id="{{ $file->id }}">
                                <td class="media-img">
                                    <div>
                                        <img width="60" height="60" class="attachment-60x60 size-60x60" src="public/{{ $file->options['styles']['small'] }}" alt="">
                                    </div>
                                    {{--<strong class="has-media-icon">
                                        <a href="{{ route('admin.media.edit', $file->id)}}" aria-label="“dog usage” (Edit)">
                                    <span class="media-icon image-icon">
                                        <img width="60" height="60" class="attachment-60x60 size-60x60" src="public/{{ $file->options['styles']['small'] }}" alt="">
                                    </span>
                                        </a>
                                    </strong>--}}
                                </td>
                                <td>
                                    {{ $file['title'] }}
                                </td>
                                <td>{{ $file->created_at }}</td>
                                {{--<td>{{ $file->updated_at }}</td>--}}
                                <td>
                                    {{--<a href="public/{{ $file->options['styles']['small'] }}" target="_blank">View</a>--}}
                                    <a href="{{ route('admin.media.delete', $file->id) }}" onclick="return confirm('Do you really want to delete this item?');">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="filter-sel" style="padding: 0 20px;">
                    <div class="row" >
                        <div class="table-footer">
                            <div class="count"><i class="fa fa-folder-o"></i> {{ $items->total() }} {{ trans('Core::operations.item') }}</div>
                            <div class="pagination-area"> {!! $items->render() !!} </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
                </div>
    </div>
        </div>
    </div>
@endsection
@section('footer')
    <!--Language -->
    {{--    @include('Core::language.scripts.scripts')--}}
    <!--end Language -->
    <!--Media -->
    <script src="{{asset('public/backend/js/jquery-ui.js')}}"></script>
    <script src="{{asset('public/backend/js/media-dev.js')}}"></script>
    <!--end media -->
@endsection