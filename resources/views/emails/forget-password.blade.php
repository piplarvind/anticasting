<!DOCTYPE html>
<html>
<head>
    <title>Forgot password send email</title>
</head>
<body>
    <h6>{{$token}}</h6>
    <a href="{{route('users.reset-password',['token'=>$token,'email'=>$email])}}">Reset link</a>
</body>
</html>