  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
      <img src="" alt="">
        <h1>{{ Config::get('name', 'Anti-Casting'); }}</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="{{ url('/') }}" class="active">Home</a></li>
          <li><a href="{{ url('/about')}}">About Us</a></li>
          <li><a href="services.html">Our Work</a></li>
           <li><a href="{{ url('/contact')}}">Contact</a></li>
           @auth
           <li><a class="get-a-quote" href="{{ route('users.submitProfile') }}">Submit Profile</a></li>
           <li><a class="get-a-quote" href="{{ route('users.logout') }}">Logout</a></li>
           @else
           <li><a class="get-a-quote" href="{{ route('users.login') }}">Login</a></li>
           @endauth
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <!-- End Header -->

 