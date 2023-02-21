// $(document).ready (function () {
   
//     $('form[id="profile-valdation"]').validate({
//         debug: false,
//         errorClass: 'text-danger',
//         errorElement: "span",
//         rules: {
//              first_name:{
//               required: true,
//               lettersonly:true
              
//             },
//             last_name:{
//                 required: true,
//                 lettersonly:true
//             },
//             email: {
//             required: true,
//             email: true,
//             },
//           mobile_no:{
//             required: true,
//             minlength: 10,
//           },
//           date_of_birth:{
//             required: true,
//           },
//           gender:{
//             required: true,
//           },
//           height:{
//             required: true,
//           },
//           weight:{
//             required: true,
//           },
//           complexions:{
//             required: true,
//           },
//           ethnicity:{
//             required: true,
//           },current_location:{
//             required: true,
//           },intro_video_link:{
//             required: true,
//           }
//         },
//         messages: {
//             first_name: {
//                 required:"Please enter firstname",
//                 alphanumeric: "Letters only please", 
//             },
//             last_name: {
//                 required:"Please enter lastname" ,
//                 alphanumeric: "Letters only please",
//             },
//             email: {
//                 required: "Please enter your email" ,
//                 email: 'Enter a valid email',
//             },
//             mobile_no:{
//                  required: "Please enter your mobile number" ,
//                  minlength:"Mobile number must be at least 10 digit long"
//             },
//             date_of_birth:{
//                 required:"Please enter your DateOfBirth" ,
//             },
//               gender:{
//                 required:"Please select your gender",
//               },
//               height:{
//                 required:"Please enter your height",
//               },
//               weight:{
//                 required:"Please enter your weight",
//               },
//               complexions:{
//                 required:"Please select your complexions",
//               },
//               ethnicity:{
//                 required:"Please select your ethnicity",
//               },
//               current_location:{
//                 required:"Please enter your current location",
//               }

//         },
//     });
// });