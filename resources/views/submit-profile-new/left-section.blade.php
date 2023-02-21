<div class="card mb-4">

    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3 class="h6">Headshot Images</h3>
            <div class="info"  style="cursor: pointer;">
                <a tabindex="0"  data-bs-placement="top" data-bs-toggle="popover" data-bs-content-id="popover-content" data-bs-trigger="focus" title="Headshot Image">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div id="popover-content" class="d-none">
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
            <div class="info" id="show-intro" style="cursor: pointer;">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
            </div>
        </div>
        <div id="video-section" class="mb-2" style="display: none;">
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
                <iframe id="hindi_video" class="video" style="width:100%;"
                    src="https://www.youtube.com/embed/dpu3O3LdjJs">
                </iframe>
                <iframe id="english_video" class="video" style="width:100%;"
                    src="https://www.youtube.com/embed/Tj1w86bw4EM">
                </iframe>
            </div>
        </div>
        <form action="{{route('users.introvideos')}}" method="post">
            @csrf
            <div class="video-input mb-2">
                <div class="input-group mb-3">
                    <input type="text" name="intro_video" class="form-control" placeholder="Enter intro video link" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-sm" style="background-color: #ff5b00;" type="submit">Save</button>
                  </div>
                  @error('intro_video')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                  @enderror
                
            </div>
        </form>
         <iframe style="width: 100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY">
        </iframe>
    </div>
</div>
@include('submit-profile-new.upload-image')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script>
    $('#show-intro').on('click', function() {
        $('#video-section').slideToggle();
    });
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
</script>
