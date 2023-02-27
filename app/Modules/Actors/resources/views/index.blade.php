@extends('admin.layouts.admin_master')
@section('title')
    Manage Actors
@endsection
@push('style')
    <style type="text/css">
        .my-active span {
            background-color: #909192 !important;
            color: white !important;
            border-color: #0f100f !important;
        }

        ul.pager>li {
            display: inline-flex;
            padding: 5px;
        }

        .popover {
            max-width: 600px;
        }
    </style>
@endpush
@section('header')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/actors.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="main">
        <div class="container-fluid">
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
                        {{-- <li><a href=#2>2</a></li>
                    <li><a href=#3>3</a></li>
                    <li><a href=#4>4</a></li>
                    <li><a href=#5>5</a></li>
                    <li><a href=#6>6</a></li>
                    <li><a href=#7>7</a></li>
                    <li><a href=#8>8</a></li>
                    <li><a href=#9>9</a></li>
                    <li><a href=#10>…</a></li>
                    <li><a href=#41>41</a></li> --}}
                    </ul>
                    <a href=#2><i class=ion-chevron-right></i></a>
                </nav>
                <div class="container">
                    <div class="row">
                        @if (isset($actors))
                            @foreach ($actors as $k => $item)
                                <div class="col-md-3 col-sm-6">
                                    <div class="product-grid4">
                                        <div class="product-image4">
                                            <a href="#">
                                                @isset($item->profileImage[0]->image)
                                                    <img class="pic-1 actor-img" src="{{ $item->profileImage[0]?->image }}" />
                                                    <img class="pic-2 actor-img" src="{{ $item->profileImage[0]?->image }}" />
                                                @else
                                                    <img class="pic-1"
                                                        src="https://source.unsplash.com/random/234x156/?nature" />
                                                    <img class="pic-2"
                                                        src="https://source.unsplash.com/random/234x156/?nature" />
                                                @endisset
                                            </a>
                                            <label class="product-discount-label check-container"
                                                for="actor-{{ $item->id }}">
                                                {{-- <span class="product-discount-label"> --}}
                                                <input type="checkbox" name="actor" id="actor-{{ $item->id }}"
                                                    value="{{ $item->id }}" />
                                                {{-- </span> --}}
                                                <span class="mark"></span>
                                            </label>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="title"><a
                                                    href="#">{{ $item?->user?->first_name . ' ' . $item?->user?->last_name }}</a>
                                            </h3>
                                            <div class="subtitle">Actor</div>
                                            <div class="subtitle">SELF-REPRESENTED</div>
                                            <div class="price">
                                                {{-- <span style="cursor: pointer;"
                                                    onclick="handleDetail('{{ $item->id }}');"
                                                    id="popover-{{ $item->id }}">
                                                    <i class="fa fa-video-camera fa-1x" aria-hidden="true"></i>
                                                </span> --}}
                                                <span style="cursor: pointer;" data-container="body"
                                                    data-bs-toggle="popover"
                                                    title="Actor Details" role="button"
                                                    data-bs-content-id="popover-content"
                                                    tabindex="0"
                                                    data-toggle="popover" 
                                                    >
                                                    
                                                    <i class="fa fa-video-camera fa-1x" aria-hidden="true"></i>
                                                </span>
                                                &nbsp;&nbsp;
                                                <span><i class="fa fa-microphone fa-1x" aria-hidden="true"></i></span>
                                            </div>
                                            {{-- <a class="add-to-cart" href="">ADD TO CART</a> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <hr>
                @include('Actors::details-page')
            </section>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script>
        // var popover = new bootstrap.Popover(document.querySelector('.popover-dismiss'), {
        //     trigger: 'focus',
        //     container: 'body'
        // })
        // function handleDetail(id) {
        //     $('#popover-' + id).popover({
        //         placement: 'bottom',
        //         container: 'body',
        //         html: true,
        //         content: function() {
        //             return $(this).next('.popper-content').html();
        //         }
        //     })
        // }
        // $(function() {
        //     $('.example-popover').popover({
        //         container: 'body'
        //     })
        // })
        const PopOverlist = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        PopOverlist.map((el) => {
            let opts = {
                animation: true,
                container: 'body',
                placement: 'bottom',
            }
            if (el.hasAttribute('data-bs-content-id')) {
                opts.content = document.getElementById(el.getAttribute('data-bs-content-id')).innerHTML;
                opts.html = true;
            }
            new bootstrap.Popover(el, opts);
        })
        $('[data-toggle=popover]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false;
            }
        });
    </script>
@endsection
