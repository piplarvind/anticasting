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
        <form method="post" class="form-inline" name="frmReport" id="frmReport">
            {{ csrf_field() }}
            <input type="hidden" name="isExport" id="isExport" value="" autocomplete="off">
            <div class="col-md-12" style="padding: 0px;">
                @php
                    $searchValue = '';
                    if (isset($_GET['search_date'])) {
                        $testimonialValue = $_GET['search_date'];
                    }
                @endphp
                <div class="form-group">
                    <label for="search_date">Select Date Range</label>
                    <input type="text" class="form-control" name="search_date" id="search_date"
                        value="{{ $searchValue }}">
                    <label></label>
                    <button type="submit" class="btn btn-primary">{{ trans('Core::operations.filter') }}</button>
                    &nbsp;<a href="{{ route('admin.transactions.history') }}" class="btn btn-light">
                        {{ trans('Core::operations.reset') }}</a>
                    &nbsp;<button type="button" onclick="exportReport()" id="export" class="btn btn-success"
                        value="export">Export</button>
                </div>
            </div>
        </form>
    </div>
</div>
@section('footer-scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(function() {
            $('input[name="search_date"]').daterangepicker({
                autoUpdateInput: false,
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });

            $('input[name="search_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('L') + '-' + picker.endDate.format('L'));
            });

            $('input[name="search_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        function exportReport() {
            $("#isExport").val('yes');
            $('form[name=frmReport]').attr('action', "{{ route('transaction-report-export') }}");
            $('form[name=frmReport]').submit();
        }
    </script>
@endsection
