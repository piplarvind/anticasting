<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Anticasting | ChangePassword</title>
        <link href="{{ asset('assets/auth/css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
        <script src="{{ asset('assets/auth/toastr.min.js') }}"></script>
    </head>
    <body>
        <br/>
        <br/>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <script>
                    @if(Session::has('message'))
                       toastr.success("{{ Session::get('message') }}");
                       @elseif (Session::has('error'))
                         toastr.error("{{ Session::get('error') }}");
                     @endif
                 </script>
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                  
                                        <h3 class="text-center text-danger font-weight-light my-4">Change Password</h3>
                                        <form action="{{ route('users.changepassword-post') }}" method="post">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="oldPassword" name="oldpassword" type="password" placeholder="Enter a old password" />
                                                <label for="oldPassword">Old Password</label>
                                                @error('oldpassword')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="NewPassword" name="password" type="password" placeholder="Enter new password" />
                                                <label for="NewPassword">New Password</label>
                                                @error('password')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="confirmPassword" name="confirm_password" type="password" placeholder="Enter cofiram password" />
                                                <label for="NewPassword">New ConfiramPassword</label>
                                                @error('confirm_password')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                               
                                                <button type="submit" class=" form-control btn btn-danger">Change Password</button>
                                            </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
           
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/auth/js/scripts.js') }}"></script>
    </body>
</html>
