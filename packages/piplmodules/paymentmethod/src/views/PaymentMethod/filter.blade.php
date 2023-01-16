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
                    $payment_method_name_value = '';
                    if (isset($_GET['payment_method_name'])) {
                        $payment_method_name_value = $_GET['payment_method_name'];
                    }
                @endphp
                <div class="form-group">
                    <label for="payment_method_name">Payment Method Name</label>
                    <input type="text" class="form-control" name="payment_method_name" id="payment_method_name"
                        value="{{ $payment_method_name_value }}">
                    <label></label>
                    <button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
                    <label></label>
                    <a href="{{ route('admin.country.send') }}"
                        class="btn btn-light">{{ trans('Core::operations.reset') }}</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    <a class="btn btn-success pull-right" style="margin-bottom: 5px;"
                        href="{{ route('admin.paymentmethod.create') }}">Create Payment Method</a>
                </div>
            </div>
        </form>
    </div>
</div>
