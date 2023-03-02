<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.head')
    @yield('header')
    @stack('style')
</head>

<body>

    @include('admin.includes.sidebar')
    @include('admin.includes.header')
   <div class="content-wrap">
        @yield('content')
    </div>
   
    {{--
     <script src="js/bootstrap.min.js"></script>
     <script src="js/bootstrap.bundle.min.js"></script>
     --}}
     <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
     <script src="{{asset('assets/admin/js/lib/bootstrap.min.js')}}"  crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script  src="{{ asset('assets/admin/js/multiselect-dropdown.js') }}"></script>
     @yield('footer')
  
   
</body>

</html>
