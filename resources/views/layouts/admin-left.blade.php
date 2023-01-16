<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ url('admin/dashboard') }}">
                    <i class="fa fa-tachometer"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li
                class="{{ request()->is('admin/country/*') || request()->is('admin/paymentmethod/*') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon" href="javascript:void();" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Settings</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/settings/info') }}">Global Settings</a></li>
                    <!--<li><a class="{{ request()->is('admin/country/paymentmethod/*') ? 'mm-active' : '' }}"
                            href="{{ url('admin/paymentmethod/list') }}">Payment Method</a></li>
                    <li><a class="{{ request()->is('admin/country/send/*') ? 'mm-active' : '' }}"
                            href="{{ url('admin/country/send') }}">Send Country</a></li>
                    <li><a class="{{ request()->is('admin/country/receive/*') ? 'mm-active' : '' }}"
                            href="{{ url('admin/country/receive') }}">Receive Country</a></li>-->
                </ul>
            </li>
            <li class="{{ request()->is('admin/users/*') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-network"></i>
                    <span class="nav-text">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="{{ request()->is('admin/users/*') ? 'mm-active' : '' }}"
                            href="{{ url('admin/users') }}">Users</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('admin/contact-us') }}">Contact Us</a></li>
                    <li><a href="{{ url('admin/pages') }}">CMS Pages</a></li>
                    <li><a href="{{ url('admin/faq') }}">FAQ</a></li>
                    <li><a href="{{ url('admin/emailtemplates') }}">Email Templates</a></li>
                </ul>
            </li>
            <li
                class="{{ request()->is('admin/testimonials') || request()->is('admin/testimonials/*') ? 'mm-active' : '' }}">
                <a href="{{ url('admin/testimonials') }}"><i class="flaticon-381-networking"></i>
                    <span class="nav-text">Customer Reviews</span></a>

            </li>


            <li
                class="{{ request()->is('admin/notifications') || request()->is('admin/notifications/*') ? 'mm-active' : '' }}">
                <a href="{{ url('admin/notifications') }}"><i class="flaticon-381-networking"></i>
                    <span class="nav-text">Notifications</span></a>
            </li>

        </ul>

    </div>
</div>
