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
@php
    $movie_video_link = $item->movie_link;
    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
    $youtube_video_link = ' ';
    if (preg_match($longUrlRegex, $movie_video_link, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
        $youtube_video_link = 'https://www.youtube.com/embed/' . $youtube_id;
    }
    if (preg_match($shortUrlRegex, $movie_video_link, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
        $youtube_video_link = 'https://www.youtube.com/embed/' . $youtube_id;
    }
    
@endphp
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
                            <h1>Manage Bucket</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Bucket</li>
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
                        {{-- <h6><b class="breadcrumb-item">Bucket Details</b></h6> --}}
                    </div>
                    <div class="card-body">
                        <hr />
                        <div class="container py-4 my-4 mx-auto d-flex flex-column">
                            <div class="row r1">
                                <div class="col-md-9 abc">
                                    {{-- <h1 class="text-muted">Bucket</h1> --}}
                                </div>
                            </div>

                            <div class="container mt-4">
                                <div class="row r3">
                                    <div class="col-md-7 p-0 klo">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="content-list">
                                                    <li class="c-green text-break text-truncate">

                                                        <span class="fw-bold text-muted fs-1"><b> Bucket Name : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item->bucket_name }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> Movie Name : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            {{ $item->movie_name }}
                                                        </span>
                                                    </li>
                                                    <li class="c-green text-break text-truncate">
                                                        <span class="fw-bold text-muted fs-1"><b> Movie Link : </b></span>
                                                        <span class="white-space fw-bold fs-1 text-secondary">
                                                            <a href="{{ $item->movie_link }}"
                                                                target="__blank">{{ $item->movie_link }}</a>
                                                        </span>
                                                    </li>

                                                </ul>
                                            </div>

                                            <div class="col-md-6">
                                                <span class=" d-flex justify-content-center fw-bold text-muted fs-1">
                                                    <b>
                                                        Description
                                                    </b>
                                                </span>
                                                <span class="text-justify text-muted fw-bold fs-1 text-secondary">
                                                    {!! $item->description !!}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    @if ($youtube_video_link != ' ')
                                        <div class="col-md-5">
                                            <iframe width="100%" height="100%" src="{{ $youtube_video_link }}"
                                                frameborder="2"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                      
                                        @else
                                        <div class="col-md-5">
                                            <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                       src="{{ asset('assets/images/video-thumb.png') }}" width="85%"
                                                        height="85%"/>
                                        </div>   
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
