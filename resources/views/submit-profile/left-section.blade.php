<style>
    .count b {
        background-color: red;
        border-radius: 50%;
        padding: 3px;

    }

    .count {
        : 120px;
    }
</style>
<div class="alert alert-success" role="alert" id="successMsg" style="display: none">
    Message success
</div>
<div class="static-list " style="">
    {{--  
       <img class="w-25 h-25 p-3"
           src="{{ asset('upload/profile/' . $user->images[0]->profile_images) }}" />
      --}}
    {{-- <img src="https://png.pngitem.com/pimgs/s/80-800194_transparent-users-icon-png-flat-user-icon-png.png" class="p-3"
        style="width: 70%; height: 70%; margin-left: 40px; border:3px solid black;" />
    <br /> --}}
    
    <div class="image-info">
        {{-- <i class="fa fa-info-circle" aria-hidden="true"></i> --}}
        <a href="#" title="Header" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Content"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
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

    {{-- <div class="controls">
		<button class="move-btn left">&larr;</button>
		<button class="move-btn right">&rarr;</button>
	</div> --}}
    <div class="form-outline">
       
   
            <span id="chat-icon" class="fas fa-comment-dots"
            style="margin-top:30px;font-size: 3.5rem; color: rgb(0, 0, 255); opacity: 1; -webkit-text-stroke-width: 2.7px;">
            </span>

        <span class="count badge badge-dark"><b>2</b></span>
        <div id="box-shadow" class="shadow-lg p-3 mt-5 bg-body rounded">

           
                <ul class="msgs">
                   <li>Message 1</li>
                   <li>Message 2</li>
                   <li>Message 3</li>
                </ul>
            
        </div>
    </div>
    <br />
    <button  id="replay"class="btn btn-primary">
     Replay
    </button>
    <div class="input-hide">
        <form action="{{ route('users.message') }}" method="POST">
            @csrf
            <input type="text" id="InputMessage" class="form-control" style="margin-top:20px;"
                placeholder="Reply message" name="reply_msg" class="form-control" />

            <button type="submit" style="margin-left:160px; margin-top:10px;" class="btn btn-success">
                <i class="fa fa-share" aria-hidden="true"></i>
                Send
            </button>
        </form>
    </div>
</div>
<br />
<div class="form-group">
    <label class="form-label" for="LocationInput">Sample Headshot Image</label>
    <div id="" class="yt-video">
        <img width="250"
            src="https://t4.ftcdn.net/jpg/02/86/91/07/360_F_286910763_zOX9bUhDQPUvk45vWOaNsGAvDf18oSod.jpg"
            border="1">

    </div>
</div>
{{-- <a href="#" data-bs-toggle="modal" data-bs-target="#upload-image-modal">open</a> --}}
@include('submit-profile.upload-image')
{{-- <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script> --}}
<script>
    $('#SubmitMessage').on('click', function(e) {
       $('.input-hide').hide();
       
    })
</script>
