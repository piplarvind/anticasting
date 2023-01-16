@php
    $itemTitle = $pageTitle = 'Notifications';

    $breadcrumbs = [
                        ['url' => '', 'name' => $pageTitle]
    ];


@endphp

@extends('admin.master')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')

    <div class="right-auth-landing">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Notifications</h3>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="active">
                            Notifications
                        </li>
                    </ol>
                    {{--<h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>--}}
                </div>
                @if($notifications->count() || $_GET)
                    @include('Users::notifications.filter')
                @endif

                <div class="table-responsive essay-table">
                    <div class="editable-forms-users">
                        @forelse($notifications as $notification)
                            <div class="alert alert-success" role="alert">
                                [{{ $notification->created_at }}] User {{ isset($notification->data['first_name'])?$notification->data['first_name']:''}} {{ isset($notification->data['last_name'])?$notification->data['last_name']:''}} ({{ isset($notification->data['email'])?$notification->data['email']:'' }}) has just registered.
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
    </div>
@endsection
@section('footer')
    <script type="text/javascript">
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
                });
            });
        });
    </script>
@endsection