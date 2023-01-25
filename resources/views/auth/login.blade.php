<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Anticasting | Login</title>
        <link href="{{ asset('assets/auth/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/toastr.min.css') }}">
        <script src="{{ asset('assets/auth/toastr.min.js') }}"></script>
    </head>
    <body>
        <br/>
        <br/>
        <div id="layoutAuthentication">
            {{-- <img src="{{ asset('assets/website/images/anticasting-banner.png') }}" /> --}}
            <div id="layoutAuthentication_content">
             
              <script>
                 @if(Session::has('message'))
                    toastr.success("{{ Session::get('message') }}");
                    @elseif (Session::has('error'))
                      toastr.error("{{ Session::get('error') }}");
                      @elseif (Session::has('success'))
                      toastr.success("{{ Session::get('success') }}");
                  @endif
              </script>
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    
                                    <div class="card-body">
                                        <h3 class="text-center font-weight-light my-3 text-danger">Login</h3>
                                        <form action="{{ route('users.loginpost') }}" method="post">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                                @error('email')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                                @error('password')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>

                                            <div class="form-floating mb-3">
                                              
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remeber_me">
                                                        <label class="form-check-label" for="gridCheck">
                                                          Remeber Me
                                                        </label>
                                                      </div>
                                              
                                             </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                              
                                                <button type="submit" class=" form-control btn btn-danger">Contune</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">

                                        </div>
                                        <div class="col-md-4" style="margin-left:0px;">
                                            <a class="small text-danger" href="{{ route('users.forgot-password') }}"><b>Forgot Password?</b></a>
                                        </div>
                                        <div class="col-md-6" style="margin-left:35px;">
                                            <a  class="small text-danger" href="{{ route('users.register') }}"><b>Need an account? Sign up!</b></a>
                                        </div>
                                      <br/>
                                      <br/>
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
