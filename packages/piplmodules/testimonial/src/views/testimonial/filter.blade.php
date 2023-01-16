<style>
    label {
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
                    $testimonialValue = '';
                    if (isset($_GET['client_name'])) {
                        $testimonialValue = $_GET['client_name'];
                    }
                @endphp
                <div class="form-group">
                    <label for="client_name">Customer Name</label>
                    <input type="text" class="form-control" name="client_name" id="client_name"
                        value="{{ $testimonialValue }}">
                    <label></label>
                    <button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
                    <a href="{{ route('admin.testimonials') }}"
                        class="btn btn-light">{{ trans('Core::operations.reset') }}</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    <a class="btn btn-success pull-right" style="margin-bottom: 5px;"
                        href="{{ route('admin.testimonials.create') }}">Add Customer Review</a>
                </div>
            </div>
        </form>
    </div>
</div>
