<script src="{{ asset('public/admin-assets/vendors/modal/js/classie.js') }}"></script>
<script src="{{ asset('public/admin-assets/vendors/modal/js/modalEffects.js') }}"></script>
<script type="text/javascript">
$(document).on('click', '#set-image', function() {
    // get id and set it to hidden value
    var returned_id = $("#iframe").contents().find("#return-id").val();
    $("#main-image").val(returned_id);

    // change main image thumbnail after select image
    var returned_url = $("#iframe").contents().find("#return-url").val();
    $("#main-image-thumbnail").attr("src", returned_url);
    $('.main-img-delete').show();
});
$('.main-img-delete').click(function() {
    $('.main-img-delete').hide();
    $("#main-image").val('');
    $("#main-image-thumbnail").attr("src", $('#default_image').val());
});
</script>
<script type="text/javascript">
    $(document).on('click', '#set-gallery-images', function() {
        // get id and set it to hidden value
        var returned_json = $("#iframe-gallery").contents().find("#json-data").val();
        var gallery = document.getElementById("gallery");
        var gallery_data = JSON.parse(returned_json);
        for (var i = 0; i < gallery_data.length; i++) {
            var id = gallery_data[i].id;
            var url = gallery_data[i].url;

            gallery.innerHTML += "<div class='gallery-img'><img src='" + url + "' /><a href='#gallery' class='img-delete'>x</a><input type='hidden' name='gallery_images[]' value='" + id + "'></div>";
            // remove selected images from iframe
            $("#iframe-gallery").contents().find(".selected").removeClass("selected");
            $("#iframe-gallery").contents().find("#json-data").val('');
            $("#iframe-gallery").contents().find("#ids").empty();
        }
    });

    $(function() {
        $('#gallery').on('click', '.img-delete', function(event) {
            var commentContainer = $(this).parent();
            commentContainer.remove();
        });
        return false;
    });

    if ($('#main-image').val() != "") {
//        $.get("{{url('/')}}/{{Lang::getlocale()}}/media/"+$('#main-image').val()+"", function(data) {
//          $('#main-image-thumbnail').attr("src", data['url']);
//        });
    }

    // Old gallery images
    oldGalleryImages = '{{json_encode(old('gallery_images'))}}';
    var oldGallery = JSON.parse(oldGalleryImages.replace(/&quot;/g, '"'));
    if (oldGallery != null) {
        gallery.innerHTML = '';
        for (var i = 0; i < oldGallery.length; i++) {
            $.get("{{url('/')}}/{{Lang::getlocale()}}/media/" + oldGallery[i] + "", function(data) {
                gallery.innerHTML += "<div class='gallery-img'><img src='" + data['url'] + "' /><a href='#gallery' class='img-delete'>x</a><input type='hidden' name='gallery_images[]' value='" + data['id'] + "'></div>";
            });
        }
    }


    function trueImagePath(extension)
    {
        
        ret = 0;
        switch(extension)
        {
            
            case "jpg":break;
            case "png":break;
            case "jpeg":break;
            case "gif":break;
            case "bmp":break;
            case "JPG":break;
            case "JPEG":break;
            case "PNG":break;
            case "GIF":break;
            case "BMP":break;
            default:
                 ret = 1;    
                
        }
        if(ret)
           return -1;
       else
           return 1;
    }

    function fetchImageUrlToGallery() {
        var imgUrl = jQuery.trim(jQuery("#urlFile").val());
        var ext = imgUrl.slice((imgUrl.lastIndexOf(".")) + 1);
        if (imgUrl.length < 1 || trueImagePath(ext) == -1) {
            alert('Please enter valid URL');
            return;
        } else {
            $("#go_spin").show();
            $("#hide_spin").hide();
        }


        jQuery.ajax({
            url: "{{url('/')}}/fetch-image-url",
            type: "POST",
            data: {'url': imgUrl},
            success: function(data) {
                if (typeof data.error === 'undefined') {
                    // Success
                    $("#hide_spin").show();
                    $("#go_spin").hide();
                    jQuery("#urlFile").val("");
                    uploadedSuccess(data, 'top', true);

                } else {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                }
                // Hide progress
                $("#pipl_media_modal .progress").hide();
                $("#pipl_media_modal .progress .progress-bar").css("width", +0 + "%");
                $("#pipl_media_modal .progress .progress-bar").text('');
                $("#pipl_media_modal .progress .progress-bar").attr('aria-valuenow', 0);
            }
        });

    }
</script>