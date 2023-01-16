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
                    $country_name_value = '';
                    if (isset($_GET['country_name'])) {
                        $country_name_value = $_GET['country_name'];
                    }
                @endphp
                <div class="form-group">
                    <label for="country_name">Country Name </label>
                    <input type="text" class="form-control" name="country_name" id="country_name"
                        value="{{ $country_name_value }}">
                    <label></label>
                    <button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
                    <label></label>
                    <a href="{{ route('admin.country.receive') }}"
                        class="btn btn-light">{{ trans('Core::operations.reset') }}</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    <a class="btn btn-success pull-right" style="margin-bottom: 5px;"
                        href="{{ route('admin.country.receive.create') }}">Create Country</a>
                </div>
            </div>
        </form>
    </div>
</div>
