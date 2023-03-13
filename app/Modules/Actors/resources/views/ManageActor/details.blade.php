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

    .r4 {
        padding-left: 25px
    }

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
        .text{
            padding-left:30px; 
        }
        .content-list{
            margin-left:50px;
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
                                    <h1 class="">Actor Information</h1>
                                </div>
                            </div>

                            <div class="container mt-4">
                                <div class="row r3">
                                    <div class="col-md-7 p-0 klo">
                                        <ul class="content-list">
                                            <li>

                                                <span class="fw-bold h6"><b> Name : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate text">{{ $item->first_name . ' ' . $item->last_name }}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="fw-bold h6"><b> email : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{ $item->email}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="fw-bold h6"><b> Phone No : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{ $item->countryCode . ' ' . $item->mobile_no }}
                                                </span>
                                            </li>
                                            <li> 
                                                <span class="fw-bold h6"><b> Date Of Birth : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{ $item?->profile?->date_of_birth }}
                                                </span>
                                            </li>
                                            <li> 
                                                <span class="fw-bold h6"><b>Current Location : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{ $item?->profile?->current_location }}
                                                </span>
                                            </li>
                                            <li>

                                                <span class="fw-bold h6"><b> Ethnicity : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{ $item?->profile?->ethnicity}}
                                                </span>
                                            </li>
                                           
                                            <li>
                                                <span class="fw-bold h6"><b> Gender : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{ $item?->profile?->gender }}
                                                </span>
                                            </li>
                                            <li> 
                                                <span class="fw-bold h6"><b> Height : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{$item?->profile?->height }}
                                                </span>
                                            </li>
                                            <li> 
                                                <span class="fw-bold h6"><b> Weight : </b></span>
                                                <span
                                                    class="c-green text-break text-truncate ps-5">{{$item?->profile?->weight }}
                                                </span>
                                            </li>
                                          
                                        </ul>
                                    </div>
                                    <div class="col-md-5"> <img src="{{ $item?->images[0]?->image }}" width="85%"
                                            height="85%"> </div>
                                </div>
                            </div>
                            {{-- <div class="footer d-flex flex-column mt-5">
                                <div class="row r4">
                                    <div class="col-md-2 myt des"><a href="#">Description</a></div>
                                    <div class="col-md-2 myt "><a href="#">Review</a></div>
                                    <div class="col-md-2 mio offset-md-4"><a href="#">ADD TO CART</a></div>
                                    <div class="col-md-2 myt "><button type="button" class="btn btn-outline-warning"><a href="#">BUY NOW</a></button></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
