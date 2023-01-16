@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
    <title>Admin Dashboard</title>
@endsection

@section('content')

<section class="auth-dash-sec fullHt">
@include(config("piplmodules.back-left-view-layout-location"))
    <div class="right-auth-landing">
        <div class="all-heads">
            <h3>Dashboard</h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('admin/dashboard')}}"> <i class="fa fa-tachometer"></i> Home Page</a>
                </li>
                <li class="active">
                    All Info
                </li>
            </ol>
            <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>
        </div>
        <div class="pub-main-div">
            <div class="row">
                <div class="col-sm-4">
                    <div class="all-ourt-style">
                        <a href="javascript:void(0)" class="pul-clie-main">
                        <i class="fa fa-file ab-icons"></i>
                        <h2>Total Users</h2>
                        <h1><span>1,22,355</span></h1>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="all-ourt-style">
                        <a href="javascript:void(0)" class="pul-clie-main">
                        <i class="fa fa-check-square-o ab-icons"></i>
                        <h2>Total Admin</h2>
                        <h1><span>12,323</span></h1>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="all-ourt-style">
                        <a href="javascript:void(0)" class="pul-clie-main">
                        <i class="fa fa-code ab-icons"></i>
                        <h2>Total Subadmin</h2>
                        <h1><span>28,934</span></h1>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="all-ourt-style">
                        <a href="javascript:void(0)" class="pul-clie-main">
                        <i class="fa fa-calendar ab-icons"></i>
                        <h2>New Essay <span class="pull-right">Current Week</span></h2>
                        <h1><span data-placement="top" data-toggle="tooltip" data-original-title="Actual">115</span> / <span data-placement="top" data-toggle="tooltip" data-original-title="Target">120</span></h1>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="all-ourt-style">
                        <a href="javascript:void(0)" class="pul-clie-main">
                        <i class="fa fa-calendar ab-icons"></i>
                        <h2>All Essay <span class="pull-right">Current Month</span></h2>
                        <h1><span data-placement="top" data-toggle="tooltip" data-original-title="Actual">45</span> / <span data-placement="top" data-toggle="tooltip" data-original-title="Target">300</span></h1>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="all-ourt-style">
                        <a href="javascript:void(0)" class="pul-clie-main">
                        <i class="fa fa-calendar ab-icons"></i>
                        <h2>Donation <span class="pull-right">Current Year</span></h2>
                        <h1><span data-placement="top" data-toggle="tooltip" data-original-title="Actual">1521230</span> / <span data-placement="top" data-toggle="tooltip" data-original-title="Target">22356000</span></h1>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection