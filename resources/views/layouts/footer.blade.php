<div class="spinnermodal" id="progressbar" style="display: none; z-index: 10001">
    <div class="progressbar-ldr">
        <img src="{{ asset('public') }}/img/loader.gif" alt="Loading..." />
    </div>
</div>
<footer>
    <div class="container">
        <div class="need-help clearfix">
            <h2 class="pull-left">Need Help? <a href="{{ url('/contact-us') }}">Visit our Help Center</a></h2>
            <div class="pull-right">
                <a href="mailto:{{ GlobalValues::get('contact_email') }}" class="btn">Email Us</a>
                <a href="tel:{{ GlobalValues::get('phone') }}" class="btn">Call Us</a>
            </div>
        </div>
        <div class="mid-footer">
            <div class="row">

                <div class="col-sm-6">
                    <h2>Explore</h2>
                    <ul class="clearfix">
                        <li><a href="{{ url('/pages/about-us') }}">About Us</a></li>
                        <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                        <li><a href="{{ url('/faq') }}">FAQs</a></li>
                        <li><a href="{{ url('/reviews') }}">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <h2>Useful Links</h2>
                    <ul class="clearfix">
                        <li><a href="{{ url('/pages/how-it-works') }}">How It Works</a></li>
                        <li><a href="{{ url('/contact-us') }}">Complaints</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bot-footer text-center">
            <p>Copyright © {{ date('Y') }} <b>{{ GlobalValues::get('site_title') }}</b></p>
        </div>
    </div>
</footer>
