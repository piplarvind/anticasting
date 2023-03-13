@extends('admin.layouts.admin_master')
@section('title')
    Manage Actor
@endsection
@push('style')
    <style>
        .headshot_img:hover {
            color: #424242;
            -webkit-transition: all .3s ease-in;
            -moz-transition: all .3s ease-in;
            -ms-transition: all .3s ease-in;
            -o-transition: all .3s ease-in;
            transition: all .3s ease-in;
            opacity: 1;
            transform: scale(3);
            -ms-transform: scale(3);
            /* IE 9 */
            -webkit-transform: scale(3);
            /* Safari and Chrome */
        }
    </style>
@endpush
@section('content')
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage Actor</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 p-r-0 mt-3 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            @if (auth()?->user()?->user_type == 1)
                                <a class="btn btn-primary" href="{{route('admin.actors.mange.create')}}">Add Actor</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 p-l-0 title-margin-left">
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

            <!-- /# row -->
         <section id="main-content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-title pr">
                                <h6><b class="breadcrumb-item">Manage Actor</b></h6>
                            </div>
                            <hr />
                            <div class="card-body">

                                {{-- <form method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="label-control" for="staticName"
                                                class="col-form-label"><b>Name</b></label>
                                            <input type="text" name="q" class="form-control" id="staticName"
                                                value="{{ old('q', request()->q) }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label-control" for="status"
                                                class="col-form-label"><b>Status</b></label>
                                            <select name="status" class="form-control" id="">
                                                <option value="">--select--</option>
                                                <option value="1"
                                                    {{ old('status', request()->status) == '1' ? 'selected="selected"' : '' }}>
                                                    Active</option>
                                                <option value="2"
                                                    {{ old('status', request()->status) == '2' ? 'selected="selected"' : '' }}>
                                                    Inactive</option>
                                            </select>



                                        </div>
                                        <div class="col-md-4">
                                            <br />
                                            <input type="submit" value="Filter" class="btn btn-primary" id="filter">
                                            <a href="{{ route('admin.manageuser') }}" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form> --}}
                                <div class="table-responsive">
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Mobile NO</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Ethnicity</th>
                                                <th class="text-center">DateOfBirth</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-center">Image</th>
                                                {{-- <th class="text-center">Intro Hindi</th> --}}
                                                {{-- <th class="text-center">Intro English</th> --}}
                                                {{-- <th class="text-center">Work reel</th> --}}
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $key=>$item)
                                                @isset($item->profile)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="text-center">
                                                            {{ $item->first_name . ' ' . $item?->last_name }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->countryCode . ' ' . $item->mobile_no }}
                                                        </td>
                                                        <td class="text-center">{{ $item?->profile?->email }}</td>
                                                        <td class="text-center">{{ $item?->profile?->ethnicity }}</td>
                                                        <td class="text-center">{{ $item?->profile?->date_of_birth }}</td>
                                                        <td class="text-center">{{ $item?->profile?->gender }}</td>
                                                        @isset($item->images[0]->image)
                                                            <td class="text-center headshot_img">
                                                                <img src="{{ $item?->images[0]?->image }}" alt="no image"
                                                                    with="100" height="75">
                                                            </td>
                                                        @else
                                                        <td class="text-center headshot_img">
                                                            <img src="{{ asset('assets/images/default-user.jfif') }}" alt="no image"
                                                                with="100" height="75">
                                                        </td>
                                                        @endisset
                                                       
                                                        {{-- @isset($item->introVideo)
                                                            <td class="text-center">
                                                                <a href="{{ $item?->introVideo?->hindi_video }}">
                                                                {{ $item?->introVideo?->hindi_video }}</a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ $item?->introVideo?->english_video }}">
                                                                {{ $item?->introVideo?->english_video }}
                                                              </a>
                                                            </td>
                                                        @else
                                                            <td class="text-center">
                                                                NO Video
                                                            </td>
                                                        @endisset
                                                        <td class="text-center">
                                                            <a href="{{ $item?->profile?->work_reel1 }}">
                                                                {{ $item?->profile?->work_reel1 }}
                                                            </a>
                                                        </td> --}}

                                                        <td class="text-center">
                                                            <a href="{{ route('admin.actors.mange.edit', $item->id) }}"
                                                                class="btn btn-success btn-sm mb-2">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a href="{{ route('admin.actors.mange.details', $item->id) }}" class="btn btn-primary btn-sm mb-2">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.actors.mange.delete', $item->id) }}" class="btn btn-danger btn-sm mb-2">
                                                                <i class="fa-solid fa-trash-arrow-up"></i>
                                                            </a>
                                                           
                                                        </td>
                                                    </tr>
                                                @endisset
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No Record</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                    <div>
                                        {{ $items?->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
