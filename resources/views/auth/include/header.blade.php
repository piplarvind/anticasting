<header class="header">
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
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar justify-content-end"
                            id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ml-auto">

                                @auth
                                    <li class="nav-item">
                                        <a class="active" href="{{ route('users.submitProfile') }}">Submit Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('users.logout') }}">Logout</a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            href="#">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('users.register') }}">Register</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('users.login') }}">Login</a>
                                    </li>
                                @endauth
                                <!-- <li class="nav-item">
                  <a href="#">Pages</a>
                  <ul class="sub-menu">
                    <li>
                      <a href="about-us.html">About Us</a>
                    </li>
                    <li>
                      <a href="pricing.html">Our Pricing</a>
                    </li>
                    <li>
                      <a href="404.html">404 Error</a>
                    </li>
                    <li>
                      <a href="mail-success.html">Mail Success</a>
                    </li>
                  </ul>
                </li> -->

                            </ul>
                        </div>
                        <!-- <div class="button">
              <a href="contact.html" class="btn">Get it now</a>
            </div> -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
