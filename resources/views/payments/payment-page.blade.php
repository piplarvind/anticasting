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
                    <div class="dashboard-heading">
                        <h4>Payment details</h4>
                        <p>Use a bank account instead </p>
                    </div>
                    <div class="dashboard-body">
                        <div class="receipient-form">
                            <form action="{{ url('save-payment-page') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="tel" class="form-control" id="card_no" name="card_no"
                                        placeholder="eg. 1234 5678 1234 9876"
                                        value="{{ old('card_no') ? old('card_no') : $user_payment_details->card_no }}">
                                    @error('card_no')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Expiration date</label>
                                            <input type="text" class="form-control" id="expiry_date" name="expiry_date"
                                                value="{{ old('expiry_date') ? old('expiry_date') : '' }}"
                                                placeholder="mm/dd/yyyy">
                                            @error('expiry_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CVV</label>
                                            <input type="text" class="form-control" id="cvv" name="cvv"
                                                placeholder="eg. 123"
                                                value="{{ old('cvv') ? old('cvv') : $user_payment_details->cvv }}">
                                            @error('cvv')
                                                <span class="invalid-feedback" role="alert">
                                                    <error>{{ $message }}</error>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Your name as it appears on card</label>
                                    <input type="name" class="form-control" id="name_on_card" name="name_on_card"
                                        placeholder="eg. John Smith"
                                        value="{{ old('name_on_card') ? old('name_on_card') : $user_payment_details->name_on_card }}">
                                    @error('name_on_card')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="billing-sec">
                                    <h4>Billing Address</h4>
                                    <div class="checkers">
                                        <input type="checkbox" id="box-2">
                                        <label for="box-2">Use Home Address</label>
                                    </div>
                                    <p class="billing-address">
                                        {{ $user_address_details->address_line_1 . ', ' . $user_address_details->city . ', ' . $user_address_details->state . ', ' . $user_address_details->zip_code }}
                                    </p>
                                    <p>To avoid cash advance fees using credit, pay by debit. Payzz credit card fee is an
                                        added 3%.</p>
                                </div>
                                <div class="dashboard-footer receipient-form-footer clearfix">
                                    <a class="normal-btn" href="{{ route('start-over') }}">Start Over</a>
                                    <a class="normal-btn" href="{{ route('sender-details') }}">Back</a>
                                    <input type="submit" class="active-btn" value="Continue to send money">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#expiry_date").datepicker({
                format: 'mm/dd/yyyy',
                startDate: new Date()
            });
        });
    </script>
@endsection
