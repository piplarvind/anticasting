{{-- <header class="header">
    <div class="navbar-area shadow-sm bg-body rounded">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand logo" href="index.html">
                            <!-- <img class=logo1 src="assets/images/logo/logo.svg" alt=Logo data-pagespeed-url-hash=1728553520 onload="pagespeed.CriticalImages.checkImageForCriticality(this);" /> -->
                            <img src="https://anticasting.in/wp-content/uploads/2022/06/Anti-Casting-Logo-120x81.jpg"
                                class="logo1" alt="Anti Casting" style="height:69px;" />
                        </a>
                        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div id="navbar"class="collapse navbar-collapse sub-menu-bar justify-content-end"
                           >
                            <ul id="nav" class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/about') }}">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="services.html">Our Work</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/contact') }}">Contact</a>
                                </li>
                                  @auth
                                    <li class="nav-item">
                                        <a class="active" href="{{ route('users.submitProfile') }}">Submit Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('users.logout') }}">Logout</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('users.login') }}">Login</a>
                                    </li>
                                @endauth 
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>  --}}

<header class="header">
    <div class="navbar-area shadow-sm bg-body rounded">
        <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand logo" href="index.html">
                <!-- <img class=logo1 src="assets/images/logo/logo.svg" alt=Logo data-pagespeed-url-hash=1728553520 onload="pagespeed.CriticalImages.checkImageForCriticality(this);" /> -->
                <img src="https://anticasting.in/wp-content/uploads/2022/06/Anti-Casting-Logo-120x81.jpg"
                    class="logo1" alt="Anti Casting" style="height:69px;" />
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
            </button>
            <div id="navbar"class="collapse navbar-collapse justify-content-end">
                <ul id="nav"class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="services.html">Our Work</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/contact') }}">Contact</a>
                    </li>
                      @auth
                        <li class="nav-item">
                            <a class="active" href="{{ route('users.submitProfile') }}">Submit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('users.login') }}">Login</a>
                        </li>
                    @endauth 
                </ul>
            </div>
        </nav>
        </div>
     </div>
</header>