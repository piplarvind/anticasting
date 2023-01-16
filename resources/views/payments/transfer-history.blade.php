@extends('layouts.account_app')

@section('content')

    @include('layouts.payment-dropdown')

    <section class="dashboard-main">
        <div class="container">
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
            <div class="transfer-history-outer">
                <h3>Your Transfers</h3>
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#home">All transfers</a></li>
                    <li><a data-toggle="pill" href="#menu1">In progress</a></li>
                    <li><a data-toggle="pill" href="#menu2">Delivered</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sent On</th>
                                        <th>Delivery Method</th>
                                        <th>Recipient Name</th>
                                        <th>Recipient Amount</th>
                                        <th>Transfer Status</th>
                                        <th>Reason</th>
                                        <th>Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transfer_histories->count())
                                        @foreach ($transfer_histories as $transfer_history)
                                            <tr>
                                                <td>{{ date('M jS, Y', strtotime(json_decode($transfer_history->transaction_response)->creation_date)) }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->payer->service->name }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->beneficiary->firstname . ' ' . json_decode($transfer_history->transaction_response)->beneficiary->lastname }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->destination->amount . ' ' . json_decode($transfer_history->transaction_response)->destination->currency }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->status_message }}
                                                </td>
                                                <td>{!! str_replace('_', ' ', json_decode($transfer_history->transaction_response)->purpose_of_remittance) !!}
                                                </td>
                                                <td style="text-align: center"><a
                                                        href="{{ route('receipt-details', [$transfer_history->transaction_id]) }}"
                                                        alt="View">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">
                                                <div class="tab-content">
                                                    <div class="text-center">
                                                        <img src="{{ asset('public') }}/img/transfer-history-bg.jpg">
                                                        <h4>No transfers yet</h4>
                                                        <p>Once you send money, we'll show you a detailed list of your
                                                            transfers
                                                            here.</p>
                                                        <a href="{{ route('send-receive-details') }}">Send Money</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sent On</th>
                                        <th>Delivery Method</th>
                                        <th>Recipient Name</th>
                                        <th>Recipient Amount</th>
                                        <th>Transfer Status</th>
                                        <th>Reason</th>
                                        <th>Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7">
                                            <div class="tab-content">
                                                <div class="text-center">
                                                    <img src="{{ asset('public') }}/img/transfer-history-bg.jpg">
                                                    <h4>No pending transfers yet</h4>
                                                    <p>Once you send money, we'll show you a detailed list of your transfers
                                                        here.</p>
                                                    <a href="{{ route('send-receive-details') }}">Send Money</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sent On</th>
                                        <th>Delivery Method</th>
                                        <th>Recipient Name</th>
                                        <th>Recipient Amount</th>
                                        <th>Transfer Status</th>
                                        <th>Reason</th>
                                        <th>Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transfer_histories->count())
                                        @foreach ($transfer_histories as $transfer_history)
                                            <tr>
                                                <td>{{ date('M jS, Y', strtotime(json_decode($transfer_history->transaction_response)->creation_date)) }}
                                                </td>
                                                <td>Bank Deposit</td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->beneficiary->firstname . ' ' . json_decode($transfer_history->transaction_response)->beneficiary->lastname }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->destination->amount . ' ' . json_decode($transfer_history->transaction_response)->destination->currency }}
                                                </td>
                                                <td>{{ json_decode($transfer_history->transaction_response)->status_message }}
                                                </td>
                                                <td>{!! str_replace('_', ' ', json_decode($transfer_history->transaction_response)->purpose_of_remittance) !!}
                                                </td>
                                                <td style="text-align: center"><a
                                                        href="{{ route('receipt-details', [$transfer_history->transaction_id]) }}"
                                                        alt="View">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">
                                                <div class="tab-content">
                                                    <div class="text-center">
                                                        <img src="{{ asset('public') }}/img/transfer-history-bg.jpg">
                                                        <h4>No transfers yet</h4>
                                                        <p>Once you send money, we'll show you a detailed list of your
                                                            transfers
                                                            here.</p>
                                                        <a href="{{ route('send-receive-details') }}">Send Money</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
