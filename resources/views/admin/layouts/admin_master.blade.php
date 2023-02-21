<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.head')
</head>

<body>

    @include('admin.includes.sidebar')
    @include('admin.includes.header')

    <div class="content-wrap">
        @yield('content')
    </div>
   
    
     <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
