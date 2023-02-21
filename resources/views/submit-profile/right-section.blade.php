<style>
iframe {
    height: 40px;
    min-height : 40px;
}
</style>
<div class="image-info">
    {{-- <i class="fa fa-info-circle" aria-hidden="true"></i> --}}
    {{-- <a href="#" title="Header" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Content"><i
            class="fa fa-info-circle" aria-hidden="true"></i>
    </a> --}}
    <a href="#" title="Sample Video" id="sampleVideo">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
    </a>
</div>
@include('submit-profile.sample-video')
<div class="row">
    <h6>Work Reel Video</h6>
    @if (isset($userProfile->work_reel1))
        <div id="" class="yt-video col-md-4">
            <button  id="work_reel1" style="margin-bottom:5px;" class="popup btn-sm btn btn-outline-primary " data-src="{{ $userProfile->work_reel1 }}">change video</button> 
            <iframe  style="width:100px; height:100px; float:inital;" type="video/mp4"
            src="{{ $userProfile->work_reel1 }}?&autoplay=1"frameborder="0" allowfullscreen>
          </iframe>
          
         </div>
    @else
        <img src="https://pbs.twimg.com/media/Ey81vfsXIAAQZNZ.jpg" style="max-width:50%;height:50%;" class="popup"
            alt="" id="work_reel1" />
    @endif
   @if (isset($userProfile->work_reel2))
        <div id="" class="yt-video col-md-4">
            <button id="work_reel2"  style="margin-bottom:5px;" class="popup btn-sm btn btn-outline-primary" data-src="{{ $userProfile->work_reel2 }}">change video</button> 
            <iframe id=""  style="width:100px; height:100px;  float:inital;" type="video/mp4"
                src="{{ $userProfile->work_reel2 }}"frameborder="0" allowfullscreen>
            </iframe>
        </div>
    @else
        <img src="https://pbs.twimg.com/media/Ey81vfsXIAAQZNZ.jpg" style="max-width:50%;height:50%;" class="popup"
            alt="" id="work_reel2" />
    @endif
    @if (isset($userProfile->work_reel3))
        <div id=""  class="yt-video col-md-4">
            <button  id="work_reel3" style="margin-bottom:5px;" class="popup btn-sm btn btn-outline-primary" data-src="{{ $userProfile->work_reel3 }}">change video</button> 
            <iframe id="" style="width:100px; height:100px; float:inital;" type="video/mp4"
                src="{{ $userProfile->work_reel3 }}" frameborder="0" allowfullscreen>
            </iframe>
        </div>
    @else
        <img src="https://pbs.twimg.com/media/Ey81vfsXIAAQZNZ.jpg" style="max-width:50%;height:50%;" class="popup"
            alt="" id="work_reel3" />
    @endif
    <br />
    @include('submit-profile.upload-video')
   
</div>  
