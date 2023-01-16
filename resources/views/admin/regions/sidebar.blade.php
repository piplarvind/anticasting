<div class="left-navigations">
    <ul class="clearfix">

        <li class="{{ (request()->is('admin')) ? 'active' : '' }}"><a href="{{ url('/') }}/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        @if(auth()->user()->userRole->role_id == '1')
            <li class="{{ (request()->is('admin/settings/info')) ? 'active' : '' }}"><a href="{{ route('admin.settings') }}"><i class="fas fa-cogs"></i> Global Setting</a></li>

            {{--<li class="{{ (request()->is('admin/admin-users') || request()->is('admin/admin-users/*')) ? 'active' : '' }}"><a href="{{ route('admin.users') }}"><i class="fas fa-users"></i> All Sub Admin</a></li>--}}
            <li class="{{ (request()->is('admin/users') || request()->is('admin/users/*')) ? 'active' : '' }}"><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> All Users</a></li>

            {{--<li class="{{ (request()->is('admin/roles') || request()->is('admin/roles/*')) ? 'active' : '' }}"><a href="{{ route('admin.roles') }}"><i class="fas fa-address-book"></i> All Roles</a></li>--}}

            <li class="{{ (request()->is('admin/contact-us') || request()->is('admin/contact-us/*')) ? 'active' : '' }}"><a href="{{ route('admin.contact-us') }}"><i class="fas fa-list"></i> Contact Us</a></li>
            {{--<li class="{{ (request()->is('admin/banners') || request()->is('admin/banners/*')) ? 'active' : '' }}"><a href="{{ route('admin.banners') }}"><i class="fas fa-list"></i> Banners</a></li>--}}
            <li class="{{ (request()->is('admin/emailtemplates') || request()->is('admin/emailtemplates/*')) ? 'active' : '' }}"><a href="{{ route('admin.emailtemplates') }}"><i class="fas fa-list"></i> Email Templates</a></li>
            <li class="{{ (request()->is('admin/pages') || request()->is('admin/pages/*')) ? 'active' : '' }}"><a href="{{ route('admin.pages') }}"><i class="fas fa-list"></i> CMS Pages</a></li>
            <li class="{{ (request()->is('admin/faq') || request()->is('admin/faq/*')) ? 'active' : '' }}"><a href="{{ route('admin.faq') }}"><i class="fas fa-list"></i> FAQ</a></li>

        @else
            @if(isset(auth()->user()->userRole->role->hasPermission))
                @php
                    $all_permissions = auth()->user()->userRole->role->hasPermission;
                    $arr_user_permission = [];
                    foreach ($all_permissions as $key => $value) {
                        $arr_user_permission[] = $all_permissions[$key]->getPermission->slug;
                    }
                @endphp
            @endif
            {{--{{ dd($arr_user_permission) }}--}}
            @if (in_array('users', $arr_user_permission))
                <li><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> All Users</a></li>
            @endif

            @if (in_array('contact-us', $arr_user_permission))
                <li><a href="{{ route('admin.contact-us') }}"><i class="fas fa-list"></i> Contact Us</a></li>
            @endif

            @if (in_array('pages', $arr_user_permission))
                <li><a href="{{ route('admin.pages') }}"><i class="fas fa-code"></i> CMS Pages</a></li>
            @endif
            @if (in_array('banners', $arr_user_permission))
                <li><a href="{{ route('admin.banners') }}"><i class="fas fa-code"></i> Banners</a></li>
            @endif

        @endif
        <li><a href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
    </ul>
</div>