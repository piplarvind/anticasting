@extends('admin.layouts.admin_master') 
@section('title')
    Message
@endsection
@section('content')
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        <h1>Message</h1>

                    </div>

                </div>

            </div>

            <div class="col-lg-6 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Message</li>
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
                    <h6><b class="breadcrumb-item">Message</b></h6>
                </div>
                <hr />
                <div class="card-body">
                    <form action="{{ route('admin.message.store') }}" method="post">
                        @csrf
                        
                        <div class="row">

                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" id="message"><b>Message
                                        </b><span style="color:red;">*</span>
                                    </label>
                                    
                                  <input name="message_text" id="message_text" class="form-control"/>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" id="status"><b>Active
                                        </b><span style="color:red;">*</span>
                                    </label>
                                    <input type="checkbox" name="status"  id="status"
                                         />
                                </div>

                            </div>
                        </div>
                        <center>
                            <input type="submit" class="btn btn-danger" value="Submit" />
                        </center>
                    </form>
                </div>
            </div>
        </div>

    </div>



    <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
    {{-- <script>
  $(document).ready(function() {
        $('#message-text').summernote();
      });

    </script> --}}
  
</section>
@endsection