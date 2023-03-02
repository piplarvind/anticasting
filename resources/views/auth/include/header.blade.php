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
                        @if (URL::current() == url('/forgotpassword'))
                        @elseif(Route::is('users.reset-password'))
                        @else
                            <li class="nav-item">
                                <a href="{{ route('users.register') }}">Register</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.login') }}">Login</a>
                            </li>
                        @endif
                     @endauth
                </ul>
            </div>
         </nav>
        </div>
     </div>
</header>