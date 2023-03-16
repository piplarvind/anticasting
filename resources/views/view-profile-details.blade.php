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
}
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
 .image-container {
        width: 300px;
        height: 300px;
        background-color: #fff;
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 10px;
        gap: 10px;
    }

    img {
        width: 100%;
        display: block;
    }

    .card-left {
        width: 226px !important;
        overflow: hidden;
    }

    .main-image {
        display: flex;
        transition: all 0.5s ease;
       
    }
   
    .img-select {
        display: flex;
        margin-top: 2px;
    }

    .img-select-container {
        border: 2px solid white;
    }

    .active {
        border-color: black;

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
                               </div> 
                               --}}
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
                                        <div class="image-container">
                                            <div class="card-left">
                                                <div class="main-image">
                                                    @isset($item?->images[0]?->image)
                                                        <img src="{{ $item?->images[0]?->image }}" />
                                                    @else
                                                        <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                    @endisset
                                                    @isset($item?->images[1]?->image)
                                                        <img src="{{ $item?->images[1]?->image }}" />
                                                    @else
                                                        <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                    @endisset
                                                    @isset($item?->images[2]?->image)
                                                        <img src="{{ $item?->images[2]?->image }}" />
                                                    @else
                                                        <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                    @endisset

                                                </div>
                                                <div class="img-select">
                                                    <div class="img-select-container active">
                                                        <a href="#" data-id="1">
                                                            @isset($item?->images[0]?->image)
                                                                <img src="{{ $item?->images[0]?->image }}" />
                                                            @else
                                                                <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                            @endisset
                                                        </a>
                                                    </div>
                                                    <div class="img-select-container">
                                                        <a href="#" data-id="2">
                                                            @isset($item?->images[1]?->image)
                                                                <img src="{{ $item?->images[1]?->image }}" />
                                                            @else
                                                                <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                            @endisset
                                                        </a>
                                                    </div>
                                                    <div class="img-select-container">
                                                        <a href="#" data-id="3">
                                                            @isset($item?->images[2]?->image)
                                                                <img src="{{ $item?->images[2]?->image }}" />
                                                            @else
                                                                <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                            @endisset
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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
        const imgs = document.querySelectorAll('.img-select-container a');
        let imgId = 1;

        const imgDiv = document.querySelectorAll('.img-select-container');

        imgs.forEach((img) => {
            img.addEventListener('click', (e) => {
                e.preventDefault();
                imgId = img.dataset.id;

                imgDiv.forEach((img) => {
                    img.classList.remove('active');
                });

                img.parentElement.classList.add('active');

                moveImage();
            });
        });
        function moveImage() {
            const imgWidth = document.querySelector('.main-image img:first-child').clientWidth;
        
            let width = (imgId - 1) * imgWidth;
            document.querySelector('.main-image').style.transform = `translateX(${-width}px)`;

        }
    </script>
@endsection
