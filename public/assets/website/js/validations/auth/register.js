$(document).ready (function () {
    $('form[id="frm_register"]').validate({
        debug: false,
        errorClass: 'text-danger',
        errorElement: "span",
        rules: {
             first_name:{
              required: true,
              lettersonly:true
              
            },
            last_name:{
                required: true,
                lettersonly:true
            },
            email: {
            required: true,
            email: true,
            remote:'/validate-email',
          
          },
          mobile_no:{
            required: true,
            minlength: 10,
            //remote:'/validate-mobile'
          },
          password: {
            required: true,
            minlength: 8,
            pwcheck:true
          },
          confirm_password: {
              minlength: 8,
              equalTo: "#password"
          } 
        },
        messages: {
            first_name: {
                required:"Please enter firstname",
                alphanumeric: "Letters only please", 
            },
            last_name: {
                required:"Please enter lastname" ,
                alphanumeric: "Letters only please",
            },
            email: {
                required: "Please enter your email" ,
                email: 'Enter a valid email',
                remote:"Email already exist"
            },
            mobile_no:{

                 required: "Please enter your mobile number" ,
                // remote:"Mobile number already exist",
                 minlength:"Mobile number must be at least 10 digit long"
            },
            password: {
            minlength: 'Password must be at least 8 characters long'
          }
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        submitHandler: function(form) {
          form.submit();
        }
    });

    // password complexity
    $.validator.addMethod("pwcheck", function (value, element) {
        let password = value;
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%&])(.{8,20}$)/.test(password))) {
            return false;
        }
        return true;
    }, function (value, element) {
        let password = $(element).val();
        if (!(/^(.{8,20}$)/.test(password))) {
            return 'Password must be between 8 to 20 characters long.';
        }
        else if (!(/^(?=.*[A-Z])/.test(password))) {
            return 'Password must contain at least one uppercase.';
        }
        else if (!(/^(?=.*[a-z])/.test(password))) {
            return 'Password must contain at least one lowercase.';
        }
        else if (!(/^(?=.*[0-9])/.test(password))) {
            return 'Password must contain at least one digit.';
        }
        else if (!(/^(?=.*[@#$%&])/.test(password))) {
            return "Password must contain special characters from @#$%&.";
        }
        return false;
    });
    // First name & Last name check character
    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Only alphabetical characters");
   
});