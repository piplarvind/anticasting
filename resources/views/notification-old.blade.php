@extends('layouts.account_app')

@section('content')
<section class="auth-dash-sec fullHt">
    <div class="left-navigations">
        @include('layouts.account-left-nav')
    </div>
    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Notifications</h3>
                </div>
                <div class="editable-forms-users">
                    @forelse($notifications as $notification)
                        <div class="alert alert-success" role="alert">
                            {{ $notification->data['message'] }}
                            <a href="javascript:void(0);" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                Mark as read
                            </a>
                        </div>

                        @if($loop->last)
                            <a href="javascript:void(0);" id="mark-all">
                                Mark all as read
                            </a>
                        @endif
                    @empty
                        There is no new notification
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function sendMarkRequest(id = null) {
        var _token = "{{ csrf_token() }}";
        return $.ajax("{{ route('markNotification') }}", {
            method: 'POST',
            data: {
                _token,
                id
            }
        });
    }
    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.alert').remove();
        });
        });
        $('#mark-all').click(function() {
            let request = sendMarkRequest();
            request.done(() => {
                $('div.alert').remove();
        })
        });
    });
</script>
@endsection
