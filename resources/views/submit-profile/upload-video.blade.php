<div class="modal fade" id="upload-video-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.userworkreel')}}" method="POST" id="workreelpopup">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Work Reel Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p style="font-weight: bold;">Url</p>
                    <input type="text" name="work_reel1" class="form-control" id="work_reel" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="upload-video-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.userworkreel')}}" method="POST" id="workreelpopup">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Work Reel Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p style="font-weight: bold;">Url</p>
                    <input type="text" name="work_reel1" class="form-control" id="work_reel" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/website/js/jquery.validate.min.js') }}"></script>
 {{-- 
<script src="{{ asset('assets/website/js/validations/workreels.js') }}"></script>
 --}}
<script>
$(document).ready(function() {
    $("#workreelpopup").validate({
       // onclick: false, // <-- add this option
    
        debug: false,
        errorClass: 'text-danger',
        errorElement: "span",
        rules: {
            work_reel:{
                required:true,
                url: true,
            },
         },
        messages:{
            work_reel:{
                required:"Please enter valid work reel link",
                url:"Link should be url",
            },
            // errorPlacement: function (error, element) {
            //    alert(error.text());
            // }
          
        }
    });
  
});
</script>


