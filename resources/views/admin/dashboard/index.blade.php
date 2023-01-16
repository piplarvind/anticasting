@extends('layouts.admin-account-app')
@section('title')
    {{ $pageTitle = 'Dashboard' }}
@endsection
@section('content')
    @include('layouts.admin-header')
    <div class="content-body">
        <div class="main-view-content">
            <div class="right-auth-landing">
                <div class="all-heads">
                    <h3>Dashboard</h3>
                </div>
                <!--<div class="pub-main-div">
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
                </div>-->
                <div id="chart-example-3"></div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <link rel="stylesheet" href="{{ asset('public/backend/css/') }}/barchart.css">
    <script src="{{ asset('public/backend/js/') }}/barchart.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {


            /************************************************************
             *                      Example Three                        *
             ************************************************************/
            const chart3 = document.getElementById('chart-example-3');
            const data3 = [
                ['Jan', 3243],
                ['Feb', 3452],
                ['Mar', 4567],
                ['Apr', 7643],
                ['May', 3456],
                ['Jun', 7654],
                ['Jul', 9877],
                ['Aug', 1233],
                ['Sep', 3343],
                ['Oct', 5656],
                ['Nov', 5665],
                ['Dec', 0]
            ];
            const options3 = {
                width: 1000,
                height: 480,
                title: 'Current Year Monthly Payment',
                titleFontSize: 24,
                titleBG: '#FFC025',
                titleColor: 'black',
                barColors: ['#FFC025'],
                labelPos: 'middle',
                barSpacing: 0.6,
                ticks: 6,
                axisWidth: 2
            };

            createBarChart(data3, chart3, options3);
        });
    </script>
@endsection
