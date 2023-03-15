@extends('front-dashboard.layouts.app')
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
        line-height: 30px;
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
            margin-left: 0px;
        }

        .text {
            padding-left: 30px;
        }

        .content-list {
            margin-left: 50px;
        }

        .steps {
            position: relative;
        }

    }

    /* Core Styles */
    #slider {
        width: 250px;
        overflow: hidden;
        border: 0px solid #363535;
        height: 250px;
        position: relative;
        margin: auto;
    }

    #slider ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
    }

    #slider ul li img{
        display: block;
        width: 250px !important;
        height:250px !important;
      }
    #slider ul li img:hover{
        opacity: 0.4;
    }
    /* Control Styles */
    #links {
        width: 250px !important;
        height:50px !important;
        display: flex;
        margin: 2 auto;
    }

    #links a {
        display: block;
        width: 210px;
        background-color: #cec8c8;
        height: 50px;
        line-height: 50px;
        color: #221d1d;
        text-decoration: none;
        text-align: center;
    }

    #links a:hover {
        background: #c96869;
        color: #fff;
    }

</style>
@section('content')
    <section>
      
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card m-1">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center text-muted">Actor View Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="container py-4 my-4 mx-auto d-flex flex-column">
                            {{-- <div class="row r1">
                    <div class="col-md-9">
                      
                    </div>
                </div> --}}
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-md-7  col-xs-12 col-sm-12 p-0 klo">
                                        <div class="row">
                                            <div class="col-md-6  col-xs-12 col-sm-12">
                                                <ul class="content-list">
                                                    <li class="c-green text-break">

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
                                            <div class="col-md-6 col-xs-12 col-sm-12 mb-5">
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
                                    <div class="col-md-5  col-xs-5 col-sm-5">
                                        {{-- <div class="row steps">
                                            <div class="col-md-4 col-xs-4 col-sm-4 col-md-offset-1">
                                                @isset($item?->images[0]?->image)
                                                    <img class="d-flex rounded  justify-content-between"
                                                        src="{{ $item?->images[0]?->image }}"
                                                        style="width:120px; height:150px; border:1px solid black;">
                                                @else
                                                    <img class="d-flex justify-content-between"
                                                        src="{{ asset('assets/images/default-user.jfif') }}" width="120"
                                                        height="150">
                                                @endisset
                                            </div>
                                            <div class="col-md-4 col-xs-4 col-sm-4 col-md-offset-1">
                                                @isset($item?->images[1]?->image)
                                                    <img class="d-flex rounded  justify-content-between"
                                                        src="{{ $item?->images[1]?->image }}"
                                                        style="width:120px; height:150px; border:1px solid black;">
                                                @else
                                                    <img class="d-flex rounded justify-content-between"
                                                        src="{{ asset('assets/images/default-user.jfif') }}" width="120"
                                                        height="150">
                                                @endisset
                                            </div>
                                            <div class="col-md-4  col-xs-4 col-sm-4 col-md-offset-1">
                                                @isset($item?->images[2]?->image)
                                                    <img class="d-flex rounded  justify-content-between"
                                                        src="{{ $item?->images[2]?->image }}"
                                                        style="width:120px; height:150px; border:1px solid black;">
                                                @else
                                                    <img class="d-flex rounded justify-content-between"
                                                        src="{{ asset('assets/images/default-user.jfif') }}" width="120"
                                                        height="150">
                                                @endisset
                                            </div>

                                        </div> --}}
                                        <div id="slider" class="shadow-lg p-1 mb-3 bg-body rounded">
                                            <ul>
                                                <li>
                                                    @isset($item?->images[0]?->image)
                                                        <img  src="{{ $item?->images[0]?->image }}"
                                                           />
                                                    @else
                                                        <img src="{{ asset('assets/images/default-user.jfif') }}"
                                                        />
                                                    @endisset
                                                </li>
                                                <li>
                                                    @isset($item?->images[1]?->image)
                                                        <img  src="{{ $item?->images[1]?->image }}"
                                                        />
                                                    @else
                                                        <img  src="{{ asset('assets/images/default-user.jfif') }}"
                                                           />
                                                    @endisset
                                                </li>
                                                <li>
                                                    @isset($item?->images[2]?->image)
                                                        <img src="{{ $item?->images[2]?->image }}"
                                                       />
                                                    @else
                                                        <img  src="{{ asset('assets/images/default-user.jfif') }}"
                                                           >
                                                    @endisset
                                                </li>
                                
                                            </ul>
                                        </div>
                                        <div id="links">
                                            <a href="#" id="previous">Prev</a>
                                            <a href="#" id="next">Next</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer d-flex flex-column mt-5">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="d-flex justify-content-center fw-bold h6 text-muted fs-1">Work
                                                Reels</span>
                                            <div class="row steps">
                                                <div class="col-md-4 col-xs-4 col-sm-4 col-md-offset-1">
                                                    @isset($item?->profile?->work_reel1)
                                                        <iframe width="100%" height="100%"
                                                            src="{{ $item?->profile?->work_reel1 }}"
                                                            title="YouTube video player" frameborder="2"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                            src="{{ asset('assets/images/video-thumb.png') }}" width="100%"
                                                            height="100%">
                                                    @endisset
                                                </div>
                                                <div class="col-md-4 col-xs-4 col-sm-4 col-md-offset-1">
                                                    @isset($item?->profile?->work_reel2)
                                                        <iframe width="100%" height="100%"
                                                            src="{{ $item?->profile?->work_reel2 }}"
                                                            title="YouTube video player" frameborder="2"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                            src="{{ asset('assets/images/video-thumb.png') }}" width="100%"
                                                            height="100%">
                                                    @endisset
                                                </div>
                                                <div class="col-md-4 col-xs-4 col-sm-4 col-md-offset-1">
                                                    @isset($item?->profile?->work_reel3)
                                                        <iframe width="100%" height="100%"
                                                            src="{{ $item?->profile?->work_reel3 }}"
                                                            title="YouTube video player" frameborder="2"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                            src="{{ asset('assets/images/video-thumb.png') }}" width="100%"
                                                            height="100%">
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-4 col-sm-4">
                                            <span class="d-flex justify-content-center fw-bold h6 text-muted fs-1">Intro
                                                Video</span>
                                            <div class="d-flex justify-content-center">
                                                @isset($item?->introVideo?->intro_video_link)
                                                    <iframe width="100%" height="100%"
                                                        src="{{ $item?->introVideo?->intro_video_link }}"
                                                        title="YouTube video player" frameborder="2"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                        allowfullscreen>
                                                    </iframe>
                                                @else
                                                    <img class="d-flex rounded img-fluid img-thumbnail justify-content-between"
                                                        src="{{ asset('assets/images/video-thumb.png') }}" width="100%"
                                                        height="100%">
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
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(window).on('load', function() {

            const imageCount = $('#slider ul li').length;
            const imageWidth = $('#slider ul li img').first().width();
            const totalWidth = (imageWidth * imageCount) + 'px';
            let leftPosition = 0;
            let counter = 0;
            $('#slider ul').css('width', totalWidth);

            // next button
            $('#next').click(function() {
                counter++;
                if (counter === imageCount) {
                    $('#slider ul').clone().appendTo('#slider');
                    $('#slider ul').last().css('left', imageWidth + 'px');

                    leftPosition = `-${totalWidth}`;

                    $('#slider ul').last().animate({
                        left: 0
                    }, 700, 'easeInQuad');
                    $('#slider ul').first().animate({
                        left: leftPosition
                    }, 700, 'easeInQuad', function() {
                        $('#slider ul').first().remove();
                    });
                    counter = 0;
                } else {
                    leftPosition = `-${counter * imageWidth}px`;
                    $('#slider ul').animate({
                        left: leftPosition
                    }, 700, 'easeInQuad');
                }
            });

            // previous button
            $('#previous').click(function() {
                counter--;
                if (counter < 0) {
                    counter = imageCount - 1;
                    $('#slider ul').clone().appendTo('#slider');
                    $('#slider ul').last().css('left', `-${totalWidth}`);
                    leftPosition = `-${counter * imageWidth}px`;
                    $('#slider ul').last().animate({
                        left: leftPosition
                    }, 700, 'easeInQuad');
                    $('#slider ul').first().animate({
                        left: imageWidth + 'px'
                    }, 700, 'easeInQuad', function() {
                        $('#slider ul').first().remove();
                    });
                } else {
                    leftPosition = `-${counter * imageWidth}px`;
                    $('#slider ul').animate({
                        left: leftPosition
                    }, 700, 'easeInQuad');
                }
            });
        });
    </script>
@endsection
