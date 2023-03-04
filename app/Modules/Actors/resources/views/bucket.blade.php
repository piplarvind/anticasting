<style>
    .select2 {
        width: 60% !important;
    }
</style>
<div class="container">
    
    <div class="row">
        <div class="col-md-12 col-lg-12 ">
            <form id="bucket-form" style="display:none" action="{{ route('admin.actors.bucket.store') }}" method="post">
                <div class="row">
                    <div class="col-md-1 col-sm-1 col-lg-1 ">
                        <div class="form-group">
                            <span>
                                <i class="fa-solid fa-bucket fa-2xl mb-3"></i>
                                <span>
                                    <h4 id="actor-ids" class="fw-bold fs-3"></h4>
                                </span>
                            </span>
                            <input type="hidden" name="user_id" class="form-control-sm" id="bucket-item" />
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-lg-4">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">
                                <b>
                                    Bucket Name 
                                </b>
                            </label>
                            <select name="bucket_name" class="form-control" id="selecter2">
                                <option>Select Bucket</option>
                                <option value="actor">Actor</option>
                                <option value="artist">Artist</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-lg-1">
                        @csrf
                        <div class="form-group">
                            <label class="form-label"><b>Active</b></label>
                            <input type="checkbox" name="status">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-lg-2">
                        <button type="submit" id="bucket_list" class="btn btn-danger">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
