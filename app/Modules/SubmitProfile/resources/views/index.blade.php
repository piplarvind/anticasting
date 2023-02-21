@extends('admin.layouts.admin_master')
@section('title')
    Submit Profile
@endsection
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
/* 
    tr:hover {
        background: dimgray;
        cursor: pointer;
    }

    tr.header {
        background-color: #f1f1f1;
    } */
</style>
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
            {{-- 
            <section id="main-content">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title pr">
                                <h6><b class="breadcrumb-item">Actor Profile</b></h6>
                            </div>
                            <hr />
                            <div class="card-body">
                              @include('SubmitProfile::profile-filter')
                              <div class="table-responsive">
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">FirstName</th>
                                                <th class="text-center">LastName</th>
                                                <th class="text-center">Mobile NO</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Contact</th>
                                                <th class="text-center">Ethnicity</th>
                                                <th class="text-center">Current Location</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-center">Intro Video</th>
                                                <th class="text-center">Work Reel</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            @forelse ($items as $key=>$item)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.manageuserprofile', $item->user_id) }}">
                                                            {{ $item->user->first_name }} </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.manageuserprofile', $item->user_id) }}">
                                                            {{ $item->user->last_name }}</a>
                                                    </td>

                                                    <td class="text-center">{{ $item->user->mobile_no }}</td>
                                                    <td class="text-center">{{ $item->user->email }}</td>
                                                    <td class="text-center">
                                                        <img src="{{ $item->imageprofile->image }}" alt=""
                                                            class="headshot_img" loading="lazy" border="3"
                                                            height="75" width="75" />

                                                    </td>
                                                    <td class="text-center">{{ $item->user->countryCode }}</td>
                                                    <td class="text-center">{{ $item->ethnicity }}</td>
                                                    <td class="text-center">{{ $item->current_location }}</td>
                                                    <td class="text-center">{{ $item->gender }}</td>

                                                    <td class="text-center">
                                                        <a href="{{ $item->intro_video_link }}">
                                                            {{ $item->intro_video_link }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ $item->work_reel1 }}">
                                                            {{ $item->work_reel1 }}
                                                        </a>

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
                                <br />
                                <br />
                                <div>
                                    {{ $items->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
        --}}
        <div class="row">
            @if(isset($items))
              @foreach ($items as $item)
              <div class="col-md-6">
                <div class="card support-bar overflow-hidden w-50">
                    <div class="card-body pb-0">
                        <img src="{{ $item?->profileImage?->image }}" alt="" border="3" height="200" width='217'>
    
                    </div>
                    <div class="card-footer border-0 mt-2">
                        <div class="row text-center">
                            <h6 class="text-success">
                                {{$item->user->first_name." ".$item->user->last_name}}
                            </h6>
                            <div class="col">
                            </div>
                            <div class="col">
                                <h4 class="m-0">251</h4>
                                <span>June</span>
                            </div>
                            <div class="col">
                                <div class="image-info">

                                    <a href="#" title="Sample Headshot Image" ata-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover"><i
                                        class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div id="popover-content" class="d-none">
                                    <div class="form-group">
                                        {{-- <label class="form-label" for="LocationInput">Sample Headshot Image</label> --}}
                                        <div id="" class="yt-video">
                                            <img width="250"
                                                src="https://t4.ftcdn.net/jpg/02/86/91/07/360_F_286910763_zOX9bUhDQPUvk45vWOaNsGAvDf18oSod.jpg"
                                                border="1">
                            
                                        </div>
                                        <strong class="form-label">Sample resolutions</strong>
                                        <ul>
                                            <li>width: 250px</li> 
                                            <li>height: 167px</li> 
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="support-chart1"></div>
                </div>
            </div>
              @endforeach
            @endif
           
        </div>
     
        </div>
    </div>
    <script src="{{ asset('assets/website/backend/submitprofile/js/index.js') }}"></script>
 
@endsection
