<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Anticasting | ForgotPassword</title>
        <link href="{{ asset('assets/auth/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
        <script src="{{ asset('assets/auth/toastr.min.js') }}"></script>
    </head>
    <body class="bg-primary">
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Forgot Your Password</h3></div>
                                    <div class="card-body">
                                        <form action="{{ route('users.forgotpassword-post') }}" method="post">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="Email" name="email" type="email" placeholder="Enter a email" />
                                                <label for="email">Email address</label>
                                                @error('email')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>
                                           
                                           
                                           <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                               
                                            <button type="submit" class="form-control btn btn-primary">Send Password Reset Link</button>
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
