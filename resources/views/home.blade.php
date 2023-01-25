<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
    <script src="{{ asset('assets/auth/toastr.min.js') }}"></script>
</head>
<body>
    <script>
        @if(Session::has('message'))
           toastr.success("{{ Session::get('message') }}");
         @endif
     </script>
    <h1>Home</h1>
   
    <a href="{{ route('users.change-password') }}">ChangePassword</a>
    <a href="{{ route('users.submitProfile') }}">SubmitProfile</a>
    <a href="{{ route('users.logout') }}">Logout</a>
</body>
</html>