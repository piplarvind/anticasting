 /* Image show on background */
 /*
const output = document.querySelector("output")
const input = document.querySelector("#select-image")
let imagesArray = [];

input.addEventListener("change", () => {
    const files = input.files
    for (let i = 0; i < files.length; i++) {
      imagesArray.push(files[i])
    }
    displayImages()
  });

  function displayImages() {
    let images = ""
    imagesArray.forEach((image, index) => {
      images += `<div class="image">
                  <img src="${URL.createObjectURL(image)}" alt="image">
                  <span class="delete-btn" onclick="deleteImage(${index})">&times;</span>
                </div>`
    })
    output.innerHTML = images
  }

  function deleteImage(index) {
    imagesArray.splice(index, 1)
    displayImages()
  }
*/
  /**
   * Custom JS
   */
/*
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
*/

/**
 * Mahesh logic
 */
/* Replay Message Text box */
$('.input-hide').hide();
$('#replay').on("click", function(e) {

    $('.input-hide').toggle('slow');


});

$('#box-shadow').hide();
$('#chat-icon').on("click", function(e) {

    $('#box-shadow').toggle('slow');


});
/*Intro video link*/
function stop(element) {

    var iframes = element.querySelectorAll('iframe');
    for (let i = 0; i < iframes.length; i++) {
        if (iframes[i] !== null) {
            var temp = iframes[i].src;
            iframes[i].src = temp;
        }
    }
}
$('.hide').hide();
$('.hideVideo1').on("click", function(e) {

    $('#sample_intro1').hide();


});

$('.showVideo1').on("click", function(e) {

    $('#sample_intro1').show();

});
//Reels Script
$('.reel').hide();
$('#work_reel1_img').on("click", function() {
    $('#work_reel1').toggle('slow');
});

$('#work_reel2_img').on("click", function() {

    $('#work_reel2').toggle('slow');
});
$('#work_reel3_img').on("click", function() {

    $('#work_reel3').toggle('slow');
});
/* Summer notes */
/*
ClassicEditor
	.create( document.querySelector( '#editor' ), {
		})
	.then( editor => {
		console.log( 'Editor was initialized', editor );
	} )
	.catch( err => {
		console.error( err.stack );
	} );
*/
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})