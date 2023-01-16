<style>
	label{
		padding: 5px;
	}
	.form-group {
		padding: 5px;
	}
</style>
<div class="panel panel-default panel-filter">
	<div class="panel-footer">
		<form action="" method="GET" class="form-inline">
			<div class="col-md-8" style="padding: 0px;">
			@php
				$questionValue = '';
                if(isset($_GET['question'])){
                    $questionValue = $_GET['question'];
                }
			@endphp
			<div class="form-group">
				<label for="question">Question </label>
				<input type="text" class="form-control" name="question" id="question" value="{{ $questionValue }}">
				<label></label>
			<button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
		  	<a href="{{ route('admin.faq')}}" class="btn btn-light">{{ trans('Core::operations.reset') }}</a>
			</div>
			</div>
			<div class="col-md-4">
			<div class="pull-right">
				<a class="btn btn-success pull-right" style="margin-bottom: 5px;" href="{{ route('admin.faq.create') }}">Create FAQ</a>
			</div>
			</div>
		</form>
	</div>
</div>