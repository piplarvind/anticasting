<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Anticasting | Register</title>
    <link href="{{ asset('assets/website/css/style.css') }}" rel="stylesheet" />
    {{-- Header and footer css --}}
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}" />
    {{-- Register form page and Login form page css --}}
    <link href="{{ asset('assets/auth/css/styles.css') }}" rel="stylesheet" />{{--  --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    @yield('header')
    <script>
        var url = "{{ url('/') }}";
    </script>
</head>
<style>
    .input-group-addon {
        background-color: hsl(0, 2%, 72%);
        padding: 9px;
    }
</style>

<body>
   <div id="layoutAuthentication_content">
      
        <main>
            {{-- Header Start --}}
            @include('include.submitprofile.header')
            {{-- Header End --}}
            <div class="container">
             
                    @yield('content')

                </div>
            </main>
        </div>
    </div>
    
    {{-- <script src="{{ asset('assets/website/js/jquery-3.1.1.min.js') }}"></script> --}}
    <script src="{{ asset('assets/website/js/jquery-1.11.1.min.js') }}"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    @yield('footer')
</body>
</html>
