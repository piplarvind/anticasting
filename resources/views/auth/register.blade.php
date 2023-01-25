 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
     <meta name="description" content="" />
     <meta name="author" content="" />
     <title>Anticasting | Register</title>
     <link href="{{ asset('assets/auth/css/styles.css') }}" rel="stylesheet" />
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
     <link rel="stylesheet" href="/resources/demos/style.css">
     <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
     <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


 </head>

 <body>
      <div id="layoutAuthentication_content">
             <main>
                 <div class="container">
                     <div class="row justify-content-center">

                         <div class="col-lg-7">

                             <div class="card shadow-lg border-0 rounded-lg mt-5">
                           
                                 <div class="card-body">
                                    <h3 class="text-center font-weight-light my-4 text-danger">Create Your Account</h3>
                                     <form method="post" action="{{ route('users.registerpost') }}">
                                         @csrf
                                         <div class="row mb-3">
                                             <div class="col-md-6">
                                                 <div class="form-floating mb-3 mb-md-0">
                                                     <input class="form-control" name="first_name" id="inputFirstName"
                                                         type="text" placeholder="Enter your first name" />
                                                     <label for="inputFirstName">First name</label>
                                                     @error('first_name')
                                                         <span class="text-danger"><b>{{ $message }}</b></span>
                                                     @enderror
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-floating">
                                                     <input class="form-control" name="last_name" id="inputLastName"
                                                         type="text" placeholder="Enter your last name" />
                                                     <label for="inputLastName">Last name</label>
                                                     @error('last_name')
                                                         <span class="text-danger"><b>{{ $message }}</b></span>
                                                     @enderror
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="form-floating mb-3">
                                             <input class="form-control" id="inputEmail" name="email" type="email"
                                                 placeholder="Enter email address" />
                                             <label for="inputEmail">Email address</label>
                                             @error('email')
                                                 <span class="text-danger"><b>{{ $message }}</b></span>
                                             @enderror
                                         </div>
                                         <div class="row mb-3">

                                             <div class="col-md-12">
                                                 <div class="form-floating mb-3 mb-md-0">
                                                     <input class="form-control" name="moblie_number"
                                                         id="inputmobileNumber" type="text"
                                                         placeholder="mobile number" />
                                                     <label for="inputmobileNumber">Moblile Number</label>
                                                     @error('moblie_number')
                                                         <span class="text-danger"><b>{{ $message }}</b></span>
                                                     @enderror
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row mb-3">
                                             <div class="col-md-6">
                                                 <div class="form-floating mb-3 mb-md-0">
                                                     <input class="form-control" name="password" id="inputPassword"
                                                         type="password" placeholder="Create a password" />
                                                     <label for="inputPassword">Password</label>
                                                     @error('password')
                                                         <span class="text-danger"><b>{{ $message }}</b></span>
                                                     @enderror
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-floating mb-3 mb-md-0">
                                                     <input class="form-control" name="confirm_password"
                                                         id="inputPasswordConfirm" type="password"
                                                         placeholder="Confirm password" />
                                                     <label for="inputPasswordConfirm">Confirm Password</label>
                                                     @error('confirm_password')
                                                         <span class="text-danger"><b>{{ $message }}</b></span>
                                                     @enderror
                                                 </div>
                                             </div>

                                         </div>
                                      
                                            <div class="mt-4 mb-0">
                                             <div class="d-grid"><button type="submit"
                                             class="btn btn-danger btn-block">Register
                                            </button>
                                             </div>
                                         </div>
                                     </form>
                                      <br/>
                                     <div class="small"><a class="text-danger" href="{{ route('users.login') }}">
                                      <b>Have an account? Go to  login</b> </a>
                                    </div>
                                 </div>
                                
                                    
                              
                             </div>
                         </div>
                     </div>
                 </div>
             </main>
         </div>
      </div>
     <script>
      
     
     </script>

 </body>

 </html>
