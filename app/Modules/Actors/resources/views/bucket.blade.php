<style>
    .select2 {
        width: 60% !important;
    }
</style>
<div class="container">
    <form id="bucket-form" style="display: none;" action="">
        <div class="row">
            <div class="col-md-1 col-sm-1 col-lg-1 ">
                <div class="form-group">
                    <span>
                        <i class="fa-solid fa-bucket fa-2xl mb-3"></i>
                        <span>
                            <h4 id="actor-ids" class="fw-bold fs-3"></h4>
                        </span>
                    </span>
                    <input type="hidden" name="bucket_id" class="form-control-sm" id="bucket-item" />
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-4">
                <div class="form-group">
                    <label class="form-label"><b>Bucket Name</b></label>
                    <select class="form-control" id="selecter2">
                        <option selected="selected">Hero</option>
                        <option>Actor</option>
                        <option>Artist</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-lg-3">
              <button type="submit" class="btn btn-danger">Save</button>
            </div>
        </div>
    </form>
</div>
