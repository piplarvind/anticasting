@extends('layouts.account_app')

@section('content')
    @include('layouts.payment-dropdown')
    <style>
        .plans .columns {
            float: left;
            width: 100%;
            padding: 0 15px;
        }

        .info li {
            list-style-type: auto;
        }

        .info li::marker {
            unicode-bidi: isolate;
            font-variant-numeric: tabular-nums;
            text-transform: none;
            text-indent: 0px !important;
            text-align: start !important;
            text-align-last: start !important;
        }
    </style>
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
            <section class="money-limit-sec plans-sec">
                <div class="container">

                    <div class="clearfix">
                        <div class="ml-left">
                            <h3>Manage Sending Limits</h3>
                            <p>We require some additional information from you. We need this information to protect your
                                account and comply with banking laws.</p>
                            <p><a href="{{ route('contact-us') }}">Have a question? Contact us 24/7.</a></p>
                        </div>
                        <div class="ml-right">
                            <div class="ml-right-inner">
                                <h3>Sending Limits</h3>
                                <h4>We'd love to help you increase your sending limit. We'll need to collect some
                                    information from you first.</h4>
                                <p>Why do we need this information?</p>
                                <ul class="ml-right-top">
                                    <li>We need to comply with regulatory obligations</li>
                                    <li>We want to provide a safe service for you</li>
                                </ul>
                                <p>Any information you provide securely through our website or app is protected as described
                                    in our <a href="{{ url('/pages/privacy-policy') }}">Privacy Policy</a></p>
                                <div class="cust-plan">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="plans clearfix">
                                                <div class="columns">
                                                    <ul class="price">
                                                        <li class="header">Attributes</li>
                                                        <li>24 Hours <br> &nbsp;</li>
                                                        <li>30 Days <br> &nbsp;</li>
                                                        <li>
                                                            180 Days <br> &nbsp;
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @if (isset($items))
                                            @foreach ($items as $k => $item)
                                                <div class="col-md-4">
                                                    <div class="plans clearfix">
                                                        <div class="columns">
                                                            <ul class="price">
                                                                <li class="header">{{ $item->name }}</li>

                                                                <li>${{ number_format($item->attrs ? $item->attrs->one_day_price : 0, 2) }}
                                                                    <span class="li-spa">
                                                                        ${{ number_format($item->attrs ? $item->attrs->one_day_price : 0 - $oneDayTotalAmountSent) }}
                                                                        remaining </span>
                                                                </li>
                                                                <li>${{ number_format($item->attrs ? $item->attrs->thirty_day_price : 0, 2) }}
                                                                    <span class="li-spa">
                                                                        ${{ number_format($item->attrs ? $item->attrs->thirty_day_price : 0 - $thirtyDaysTotalAmountSent) }}
                                                                        remaining </span>
                                                                </li>
                                                                <li>${{ number_format($item->attrs ? $item->attrs->half_yearly_price : 0, 2) }}
                                                                    <span class="li-spa">
                                                                        ${{ number_format($item->attrs ? $item->attrs->half_yearly_price : 0 - $halfYearlyTotalAmountSent) }}
                                                                        remaining </span>
                                                                </li>
                                                                <li class="grey">
                                                                    {{-- <a href="javascript:void(0)" class="button">Apply
                                                                    Now</a> --}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="plans clearfix">
                                                        <div class="columns info">
                                                            <ul class="price">
                                                                <li class="grey"><span
                                                                        class="duration">Information
                                                                        needed</span></li>
                                                                <li>
                                                                    {!! $item->information_needed !!}
                                                                </li>
                                                            </ul>
                                                            {{-- <ul class="price">
                                                            <li class="grey"><span
                                                                    class="duration">Information
                                                                    needed</span></li>
                                                            <li>Your full name</li>
                                                            <li>Your residential address </li>
                                                            <li>Your date of birth </li>
                                                            <li>The last 4 digits of your SSN</li>
                                                        </ul> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="plans clearfix">
                                    <div class="columns">
                                        <ul class="price">
                                            <li class="header">Tier 1 </li>
                                            <li class="grey"><span class="duration">24 Hours</span></li>
                                            <li>$2,999
                                                <!--<span class="li-spa">$2,999 remaining</span> -->
                                            </li>
                                            <li>$10,000 </li>
                                            <li>$18,000 </li>
                                            <li class="grey"><a href="javascript:void(0)"
                                                    class="button">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="plans clearfix">
                                    <div class="columns">
                                        <ul class="price">
                                            <li class="grey"><span class="duration">Information
                                                    needed</span></li>
                                            <li>Your full name</li>
                                            <li>Your residential address </li>
                                            <li>Your date of birth </li>
                                            <li>The last 4 digits of your SSN</li>
                                        </ul>
                                    </div>
                                </div> --}}

                                <div class="plans-footer">
                                    <p>If we are unable to verify this information electronically we may require additional
                                        information. This information may include: proof of identity, proof of address, and
                                        proof of funding.</p>
                                    <p><b>Additional sending limits may apply depending upon your choice of payout partner
                                            or receiving location.</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <style type="text/css">
        .info li {
            list-style-type: none;
        }
    </style>
@endsection
