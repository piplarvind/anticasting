@extends('admin.master')
@section('content')
	<div class="right-auth-landing">
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
		<form action="{{ route('admin.media.delete', $media->id) }}" method="POST" role="form">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="DELETE">

			<div class="form-group">
				<label for="">label</label>
				<input type="text" class="form-control" id="" placeholder="Input field">
			</div>

			<button type="submit" class="btn btn-primary">Delete</button>
		</form>
	</div>
@endsection