<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.head')
    @yield('header')
</head>

<body>

    @include('admin.includes.sidebar')
    @include('admin.includes.header')

    <div class="content-wrap">
        @yield('content')
    </div>
   
    
     <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
     <link rel="stylesheet" href="filter_multi_select.css" />
     <script src="filter-multi-select-bundle.min.js"></script>
     <script src="/path/to/cdn/jquery.slim.min.js"></script>
    
</body>

</html>
