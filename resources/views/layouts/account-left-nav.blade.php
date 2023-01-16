<div class="col-md-4">
    <div class="account-options">
        <ul>
            <h3>Settings</h3>
            <li class="{{ request()->is('edit-profile') ? 'active' : '' }}">
                <a href="{{ route('edit-profile') }}">Profile Information</a>
            </li>
            {{-- <li class="{{ request()->is('notifications') ? 'active' : '' }}"><a href="{{ route('notifications') }}">Notifications</a></li> --}}

            <li><a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <!--<i class="fas fa-sign-out-alt"></i>--> Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
