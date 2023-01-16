@extends('admin.master')
@section('title')
    Upload Gallery
@endsection
@section('content')
    <div class="right-auth-landing">
        <div class="all-heads">
            <h3>Gallery</h3>
            {{--<span class="pull-right"><a class="btn btn-default" href="{{ route('admin.customers.create') }}">Create Sub Admin</a></span>--}}
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.media') }}"> <i class="fa fa-picture-o"></i> Gallery</a>
                </li>
                <li class="active">
                    Gallery
                </li>
            </ol>
            {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
        </div>
        <form action="{{ route('admin.media.upload') }}" method="POST" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <h1>Upload New Media</h1>
            <div class="form-group">
                <input type="file" name="file" id="file" />
                @error('file')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                {{--<p class="help-block">
                    Switch to the multi-file uploader.
                </p>--}}
                <p class="help-block">
                    Maximum upload file size: 2 MB.
                </p>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection