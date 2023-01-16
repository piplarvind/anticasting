<link href="{{ asset('public/css/toastr.min.css') }}" rel="stylesheet">
<script type="text/javascript">
    $(document).ready(function() {
        // Override global options
        @if (session('alert-class') == "alert-success")
        toastr.success('{{session('message')}}', 'Success', {timeOut: 0,extendedTimeOut: 60000, closeButton: true,"positionClass": "toast-bottom-right"})
        @elseif(session('alert-class') == "alert-danger")
        toastr.error('{{session('message')}}', 'Error', {timeOut: 0,extendedTimeOut: 60000, closeButton: true,"positionClass": "toast-bottom-right"})
        @elseif(session('alert-class') == "alert-warning")
        toastr.warning('{{session('message')}}', 'Warning', {timeOut: 0,extendedTimeOut: 60000, closeButton: true,"positionClass": "toast-bottom-right"})
        @elseif(session('alert-class') == "alert-info")
        toastr.info('{{session('message')}}', 'Info', {timeOut: 0,extendedTimeOut: 60000, closeButton: true,"positionClass": "toast-bottom-right"})
        @endif
    });
</script>
<script defer src="{{ asset('public/js/toastr.min.js') }}" type="text/javascript" ></script>
