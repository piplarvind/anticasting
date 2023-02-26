@php
    // $dateOfBirth = '1996-11-19';
    // $age = \Carbon\Carbon::parse($dateOfBirth)->age;
    // echo "You are ". $age;
    // $minimum =  \Carbon\Carbon::today()->subYears($age)->toDateString();
    // echo "Minimum age".$minimum;
    // $maximum = \Carbon\Carbon::tomorrow()->subYears($age + 1)->toDateString();
    // echo "Maximum age".$maximum;
@endphp
<div class="container">

    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-3">
            <div class="form-group">
                <label class="form-label"><b>Ethnicty</b></label>
                <select name="ethnicity[]" class="form-control-sm  w-50" id="ethnicity" multiple multiselect-search="true"
                    multiselect-select-all="true">
                    @if (isset($state))
                        @foreach ($state as $item)
                            <option value="{{ $item->value }}">{{ $item->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-3">
            <div class="form-group">
                <label class="form-label"><b>Gender</b></label>
                <select name="gender" class="form-control-sm  w-50" multiple multiselect-search="true"
                    multiselect-select-all="true">
                    <option value='male'>Male</option>
                    <option value='female'>Female</option>
                    <option value='prefernottosay'>Prefer not to say</option>
                </select>
            </div>
        </div>
    </div>
    <form  method="get">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group ">
                    <label class="form-label"><b>Max age</b></label>
                    <input type="number" name="max_age" value="{{old('max_age', request()->max_age)}}" class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group">
                    <label class="form-label"><b>Min age</b></label>
                    <input type="number" name="min_age" value="{{old('min_age', request()->min_age)}}" class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group pull-right">
                    <label class="form-label"><b>Max height</b></label>
                    <input type="number" name="max_height" value="{{old('max_height', request()->max_height)}}" class="form-control-sm w-50">
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-4">
                <div class="form-group">
                    <label class="form-label"><b>Min height</b></label>
                    <input type="number" name="min_height" value="{{old('min_height', request()->min_height)}}" class="form-control-sm w-50">
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
