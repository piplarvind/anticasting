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

    .popover-body {
        padding: 0 !important;
        color: #212529;
    }
</style>
<div class="">
    <div class="close-btn" id="close-yt">x</div>

    @isset($actor?->introVideo)
        <div class="d-flex justify-content-center">
            <iframe width="426" height="240" src="{{ $actor?->introVideo?->intro_video_link }}"
                title="YouTube video player" frameborder="2"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    @else
        <div class="d-flex justify-content-center">
            <img src="{{ asset('assets/website/images/youtube.png') }}" alt="" width="230" height="215">

        </div>
        {{-- <h6 class=" text-center text-info text-uppercase fw-light fs-5">No Available Video</h6> --}}
    @endisset
</div>
<script>
    $('#close-yt').on('click', function(e) {
        if (($('.popover').has(e.target).length != 0) || $(e.target).is('.close')) {
            $('.popover').popover('hide');
        }
    });
</script>
