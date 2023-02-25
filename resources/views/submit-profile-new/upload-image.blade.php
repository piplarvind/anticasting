<div class="modal fade" id="upload-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.uploadImages') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-weight: bold;">Picture </p>
                    <input type="file" name="picture" class="form-control image mb-2" id="picture" />
                    <input type="hidden" name="old_image"  class="mb-2" id="old_image" />
                     
                    <span id="error1" style="display:none; color:#FF0000;">
                        Invalid image format. Image format must be jpg, jpeg,png or gif.
                    </span>
                    <!--
                    <span id="error2"  style="display:none; color:#FF0000;">
                        File too Big, please select a file less than 4mb.
                    </span>
                      -->
                    <span id="error3"  style="display:none; color:#FF0000;">
                         Image should be more than 2 MB.
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary pictureCls" value="Save changes" />
                </div>
            </form>
        </div>
    </div>
</div>
