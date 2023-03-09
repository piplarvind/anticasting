<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <!-- <img src="images/logo.png" alt="" /> --><span>Anticasting</span>
                    </a>
                </div>
                {{-- <li class="label">Main</li> --}}
                
                <li><a href="{{ route('admin.dashboard') }}"><i class="ti-home"></i> Dashboard </a></li>
                <li><a href="{{ route('admin.settings')}}"><i class="ti-settings"></i> Settings </a></li>
                {{-- <li><a href="{{ route('admin.users') }}"><i class="ti-user"></i> Users </a></li> --}}
                {{-- 
                <li><a href=""><i class="ti-list"></i> Categories </a></li>
                <li><a href=""><i class="ti-list"></i> Products </a></li>
                <li><a href=""><i class="ti-list"></i> Services </a></li>
                <li><a href=""><i class="ti-list"></i> CMS Pages </a></li>
                <li><a href=" "><i class="ti-comment"></i>Testimonials</a></li>
                  --}}
                {{-- <li class="label">Apps</li> --}}
                {{-- <li><a class="sidebar-sub-toggle"><i class="ti-user"></i> Manage Actors <span
                            class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.actors.mange') }}">List Actors</a></li>
                        <li><a href="{{ route('admin.actors') }}">Actors Profile</a></li>
                    </ul>
                </li> --}}
                {{-- <li><a href="{{ route('admin.manageuser') }}"><i class="ti-user"></i>Manage User</a></li> --}}
                <li><a href="{{ route('admin.bucket.manage') }}"><i class="ti-user"></i>Manage Bucket</a></li>
                <li><a href="{{ route('admin.actors.mange') }}"><i class="ti-user"></i>Manage Actors</a></li>
                <li><a href="{{ route('admin.actors') }}"><i class="ti-user"></i>Actors Profiles</a></li>
                {{-- <li><a href="{{ route('admin.changePassword') }}"><i class="ti-user"></i> Change Password</a></li> --}}
                <li><a href="{{ route('admin.logout') }} "><i class="ti-close"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
