@php
    $pageTitle = 'Transfer History';
    $breadcrumbs = [['url' => '', 'name' => $pageTitle]];
@endphp
@section('title')
    {{ $pageTitle }}
@endsection
@extends('layouts.admin-account-app')
<style>
    .dashboard-main {
        margin-top: 20px;
        margin-bottom: 100px;
    }
    .v-rec-name {
        padding: 20px;
        background: #FF177B;
        border-radius: 5px 5px 0 0;
    }
    .v-rec-name h4 {
        margin: 0;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
    }
    .v-rec-name h4 span {
        color: rgb(252, 249, 249);
        font-weight: normal;
    }

    .v-rec-price {
        padding: 13px;
        background: #FF177B;
        border-radius: 5px 5px 0 0;
    }
    .v-rec-price h5 {
        margin: 0;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
    }
    .v-rec-price h5 span {
        color: rgb(248, 248, 248);
        font-weight: normal;
    }

    .v-rec-time {
        /* padding: 20px; */
        padding: 17px;
        background: #FF177B;
        border-radius: 5px 5px 0 0;
    }
    .v-rec-time h4 {
        margin: 0;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        line-height: 50px;
    }
    .v-rec-time h4 span {
        color: rgb(248, 248, 248);
        font-weight: normal;
    }

    .v-avl-time {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 0 0 5px 5px;
        /* padding: 20px; */
        padding: 13px;
        margin-bottom: 20px;
    }
    .v-avl-time p {
        font-size: 12px;
        margin: 20px 0;
    }
    .q-s {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
    }
    .q-s h5 {
        font-size: 20px;
        margin: 0px;
    }
    .v-tags {
        font-size: 12px;
        padding: 4px 5px;
        color: #fff;
        letter-spacing: 1px;
        margin: 0px;
        border-radius: 4px;
        background: linear-gradient(to right, #FFC024, #1EAAE7);
    }
    .v-avl-time h3, .set-v-timeline h3 {
        font-size: 14px;
        background: #fafafa;
        color: #FF177B;
        text-align: center;
        font-weight: bold;
        letter-spacing: 0.5px;
        padding: 10px 15px;
        margin: 15px 0;
    }
    .v-avl-time h1 {
        font-size: 20px;
        color: #FF177B;
        margin: 0px;
        text-align: center;
    }
    .set-v-timeline {
        padding: 20px;
    }
    .dashboard-left-menu {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
    }
    .set-v-timeline h3 {
        margin-top: 0px;
    }
    .v-avl-time h3, .set-v-timeline h3 {
        font-size: 14px;
        background: #fafafa;
        color: #FF177B;
        text-align: center;
        font-weight: bold;
        letter-spacing: 0.5px;
        padding: 10px 15px;
        margin: 15px 0;
    }
    .set-v-timeline .menue-options ul li {
        margin-left: 0px;
    }
    .menue-options ul li {
        margin: 30px 0px 30px 40px;
    }
    .v-sender-rec-bx {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .v-medi-bcx {
        width: 50%;
        float: left;
    }
    .v-medi-bcx h3 {
        margin: 0px 0 10px;
        font-size: 14px;
        color: #989898;
        text-decoration: underline;
    }
    .v-medi-bcx .media-left {
        font-size: 30px;
        text-align: center;
        color: #FF177B;
    }
    .v-medi-bcx p {
        font-size: 12px;
        color: #737373;
    }
    .media-body p {
        margin: 0 0 10px;
    }
    .media-left, .media>.pull-left {
        padding-right: 10px;
    }
    .v-reciver-bx {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .v-reciver-bx h3 {
        margin: 0px;
        padding-bottom: 10px;
        margin-bottom: 10px;
        font-size: 16px;
        border-bottom: 1px solid #ddd;
    }
    .dashboard-footer {
        padding-top: 20px;
    }
    .dashboard-footer.receipient-form-footer a {
        width: 32%;
    }
    a.normal-btn {
        border: 1px solid #ccc;
        padding: 10px 15px;
        text-align: center;
        border-radius: 5px;
        color: #555;
        background: #fff;
        font-weight: 500;
        font-size: 14px;
        margin-right: 1%;
    }
    .dashboard-footer a {
        width: 48%;
        float: left;
    }
    .red-avts {
        border-color: #1EAAE7 !important;
        color: #1EAAE7 !important;
    }
    .media-body {
        flex: 1;
    }
    .v-reciver-bx .table > tfoot {
        background: #ddd;
        font-weight: bold;
    }
    ul {
        padding: 0px;
        margin: 0px;
    }
    li.active span {
        background: linear-gradient(to right, #FFC024, #FF177B);
        color: #fff;
        border: 1px solid #FFC024;
    }
    .menue-options li > span {
        font-size: 14px;
        font-weight: 600;
        margin-right: 20px;
        width: 30px;
        height: 30px;
        /* background: linear-gradient(to right, #FFC024, #FF177B); */
        border: 1px solid #ccc;
        color: #777;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        border-radius: 50px;
        position: relative;
    }
    .menue-options li:first-child > span::after {
        height: 65px;
    }
    .menue-options li > span::after {
        content: '';
        width: 1px;
        height: 32px;
        background: #ccc;
        position: absolute;
        left: 14px;
        top: 100%;
    }
</style>
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="all-ourt-style w-80-cust">
                <div class="all-heads">
                    <h3>Transfer History</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}/admin"> <i class="fa fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.transactions.history') }}"> <i class="fa fa-list"></i> Transfer History</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Transfer Detail
                        </li>
                    </ol>
                </div>

                @if (session('alert-success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                             fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        {{ session('alert-success') }}
                        <button type="button" class="close h-100" data-dismiss="alert"
                                aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>
                @endif
                @if (session('alert-danger'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                             fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                            <polygon
                                    points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                            </polygon>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        {{ session('alert-danger') }}
                        <button type="button" class="close h-100" data-dismiss="alert"
                                aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                    </div>
                @endif


                <section class="dashboard-main">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="v-rec-name">
                                    <h4>Recipient:
                                        <span>{{ $transaction_response ? $transaction_response->beneficiary->firstname : '' }}
                                            {{ $transaction_response ? $transaction_response->beneficiary->lastname : '' }}</span>
                                    </h4>
                                    <h4 style="margin-top: 10px;">Transfer No.:
                                        <span>{{ $transaction_details->transaction_id }}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="v-rec-price">
                                {{-- <div class="v-avl-time"> --}}
                                    <div class="q-s clearfix">
                                        <h5 class="pull-left">
                                            {{ $transaction_response->sent_amount->currency }}
                                            <b>{{ $transaction_response->sent_amount->amount + 3.99 }}
                                            </b>
                                        </h5>
                                        <span class="v-tags pull-right">{{ $transaction_response->status_message }}</span>
                                    </div>
                                {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="v-rec-time">
                                    <h4>Arrival Time:
                                        <span>{{ date('M jS, Y H:i:s A', strtotime($transaction_response->creation_date)) }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <br/>
                                <div class="v-sender-rec-bx">
                                    <div class="v-sender-rec-med clearfix">
                                        <div class="v-medi-bcx">
                                            <h3>Sender</h3>
                                            <div class="media">
                                                <div class="media-left">
                                                    {{ substr($transaction_response->sender->firstname, 0, 1) }}{{ substr($transaction_response->sender->lastname, 0, 1) }}
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        {{ $transaction_response ? $transaction_response->sender->firstname : '' }}
                                                        {{ $transaction_response ? $transaction_response->sender->lastname : '' }}
                                                    </h4>
                                                    <p>{{ $transaction_response ? $transaction_response->sender->address : '' }}
                                                    </p>
                                                    <p>{{ $transaction_response ? $transaction_response->sender->city : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="v-medi-bcx">
                                            <h3>Recipient's</h3>
                                            <div class="media">
                                                <div class="media-left">
                                                    {{ substr($transaction_response->beneficiary->firstname, 0, 1) }}{{ substr($transaction_response->beneficiary->lastname, 0, 1) }}
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        {{ $transaction_response ? $transaction_response->beneficiary->firstname : '' }}
                                                        {{ $transaction_response ? $transaction_response->beneficiary->lastname : '' }}
                                                    </h4>
                                                    <p>{{ $transaction_response ? $transaction_response->beneficiary->address : '' }}
                                                    </p>
                                                    <p>{{ $transaction_response ? $transaction_response->beneficiary->city : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="v-reciver-bx">
                                    <h3>Payment Details</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Submitted</th>
                                                <td class="text-right">
                                                    {{ date('M jS, Y', strtotime($transaction_details->created_at)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reference No.</th>
                                                <td class="text-right">{{ $transaction_response->id }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery</th>
                                                <td class="text-right">{{ $transaction_response->payer->service->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Bank</th>
                                                <td class="text-right">{{ $transaction_response->payer->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Currency</th>
                                                <td class="text-right">{{ $transaction_response->payer->currency }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Payment Method</th>
                                                <td class="text-right"> {{ $transaction_response->payer->name }}. Ending
                                                    in
                                                    <?php
                                                    if ($transaction_response->payer->service->name == 'BankAccount' && $transaction_response->payer->currency == 'MXN') {
                                                        $credit_party_no = $transaction_response->credit_party_identifier->clabe;
                                                    } elseif ($transaction_response->payer->service->name == 'BankAccount') {
                                                        $credit_party_no = $transaction_response->credit_party_identifier->bank_account_number;
                                                    } else {
                                                        $credit_party_no = $transaction_response->credit_party_identifier->msisdn;
                                                    }
                                                    ?>
                                                    {{ substr($credit_party_no, -4) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Amount Sent</th>
                                                <td class="text-right">{{ $transaction_response->sent_amount->amount }}
                                                    {{ $transaction_response->sent_amount->currency }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reason</th>
                                                <td class="text-right">{{ $transaction_response->purpose_of_remittance }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Fee</th>
                                                <td class="text-right">3.99 USD</td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th scope="row">Total Amount Charged</th>
                                                <td class="text-right">
                                                    {{ $transaction_response->sent_amount->amount + 3.99 }}
                                                    {{ $transaction_response->sent_amount->currency }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Net Recipient Amount</th>
                                                <td class="text-right">
                                                    {{ $transaction_response->destination->amount }}
                                                    {{ $transaction_response->destination->currency }}
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    {{-- <div class="table-responsive">
                                        <table class="table" style="background: #f5f5f5;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">Exchange Rate</td>
                                                </tr>
                                                <tr>
                                                    <td>Promo rate (up to $500)</td>
                                                    <th class="text-right">1 USD = 7.78 GTQ</th>
                                                </tr>
                                                <tr>
                                                    <td>Economy rate ($500 +)</td>
                                                    <th class="text-right">1 USD = 7.34 GTQ</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> --}}

                                    {{--@if ($transaction_response->status === 20000)
                                        <h6>Please review our <a href="{{ url('/pages/refund policy') }}">refund policy</a> if
                                            you wish to </h6>
                                        <div class="dashboard-footer receipient-form-footer clearfix">
                                            <a class="normal-btn red-avts" href="javascript:void(0)">cancel your transfer</a>
                                        </div>
                                    @endif--}}
                                    <div class="dashboard-footer receipient-form-footer clearfix">
                                        <a class="normal-btn red-avts" href="{{ route('admin.transactions.history') }}">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
@endsection
