<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Admin Dashboard" name="description"/>
    <meta content="{{ csrf_token() }}" name="_token">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    @yield("meta")
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="{{url('public/backend/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('public/backend/css/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('public/backend/css/owl.theme.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('public/backend/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
{{--    <link href="{{url('public/backend/css/si-icons.css')}}" rel="stylesheet" type="text/css" />--}}
    <link href="{{url('public/backend/css/animated.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('public/backend/css/main.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('public/backend/css/responsive.css')}}" rel="stylesheet" type="text/css" />
    <script>
        var javascript_site_path = "{{url('/')}}" + "/";
    </script>
</head>
<body>
<div class="body_wrapper">
    <div class="main_area top_menus">
        @include('layouts/admin-header')
        @yield("content")

    </div>
</div>
<script src="{{url('public/backend/js/jquery.js')}}"></script>
<script src="{{url('public/backend/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/backend/js/owl.carousel.min.js')}}"></script>
<script src="{{url('public/backend/js/scrollIt.min.js')}}"></script>
<script src="{{url('public/backend/js/skrollr.min.js')}}"></script>
<script src="{{url('public/backend/js/wow.js')}}"></script>
<script src="{{url('public/backend/js/device.min.js')}}"></script>
<script src="{{url('public/backend/js/custom.js')}}"></script>
@yield("jcontent")
</body>
</html>