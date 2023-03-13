@extends('admin.layouts.admin_master')
@section('title')
    Actor Manage Bucket
@endsection
<style>
    #contact_select {


        background: #FFF;
        color: #aaa;
    }
</style>

@section('content')
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage Bucket</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-l-0 title-margin-left">
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
        </div>
    </div>
    <section id="main-content">
        @if (Session::has('error'))
            {
            <script>
                alert("{{ Session::get('error') }}");
            </script>
            }
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title pr">
                        <h6><b class="breadcrumb-item">Create</b></h6>
                    </div>
                    <div class="card-body">
                        <hr />
                        <form action="{{ route('admin.bucket.manage.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" id="bucket"><b>Bucket name
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="bucket_name" class="form-control"
                                            value="{{ old('bucket_name') }}" placeholder="Enter bucket name" />
                                        @error('bucket_name')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><b>Movie name
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="movie_name" class="form-control"
                                            value="{{ old('movie_name') }}" placeholder="Enter movie name" />
                                        @error('movie_name')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="description"><b>Description
                                            </b>&nbsp;<span style="color:red;">*</span></label>
                                        <textarea type="text" name="description" class="form-control" id="description" placeholder="Enter movie description"></textarea>
                                        @error('description')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><b>Movie Link</label>
                                        </b><span style="color:red;">*</span>
                                        <input type="text" class="form-control" id="movie_link" name="movie_link"
                                            placeholder="Enter move link" />
                                        @error('movie_link')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><b>Active</label>
                                            </b><span style="color:red;">*</span>
                                            <input type="checkbox"  name="status"
                                                /> 
                                        </div>
                                    </div>
                               
                            </div>
                                <center>
                                    <input type="submit" class="btn btn-danger" value="Save" />
                                </center>
                        </form>
                        <hr />
                        <div class="row">
                            <div class="col-lg-6">

                            </div>
                            <div class="col-lg-6">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Initialize Quill editor -->
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Enter movie description goes here..',
                // tabsize: 2,
                height: 300,
                // followingToolbar: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                }

            })
            //.summernote("code", '{!! old('policy', isset($item->policy) ? $item->policy : '') !!}');

            // var postForm = function() {
            //     var content = $('textarea[name="policy"]').html($('#policycontent').code());
            // }
        });
    </script>
@endsection
