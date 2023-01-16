@extends('layouts.app')
@section('content')
    @include('layouts/banner')
    <section class="calculator-sec">
        <div class="container">
            <div class="calculator-main">
                <!-- <div class="labels"><span>New Customer Offer</span></div> -->
                <h2>Where are you sending money to?</h2>
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="dropdown">
                            <div class="dropdown__skeleton">
                                <div class="dropdown__skeleton_inner">
                                    <label>From</label>
                                    <div class="dropdown__selected dropdown__option"><img
                                            src="{{ asset('public') }}/img/us.svg" alt="U.S." /><span>United
                                            States</span>
                                    </div>
                                    <div class="dropdown__arrow"></div>
                                </div>
                            </div>
                            <div class="dropdown__options">
                                <div class="dropdown__option dropdown__option--selected"><img
                                        src="{{ asset('public') }}/img/us.svg" alt="U.S." /><span>United States</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="dropdown">
                            <div class="dropdown__skeleton">
                                <div class="dropdown__skeleton_inner">
                                    <label>To</label>
                                    @if (isset($selected_send_country))
                                        <div class="dropdown__selected dropdown__option"><img
                                                src="{{ asset('public') }}/country/{{ $selected_send_country->flag }}"
                                                alt="{{ $selected_send_country->country_name }}" /><span>{{ $selected_send_country->country_name }}</span>
                                        </div>
                                    @else
                                        <div class="dropdown__selected dropdown__option"><img
                                                src="{{ asset('public') }}/img/mexico.svg"
                                                alt="Mexico" /><span>Mexico</span>
                                        </div>
                                    @endif
                                    <div class="dropdown__arrow"></div>
                                </div>
                            </div>
                            <div class="dropdown__options">
                                @if (isset($header_receiving_countries))
                                    @foreach ($header_receiving_countries as $header_receiving_country)
                                        <div onclick="chageSendToCountry('{{ $header_receiving_country->country_iso_code }}')"
                                            class="dropdown__option dropdown__option--selected"><img
                                                src="{{ asset('public') }}/country/{{ $header_receiving_country->flag }}"
                                                alt="{{ $header_receiving_country->country_name }}" /><span>{{ $header_receiving_country->country_name }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- POWER PAYEMNT -->
    <section class="power-payment-sec">
        <div class="container">
            <div class="sec-head">
                <h4>Fast, secure and cost-effective.</h4>
                <h1>Protecting you and your money</h1>
            </div>
            <div class="power-slide-main">
                <div class="" id="power-slide">
                    <div class="item">
                        <div class="power-boxer">
                            <img src="{{ asset('public') }}/img/bank-1.png" alt="icons" />
                            <h4>Bank Deposit</h4>
                            <p>Plug into our payment network and open a world of opportunity</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="power-boxer">
                            <img src="{{ asset('public') }}/img/money-2.png" alt="icons" />
                            <h4>Save on fees</h4>
                            <p>$0 when sending $500 or more </br> $3.99 when sending less than $500</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="power-boxer">
                            <img src="{{ asset('public') }}/img/bank-rate1.png" alt="icons" />
                            <h4>Great everyday rates</h4>
                            <p>Appointment Booking everyday rate: $20.97 </br> (Last updated: less than 1 hour ago)</p>
                        </div>
                    </div>
                    <!-- <div class="item">
                                                                                                                                                             <div class="power-boxer">
                                                                                                                                                             <img src="{{ asset('public') }}/img/p-icon-2.png" alt="icons"/>
                                                                                                                                                             <h4>On time</h4>
                                                                                                                                                             <p>Every transfer carries a delivery promise. We </br> deliver on time or your money back</p>
                                                                                                                                                             </div>
                                                                                                                                                             </div>
                                                                                                                                                             <div class="item">
                                                                                                                                                             <div class="power-boxer">
                                                                                                                                                             <img src="{{ asset('public') }}/img/p-icon-4.png" alt="icons"/>
                                                                                                                                                             <h4>Money Transfer</h4>
                                                                                                                                                             <p>Plug into our payment network and open a world of opportunity</p>
                                                                                                                                                             </div>
                                                                                                                                                             </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- IN_POCKET -->
    <section class="send-money-sec">
        <div class="container">
            <div class="sec-head">
                <h4>We know you like to be in control and always know what you are paying for, so that’s exactly what you’ll
                    get with us.</h4>
                <h1>In your pocket, wherever you go</h1>
            </div>
            <div class="sender-money-boxes">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mid-mobiles wow zoomIn">
                            <img src="{{ asset('public') }}/img/send_money_tab.png" alt="mob-screen" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-boxs wow fadeInLeft" style="animation-delay: 0.6s">
                            <div class="mb-img drk-pink-bg">
                                <img src="{{ asset('public') }}/img/icon-11.png" alt="icons" />
                            </div>
                            <h4>Step 1</h4>
                            <p>Competitive pricing, no hidden fees.</p>
                        </div>
                        <div class="mb-boxs wow fadeInLeft" style="animation-delay: 0.8s">
                            <div class="mb-img green-bg">
                                <img src="{{ asset('public') }}/img/icon-13.png" alt="icons" />
                            </div>
                            <h4>Step 2</h4>
                            <p>Usually instant or same day transfer.</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-boxs wow fadeInRight" style="animation-delay: 0.6s">
                            <div class="mb-img pink-bg">
                                <img src="{{ asset('public') }}/img/icon-12.png" alt="icons" />
                            </div>
                            <h4>Step 3</h4>
                            <p>We verify everyone and everything, always.</p>
                        </div>
                        <div class="mb-boxs wow fadeInRight" style="animation-delay: 0.8s">
                            <div class="mb-img purple-bg">
                                <img src="{{ asset('public') }}/img/icon-14.png" alt="icons" />
                            </div>
                            <h4>Step 4</h4>
                            <p>Always know the cost. Stay in control.</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- TESTIMONIAL -->
    <section class="testimonial-sec">
        <div class="container">
            <div class="sec-head">
                <h4>Customer Reviews</h4>
                <h1>See what our customers say</h1>
            </div>
            <div class="tsti-slide">
                <div class="owl-carousel owl-theme" id="testi-slide">
                    @if ($testimonials->count())
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testi-boxer">
                                    <img src="{{ asset('public') }}/img/stars-{{ $testimonial->rating }}.svg"
                                        alt="icons" />
                                    <div class="testimonial_txt">{!! $testimonial->testimonial !!}</div>
                                    <h4>{{ $testimonial->client_name }}</h4>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function chageSendToCountry(country_iso_code) {
            var isLoggedIn = "{{ Auth::user() }}";
            if (!isLoggedIn) {
                document.location.href = "/login";
                return false;
            }
            $.ajax({
                beforeSend: function() {
                    showLoader();
                },
                type: "POST",
                url: "{{ route('change-send-to-country') }}",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'country_iso_code': country_iso_code
                },
                success: function(res) {
                    hideLoader();
                    if (res.success) {
                        document.location.href = "{{ route('send-receive-details') }}";
                    } else {
                        alert(res.msg);
                    }
                }
            });

            function showLoader() {
                $("#progressbar").css("display", "block");
            }

            function hideLoader() {
                setTimeout(function() {
                    $("#progressbar").css("display", "none");
                }, 1000);
            }
        }
    </script>
@endsection
