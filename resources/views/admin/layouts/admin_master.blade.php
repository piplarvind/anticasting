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
  
     <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
     <script src="{{asset('assets/admin/js/lib/bootstrap.min.js')}}"  crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script  src="{{ asset('assets/admin/js/fSelect.js') }}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    @yield('footer')
  </body>
</html>
