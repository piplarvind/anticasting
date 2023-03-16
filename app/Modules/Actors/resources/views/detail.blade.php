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

    .work-reels {
        margin-bottom: 10px;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    .image-container {
        width: 150px !important;
        height: 290px !important;
        background-color: #fff;
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 5px;
        gap: 10px;
        object-fit: contain;
    }

    .gallary-image img {
        width: 100%;
        display: block;
        box-shadow: 2px 2px 2px 1px rgb(87, 88, 88);

    }
    .gallary-image img:hover{
       
        object-fit: fill;
        opacity: 0.5;


    }
    .card-left {
        width: 180px !important;
        overflow: hidden;
    }

    .main-image {
        display: flex;
        transition: all 0.5s ease;

    }

    .img-select {
        display: flex;
        margin-top: 2px;
        height: 30px;
        width: 180px !important;

    }

    .img-select-container {

        border: 2px solid white;
    }

    .img-select-container img{
        width: 100% !important;
        display: inline-block;
       
    }
    .img-select-container img:hover{
        width: 100% !important;
        display: inline-block;
        object-fit:cover;
        opacity: 0.5;
    }
    /* .img-select-container img hover:{
        width: 100% !important;
        display: inline-block;
        border: 1px solid black;
        opacity: 0.4;

    } */
    .img-select .active{
        border: 1px dotted black;
        height: 50px !important;
        width: 60px !important;

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
                                            <div class="image-container">
                                                <div class="card-left">
                                                    <div class="main-image gallary-image border border-dark rounded-6">
                                                        @isset($actor?->images[0]?->image)
                                                            <img src="{{ $actor?->images[0]?->image }}" />
                                                        @else
                                                            <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                        @endisset
                                                        @isset($actor?->images[1]?->image)
                                                            <img src="{{ $actor?->images[1]?->image }}" />
                                                        @else
                                                            <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                        @endisset
                                                        @isset($actor?->images[2]?->image)
                                                            <img src="{{ $actor?->images[2]?->image }}" />
                                                        @else
                                                            <img src="{{ asset('assets/images/default-user.jfif') }}" />
                                                        @endisset

                                                    </div>
                                                    <div class="img-select">
                                                        <div class="img-select-container active">
                                                            <a  href="#" data-id="1">
                                                                @isset($actor?->images[0]?->image)
                                                                    <img height="50" width="60"
                                                                        src="{{ $actor?->images[0]?->image }}" />
                                                                @else
                                                                    <img height="50" width="60"
                                                                        src="{{ asset('assets/images/default-user.jfif') }}" />
                                                                @endisset
                                                            </a>
                                                        </div>
                                                        <div class="img-select-container">
                                                            <a   href="#" data-id="2">
                                                                @isset($actor?->images[1]?->image)
                                                                    <img  height="50" width="60"
                                                                        src="{{ $actor?->images[1]?->image }}" />
                                                                @else
                                                                    <img height="50" width="60"
                                                                        src="{{ asset('assets/images/default-user.jfif') }}" />
                                                                @endisset
                                                            </a>
                                                        </div>
                                                        <div class="img-select-container">
                                                            <a   href="#" data-id="3">
                                                                @isset($actor?->images[2]?->image)
                                                                    <img  height="50" width="60"
                                                                        src="{{ $actor?->images[2]?->image }}" />
                                                                @else
                                                                    <img height="50" width="60"
                                                                        src="{{ asset('assets/images/default-user.jfif') }}" />
                                                                @endisset
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                <span class="h6 fw-bold fs-2 d-flex justify-content-center"><b>Work Reels</b></span>
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        {{-- <span  class="fw-bold fs-2 d-flex justify-content-center"><b>One</b></span> --}}
                                        @if ($actor?->profile?->work_reel1 != null)
                                            <div>
                                                <iframe width="80%" src="{{ $actor?->profile?->work_reel1 }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset('assets/website/images/youtube.png') }}" alt=""
                                                    width="70%">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        {{-- <span  class="fw-bold fs-2 d-flex justify-content-center"><b>Two</b></span> --}}
                                        @if ($actor?->profile?->work_reel2 != null)
                                            <div>
                                                <iframe  width="80%" src="{{ $actor?->profile?->work_reel2 }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            </div>
                                        @else
                                            <div class=" d-flex justify-content-center">
                                                <img src="{{ asset('assets/website/images/youtube.png') }}" alt=""
                                                    width="70%">
                                            </div>
                                        @endif

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        {{-- <span  class="fw-bold fs-2 d-flex justify-content-center"><b>Three</b></span> --}}
                                        <div>
                                            @if ($actor?->profile?->work_reel3 != null)
                                                <iframe  width="80%" src="{{ $actor?->profile?->work_reel3 }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('assets/website/images/youtube.png') }}" alt=""
                                                width="70%">
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
</div>
</div>
<script>
    $('#close-yt').on('click', function(e) {
        if (($('.popover').has(e.target).length != 0) || $(e.target).is('.close')) {
            $('.popover').popover('hide');
        }
    });
    $(function() {
        const imgs = document.querySelectorAll('.img-select-container a');
        let imgId = 1;

        const imgDiv = document.querySelectorAll('.img-select-container');
        imgs.forEach((img) => {
            img.addEventListener('mousemove', (e) => {
                e.preventDefault();
                imgId = img.dataset.id;

                imgDiv.forEach((img) => {
                    img.classList.remove('active');
                });

                img.parentElement.classList.add('active');

                moveImage();
            });
        });

        function moveImage() {
            const imgWidth = document.querySelector('.main-image img:first-child').clientWidth;

            let width = (imgId - 1) * imgWidth;
            document.querySelector('.main-image').style.transform = `translateX(${-width}px)`;

        }
    })
</script>
