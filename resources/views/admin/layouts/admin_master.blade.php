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
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
     <script  src="{{ asset('assets/admin/js/multiselect-dropdown.js') }}"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     
     @yield('footer')
  
   
</body>

</html>
