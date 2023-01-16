<header>
    <div class="top-header">
        <div class="cust-container">
            <div class="custom-nav clearfix">
                <div class="logo"><a href="{{ url('/') }}/admin"><img src="{{ asset('public/backend/img/logo.png') }}" alt="site-logo"/></a></div>
                <div class="left-user-detail">
                    <div class="media">
                        <div class="media-left"><div class="user-pros"><img class="media-object" src="{{ asset('public/backend/img/user-profile.png') }}" alt="user"/></div></div>
                        <div class="media-body">
                            <p>Welcome back, Admin</p>
                            <h4 class="media-heading">{{ auth()->user()->first_name }}</h4>
                        </div>
                    </div>
                </div>
                <div class="right-nav">
                    <ul class="clearfix">
                        <li><a target="_blank" href="{{ url('/') }}/">Back to Home</a></li>
                        <li><a class="notification" href="{{ route('admin.notifications') }}"><span class="badge">{{ isset(auth()->user()->unreadNotifications)?auth()->user()->unreadNotifications->count():0 }}</span><i class="fa fa-bell-o"></i> Notifications </a></li>
                        <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out"></i> Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-navs-opt">
        <span></span>
    </div>
</header>
