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
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
     </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
     <link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
 </head>
 <style>
    
   .input-group-addon{
  background-color:hsl(0, 2%, 72%);
  padding: 9px;
}
 </style>

 <body>
     <div id="layoutAuthentication_content">
         <main>
             <div class="container">
                 <div class="row justify-content-center">

                     <div class="col-lg-7">

                         <div class="card shadow-lg border-0 rounded-lg mt-5">

                             <div class="card-body">
                                 <h3 class="text-center font-weight-light my-4 text-danger">Create Your Account</h3>
                                 <form method="post" id="frm_register" action="{{ route('users.registerpost') }}">
                                     @csrf
                                     <div class="row mb-3">
                                         <div class="col-md-6">
                                             <div class=" mb-3 mb-md-0">
                                                 <label for="inputFirstName">First name</label>
                                                 <input class="form-control" name="first_name" id="inputFirstName"
                                                     type="text" placeholder="Enter your first name" />

                                                 @error('first_name')
                                                     <span class="text-danger"><b>{{ $message }}</b></span>
                                                 @enderror
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class=" mb-3 mb-md-0">
                                                 <label for="inputLastName">Last name</label>
                                                 <input class="form-control" name="last_name" id="inputLastName"
                                                     type="text" placeholder="Enter your last name" />

                                                 @error('last_name')
                                                     <span class="text-danger"><b>{{ $message }}</b></span>
                                                 @enderror
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-md-6 col-lg-6 mb-3">
                                             <label for="email">Email address</label>
                                             <input class="form-control" id="inputEmail" name="email" type="email"
                                                 placeholder="Enter email address" />

                                             @error('email')
                                                 <span class="text-danger"><b>{{ $message }}</b></span>
                                             @enderror
                                         </div>
                                         <div class="col-md-6 col-lg-6 mb-3">
                                             <label for="inputmobileNumber">Moblile Number</label>
                                             <div class="input-group input-span mb-3">
                                                 <input type="hidden" class="" id="code" name="countryCode"
                                                     />

                                                 <input type="tel" class="form-control" id="phone"
                                                     name="mobile_no" placeholder="Mobile number" />

                                             </div>

                                         </div>
                                     </div>

                                     <div class="row mb-3">
                                         <div class="col-md-6">


                                             <div class="mb-3 mb-md-0">
                                                 <label for="inputPassword">Password</label>
                                                 <input class="form-control" name="password" id="password"
                                                     type="password" placeholder="Enter a password" />

                                                 @error('password')
                                                     <span class="text-danger"><b>{{ $message }}</b></span>
                                                 @enderror
                                             </div>


                                         </div>

                                         <div class="col-md-6">
                                            
                                             <div class="form-group">
                                                 <label>Confirm Password</label>
                                                 <div class="input-group" id="show_hide_password">
                                                    <div class="input-group-addon">
                                                        <i class="fas fa-eye-slash"
                                                                 aria-hidden="true" id="togglePassword"></i>
                                                         </div>
                                                     <input class="form-control" placeholder="Enter confirm password"
                                                         type="password"  id="confirm_password" name="confirm_password" >
                                                    
                                                 </div>
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
                                 <br />
                                 <div class="small"><a class="text-danger" href="{{ route('users.login') }}">
                                         <b>Have an account? Go to login</b> </a>
                                 </div>
                             </div>



                         </div>
                     </div>
                 </div>
             </div>
         </main>
     </div>
     </div>
   
     <script src="{{ asset('assets/website/js/jquery.validate.min.js') }}"></script>
     <script src="{{ asset('assets/website/js/validations/auth/register.js') }}"></script>
     <script>
    
         $(document).ready(function() {
             var phoneInputID = "#phone";
            
             var input = document.querySelector(phoneInputID);
            
             var iti = window.intlTelInput(input, {
                 // allowDropdown: false,
                 // autoHideDialCode: false,
                 // autoPlaceholder: "off",
                 // dropdownContainer: document.body,
                 // excludeCountries: ["us"],
                 formatOnDisplay: true,
                 // geoIpLookup: function(callback) {
                 //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                 //     var countryCode = (resp && resp.country) ? resp.country : "";
                 //     callback(countryCode);
                 //   });
                 // },
                 // hiddenInput: "full_number",
                 // initialCountry: "auto",
                 // localizedCountries: { 'de': 'Deutschland' },
                 // nationalMode: false,
                 // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                 // placeholderNumberType: "MOBILE",
                 preferredCountries: ['in', 'us'],
                 separateDialCode: true,
                 utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
             });


             $(phoneInputID).on("countrychange", function(event) {

                 // Get the selected country data to know which country is selected.
                 var selectedCountryData = iti.getSelectedCountryData();

                 // Get an example number for the selected country to use as placeholder.
                 newPlaceholder = intlTelInputUtils.getExampleNumber(selectedCountryData.iso2, true,
                         intlTelInputUtils.numberFormat.INTERNATIONAL),

                     // Reset the phone number input.
                     iti.setNumber("");

                 // Convert placeholder as exploitable mask by replacing all 1-9 numbers with 0s
                 mask = newPlaceholder.replace(/[1-9]/g, "0");

                 // Apply the new mask for the input
                 $(this).mask(mask);
                 $("#code").val(($("#phone").intlTelInput("getSelectedCountryData").dialCode));
             });


             // When the plugin loads for the first time, we have to trigger the "countrychange" event manually, 
             // but after making sure that the plugin is fully loaded by associating handler to the promise of the 
             // plugin instance.

             iti.promise.then(function() {
                 $(phoneInputID).trigger("countrychange");
             });

         });
     </script>

    
 </body>

 </html>
