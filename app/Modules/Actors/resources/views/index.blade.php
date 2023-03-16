@extends('admin.layouts.admin_master')
@section('title')
    Manage Actors
@endsection
@push('style')
    <style type="text/css">
        .my-active span {
            /* background-color: #909192 !important; */
            color: #0a11f1 !important;
            border-color: #0f100f !important;
            font-weight: bold;
        }

        ul.pager>li {
            display: inline-flex;
            padding: 5px;
        }

        .popover {
            max-width: 600px !important;
            max-height:600px !important;
        }
    </style>
@endpush
@section('header')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/actors.css') }}" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="main">
        <div class="container-fluid">
            @if (Session::has('success'))
                <script>
                    alert("{{ Session::get('success') }}")
                </script>
            @endif
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage Actors</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Actors</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /# row -->
            <section id="main-content">
                @include('Actors::index-filter')
                <nav data-pagination>
                    <ul>
                        <li>
                            {{ $actors->links('Actors::pagination') }}
                        </li>
                    </ul>
                    <a href=#2><i class=ion-chevron-right></i></a>
                </nav>
                <hr />
                <div class="container">
                    <div class="row">
                        @if (isset($actors))
                            @foreach ($actors as $k => $item)
                                @if (isset($item?->profile))
                                    <div class="col-md-3 col-sm-6">
                                        <div class="product-grid4">
                                            <div class="product-image4">
                                                <a href="#">
                                                    @isset($item->images[0]->image)
                                                        <img class="pic-1 actor-img" src="{{ $item->images[0]?->image }}" />
                                                        <img class="pic-2 actor-img" src="{{ $item->images[0]?->image }}" />
                                                    @else
                                                        <img class="pic-1 actor-img"
                                                            src="https://source.unsplash.com/random/234x156/?nature" />
                                                        <img class="pic-2 actor-img"
                                                            src="https://source.unsplash.com/random/234x156/?nature" />
                                                    @endisset
                                                </a>
                                                <label class="product-discount-label check-container"
                                                    for="actor-{{ $item->id }}">
                                                    {{-- <span class="product-discount-label"> --}}
                                                    <input type="checkbox" name="actor" id="actor-{{ $item->id }}"
                                                        value="{{ $item->id }}" class="actor-item"
                                                        data-id="{{ $item->id }}"
                                                        onclick="GetBucketId({{ $item->id }})" />
                                                    {{-- </span> --}}
                                                    <span class="mark"></span>
                                                </label>
                                            </div>
                                            @php
                                                $dateOfBirth = $item?->profile?->date_of_birth;
                                                $age = \Carbon\Carbon::parse($dateOfBirth)->age;
                                            @endphp
                                            <div class="product-content">
                                                <h3 class="title text-truncate"><a
                                                        href="#">{{ $item?->first_name . ' ' . $item?->last_name }}</a>
                                                </h3>
                                                <div class="subtitle text-truncate">Mobile no : {{ $item?->mobile_no }}
                                                </div>
                                                <div class="subtitle">
                                                    <span class="text-left text-truncate"> Age : {{ $age . ' ' }}</span>
                                                    <span class="text-left text-truncate"> Height :
                                                        {{ $item?->profile?->height . ' ' . ' ' }} cm</span>
                                                    <span class="text-left text-truncate"> Weight :
                                                        {{ $item?->profile?->weight . ' ' . ' ' }}kg</span>
                                                </div>
                                                <div class="price">
                                                    <span style="cursor: pointer;" data-toggle="popover"
                                                        data-poload="{{ route('admin.actors.video', $item->id) }}">
                                                        <i class="fa fa-video-camera fa-1x" aria-hidden="true"></i>
                                                    </span>
                                                    &nbsp;&nbsp;
                                                    <span style="cursor: pointer;" data-toggle="popover"
                                                        data-poload="{{ route('admin.actors.detail', $item->id) }}">
                                                        <i class="fa-solid fa-eye fa-1x" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                {{-- <a class="add-to-cart" href="">ADD TO CART</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endisset
                            @endforeach
                        @endif
                </div>
            </div>
            <hr>
            {{-- Bucket Form --}}
            @include('Actors::bucket')
        </section>
    </div>
</div>
@endsection
@section('footer')
<script>
    $('body').on('click', function(e) {
        $('[data-toggle="popover"]').each(function() {
            if (!$(this).is(e.target) &&
                $(this).has(e.target).length === 0 &&
                $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
    // $('[data-toggle="popover"]').on('click', function(e) {
    //     $('[data-toggle="popover"]').not(this).popover('hide');
    // });
    $('*[data-poload]').click(function() {
        var e = $(this);
        // e.off('click');
        $.get(e.data('poload'), function(d) {
            e.popover({
                html: true,
                placement: "bottom",
                container: 'body',
                trigger: 'focus',
                content: d
            }).popover('show');
        });
    });
    
    // $('.actor-detail').click(function(e) {
    //     let id = e.target.parentElement.dataset.value;
    //     $.ajax({
    //         url: "{{ url('/admin/actor-detail/') }}/" + id,
    //         type: 'get',
    //         cache: false,
    //         success: function(data) {
    //             // $('#actor-data').html(data);
    //             $('#' + e.target.parentElement.id).popover({
    //                 content: data
    //             }).popover('show');
    //         }
    //     });
    // });
    /*Add a Actor Id for bucket list*/
    var array = [];

    function GetBucketId(id) {
        if (array.indexOf(id) === -1) {
            array.push(id);
            $('#bucket-form').show();
        } else {
            let index = array.indexOf(id);
            array.splice(index, 1);
        }
        document.getElementById('actor-ids').innerHTML = array.length;
        document.querySelector('#bucket-item').value = array.join(',');

        //  alert(array.join(','))
        if (array.length === 0) {
            $('#bucket-form').hide();
        }
    }
    $("#selecter2").select2({
        tags: true
    });

    // $('#close-yt').on('click', function(e) {
    //     alert("dsad")
    //     if (!$(e.target).is('.bs-popover-top') && $(e.target).closest('.popover').length == 0) {
    //         $(".bs-popover-top").popover('hide');
    //     }
    // });
   
  $(function () {
    $('#ethnicity').fSelect();
  });
  $(function () {
    $('#gender').fSelect();
  });
  
</script>
@endsection
