<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Anticasting | OTP</title>
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
            <div id="layoutAuthentication_content">
             
              <script>
                 @if(Session::has('msg'))
                    toastr.success("{{ Session::get('msg') }}");
                 
                      @elseif (Session::has('expire'))
                      toastr.info("{{ Session::get('expire') }}");
                      @elseif (Session::has('invalid'))
                      toastr.error("{{ Session::get('invalid') }}");
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
                                        <div class="border-0">
                                              <span class="lead text-muted" >
                                                OTP has been sent your email please enter. You will receive an email message and enter below.
                                              </span>
                                        </div>
                                   </div>
                                 
                               </div>
                                <div class="card shadow-lg border-0 rounded-lg mt-3">
                                  
                                    <div class="card-body">
                                        <form action="{{ route('verify.otp') }}" method="post">
                                            @csrf
                                            <div class="form mb-3">
                                                <label for="otp" class="text-muted" >OTP Number</label>
                                                <br/>
                                                <input class="form-control" id="otp" name="otp" maxlength="4" type="text" placeholder="Please enter otp" />
                                               
                                                @error('otp')
                                                  <span class="text-danger"><b>{{ $message }}</b></span>  
                                                @enderror
                                            </div>
                                           
                                           
                                            <div style="margin-left:330px;" class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                             
                                                <button type="submit" class="btn-sm btn btn-primary active">Verify Otp</button>
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
