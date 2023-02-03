@extends('admin.layouts.admin_master')
@section('title')
    Manage User
@endsection
@section('content')
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage User</h1>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('admin.submitprofile') }}">UserProfile</a></li>
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
                        <h6><b class="breadcrumb-item">Manage UserProfile</b></h6>
                    </div>
                    <hr />
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.manageuserprofile.post',$user->id) }}">
                             @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" id="name"><b>Name
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="name" class="form-control" id="staticName"
                                            value="{{ old('name', $user->name) }}">
                                    </div>

                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="form-label" id="firstname"><b>FirstName
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="firstname" class="form-control" id="firstname"
                                                value="{{ old('firstname', $user->first_name) }}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="form-label" id="lastname"><b>LastName
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="lastname" class="form-control" id="lastname"
                                                value="{{ old('lastname', $user->last_name) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">

                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="form-label" id="email"><b>Email
                                                    </b><span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="email" class="form-control" id="email"
                                                    value="{{ old('email', $user->email) }}">
                                            </div>
                                        </div>
                                        @error('email')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="mobile_no"><b>Mobile NO</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="text" name="mobile_no" class="form-control" id="mobile_no"
                                        value="{{ old('mobile_no', $user->mobile_no) }}" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                  
                                   </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                 <input type="submit" class="btn btn-success" value="Update"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
        <script>
            $(function() {
                $("#date_of_birth").datepicker();
            });
        </script>
    </section>
@endsection
