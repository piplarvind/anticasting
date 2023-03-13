@extends('admin.layouts.admin_master')
@section('title')
    Manage Bucket
@endsection
@section('content')
    <div class="main">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage Bucket</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                           <a href="{{ route('admin.bucket.manage.create') }}" class="btn btn-primary">Add Bucket</a>
                        </div>
                    </div>
                </div>
               <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Bucket</li>
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
                                <h6><b class="breadcrumb-item">Bucket</b></h6>
                            </div>
                            <hr />
                            <div class="card-body">
                            <div class="table-responsive">
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Bucket</th>
                                                <th class="text-center">Movie</th>
                                                <th class="text-center">Move Link</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Action</th>
                                              
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $key=>$item)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="text-center">
                                                        
                                                            {{ $item->bucket_name }} 
                                                        </td>
                                                        <td class="text-center">{{ $item->movie_name}}</td>
                                                        <td class="text-center">
                                                            <a class="text-truncate" href="{{ $item->movie_link }}"></a>
                                                            {{ $item->movie_link }}
                                                        </td>
                                                        <td class="text-center">
                                                          {!! $item->description!!}
                                                        </td>
                                                        {{-- @if (isset($item->status) && $item->status == 1)
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
                                                        @endif --}}
                                                         <td class="text-center">
                                                            <a href="{{ route('admin.bucket.manage.edit', $item->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a href="{{ route('admin.bucket.manage.details', $item->id) }}"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.bucket.manage.delete', $item->id) }}" class="btn btn-danger btn-sm">
                                                                <i class="fa-solid fa-trash-arrow-up"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No Record</td>
                                                    </tr>
                                                @endforelse
                                       </tbody>
                                    </table>
                                 </div>
                                <div>
                                   {{ $items->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection
