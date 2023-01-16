<div class="container" style="width: 1170px;">
    <div class="col-sm-4" style="width: 18%; float: left;">
        <div style="padding: 20px;
                border-radius: 5px 5px 0 0;">
            <img style="width: 130px;" src="{{ asset('public/img/logo.png') }}" alt="Logo" />
        </div>

        <div class="v-rec-name" style="padding: 20px;
            background: #333;
            border-radius: 5px 5px 0 0;">
            <h4 style="    margin: 0;
    color: #fff;
    font-size: 14px;
    font-weight: bold;">Recipient:
                <span
                    style="color: #ddd;
                    font-weight: normal;">{{ $items['transaction_response'] ? $items['transaction_response']->beneficiary->firstname : '' }}
                    {{ $items['transaction_response'] ? $items['transaction_response']->beneficiary->lastname : '' }}</span>
            </h4>
            <h4 style="margin-top: 10px; margin: 0;
                color: #fff;
                font-size: 14px;
                font-weight: bold;">Transfer No.:
                <span style="color: #ddd;
                    font-weight: normal;">{{ $items['receipt_details']->transaction_id }}</span>
            </h4>
        </div>
        <div class="v-avl-time" style="background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 0 0 5px 5px;
            padding: 20px;
            margin-bottom: 20px;">
            <div class="q-s clearfix" style="padding: 8px 13px 28px 15px;
                border: 1px solid #ddd;
                border-radius: 10px;">
                <h5 class="pull-left" style="float: left!important; font-size: 14px;
                    margin: 3px 0 0px -3px; text-align:center;">
                    {{ $items['transaction_response']->sent_amount->currency }}
                    <b style="font-weight: 700;">{{ $items['transaction_response']->sent_amount->amount + GlobalValues::get('fees') }}
                    </b>
                </h5>
            </div>

            <h3 style="font-size: 12px;
                    background: #fafafa;
                    color: #333;
                    text-align: center;
                    font-weight: bold;
                    letter-spacing: 0.5px;
                    padding: 10px 15px;
                    margin: 15px 0;">{{ $items['transaction_response']->status_message }}</h3>
            <h3 style="font-size: 12px;
                background: #fafafa;
                color: #333;
                text-align: center;
                font-weight: bold;
                letter-spacing: 0.5px;
                padding: 10px 15px;
                margin: 15px 0;">Arrival Time</h3>
            <h1 style="font-size: 12px;
                color: #333;
                margin: 0px;
                text-align: center;">
                {{ date('M jS, Y H:i:s A', strtotime($items['transaction_response']->creation_date)) }}
            </h1>
        </div>

        {{-- <div class="dashboard-left-menu set-v-timeline" style="padding: 20px; background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 5px;">
                    <h3 style="margin-top: 0px; font-size: 14px;
                background: #fafafa;
                color: #333;
                text-align: center;
                font-weight: bold;
                letter-spacing: 0.5px;
                padding: 10px 15px;
                margin: 15px 0;">Track Your Transfer</h3>
                    <div class="menue-options">
                        <ul style="padding: 0px;
                    margin: 0px;">
                            <li class="active"
                                style="margin-left: 0px; margin: 30px 0px 30px 40px; list-style-type: none;"><span
                                    style="background: linear-gradient(to right, #FFC024, #FF177B);
                            color: #fff;
                            border: 1px solid #FFC024;font-size: 14px; font-weight: 600;
    margin-right: 20px;
    width: 30px;
    height: 30px;
    border: 1px solid #ccc;
    color: #777;
    display: block;
    text-align: center;
    line-height: 30px;
    border-radius: 50px;
    position: relative;
}">1</span>
                                <strong>Your bank Account</strong>
                            </li>
                            <li class="active"
                                style="margin-left: 0px; margin: 30px 0px 30px 40px; list-style-type: none;">
                                <span style="background: linear-gradient(to right, #FFC024, #FF177B);
                            color: #fff;
                            border: 1px solid #FFC024;font-size: 14px; font-weight: 600;
    margin-right: 20px;
    width: 30px;
    height: 30px;
    border: 1px solid #ccc;
    color: #777;
    display: block;
    text-align: center;
    line-height: 30px;
    border-radius: 50px;
    position: relative;
}">2</span><strong>{{ GlobalValues::get('site_title') }}</strong>
                            </li>
                            <li class="active"
                                style="margin-left: 0px; margin: 30px 0px 30px 40px; list-style-type: none;">
                                <span style="background: linear-gradient(to right, #FFC024, #FF177B);
                            color: #fff;
                            border: 1px solid #FFC024;font-size: 14px; font-weight: 600;
    margin-right: 20px;
    width: 30px;
    height: 30px;
    border: 1px solid #ccc;
    color: #777;
    display: block;
    text-align: center;
    line-height: 30px;
    border-radius: 50px;
    position: relative;
}">3</span><strong>{{ $items['transaction_response']->payer->name }}</strong>
                            </li>
                            <li class="active"
                                style="margin-left: 0px; margin: 30px 0px 30px 40px; list-style-type: none;">
                                <span style="background: linear-gradient(to right, #FFC024, #FF177B);
                            color: #fff;
                            border: 1px solid #FFC024;font-size: 14px; font-weight: 600;
    margin-right: 20px;
    width: 30px;
    height: 30px;
    border: 1px solid #ccc;
    color: #777;
    display: block;
    text-align: center;
    line-height: 30px;
    border-radius: 50px;
    position: relative;
}">4</span><strong href="javascript:void(0)">Recipient's
                                    account</strong>
                            </li>
                        </ul>
                    </div>
                </div> --}}

    </div>
    <div class="col-sm-8" style="width: 45%; float: left; position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;">
        <div class="v-sender-rec-bx" style="background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 20px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
            <div class="v-sender-rec-med clearfix">
                <table style="table-layout: fixed; width: 100%;">
                    <tr>
                        <td>
                            <div class="v-medi-bcx">
                                <h3 style="margin: 0px 0 10px;
                        font-size: 14px;
                        color: #989898;
                        text-decoration: underline;">Sender</h3>
                                <div class="media" style="overflow: hidden;
                        zoom: 1;margin-top: 15px;">
                                    <div class="media-body"
                                        style="vertical-align: top;width: 10000px; overflow: hidden; zoom: 1;">
                                        <h4 class="media-heading" style="margin-top: 0;
                                margin-bottom: 5px;">
                                            {{ $items['transaction_response'] ? ucfirst($items['transaction_response']->sender->firstname) : '' }}
                                            {{ $items['transaction_response'] ? ucfirst($items['transaction_response']->sender->lastname) : '' }}
                                        </h4>
                                        <p style="font-size: 12px; color: #737373;margin: 0 0 10px; width: 180px;">
                                            {{ $items['transaction_response'] ? $items['transaction_response']->sender->address : '' }}
                                        </p>
                                        <p style="font-size: 12px; color: #737373;margin: 0 0 10px;">
                                            {{ $items['transaction_response'] ? $items['transaction_response']->sender->city : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="v-medi-bcx">
                                <h3 style="margin: 0px 0 10px;
                        font-size: 14px;
                        color: #989898;
                        text-decoration: underline;">Recipient's</h3>
                                <div class="media" style="overflow: hidden;
                        zoom: 1;">
                                    <div class="media-body"
                                        style="vertical-align: top; width: 10000px; overflow: hidden; zoom: 1;">
                                        <h4 class="media-heading" style="margin-top: 0; margin-bottom: 5px;">
                                            {{ $items['transaction_response'] ? ucfirst($items['transaction_response']->beneficiary->firstname) : '' }}
                                            {{ $items['transaction_response'] ? ucfirst($items['transaction_response']->beneficiary->lastname) : '' }}
                                        </h4>
                                        <p style="font-size: 12px; color: #737373; margin: 0 0 10px; width: 180px;">
                                            {{ $items['transaction_response'] ? $items['transaction_response']->beneficiary->address : '' }}
                                        </p>
                                        <p style="font-size: 12px; color: #737373; margin: 0 0 10px;">
                                            {{ $items['transaction_response'] ? $items['transaction_response']->beneficiary->city : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        <div class="v-reciver-bx" style="background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;">
            <h3 style="margin: 0px;
                padding-bottom: 10px;
                margin-bottom: 10px;
                font-size: 16px;
                border-bottom: 1px solid #ddd;">Payment Details</h3>
            <div class="table-responsive" style="min-height: .01%;
                overflow-x: auto;">
                <table class="table" style="font-size: 14px;width: 100%;
                        max-width: 100%;
                        margin-bottom: 20px;background-color: transparent;border-spacing: 0;
    border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Submitted</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ date('M jS, Y', strtotime($items['receipt_details']->created_at)) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Reference No.</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->id }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Delivery</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->payer->service->name }}
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Bank</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->payer->name }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Currency</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->payer->currency }}
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Payment Method</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->payer->name }}.
                                Ending
                                in
                                <?php
                                if ($items['transaction_response']->payer->service->name == 'BankAccount' && $items['transaction_response']->payer->currency == 'MXN') {
                                    $credit_party_no = $items['transaction_response']->credit_party_identifier->clabe;
                                } elseif ($transaction_response->payer->service->name == 'BankAccount' && $transaction_response->payer->currency == 'CRC') {
                                    $credit_party_no = $transaction_response->credit_party_identifier->iban;
                                } elseif ($items['transaction_response']->payer->service->name == 'BankAccount') {
                                    $credit_party_no = $items['transaction_response']->credit_party_identifier->bank_account_number;
                                } else {
                                    $credit_party_no = $items['transaction_response']->credit_party_identifier->msisdn;
                                }
                                ?>
                                {{ substr($credit_party_no, -4) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Amount Sent</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->sent_amount->amount }}
                                {{ $items['transaction_response']->sent_amount->currency }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Reason</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ str_replace('_', ' ', $items['transaction_response']->purpose_of_remittance) }}
                            </td>
                        </tr>

                        <tr>
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Fee</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['receipt_details']->fees }}
                                {{ $items['receipt_details']->fees_currency }}</td>
                        </tr>

                        <tr style="background: #ddd; font-weight: bold;">
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Total Amount Charged</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->sent_amount->amount + $items['receipt_details']->fees }}
                                {{ $items['transaction_response']->sent_amount->currency }}</td>
                        </tr>
                        <tr style="background: #ddd; font-weight: bold;">
                            <th style="text-align: left; padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" scope="row">Net Recipient Amount</th>
                            <td style="padding: 10px; line-height: 1.42857143;
                                    vertical-align: top;
                                    border-top: 1px solid #ddd;" class="text-right">
                                {{ $items['transaction_response']->destination->amount }}
                                {{ $items['transaction_response']->destination->currency }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
