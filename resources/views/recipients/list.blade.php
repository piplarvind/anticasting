@extends('layouts.account_app')

@section('content')
    <section class="setting-page-sec">
        <div class="container">
            <div class="row">
                @include('layouts.account-left-nav')
                <div class="col-md-8">
                    @if (session('alert-danger'))
                        <div class="alert alert-danger">
                            {{ session('alert-danger') }}
                        </div>
                    @endif
                    @if (session('alert-class'))
                        <div class="alert alert-success">
                            {{ session('alert-class') }}
                        </div>
                    @endif
                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif
                    <span class="banner-cont"><a style="padding:10px; float:right; margin:10px;"
                            href="{{ route('add-recipient') }}">Add New Recipient</a></span>
                    <div class="profile-info">
                        <h3>Recipients</h3>

                        @if (isset($recipients))
                            <div id="home" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Reason for sending</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($recipients->count() > 0)
                                                @foreach ($recipients as $recipient)
                                                    <tr>
                                                        <td>{{ $recipient->first_name }}</td>
                                                        </td>
                                                        <td>{{ $recipient->last_name }}</td>
                                                        <td>{{ str_replace('_', ' ', $recipient->reason_for_sending) }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('edit-recipient', [$recipient->id]) }}"><svg
                                                                    xmlns="https://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-pencil"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                                </svg></a>
                                                            | <a href="javascript:void(0);"
                                                                onclick="deleteRecipient('{{ $recipient->id }}')"><svg
                                                                    xmlns="https://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-trash"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                                </svg></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No record found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="text-center">
                                <img src="{{ asset('public') }}/img/teamwork.png" alt="img">
                                <p><b>You haven't added any recipients.</b></p>
                                <p>When you do, they'll show up here.</p><br>
                                <a class="comman-btn" href="{{ route('add-recipient') }}">Add New Recipient</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
        function deleteRecipient(recipient_id) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    beforeSend: function() {
                        showLoader();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "delete",
                    url: "{{ route('delete-recipient') }}",
                    data: {
                        recipient_id: recipient_id
                    },
                    dataType: "json",
                    success: function(msg) {
                        hideLoader();
                        alert(msg.msg)
                        document.location.reload();
                    }
                });
            }
        }

        function showLoader() {
            $("#progressbar").css("display", "block");
        }

        function hideLoader() {
            setTimeout(function() {
                $("#progressbar").css("display", "none");
            }, 1000);
        }
    </script>
@endsection
