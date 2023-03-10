<style>
    .close-btn {
        padding: .2rem .3rem;
        position: absolute;
        /* You may need to change top and right. They depend on padding/widht of .badge */
        top: -10px;
        right: -10px;
        background: red;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
    }
    .work-reels{
        margin-bottom:10px;
    }
</style>
<div id="popover-content">
    <div class="row">
        <div class="col-12">
            <div class="card-details">
                <div class="card-body  border">
                    <div class="btn-close text-right h4" id="close-yt">x</div>
                    <div class="collapse show pt-0">
                        @if (isset($actor))
                            @isset($actor?->profile)
                                <div class="row mt-1 mb-1">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="pt-1 ms-1">
                                            @isset($actor?->images[0]?->image)
                                                <img class="img-responsive actor-details-img"
                                                    src="{{ $actor?->images[0]?->image }}" alt=" ">
                                            @else
                                                <img class="img-responsive actor-details-img"
                                                    src="{{ asset('assets/images/actor-image-thumbnail.jpg') }}"
                                                    alt=" " />
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 ms-5" style="margin-top:9px;">
                                        <h6 class="h4 mb-2 fw-bold text-break text-truncate">
                                            <b>{{ $actor->first_name . ' ' . $actor->last_name }}</b>
                                        </h6>
                                        <p class="mb-1"><span class="fw-bold"><b>Email:</b></span><span
                                                class="c-green text-break text-truncate">{{ $actor?->profile?->email }}</span>

                                        </p>
                                        <p class="mb-1"><span class="fw-bold"><b>Ethnicity:</b></span><span
                                                class="c-green text-break text-truncate">{{ $actor?->profile?->ethnicity }}</span>

                                        </p>
                                        <p class="mb-1">
                                            <span class="fw-bold"><b>Gender:</b></span>
                                            <span
                                                class="c-green text-break text-truncate">{{ $actor?->profile?->gender }}</span>
                                        </p>
                                        <p class="mb-1">
                                            <span class="fw-bold"><b>Date Of Birth:</b></span>
                                            <span
                                                class="c-green text-break text-truncate">{{ $actor?->profile?->date_of_birth }}</span>
                                        </p>

                                        <p class="mb-1">
                                            <span class="fw-bold "><b>Current Location:</b></span>
                                            <span
                                                class="c-green text-break text-truncate">{{ $actor?->profile?->current_location }}</span>
                                        </p>
                                    </div>
                                </div>
                                <span  class="h6 fw-bold fs-2 d-flex justify-content-center"><b>Work Reels</b></span>
                                <div class="row">
                                   <div class="col-md-4 mb-5">
                                        {{-- <span  class="fw-bold fs-2 d-flex justify-content-center"><b>One</b></span> --}}
                                         @if ($actor?->profile?->work_reel1 != null)
                                            <div>
                                                <iframe width="100%"
                                                    src="{{ $actor?->profile?->work_reel1 }}" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                            @else
                                               <div  class="d-flex justify-content-center">
                                                 <img src="{{ asset('assets/website/images/youtube.png') }}"
                                                    alt=""  width="70%">
                                                </div>
                                            @endif
                                     </div>
                                    <div class="col-md-4 mb-3">
                                        {{-- <span  class="fw-bold fs-2 d-flex justify-content-center"><b>Two</b></span> --}}
                                        @if ($actor?->profile?->work_reel2 != null)
                                        <div>
                                                <iframe width="100%"
                                                    src="{{ $actor?->profile?->work_reel2 }}" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                                </div>
                                            @else
                                             <div  class=" d-flex justify-content-center">
                                                <img src="{{ asset('assets/website/images/youtube.png') }}"
                                                    alt=""  width="70%">
                                                </div>
                                            @endif
                                   
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        {{-- <span  class="fw-bold fs-2 d-flex justify-content-center"><b>Three</b></span> --}}
                                        <div>
                                           @if ($actor?->profile?->work_reel3 != null)
                                                <iframe width="100%" 
                                                    src="{{ $actor?->profile?->work_reel3 }}" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                                </div>
                                            @else
                                           <div class="d-flex justify-content-center">
                                                <img src="{{ asset('assets/website/images/youtube.png') }}"
                                                    alt="" width="70%">
                                           </div>      
                                            @endif
                                     
                                    </div>
                                </div>
                            @endisset
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">

        </div>
    </div>
</div>
<script>
    $('#close-yt').on('click', function(e) {
        if (($('.popover').has(e.target).length != 0) || $(e.target).is('.close')) {
            $('.popover').popover('hide');
        }
    });
    /*Work reels vido close btn*/ 
    
</script>
