@extends('layouts.auth_app')
@section('content')
    <section class="cms-banner" style="background: url({{ asset('public') }}/img/review-banner-bg.jpg);">
        <div class="container">
            <div class="comman-head">
                <h1>There's a reason why our customers choose {{ GlobalValues::get('site_title') }}</h1>
                <h3>Check out the latest {{ GlobalValues::get('site_title') }} reviews from actual customers.</h3>
            </div>
        </div>
    </section>

    <section class="rating-sec">
        <div class="sec-head">
            <h4>Customer Reviews</h4>
            <h1>See what our customers say</h1>
        </div>
        <div class="container">
            <div class="row">
                @if ($testimonials->count())
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4">
                            <div class="review-item">
                                {{-- <div class="client-img"><img src="{{ asset('public') }}/img/user-1.jpg"
                                        alt="client_img"></div> --}}
                                <div class="text-center"><img
                                        src="{{ asset('public') }}/img/stars-{{ $testimonial->rating }}.svg"
                                        alt="rating_img"></div>
                                <div>{!! $testimonial->testimonial !!}</div>
                                <div class="text-right"><b>{{ $testimonial->client_name }}</b></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
