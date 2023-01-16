@extends('layouts.account_app')
<style>
    .blue-avts {
        border-color: #5593FC !important;
        color: #5593FC !important;
    }
</style>
@section('content')
    @include('layouts.payment-dropdown')

    <section class="dashboard-main">
        <div class="container">
            @if (session('alert-danger'))
                <div class="alert alert-danger">
                    {{ session('alert-danger') }}
                </div>
            @endif
            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif

            <section class="dashboard-main">
                <div class="container">
                    <div id="printableArea">
                        <div class="col-sm-4">
                            <div class="v-rec-name">
                                <h4>Recipient:
                                    <span>{{ $transaction_response ? $transaction_response->beneficiary->firstname : '' }}
                                        {{ $transaction_response ? $transaction_response->beneficiary->lastname : '' }}</span>
                                </h4>
                                <h4 style="margin-top: 10px;">Transfer No.:
                                    <span>{{ $receipt_details->transaction_id }}</span>
                                </h4>
                            </div>
                            <div class="v-avl-time">
                                <div class="q-s clearfix">
                                    <h5 class="pull-left">
                                        {{ $transaction_response->sent_amount->currency }}
                                        <b>{{ $transaction_response->sent_amount->amount + GlobalValues::get('fees') }}
                                        </b>
                                    </h5>
                                    <span class="v-tags pull-right">{{ $transaction_response->status_message }}</span>
                                </div>
                                <h3>Arrival Time</h3>
                                <h1>{{ date('M jS, Y H:i:s A', strtotime($transaction_response->creation_date)) }}</h1>
                            </div>

                            <div class="dashboard-left-menu set-v-timeline trctrf-new">
                                <h3>Track Your Transfer</h3>
                                <div class="menue-options">
                                    <ul class="clearfix">
                                        <li class="active clearfix"> <span>1</span>
                                            <a href="javascript:coid(0);">Your bank Account</a>
                                        </li>
                                        <li class="active clearfix">
                                            <span>2</span> <a
                                                href="javascript:coid(0);">{{ GlobalValues::get('site_title') }}</a>
                                        </li>
                                        <li class="active clearfix ">
                                            <span>3</span> <a
                                                href="javascript:coid(0);">{{ $transaction_response->payer->name }}</a>
                                        </li>
                                        <li class="active clearfix"> <span>4</span><a href="javascript:coid(0);">Recipient's
                                                account</a> </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8">
                            <div class="v-sender-rec-bx">
                                <div class="v-sender-rec-med clearfix">
                                    <div class="v-medi-bcx">
                                        <h3>Sender</h3>
                                        <div class="media">
                                            <div class="media-left">
                                                {{ substr(ucfirst($transaction_response->sender->firstname), 0, 1) }}{{ substr(ucfirst($transaction_response->sender->lastname), 0, 1) }}
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    {{ $transaction_response ? ucfirst($transaction_response->sender->firstname) : '' }}
                                                    {{ $transaction_response ? ucfirst($transaction_response->sender->lastname) : '' }}
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
                                                {{ substr(ucfirst($transaction_response->beneficiary->firstname), 0, 1) }}{{ substr(ucfirst($transaction_response->beneficiary->lastname), 0, 1) }}
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    {{ $transaction_response ? ucfirst($transaction_response->beneficiary->firstname) : '' }}
                                                    {{ $transaction_response ? ucfirst($transaction_response->beneficiary->lastname) : '' }}
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
                                                    {{ date('M jS, Y', strtotime($receipt_details->created_at)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reference No.</th>
                                                <td class="text-right">{{ $transaction_response->id }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery</th>
                                                <td class="text-right">
                                                    {{ $transaction_response->payer->service->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Bank</th>
                                                <td class="text-right">{{ $transaction_response->payer->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Currency</th>
                                                <td class="text-right">{{ $transaction_response->payer->currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Payment Method</th>
                                                <td class="text-right"> {{ $transaction_response->payer->name }}.
                                                    Ending
                                                    in
                                                    <?php
                                                    if ($transaction_response->payer->service->name == 'BankAccount' && $transaction_response->payer->currency == 'MXN') {
                                                        $credit_party_no = $transaction_response->credit_party_identifier->clabe;
                                                    } elseif ($transaction_response->payer->service->name == 'BankAccount' && $transaction_response->payer->currency == 'CRC') {
                                                        $credit_party_no = $transaction_response->credit_party_identifier->iban;
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
                                                <td class="text-right">
                                                    {{ $transaction_response->sent_amount->amount }}
                                                    {{ $transaction_response->sent_amount->currency }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Reason</th>
                                                <td class="text-right">
                                                    {{ str_replace('_', ' ', $transaction_response->purpose_of_remittance) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Fee</th>
                                                <td class="text-right">{{ $receipt_details->fees }}
                                                    {{ $receipt_details->fees_currency }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th scope="row">Total Amount Charged</th>
                                                <td class="text-right">
                                                    {{ $transaction_response->sent_amount->amount + $receipt_details->fees }}
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

                                {{-- @if ($transaction_response->status === 20000)
                                    <h6>Please review our <a href="{{ url('/pages/refund policy') }}">refund policy</a> if
                                        you wish to </h6>
                                    <div class="dashboard-footer receipient-form-footer clearfix">
                                        <a class="normal-btn red-avts" href="javascript:void(0)">cancel your transfer</a>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="dashboard-footer receipient-form-footer clearfix">
                                            <a class="normal-btn red-avts" href="{{ route('transfer-history') }}">Back</a>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="dashboard-footer receipient-form-footer clearfix">
                                            <a class="normal-btn blue-avts" onclick="printDiv('printableArea')" ><i class="fa fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @if ($transaction_response->status === 20000)
                        <h6>Please review our <a href="{{ url('/pages/refund policy') }}">refund policy</a> if
                            you wish to </h6>
                        <div class="dashboard-footer receipient-form-footer clearfix">
                            <a class="normal-btn red-avts" href="javascript:void(0)">cancel your transfer</a>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-footer receipient-form-footer clearfix">
                                <a class="normal-btn red-avts" href="{{ route('transfer-history') }}">Back</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-footer receipient-form-footer clearfix">
                                <a class="normal-btn blue-avts print-btn"
                                    href="{{ route('generate-receipt-pdf', [$receipt_details->transaction_id]) }}"><i
                                        class="fa fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>


                </div>
            </section>
        </div>
    </section>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
