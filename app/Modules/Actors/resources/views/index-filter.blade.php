<style>
    .ui-slider-handle {
        outline: 0;
        background: rgb(241, 239, 241);
        border-radius: 50%;

    }

    .ui-slider {
        width: 160px;
    }

    /*age card css*/
    .filter-age-show {
        background-color: #42404024;
        width: 215px !important;
        height: 30px !important;
        border-radius: 30px;
    }

    .filter-age-show label {
        padding: 5px;
        padding-left: 15px;
    }

    .filter-age-show .close-filter-btn {
        padding-left: 20px;
        font-size: 18px;
        position: relative;
    }

    /*gender card css*/
    .filter-gender-show {
        background-color: #42404024;
        width: 300px !important;
        height: 30px !important;
        border-radius: 30px;
        margin-top: 10px;
    }

    .filter-gender-show label {
        padding: 5px;
        padding-left: 15px;
    }

    .filter-gender-show .close-filter-btn {
        padding-left: 20px;
        font-size: 18px;

    }
</style>
<div class="container">
    <form method="get">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex">
                    <div style="margin-right:20px;">
                        <label class="form-label"><b>Gender</b></label>
                        <div class="form-group">
                            <select name="gender[]" class="form-control gender" multiple="multiple">
                                <optgroup label="Gender">
                                    <option value='Male' @if (isset(request()->gender) && in_array('Male', old('gender', request()->gender))) selected @endif>Male
                                    </option>
                                    <option value='Female' @if (isset(request()->gender) && in_array('Female', old('gender', request()->gender))) selected @endif>Female
                                    </option>
                                    <option value='prefernottosay' @if (isset(request()->gender) && in_array('prefernottosay', old('gender', request()->gender))) selected @endif>
                                        Prefer not
                                        to
                                        say</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div style="margin-right:20px;">
                        <label class="form-label"><b>Ethnicty</b></label>
                        <div class="form-group">
                            <select id="ethnicity" name="ethnicity[]" class="form-control pe-1" multiple="multiple">
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
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between">
                    <div style="margin-left:100px;">
                        <input type="hidden" name="max_age" id="max_age"
                            value="{{ old('max_age', request()->max_age) }}" />
                        <input type="hidden" name="min_age" id="min_age"
                            value="{{ old('min_age', request()->min_age) }}" />
                        <label class="form-label" for=""><b>Age:</b></label>
                        <span class="age"></span>
                        <span>years old</span>
                        <div id="slider-range"></div>

                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <div style="margin-left:20px;">
                <input type="submit" value="Filter" class="btn btn-success" style="margin-left:40;">
            </div>
            <div style="margin-left:20px;">
                <a href="{{ route('admin.actors') }}" class="btn btn-danger">
                    Reset
                </a>
            </div>
        </div>
        <br />
        <div id="selected-filters" class="d-flex">
            @if (request()->has('min_age') && request()->has('max_age'))
                <div class="filters-selected">
                    <label class="form-label" for=""><b>Age:</b></label>
                    <span class="">
                        {{ request()->min_age }} - {{ request()->max_age }}
                    </span>
                    <span>Yr</span>
                    <span class="close-filter-btn">X</span>
                </div>
            @endif
            @if (isset(request()->gender) && request()->gender != '')
                @foreach (request()->gender as $gender)
                    <div class="filters-selected">
                        <label class="form-label" for=""><b>Gender:</b></label>
                        <span class="">
                            {{$gender}}
                        </span>
                        <span class="close-filter-btn">X</span>
                    </div>
                @endforeach
            @endif
            @if (isset(request()->ethnicity) && request()->ethnicity != '')
                @foreach (request()->ethnicity as $ethnicity)
                    <div class="filters-selected">
                        <label class="form-label" for=""><b>Location:</b></label>
                        <span class="">
                            {{$ethnicity}}
                        </span>
                        <span class="close-filter-btn">X</span>
                    </div>
                @endforeach
            @endif
        </div>
        {{-- <div class="filter-age-show">
            <label class="form-label" for=""><b>Age : </b></label>
            <span class="age"></span>
            <span>years old</span>
            <span class="close-filter-btn">X</span>
        </div>
        <div class="filter-gender-show">
            <label class="form-label" for=""><b>Gender : </b></label>
            <span class="gender-value-text text-truncate"></span>
            <span class="close-filter-btn">X</span>
        </div>
        <div class="filter-ethnicity-show">
            <label class="form-label" for=""><b>Ethnicity : </b></label>
            <span class="ethnicity-value-text"></span>
            <span class="close-filter-btn">X</span>
        </div> --}}
    </form>
</div>
{{-- <div class="row">
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

</div> --}}
