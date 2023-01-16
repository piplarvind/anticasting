@extends('layouts.account_app')

@section('content')
    @include('layouts.payment-dropdown')

    <section class="dashboard-main">
        <div class="container">
            <div class="col-sm-4">
                @include('layouts.account-left-steps-nav')
            </div>
            <div class="col-sm-8">
                <div class="dashboard-right">
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
                    <form action="{{ url('save-payment-confirmation') }}" method="post">
                        @csrf
                        <div class="dashboard-body confirm-table">
                            <div class="dashboard-heading">
                                <h4>Confirm and Send</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Amount to send</td>
                                            <td>{{ $user_activity->send_amount }} USD</td>
                                        </tr>
                                        <tr>
                                            <td>Fees (if any)</td>
                                            <td>{{ GlobalValues::get('fees') }} USD</td>
                                        </tr>
                                        <tr>
                                            <td>Total cost</td>
                                            <td>{{ $user_activity->send_amount + GlobalValues::get('fees') }} USD</td>
                                        </tr>
                                        <tr>
                                            <td>Total to Recipient (amount)</td>
                                            <td>{{ $user_activity->receive_amount }}
                                                {{ $user_activity->receive_country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Exchange rate</td>
                                            <td>{{ $current_rate }} {{ $user_activity->receive_country }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="dashboard-heading">
                                    <h4>The amount and delivery details </h4>
                                </div>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Amount</td>
                                            <td>{{ $user_activity->receive_amount }}
                                                {{ $user_activity->receive_country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Receiving amount</td>
                                            <td>{{ $user_activity->receive_amount }}
                                                {{ $user_activity->receive_country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery method</td>
                                            <td>{{ explode('###', $user_activity->payment_method)[0] }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="dashboard-heading">
                                    <h4>Recipient details </h4>
                                </div>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>First name </td>
                                            <td>{{ $user_recipient_details->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Last name </td>
                                            <td>{{ $user_recipient_details->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>{{ $user_recipient_details->phone_no }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $user_recipient_details->city . ', ' . $user_recipient_details->state }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="dashboard-heading">
                                    <h4>Sender details </h4>
                                </div>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>First name </td>
                                            <td>{{ $user_sender_details->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Last name </td>
                                            <td>{{ $user_sender_details->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>{{ $user_sender_details->phone_no }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $user_sender_details->address_line_1 . ', ' . $user_sender_details->address_line_2 . ', ' . $user_sender_details->city . ', ' . $user_sender_details->state . ', ' . $user_sender_details->zip_code }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="dashboard-heading">
                                    <h4>OTP Verification</h4>
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Enter OTP </td>
                                            <td> <input class="form-control" type="tel" name="otp" id="otp"
                                                    style="width:80px;">
                                                <a href="{{ route('payment-resend-otp') }}">Resend OTP</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="dashboard-footer clearfix">
                            <a class="normal-btn" href="{{ route('payment-page') }}">Back</a>
                            <input type="submit" class="active-btn half" value="Review and send money">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
