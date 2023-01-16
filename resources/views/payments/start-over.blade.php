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
                        <h4>Select a recipient to send money</h4>
                    </div>
                    <div class="dashboard-body">
                        <div class="receipient-form">
                            <form action="{{ url('save-start-over') }}" method="post">
                                @csrf
                                @foreach ($user_recipient_details as $key => $user_recipient_detail)
                                    <div class="form-group cust-radio">
                                        <div class="form-control" style="height:auto">
                                            <label class="radio-container">
                                                {{ $user_recipient_detail->first_name . ' ' . $user_recipient_detail->last_name }}<br>
                                                @if ($key == 0)
                                                    {{ explode('###', $user_activity->bank_name)[0] }} account ending with
                                                    {{ substr($user_recipient_detail->bank_account_no, -4) }}
                                                @endif
                                                <input class="payment_method" type="radio" name="selecetd_recipient"
                                                    onclick="selectDeliveryLocation('{{ $user_recipient_detail->id }}')"
                                                    @if ($key == 0) checked="checked" @endif value="{{ $user_recipient_detail->id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="dashboard-footer receipient-form-footer clearfix">
                                    <input type="submit" class="active-btn" value="Continue">
                                    <a class="normal-btn" href="{{ route('send-receive-details') }}">Add New
                                        Recipient</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
