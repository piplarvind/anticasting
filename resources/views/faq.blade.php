@extends('layouts.auth_app')

@section('content')
    @include('layouts.payment-dropdown')
    <section class="public-main">
        <div class="container">
            <h1>FAQ</h1>
        </div>


        <section class="copmetition-page-style" style="padding-top:20px;">
            <div class="container">
                All the persons who browse the <a href="{{ route('home') }}">{{ GlobalValues::get('site_title') }}</a>
                are
                requested to READ and UNDERSTAND the following information. If you are unable to get the answers for your
                questions, please feel free to contact us at <a
                    href="mailto:{{ GlobalValues::get('contact_email') }}">{{ GlobalValues::get('contact_email') }}</a>
            </div>
        </section>
        <section class="faq-sec-v">
            <div class="container">
                <div class="faq-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="accordion" class="panel-group accordion">
                                @foreach ($faqs as $faq)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#collapse{{ $faq->id }}" data-parent="#accordion"
                                                    data-toggle="collapse">
                                                    <i class="switch fa fa-plus"></i>
                                                    {{ $faq->question }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="collapse{{ $faq->id }}">
                                            <div class="panel-body">{!! $faq->answer !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
