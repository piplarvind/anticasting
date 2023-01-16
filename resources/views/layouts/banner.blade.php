<section class="hero-banner-sec" style="background-image: url({{ asset('public') }}/img/hero-bg-1.jpg);">
    <div class="container">
        <div class="row">
            {{-- @if (session('alert-danger'))
                <div class="alert alert-danger">
                    {{ session('alert-danger') }}
                </div>
            @endif
            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif --}}
            <div class="col-sm-6">
                <div class="banner-cont">
                    <h1>Send money online for what matters most</h1>
                    <p>We make international money transfers easier than ever. Choose how and when you send,
                        with great exchange rates and low fees.</p>
                    @guest
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#login-modal">Get Started</a>
                    @else
                        <a href="{{ route('dashboard') }}">Get Started</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
