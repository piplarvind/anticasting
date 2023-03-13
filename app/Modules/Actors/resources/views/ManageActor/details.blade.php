@extends('admin.layouts.admin_master')
@section('title')
    Actor Manage Actor
@endsection
<style>
    #contact_select {


        background: #FFF;
        color: #aaa;
    }

    .container {
        background: #fff !important;
        border: none;
        border-radius: none
    }

    .abc {
        padding-left: 40px
    }

    .pqr {
        padding-right: 70px;
        padding-top: 14px
    }

    .para {
        float: right;
        margin-right: 0;
        padding-left: 80%;
        top: 0
    }

    li {
        list-style: none;
        line-height: 50px;
        color: #000
    }

    .col-md-2 {
        padding-bottom: 20px;
        font-weight: bold
    }

    .col-md-2 a {
        text-decoration: none;
        color: #000
    }

    .col-md-2.mio {
        font-size: 12px;
        padding-top: 7px
    }

    .des::after {
        content: '.';
        font-size: 0;
        display: block;
        border-radius: 20px;
        height: 6px;
        width: 55%;
        background: yellow;
        margin: 14px 0
    }

    /* .r4 {
        padding-left: 25px
    } */

    .btn-outline-warning {
        border-radius: 0;
        border: 2px solid yellow;
        color: #000;
        font-size: 12px;
        font-weight: bold;
        width: 70%
    }

    @media screen and (max-width: 620px) {
        .container {
            width: 98%;
            display: flex;
            flex-flow: column;
            text-align: center
        }

        .des::after {
            content: '.';
            font-size: 0;
            display: block;
            border-radius: 20px;
            height: 6px;
            width: 35%;
            background: yellow;
            margin: 10px auto
        }

        .pqr {
            text-align: center;
            margin: 0 30px
        }

        .para {
            text-align: center;
            padding-left: 90px;
            padding-top: 10px
        }

        .klo {
            display: flex;
            text-align: center;
            margin: 0 auto;
            margin-right: 10px;
        }

        .text {
            padding-left: 30px;
        }

        .content-list {
            margin-left: 50px;
        }

    }
</style>

@section('content')
    <div class="main">

        <div class="container-fluid">
            @if (Session::has('error'))
                {
                <script>
                    alert("{{ Session::get('error') }}");
                </script>
                }
            @endif
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage Actor</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Actor</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title pr">
                        <h6><b class="breadcrumb-item">About Actor</b></h6>
                    </div>
                    <div class="card-body">
                        <hr />
                        <div class="container py-4 my-4 mx-auto d-flex flex-column">
                            <div class="row r1">
                                <div class="col-md-9 abc">
                                    <h1 class="text-muted">Actor Information</h1>
                                </div>
                            </div>

                            <div class="container mt-4">
                                <div class="row r3">
                                    <div class="col-md-7 p-0 klo">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="content-list">
                                                    <li class="c-green text-break text-truncate">

                                                        <span class="fw-bold text-muted fs-1"><b> Name : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item->first_name . ' ' . $item->last_name }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> email : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item->email }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> Phone No : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item->countryCode . ' ' . $item->mobile_no }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> Date Of Birth :
                                                            </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item?->profile?->date_of_birth }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b>Current Location :
                                                            </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item?->profile?->current_location }}
                                                        </span>
                                                    </li>


                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul>
                                                    <li class="c-green text-break text-truncate">

                                                        <span class="fw-bold text-muted fs-1"><b> Ethnicity : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item?->profile?->ethnicity }}
                                                        </span>
                                                    </li>

                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> Gender : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item?->profile?->gender }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1 "><b> Height : </b></span>
                                                        <span
                                                            class="white-space fw-bold fs-1 text-secondary">{{ $item?->profile?->height }}
                                                        </span>
                                                    </li>
                                                    <li class="text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> Weight : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item?->profile?->weight }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-5">
                                        @isset($item?->images[0]?->image)
                                            <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                src="{{ $item?->images[0]?->image }}" width="90%" height="100%">
                                        @else
                                            <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                src="{{ asset('assets/images/default-user.jfif') }}" width="90%"
                                                height="100%">
                                        @endisset
                                    </div>
                                </div>
                                <div class="footer d-flex flex-column mt-5">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="d-flex justify-content-center fw-bold h6 text-muted fs-1">Work
                                                Reels</span>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @isset($item?->profile?->work_reel1)
                                                        <iframe width="95%" height="95%"
                                                            src="{{ $item?->profile?->work_reel1 }}"
                                                            title="YouTube video player" frameborder="2"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                          src="{{ asset('assets/images/video-thumb.png') }}" width="90%"
                                                            height="95%">
                                                    @endisset
                                                </div>
                                                <div class="col-md-4">
                                                    @isset($item?->profile?->work_reel2)
                                                        <iframe width="95%" height="95%"
                                                            src="{{ $item?->profile?->work_reel2 }}"
                                                            title="YouTube video player" frameborder="2"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                        src="{{ asset('assets/images/video-thumb.png') }}" width="90%"
                                                            height="95%">
                                                    @endisset
                                                </div>
                                                <div class="col-md-4">
                                                    @isset($item?->profile?->work_reel3)
                                                        <iframe width="95%" height="95%"
                                                            src="{{ $item?->profile?->work_reel3 }}"
                                                            title="YouTube video player" frameborder="2"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                            src="{{ asset('assets/images/video-thumb.png') }}"
                                                            width="90%" height="95%">
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="d-flex justify-content-center fw-bold h6 text-muted fs-1">Intro
                                                Video</span>
                                            <div class="d-flex justify-content-center">
                                                @isset($item?->introVideo?->intro_video_link)
                                                    <iframe width="65%" height="65%"
                                                        src="{{$item?->introVideo?->intro_video_link}}"
                                                        title="YouTube video player" frameborder="2"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                        allowfullscreen>
                                                    </iframe>
                                                @else
                                                    <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                       src="{{ asset('assets/images/video-thumb.png') }}" width="85%"
                                                        height="85%">
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
