@extends('admin.master')
@section('content')
<div class="row">
	<div class="col-md-12">
	    <form action="{{ action('\Piplmodules\Media\Controllers\MediaController@update', $media->id) }}" method="POST" role="form">
	        {{ csrf_field() }}
	        <input type="hidden" name="_method" value="PATCH">
	        <div class="form-group">
	            <label for="">label</label>
	            <input type="text" class="form-control" id="" placeholder="Input field">
	        </div>

	        <button type="submit" class="btn btn-primary">Update</button>
	    </form>
	</div>
</div>
@endsection