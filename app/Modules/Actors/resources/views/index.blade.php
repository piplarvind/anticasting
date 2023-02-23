@extends('admin.layouts.admin_master')
@section('title')
    Manage Actors
@endsection
@section('header')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/actors.css') }}">
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
                {{-- <div class="container">
                    <select multiple name="language" id="languages">
                        <option value="js">JavaScript</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        ... more options here ...
                      </select>
                </div> --}}
              
                <nav data-pagination>
                    <a href=# disabled><i class=ion-chevron-left></i></a>
                    <ul>
                        <li class=current><a href=#1>1</a>
                        <li><a href=#2>2</a>
                        <li><a href=#3>3</a>
                        <li><a href=#4>4</a>
                        <li><a href=#5>5</a>
                        <li><a href=#6>6</a>
                        <li><a href=#7>7</a>
                        <li><a href=#8>8</a>
                        <li><a href=#9>9</a>
                        <li><a href=#10>…</a>
                        <li><a href=#41>41</a>
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
                                                @isset($item->images[0]->image)
                                                    <img class="pic-1 actor-img"
                                                        src="{{ $item->images[0]?->image }}" />
                                                    <img class="pic-2 actor-img"
                                                        src="{{ $item->images[0]?->image }}" />
                                                @else
                                                    <img class="pic-1"
                                                        src="https://source.unsplash.com/random/234x170/?nature" />
                                                    <img class="pic-2"
                                                        src="https://source.unsplash.com/random/234x170/?nature" />
                                                @endisset
                                            </a>
                                            {{-- <ul class="social">
                                                <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a>
                                                </li>
                                                <li><a href="#" data-tip="Add to Wishlist"><i
                                                            class="fa fa-shopping-bag"></i></a></li>
                                                <li><a href="#" data-tip="Add to Cart"><i
                                                            class="fa fa-shopping-cart"></i></a>
                                                </li>
                                            </ul> --}}
                                            {{-- <span class="product-new-label">New</span> --}}
                                            {{-- <span class="product-discount-label">-10%</span> --}}
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
                                                    href="#">{{ $item?->first_name . ' ' . $item?->last_name }}</a></h3>
                                            <div class="subtitle">Actor</div>
                                            <div class="subtitle">SELF-REPRESENTED</div>
                                            <div class="price">
                                                <i class="fa fa-video-camera fa-1x" aria-hidden="true"></i>
                                                &nbsp;&nbsp;
                                                <span><i class="fa fa-microphone fa-1x" aria-hidden="true"></i></span>
                                            </div>
                                            {{-- <a class="add-to-cart" href="">ADD TO CART</a> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- <div class="col-md-3 col-sm-6">
                            <div class="product-grid4">
                                <div class="product-image4">
                                    <a href="#">
                                        <img class="pic-1" src="https://www.bootdey.com/image/280x300/20B2AA/000000">
                                        <img class="pic-2" src="https://www.bootdey.com/image/280x300/FFB6C1/000000">
                                    </a>
                                    <ul class="social">
                                        <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#" data-tip="Add to Wishlist"><i
                                                    class="fa fa-shopping-bag"></i></a></li>
                                        <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                        </li>
                                    </ul>
                                    <span class="product-new-label">New</span>
                                    <span class="product-discount-label">-10%</span>
                                </div>
                                <div class="product-content">
                                    <h3 class="title"><a href="#">Women's Black Top</a></h3>
                                    <div class="price">
                                        $14.40
                                        <span>$16.00</span>
                                    </div>
                                    <a class="add-to-cart" href="">ADD TO CART</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="product-grid4">
                                <div class="product-image4">
                                    <a href="#">
                                        <img class="pic-1" src="https://www.bootdey.com/image/280x300/B0C4DE/000000">
                                        <img class="pic-2" src="https://www.bootdey.com/image/280x300/FFB6C1/000000">
                                    </a>
                                    <ul class="social">
                                        <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#" data-tip="Add to Wishlist"><i
                                                    class="fa fa-shopping-bag"></i></a></li>
                                        <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                        </li>
                                    </ul>
                                    <span class="product-discount-label">-12%</span>
                                </div>
                                <div class="product-content">
                                    <h3 class="title"><a href="#">Men's Blue Shirt</a></h3>
                                    <div class="price">
                                        $17.60
                                        <span>$20.00</span>
                                    </div>
                                    <a class="add-to-cart" href="">ADD TO CART</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="product-grid4">
                                <div class="product-image4">
                                    <a href="#">
                                        <img class="pic-1" src="https://www.bootdey.com/image/280x300/7B68EE/000000">
                                        <img class="pic-2" src="https://www.bootdey.com/image/280x300/FFB6C1/000000">
                                    </a>
                                    <ul class="social">
                                        <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#" data-tip="Add to Wishlist"><i
                                                    class="fa fa-shopping-bag"></i></a></li>
                                        <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                        </li>
                                    </ul>
                                    <span class="product-new-label">New</span>
                                    <span class="product-discount-label">-10%</span>
                                </div>
                                <div class="product-content">
                                    <h3 class="title"><a href="#">Women's Black Top</a></h3>
                                    <div class="price">
                                        $14.40
                                        <span>$16.00</span>
                                    </div>
                                    <a class="add-to-cart" href="">ADD TO CART</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="product-grid4">
                                <div class="product-image4">
                                    <a href="#">
                                        <img class="pic-1" src="https://www.bootdey.com/image/280x300/48D1CC/000000">
                                        <img class="pic-2" src="https://www.bootdey.com/image/280x300/FFB6C1/000000">
                                    </a>
                                    <ul class="social">
                                        <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="#" data-tip="Add to Wishlist"><i
                                                    class="fa fa-shopping-bag"></i></a></li>
                                        <li><a href="#" data-tip="Add to Cart"><i
                                                    class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                    <span class="product-new-label">New</span>
                                    <span class="product-discount-label">-10%</span>
                                </div>
                                <div class="product-content">
                                    <h3 class="title"><a href="#">Women's Black Top</a></h3>
                                    <div class="price">
                                        $14.40
                                        <span>$16.00</span>
                                    </div>
                                    <a class="add-to-cart" href="">ADD TO CART</a>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
                <hr>
            </section>
        </div>
    </div>
    <script>
    const languages = $('#languages').filterMultiSelect();

    </script>
@endsection
