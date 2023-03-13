<style>
    .close-btn {
        padding: .2rem .6rem;
        position: relative;
        /* You may need to change top and right. They depend on padding/widht of .badge */
        top: -10px;
        right: -10px;
        background: red;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
    }

    .delete-single-btn {
        padding: .2rem .6rem;
        position: relative;
        top: -10px;
        right: -70px;
        background: red;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        width: 20px;
        height: 20px;
    }
</style>
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3 class="h6 fw-bold">Headshot Images</h3>
            <div class="info" style="cursor:pointer;" tabindex="0" data-bs-placement="top" data-bs-toggle="popover"
                data-bs-content-id="popover-content" data-bs-trigger="focus" title="Headshot Image">
                <i class="fa fa-info-circle"></i>
            </div>
            @if (count($userInfo?->images) > 0)
                <div class="close-btn"
                    onclick="deleteAllHeadShotImages('{{ route('user.delete-all-headshots', auth()->user()->id) }}')">x
                </div>
            @endif
        </div>
        <div id="popover-content" class="d-none">
            <div class="form-group">
                {{-- <label class="form-label" for="LocationInput">Sample Headshot Image</label> --}}
                <div class="yt-video">
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

        <div class="feature" @if (count($userInfo?->images) == 0) id="upload-default" @endif>
            <figure class="featured-item r-3-2 transition main-img">
                @if (count($userInfo?->images) == 0)
                    <img src="{{ asset('assets/images/default-user.jfif') }}" alt="User"
                        title="Please select an image" style="width:100%; cursor: pointer;">
                @endif
            </figure>
        </div>
        <div class="gallery-wrapper">
            <div class="gallery">
                <div class="item-wrapper">
                    {{-- <div class="delete-single-btn">x</div> --}}
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
<div class="card mb-3">
    <div class="card-body ms-1">
        <div class="d-flex justify-content-between">
            <span class="h6 fw-bold">Choose intro video language</span>
        </div>
        <div id="video-section" class="mb-2 ms-3">
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
                    <div id="intro_hindi">
                        <iframe class="video" style="width:75%;" src="https://www.youtube.com/embed/q22JrhzFEuQ"
                            allowfullscreen="true">
                        </iframe>
                    </div>
                </div>
                <div class="sample-yt-video mt-2">
                    <div id="intro_english">
                        <iframe class="video" style="width:75%;" src="https://www.youtube.com/embed/hx1mjT73xYE"
                            allowfullscreen="true">
                        </iframe>
                    </div>
                </div>
            </div>     
        <div class="d-flex justify-content-between">
            <span class="h6 fw-bold">Sample intro video</span>
        </div>

        <div id="video-section" class="mb-2 ms-3">
            <div class="radio-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sample_video" id="hide" value="hide" checked
                        onclick="stopVideo(body)" />
                    <label class="form-check-label" for="hide">Hide</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sample_video" id="show" value="show"
                        onclick="stopVideo(body)" />
                    <label class="form-check-label" for="show">Show</label>
                </div>
            </div>
            <div class="sample-yt-video mt-2">
                <div id="intro_video">
                    <iframe class="video" style="width:75%;" src="https://www.youtube.com/embed/CTcoCHKnkT8"
                        allowfullscreen="true">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:20px;">
            <form action="{{ route('users.introvideos') }}" method="post">
                @csrf
                <div class="col-md-12 col-lg-12 col-sm-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="intro_video_link"
                            placeholder="Please enter  intro video"
                            value="{{ old('intro_video_link', isset($userIntroVideo->intro_video_link) ? $userIntroVideo->intro_video_link : '') }}" />
                        <button class="btn btn-sm" style="background-color: #ff5b00;" type="submit">Save</button>
                    </div>
                    @error('intro_video_link')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-between">
                    <span class="h6 fw-bold">Intro video show</span>
                </div>
                <div class="form-group mb-3 ms-3">
                    @if (isset($userIntroVideo) && $userIntroVideo != null)
                        <iframe style="width:75%;" src="{{ $userIntroVideo->intro_video_link }}"
                            allowfullscreen="true">
                        </iframe>
                    @else
                        <img src="{{ asset('assets/images/video-thumb.png') }}" alt="" style="width:75%;">
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@include('submit-profile-new.upload-image')
