<div class="container">
    <form method="get">
        <div class="row">
            <div class="col-md-4 col-sm-4 ms-3">
                <label class="form-label"><b>Ethnicty</b></label>
                <div class="form-group">
                    <select id="ethnicity" name="ethnicity[]" class="form-control" multiple="multiple">
                        <optgroup label="Ethnicity">
                            @if (isset($state))
                                @foreach ($state as $item)
                                    <option value="{{ $item->value }}"
                                        @if (isset(request()->ethnicity) && in_array($item->value, old('ethnicity', request()->ethnicity))) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            @endif
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 ms-3">
                <label class="form-label"><b>Gender</b></label>
                <div class="form-group">
                    <select name="gender[]" class="form-control" id="gender" multiple="multiple">
                        <optgroup label="Gender">
                            <option value='Male' @if (isset(request()->gender) && in_array('Male', old('gender', request()->gender))) selected @endif>Male</option>
                            <option value='Female' @if (isset(request()->gender) && in_array('Female', old('gender', request()->gender))) selected @endif>Female</option>
                            <option value='prefernottosay' @if (isset(request()->gender) && in_array('prefernottosay', old('gender', request()->gender))) selected @endif>Prefer not
                                to
                                say</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 me-1">
                <label class="form-label"><b>Min age</b></label>
                <div class="form-group">

                    <input type="number" name="min_age" value="{{ old('min_age', request()->min_age) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-2 col-sm-2 me-1">
                <label class="form-label"><b>Max age</b></label>
                <div class="form-group">
                    <input type="number" name="max_age" value="{{ old('max_age', request()->max_age) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2 me-1">
                <label class="form-label"><b>Min height</b></label>
                <div class="form-group pull-right">

                    <input type="number" name="min_height" value="{{ old('min_height', request()->min_height) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-2 ms-1 ">
                <label class="form-label"><b>Max height</b></label>
                <div class="form-group">
                    <input type="number" name="max_height" value="{{ old('max_height', request()->max_height) }}"
                        class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-2 mt-3">
                <input type="submit" value="Filter" class="btn btn-success"  style="margin-left:40;">
            </div>
            <div class="col-md-2 mt-3">
                <a href="{{ route('admin.actors') }}" class="btn btn-danger">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>
