<div class="panel panel-default panel-filter">
	<div class="panel-footer">

        <form action="" method="GET" class="form-inline">
        	{{-- name --}}
        	@php
		  		$nameValue = '';
		  		if(isset($_GET['name'])){
            		$nameValue = $_GET['name'];
            	}
		  	@endphp

		  	@include('Core::fields.input_text', [
                'field_name' => 'name',
                'name' => trans('Core::operations.name'),
                'value' => $nameValue,
                'placeholder' => ''
            ])
            

            {{-- Select --}}
            @php
            	$statusValue = '';
            	if(isset($_GET['status'])){
            		$statusValue = $_GET['status'];
            	}
            @endphp

            @include('Core::fields.select', [
                'field_name' => 'status',
                'name' => trans('Core::operations.status'),
                'value' => $statusValue,
                'options' => [
                				['value' => '', 'name' => '-- '.trans('Core::operations.select').' --'],
                                ['value' => 1, 'name' => trans('Core::operations.active')],
                                ['value' => 2, 'name' => trans('Core::operations.inactive')]
                ]
            ])

		  	<button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
		  	<a href="{{ action('\Piplmodules\Users\Controllers\AdminController@index')}}" class="btn btn-default">{{ trans('Core::operations.reset') }}</a>
		</form>

	</div>
</div>