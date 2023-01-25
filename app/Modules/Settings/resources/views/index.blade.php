@extends('admin.layouts.admin_master')
@section('title')
    Setting
@endsection
@section('content')
<div class="main">
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

                <div class="col-lg-12 col-md-12 col-sm">
                    <div class="card">
                        <div class="card-title pr">
                            <h4>Settings List</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table bomt-10">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
@stop

