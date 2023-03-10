@extends('admin.layouts.admin_master')
@section('title')
   Dashboard
@endsection
@section('content')
<script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
<script src="{{ asset('assets/auth/toastr.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
<div class="main">
    <script>
        @if(Session::has('message'))
           toastr.success("{{ Session::get('message') }}");
           @elseif (Session::has('error'))
             toastr.error("{{ Session::get('error') }}");
         @endif
     </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Hello, <span>Welcome Here</span></h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        <!-- /# row -->
        <section id="main-content">
            <div class="row">
                {{-- <div class="col-lg-3">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Total Profit</div>
                                <div class="stat-digit">1,012</div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-3">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Actors</div>
                                <div class="stat-digit">961</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-layout-grid2 color-pink border-pink"></i>
                            </div>
                            <div class="stat-content dib">
                                <div class="stat-text">Active Projects</div>
                                <div class="stat-digit">770</div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3">
                    <div class="card">
                        <div class="stat-widget-one">
                            <div class="stat-icon dib"><i class="ti-link color-danger border-danger"></i></div>
                            <div class="stat-content dib">
                                <div class="stat-text">Referral</div>
                                <div class="stat-digit">2,781</div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        
         


            <div class="row" style="bottom: 0; position: fixed;">
                <div class="col-lg-12">
                    <div class="footer">
                        <p>{{Carbon\Carbon::now()->year}} © Admin Dashboard <a class="nav-item" href="https://sascoders.com/" target="__blank">SASCoders</a></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection