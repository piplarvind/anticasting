@extends('layouts.submit-profile-new')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/website/css/image-gallery.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/website/css/alertbox.css') }}" />
    <style>
        .btn {
            color: #fff;
        }
    </style>
@endsection
@section('header')
    @include('include.submitprofile.image-header')
@endsection
@section('content')
    <section id="contact-us" class="contact-us section">

        @if (Session::has('message'))
            <div id="success" title="Success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <form id="profile-valdation" action="{{ route('users.submitProfile.store') }}" method="post">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h6 mb-4 fw-bold">Personal Information</h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <b>
                                                    First name
                                                 <span style="color:red;"><b>*</b></span>
                                                </b>
                                            </label>
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="first_name" value="{{ old('first_name', $userInfo->first_name) }}" />
                                            @error('first_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <b>
                                                    Last name
                                                 <span style="color:red;"><b>*</b></span>
                                                </b>
                                            </label>
                                            <input type="text" class="form-control" placeholder="Last Name"
                                                name="last_name" value="{{ old('last_name', $userInfo->last_name) }}" />
                                            @error('last_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label"><b>Email</b></label>
                                            <input type="email" class="form-control" placeholder="Email" name="email"
                                                readonly value="{{ old('email', $userInfo->email) }}" />

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label"><b>Phone number</b></label>
                                            <div class="input-group mb-3">
                                                <!--
                                                 <span class="input-group-text" style="width:10px;">+</span>
                                                                -->
                                                <input type="text" class="form-control" name="countryCode" readonly
                                                    style="width:15px;"
                                                    value="{{ old('countryCode', $userInfo->countryCode) }}" />
                                                <input type="text" class="form-control d-flex text-left" name="mobile_no"
                                                    readonly style="width:248px;"
                                                    value="{{ old('mobile_no', $userInfo->mobile_no) }}" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <b>
                                                 Date Of Birth
                                                 <span style="color:red;"><b>*</b></span>
                                                </b>
                                            </label>
                                            <input type="date" class="form-control" placeholder="Date of Birth"
                                                name="date_of_birth"
                                                value="{{ old('date_of_birth', isset($userProfile->date_of_birth) ? $userProfile->date_of_birth : ' ') }}" />

                                            @error('date_of_birth')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <b>
                                                    First name
                                                 <span style="color:red;"><b>*</b></span>
                                                </b>
                                            </label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="" selected="selected" class="0">
                                                    Gender
                                                </option>
                                                <option value="Male" @if (isset($userProfile->gender) && $userProfile->gender == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if (isset($userProfile->gender) && $userProfile->gender == 'Female') selected @endif>
                                                    Female</option>
                                                <option
                                                    value="prefernottosay"@if (isset($userProfile->gender) && $userProfile->gender == 'prefernottosay') selected @endif>
                                                    Prefer not to say</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label"><b>Height (CM)</b></label>
                                            <input type="text" class="form-control" placeholder="Enter height"
                                                name="height"
                                                value="{{ old('height', isset($userProfile->height) ? $userProfile->height : ' ') }}" />
                                            @error('height')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label"><b>Weight (KG)</b></label>
                                            <input type="text" class="form-control" placeholder="Enter weight"
                                                name="weight"
                                                value="{{ old('weight', isset($userProfile->weight) ? $userProfile->weight : ' ') }}" />
                                            @error('weight')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <b>
                                                    Current Location
                                                 <span style="color:red;"><b>*</b></span>
                                                </b>
                                            </label>
                                            <input type="text" class="form-control" name="current_location"
                                                placeholder="Enter current location"
                                                value="{{ old('current_location', isset($userProfile->current_location) ? $userProfile->current_location : ' ') }}" />
                                            @error('current_location')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <b>
                                                    Ethnicity
                                                 <span style="color:red;"><b>*</b></span>
                                                </b>
                                            </label>
                                            <select name="ethnicity" id="ethnicity" class="form-control">
                                                <option value="" selected="selected" class="0">
                                                    Select Ethnicity
                                                </option>
                                                @if (isset($states))
                                                    @foreach ($states as $item)
                                                        <option value="{{ $item->value }}"
                                                            @if (isset($userProfile->ethnicity) && $userProfile->ethnicity == $item->value) selected @endif>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('ethnicity')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h6 mb-4 fw-bold">Work Reels</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="work_reel1"
                                                placeholder="Work Reel 1"
                                                value="{{ old('work_reel1', isset($userProfile->work_reel1) ? $userProfile->work_reel1 : ' ') }}" />
                                            @error('work_reel1')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="work_reel2"
                                                placeholder="Work Reel 2"
                                                value="{{ old('work_reel2', isset($userProfile->work_reel2) ? $userProfile->work_reel2 : ' ') }}" />
                                            @error('work_reel2')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="work_reel3"
                                                placeholder="Work Reel 3"
                                                value="{{ old('work_reel3', isset($userProfile->work_reel3) ? $userProfile->work_reel3 : ' ') }}" />
                                            @error('work_reel3')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" style="background-color: #ff5b00; margin-bottom:10px;" class="btn btn-sm"
                            id="btn" value="Submit" tabindex="75">
                    </form>
                </div>
                <div class="col-lg-4 col-12 mb-3">
                    @include('submit-profile-new.right-section')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        var images = @json($userInfo?->images?->pluck('image')?->toArray());
    </script>
    <script src="{{ asset('assets/website/js/submit-profile/image-gallery.js') }}"></script>
    <script>
        $(function() {
            $("#success").dialog({
                autoOpen: true,
                modal: true,
                width: 350,
                height: 150,
                buttons: [
                    // {
                    //     text: 'Yes, proceed!',
                    //     open: function() {
                    //         $(this).addClass('yescls')
                    //     },
                    //     click: function() {
                    //         $(this).dialog("close")
                    //     }
                    // },
                    {
                        text: "OK",
                        open: function() {
                            $(this).addClass('okcls')
                        },
                        click: function() {
                            $(this).dialog("close")
                        }
                    }
                ],
                show: {
                    effect: "bounce",
                    duration: 1500
                },
                hide: {
                    effect: "fade",
                    duration: 1000
                },
                open: function(event, ui) {
                    $(".ui-dialog-titlebar", $(this).parent())
                        .hide();
                }
            });
        });
    </script>
    <script>
        //  $('#show-intro').on('click', function() {
        //     $('#video-section').slideToggle();
        // });
        /*Sample Intro video js*/
        $('#intro_video').hide();
        $('#hide').on('click', function() {
            $('#intro_video').hide();
        })
        $('#show').on('click', function() {
            $('#intro_video').show();
        })
        /*Choose Intro video js*/
        $('#hindi').on('click', function() {
          
            $('#intro_hindi').show();
            $('#intro_english').hide();
        })
        $('#intro_english').hide();
        $('#english').on('click', function() {
          
          $('#intro_hindi').hide();
          $('#intro_english').show();
      })
        // to stop the ifram video
        function stopVideo(element) {
            // getting every iframe from the body
            var iframes = element.querySelectorAll('iframe');
            // reinitializing the values of the src attribute of every iframe to stop the YouTube video.
            for (let i = 0; i < iframes.length; i++) {
                if (iframes[i] !== null) {
                    var temp = iframes[i].src;
                    iframes[i].src = temp;
                }
            }
        };
        // $('#first').click(function(){
        //     alert('Mahesh')
        //     $('#content').viewbox();
        // })
        // $(function() {

        //     $('.popperOpen').popover({
        //         placement: 'bottom',
        //         container: 'body',
        //         html: true,
        //         content: function() {
        //             return $(this).next('#popover-content-head').html();
        //         }
        //     })
        // });

        //Popover Sample Headshot Image
        // const Poplist = [].slice.call(document.querySelectorAll('[data-toggle="popover"]'))
        // Poplist.map((el) => {
        //     let opts = {
        //         animation: false,
        //         html:true,
        //     }
        //     if (el.hasAttribute('data-bs-content-id')) {
        //         opts.content = document.getElementById(el.getAttribute('data-bs-content-id')).innerHTML;
        //         opts.html = true;
        //     }
        //     new bootstrap.Popover(el, opts);
        // })
        //Popover Sample Image
        const list = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        list.map((el) => {
            let opts = {
                animation: false,
            }
            if (el.hasAttribute('data-bs-content-id')) {
                opts.content = document.getElementById(el.getAttribute('data-bs-content-id')).innerHTML;
                opts.html = true;
            }
            new bootstrap.Popover(el, opts);
        })
        /*Image Size Validation*/
        $('.pictureCls').prop("disabled", true);
        var a = 0;
        //binds to onchange event of your input field
        $('.image').bind('change', function() {
            if ($('.pictureCls').attr('disabled', false)) {
                $('.pictureCls').attr('disabled', true);
            }
            var ext = $('#picture').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'jfif']) == -1) {
                $('#error1').slideDown("slow");
                $('#error2').slideUp("slow");
                a = 0;
            } else {
                const fi = document.getElementById('picture');
                if (fi.files.length > 0) {
                    for (const i = 0; i <= fi.files.length - 1; i++) {

                        const fsize = fi.files.item(i).size;
                        const file = Math.round((fsize / 1024));

                        // The size of the file.
                        // if (file >= 4096) {
                        // $('#error2').slideDown("slow");
                        //   a = 0;
                        // } 
                        if (file > 2048) {
                            $('#error3').slideDown("slow");
                            a = 0;
                        } else {
                            a = 1;
                            // $('#error2').slideUp("slow");
                            $('#error3').slideUp("slow");
                        }
                        $('#error1').slideUp("slow");
                        // $('#error2').slideDown("slow");
                        //  $('#error3').slideDown("slow");
                        if (a == 1) {
                            $('.pictureCls').attr('disabled', false);
                        }
                    }
                }
                // var picsize = (this.files[0].size);
                // if (picsize >= 2048 && picsize < 4096){

                //     $('#error2').slideDown("slow");
                //     a = 0;
                // } else {

                //    a = 1;
                //     $('#error2').slideUp("slow");
                // }
                // $('#error1').slideUp("slow");
                // if (a == 1) {

                //     $('input:submit').attr('disabled', false);
                // }
            }
        });
        @if (count($userInfo?->images) == 0)
            let defaultUpload = document.querySelector('#upload-default');
            defaultUpload.addEventListener('click', () => {
                $('#upload-image-modal').modal('show');
                $('#upload-image-modal').appendTo('body');
            })
        @endif
        function deleteAllHeadShotImages(url) {
            if (confirm('Do you really want to delete all headshot images?')) {
                document.location.href = url;
            }
        }
    </script>
@endsection
