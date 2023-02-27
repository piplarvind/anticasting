<div class="container">
    <form method="get">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-3">
                <div class="form-group">
                    <label class="form-label"><b>Ethnicty</b></label>
                    <select name="ethnicity[]" class="form-control-sm  w-50" id="ethnicity" multiple
                        multiselect-search="true">
                        @if (isset($state))
                            @foreach ($state as $item)
                                <option value="{{ $item->value }}" @if (isset(request()->ethnicity) && in_array($item->value, old('ethnicity', request()->ethnicity))) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-3">
                <div class="form-group">
                    <label class="form-label"><b>Gender</b></label>
                    <select name="gender[]" class="form-control-sm  w-50" multiple multiselect-search="true">
                        <option value='Male' @if (isset(request()->gender) && in_array('Male', old('gender', request()->gender))) selected @endif>Male</option>
                        <option value='Female' @if (isset(request()->gender) && in_array('Female', old('gender', request()->gender))) selected @endif>Female</option>
                        <option value='prefernottosay' @if (isset(request()->gender) && in_array('prefernottosay', old('gender', request()->gender))) selected @endif>Prefer not to
                            say</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group ">
                    <label class="form-label"><b>Min age</b></label>
                    <input type="number" name="min_age" value="{{ old('min_age', request()->min_age) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group">
                    <label class="form-label"><b>Max age</b></label>
                    <input type="number" name="max_age" value="{{ old('max_age', request()->max_age) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group pull-right">
                    <label class="form-label"><b>Min height</b></label>
                    <input type="number" name="min_height" value="{{ old('min_height', request()->min_height) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group">
                    <label class="form-label"><b>Max height</b></label>
                    <input type="number" name="max_height" value="{{ old('max_height', request()->max_height) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="">
                <input type="submit" value="Filter" class="btn btn-success">
            </div>
            <div class="" style="margin-left:12px;">
                <a href="{{ route('admin.actors') }}" class="btn btn-danger">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>
