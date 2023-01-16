@extends('Media::iframe.master')
@section('content')
<h2 class="sub-header">{{ trans('admin.new_image_link') }}</h2>
    <form action="{{ action('MediaController@store_links') }}" method="POST" role="form" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group">
          <label for="">{{ trans('admin.Image URL') }}</label>
          <input type="text" name="images_links">
      </div>
      <button type="submit" class="btn btn-primary">{{ trans('admin.Submit') }}</button>
    </form>
@endsection