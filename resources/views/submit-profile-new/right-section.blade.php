<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3 class="h6">Headshot Images</h3>
            <div class="info" style="cursor:pointer;">
                <i class="fa fa-info-circle popperOpen" data-bs-trigger="hover" data-bs-toggle="popover"></i>
            </div>
        </div>
        <div id="popover-content-head" class="d-none">
            <div class="form-group">
                {{-- <label class="form-label" for="LocationInput">Sample Headshot Image</label> --}}
                <div id="" class="yt-video">
                    <img width="200"
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
        <div class="feature">
            <figure class="featured-item image-holder r-3-2 transition"></figure>
        </div>
        <div class="gallery-wrapper">
            <div class="gallery">
                <div class="item-wrapper">
                    <figure class="gallery-item image-holder r-3-2 active transition"></figure>
                </div>
                <div class="item-wrapper">
                    <figure class="gallery-item image-holder r-3-2 transition"></figure>
                </div>
                <div class="item-wrapper">
                    <figure class="gallery-item image-holder r-3-2 transition"></figure>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3 class="h6">Introduction Video</h3>
            {{-- <div class="info" id="show-intro" style="cursor: pointer;">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
            </div> --}}
        </div>
        <div id="video-section" class="mb-2">
            <div class="radio-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="language" id="hindi" value="hindi" checked
                        onclick="stopVideo(body)" />
                    <label class="form-check-label" for="hindi">In Hindi</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="language" id="english" value="english"
                        onclick="stopVideo(body)" />
                    <label class="form-check-label" for="english">In English</label>
                </div>
            </div>
            <div class="sample-yt-video mt-2">
                <form action="{{ route('users.introvideos') }}" method="post">
                    @csrf
                    <div id="hindi_video">
                        @if (isset($userIntroVideo) && $userIntroVideo->hindi_video != null)
                            <iframe class="video" style="width:100%;" src="{{ $userIntroVideo->hindi_video }}"
                                allowfullscreen="true">
                            </iframe>
                        @else
                            <iframe class="video" width="600px;"
                                src="{{ asset('assets/website/images/youtube-thumbnail.jfif') }}"
                                allowfullscreen="true">
                            </iframe>
                        @endif
                        <div class="input-group mt-3">
                            <input type="text" name="intro_video_hindi" class="form-control"
                              placeholder="Enter Intro video"   />
                            @error('intro_video_hindi')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <input type="submit" style="background-color: #ff5b00;" class="btn btn-sm" id="btn"
                                value="Save" tabindex="75" />
                        </div>
                    </div>
                </form>
                <form action="{{ route('users.introvideos') }}" method="post">
                    @csrf
                    <div id="english_video">
                        @if (isset($userIntroVideo) && $userIntroVideo->english_video != null)
                            <iframe class="video" style="width:100%;" src="{{ $userIntroVideo->english_video }}"
                                allowfullscreen="true">
                            </iframe>
                        @else
                            <iframe class="video" width="600px;"
                                src="{{ asset('assets/website/images/youtube-thumbnail.jfif') }}"
                                allowfullscreen="true">
                            </iframe>
                        @endif
                        <div class="input-group mt-3">
                            <input type="text" name="intro_video_english" class="form-control"
                                placeholder="Enter Intro video" />
                            @error('intro_video_english')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <input type="submit" style="background-color: #ff5b00;" class="btn btn-sm" id="btn"
                                value="Save" tabindex="75" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <h3 class="h6">Sample Video</h3>
        </div>
        <iframe style="width: 100%;" src="https://www.youtube.com/embed/XEajFMrxbVw">
        </iframe>
    </div>
</div>
@include('submit-profile-new.upload-image')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    // $('#show-intro').on('click', function() {
    //     $('#video-section').slideToggle();
    // });
    $('#english_video').hide();
    $('#hindi').on('click', function() {
        $('#english_video').hide();
        $('#hindi_video').show();
    })
    $('#english').on('click', function() {
        $('#hindi_video').hide();
        $('#english_video').show();
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
    $(function() {

        $('.popperOpen').popover({
            placement: 'bottom',
            container: 'body',
            html: true,
            content: function() {
                return $(this).next('#popover-content-head').html();
            }
        })
    })
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
    /*Image Size Validation*/
    $('.pictureCls').prop("disabled", true);
    var a = 0;
    //binds to onchange event of your input field
    $('.image').bind('change', function() {
        if ($('.pictureCls').attr('disabled', false)) {
            $('.pictureCls').attr('disabled', true);
        }
        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', ]) == -1) {
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
</script>
