@extends('admin.layouts.admin_master')
@section('title')
    Setting
@endsection
@section('content')
<script src="{{ asset('assets/auth/toastr.min.js') }}" defer ></script>
<script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
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
                        <h1>Settings</h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>

        <!-- /# row -->
        <section id="main-content">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>Setting : Main Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="{{ route('admin.UpdateSettingMainInfo')}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b> Site Title</b> <span style="color:red;"><b>*</b></span></label>
                                                <input type="text" class="form-control" name="site_title" placeholder="Site Title" value="{{ old('site_title',$site_title) }}" />
                                                @error('site_title')
                                                   <span style="color:red;"><b>{{$message}}</b></span> 
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reward"><b>Site Email </b> <span style="color:red;"><b>*</b></span></label>
                                                <input type="text" class="form-control" name="site_email" placeholder="Site Email" value="{{ old('site_email',$site_email) }}" />
                                                @error('site_email')
                                                <span style="color:red;"><b>{{$message}}</b></span> 
                                             @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>Site Url</b> <span style="color:red;"><b>*</b></span></label>
                                                <input type="text" class="form-control" name="site_url" placeholder="Site Url" value="{{ old('site_url',$site_url) }}" />
                                                @error('site_url')
                                                <span style="color:red;"><b>{{$message}}</b></span> 
                                             @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reward"><b>Site Address</b> <span style="color:red;"><b>*</b></span></label>
                                                <input type="text" class="form-control" name="address" placeholder="Site Address" value="{{ old('address',$address) }}" />
                                                @error('address')
                                                <span style="color:red;"><b>{{$message}}</b></span> 
                                             @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
@stop

