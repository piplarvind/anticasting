@extends('layouts.auth_app')
@section('description', $page_info->trans->page_meta_keywords)
@section('keywords', $page_info->trans->page_meta_descriptions)
@section('content')
    @include('layouts.payment-dropdown')
    <section class="dashboard-main">
        <div class="container">

            <section class="inner-page-banner">
                <div class="container">
                    <h1>{{ $page_info->trans->title }}</h1>
                </div>
            </section>
            <section class="cms-page-style">
                <div class="container">
                    @if ($page_info->trans->top_image)
                        <div class="com-img-comon"><img
                                src="{{ asset('public/img/cms-images/thumbnail/') }}/{{ $page_info->trans->top_image }}"
                                alt="banner" /></div>
                    @endif

                    <div class="{{ $page_info->page_url }}">
                        {!! $page_info->trans->body !!}
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
