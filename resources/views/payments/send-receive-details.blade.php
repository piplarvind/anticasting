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
                    @if (session('alert-success'))
                        <div class="alert alert-success">
                            {{ session('alert-success') }}
                        </div>
                    @endif
                    <div class="dashboard-heading">
                        <h4>Send & Receive Details</h4>
                    </div>
                    <div class="dashboard-body">
                        <div class="send-receive-form">
                            <form action="{{ url('save-send-receive-details') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>You Send </label>
                                    <img class="country-img" src="{{ asset('public') }}/img/us.svg" alt="img">
                                    <input type="tel" name="send_amount" id="send_amount"
                                        class="form-control cust-textbox" placeholder="0.00"
                                        value="{{ session('send_amount') ? session('send_amount') : old('send_amount') }}">
                                    <select class="form-control cust-select" name="send_currency" id="send_currency">
                                        <option value="USD">USD</option>
                                    </select>
                                    @error('send_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>They Receive</label>
                                    <img class="country-img"
                                        src="{{ asset('public') }}/country/{{ $selected_send_country->flag }}"
                                        alt="img">
                                    <input type="tel" readonly="readonly" name="receive_amount" id="receive_amount"
                                        class="form-control cust-textbox" placeholder="0.00"
                                        value="{{ old('receive_amount') }}">
                                    <input type="hidden" name="receive_country" id="receive_country"
                                        value="{{ $selected_send_country->country_iso_code }}">
                                    <select class="form-control cust-select" name="receive_currency" id="receive_currency">
                                        <option value="{{ $selected_send_country->currency }}">
                                            {{ $selected_send_country->currency }}</option>
                                    </select>
                                    @error('receive_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <error>{{ $message }}</error>
                                        </span>
                                    @enderror
                                </div>
                                <div class="exchange-rate-sec clearfix">
                                    <div class="exchange-rate-left">
                                        <p>Exchange Rate</p>
                                        <p class="fees">Fees</p>
                                    </div>
                                    <div class="exchange-rate-right">
                                        <p>1 USD = <span id="current_rate_div">{{ $current_rate }}</span>
                                            {{ $selected_send_country->currency }}</p>
                                        <p>${{ GlobalValues::get('fees') }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="dashboard-heading">
                                    <h4>Send & Receive Details</h4>
                                </div>

                                @foreach ($payers as $payer)
                                    <div class="form-group cust-radio">
                                        <div class="form-control">
                                            <label class="radio-container">
                                                {{ $payer->payer_service_name }}
                                                <input class="payment_method" type="radio" name="payment_method"
                                                    onclick="selectDeliveryLocation('{{ $payer->payer_service }}','{{ $payer->payer_country }}')"
                                                    @if (session('payment_method') == $payer->payer_id) checked="checked" @endif
                                                    value="{{ $payer->payer_service . '###' . $payer->payer_id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <error>{{ $message }}</error>
                                    </span>
                                @enderror
                                <br>
                                <div class="dashboard-heading">
                                    <h4>Delivery Location</h4>
                                </div>
                                <div id="bank_outer_div"></div>
                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <error>{{ $message }}</error>
                                    </span>
                                @enderror
                                <div class="dashboard-footer">
                                    <a class="normal-btn" href="{{ route('start-over') }}">Start Over</a>
                                    <input type="submit" class="active-btn half" value="Continue to send money">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#send_amount").keyup(function() {
                if (isNaN($(this).val())) {
                    alert("Please enter a valid amount");
                    $(this).val("");
                    $("#receive_amount").val("");
                    $("#send_amount_div").html("");
                    $("#receive_amount_div").html("");
                    return false;
                }
                $("#sort_payment_div").show();
                var receive_amount = ($(this).val() * $("#current_rate_div").html()).toFixed(2);
                $("#receive_amount").val(receive_amount);
                $("#send_amount_div").html($(this).val());
                $("#receive_amount_div").html(receive_amount);
            });

            $(".payment_method").click(function() {
                $("#payment_method_div").html($(this).val().split("###")[0]);
            });
            //loadBanks();

            function loadBanks() {
                $.ajax({
                    beforeSend: function() {
                        showLoader();
                    },
                    type: "GET",
                    url: "{{ route('institutions-api') }}",
                    dataType: "json",
                    success: function(msg) {
                        //console.log(msg);
                        $("#bank_outer_div").html("");
                        $("#bank_outer_div").html(msg['html']);
                        $(".bank_name").click(function() {
                            $("#bank_name_div").html($(this).val().split("###")[0]);
                        });
                        hideLoader();
                    }
                });
            }
        });

        function selectDeliveryLocation(payment_method, payer_country) {
            $.ajax({
                beforeSend: function() {
                    showLoader();
                },
                type: "GET",
                url: "{{ route('payers-api') }}",
                dataType: "json",
                data: {
                    'payment_method': payment_method,
                    'payer_country': payer_country
                },
                success: function(msg) {
                    //console.log(msg);
                    $("#bank_outer_div").html("");
                    $("#bank_outer_div").html(msg['html']);
                    $(".bank_name").click(function() {
                        $("#bank_name_div").html($(this).val().split("###")[0]);
                    });
                    hideLoader();
                }
            });
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
