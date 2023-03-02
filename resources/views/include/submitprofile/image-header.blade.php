<div class="page-banner">
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="breadcrumbs-content mb-3">
                        <h1 class="page-title">Talent Submission Form</h1>
                    </div>

                    <ul class="breadcrumb-nav">
                        <li>
                            <span>Welcome</span>
                        </li>
                        @auth
                            <li>
                              <span>{{ auth()->user()->first_name.' '.auth()->user()->last_name }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('users.login') }}">Login</a>
                            </li>
                        @endauth
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
