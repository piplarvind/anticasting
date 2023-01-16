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
                    $sendingLimitValue = '';
                    if (isset($_GET['name'])) {
                        $sendingLimitValue = $_GET['name'];
                    }
                @endphp
                <div class="form-group">
                    <label for="name">Tier Name</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $sendingLimitValue }}">
                    <label></label>
                    <button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
                    &nbsp;<a href="{{ route('admin.sendlimits') }}"
                        class="btn btn-light">{{ trans('Core::operations.reset') }}</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    {{-- <a class="btn btn-success pull-right" style="margin-bottom: 5px;"
                        href="{{ route('admin.sendlimits.create') }}">Add Sending Limit</a> --}}
                </div>
            </div>
        </form>
    </div>
</div>
