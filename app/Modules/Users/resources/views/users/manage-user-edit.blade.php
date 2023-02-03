@extends('admin.layouts.admin_master')
@section('title')
 Manage User|Edit
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
                            <li class="breadcrumb-item active">Manage User</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        <section id="main-content">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title pr">
                            <h6><b class="breadcrumb-item">Manage User</b></h6>
                        </div>
                        <hr />
                        <div class="card-body">
                            <form action="{{ route('admin.manageuser.post', $user->id) }}" method="post">
                                @csrf
                                  @method('PUT')
                                <div class="row">
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" id="contact"><b>Name
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="name" class="form-control" id="staticName"
                                                value="{{ old('name',$user->name) }}" />
                                        </div>
    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" id="contact"><b>FirstName
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="first_name" class="form-control" id="staticName"
                                                value="{{ old('first_name',$user->first_name) }}" />
                                        </div>
    
                                    </div>
    
                                   
                                </div>
                                <div class="row">
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" id="contact"><b>LastName
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="last_name" class="form-control" id="staticName"
                                                value="{{ old('last_name',$user->last_name) }}" />
                                        </div>
    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" id="contact"><b>Email
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="email" class="form-control" id="staticName"
                                                value="{{ old('email',$user->email) }}" />
                                        </div>
    
                                    </div>
    
                                   
                                </div>
                                <div class="row">
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" id="contact"><b>Mobile No
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="mobile_no" class="form-control" id="staticName"
                                                value="{{ old('mobile_no',$user->mobile_no) }}" />
                                        </div>
    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" id="contact"><b>Status
                                                </b><span style="color:red;">*</span>
                                            </label>
                                            <input type="checkbox" name="status" value="1"
                                             id="status" 
                                               @if($user->status == 1)  checked   @endif
                                            />
                                        </div>
    
                                    </div>
    
                                   
                                </div>
                               
    
    
                                <center>
                                    <input type="submit" class="btn btn-success" value="Update" />
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
    
            </div>
    
    
    
            <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
    
        </section>
    </div>
  </div>
@endsection