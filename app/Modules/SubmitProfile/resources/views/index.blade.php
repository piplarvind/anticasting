@extends('admin.layouts.admin_master')
@section('title')
    Submit Profile
@endsection
@section('content')
    <div class="main">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Submit Profile</h1>

                        </div>

                    </div>

                </div>
               
                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Submit Profile</li>
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
                            <div class="card-title pr">
                                <h6><b class="breadcrumb-item">Actor Profile</b></h6>
                            </div>
                            <hr />
                            <div class="card-body">
                                <form method="get">
                                    <div class="row">

                                        <div class="col-md-4">

                                            <label class="label-control" for="staticName"
                                                class="col-form-label"><b>Name</b></label>
                                            <input type="text" name="q" class="form-control" id="staticName" value="{{ old('q', request()->q) }}" />


                                        </div>

                                        <div class="col-md-4">


                                            <label class="label-control" for="status"
                                                class="col-form-label"><b>Status</b></label>
                                            <select name="status" class="form-control" id="">
                                                <option value="" >--select--</option>
                                                <option value="1" {{ old('status', request()->status) == '1' ? 'selected="selected"' : '' }} >Active</option>
                                                <option value="2" {{ old('status', request()->status) == '2' ? 'selected="selected"' : '' }} >Inactive</option>
                                            </select>



                                        </div>
                                        <div class="col-md-4">
                                            <br />
                                            <input type="submit" value="Filter" class="btn btn-primary" id="filter">
                                            <a href="{{ route('admin.submitprofile') }}" class="btn btn-danger">Reset</a>

                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Mobile NO</th>
                                                <th class="text-center">Ethnicity</th>
                                                <th class="text-center">Current Location</th>
                                                <th class="text-center">Gender</th>

                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @forelse ($items as $key=>$item)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td class="text-center">
                                                       <a href="{{ route('admin.manageuserprofile',$item->user_id)}}">
                                                        {{ $item->user->name }}  </a>   
                                                    </td>
                                                    <td class="text-center">{{ $item->mobile_no }}</td>
                                                    <td class="text-center">{{ $item->ethnicity }}</td>
                                                    <td class="text-center">{{ $item->current_location }}</td>
                                                    <td class="text-center">{{ $item->gender }}</td>
                                                    @if (isset($item->status) && $item->status == 1)
                                                        <td>
                                                            <span class="badge badge-success text-center">
                                                                Active
                                                            </span>

                                                        </td>
                                                    @else
                                                        <td>
                                                            <span class="badge bg-danger text-center">
                                                                Inactive
                                                            </span>
                                                        </td>
                                                    @endif

                                                    <td class="text-center">
                                                      
                                                        <a href="{{ route('admin.submitprofile.edit',$item->id) }}" class="btn btn-success">Edit</a>
                                                        <a href="" class="btn btn-secondary">View</a>
                                                        <a href="" class="btn btn-danger">Delete</a>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center">No Record</td>
                                                </tr>
                                            @endforelse




                                        </tbody>
                                    </table>
                                    
                                </div>
                                <br/>
                                <br/>
                                <div>
                                    {{$items->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
        </div>
    </div>
@endsection
