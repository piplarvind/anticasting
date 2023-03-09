<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3 class="h6">Headshot Images</h3>
            <div class="info" style="cursor:pointer;" tabindex="0" data-bs-placement="top" data-bs-toggle="popover"
                data-bs-content-id="popover-content" data-bs-trigger="focus" title="Headshot Image">
                <i class="fa fa-info-circle"></i>
            </div>
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
                    <img src="{{ asset('assets/images/default-user.jfif') }}" alt="User" style="width:100%">
                @endif
            </figure>
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
<div class="card mb-3">
    <div class="card-body ms-1">
        <div class="d-flex justify-content-between">
            <span class="h6 ">Sample intro video</span>
        </div>
      
        <div id="video-section" class="mb-2 ms-3">
            <div class="radio-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="language" id="hide" value="hide" checked
                        onclick="stopVideo(body)" />
                    <label class="form-check-label" for="hide">Hide</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="language" id="show" value="show"
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
        <div class="row ms-1">
            <form action="{{ route('users.introvideos') }}" method="post">
                @csrf
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="form-group mb-3">
                        <input type="text" name="intro_video_link" class="form-control w-75"
                            placeholder="Youtube video link" />
                        @error('intro_video_link')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="submit" style="background-color: #ff5b00;" class="btn btn-sm" value="Save" />
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="d-flex justify-content-between">
                    <span class="h6 ">Sample intro show</span>
                </div>
                <div class="form-group mb-3 ms-3">
                    @if(isset($userIntroVideo)  && $userIntroVideo != null )
                    <iframe class="video" style="width:75%;" src="{{$userIntroVideo->intro_video_link}}"
                        allowfullscreen="true">
                    </iframe>
                   @endif
                </div>
            </div>
        </div>
      
    </div>
   </div>
@include('submit-profile-new.upload-image')
