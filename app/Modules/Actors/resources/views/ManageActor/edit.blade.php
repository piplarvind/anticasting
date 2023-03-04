@extends('admin.layouts.admin_master')
@section('title')
    Actor Manage Actor
@endsection
<style>
    #contact_select {


        background: #FFF;
        color: #aaa;
    }
</style>

@section('content')
    <div class="main">
    
        <div class="container-fluid">
            @if(Session::has('error')){
              <script>
                  alert("{{Session::get('error')}}");
              </script>
            }
            @endif
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Manage Actor</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Actor</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title pr">
                        <h6><b class="breadcrumb-item">Update</b></h6>
                    </div>
                    <div class="card-body">
                        <hr />
                        <form action="{{ route('admin.actors.mange.update', [$items->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" id="contact"><b>First name
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ old('first_name', $items->first_name) }}"
                                            placeholder="Enter firstname" />
                                        @error('first_name')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><b>Last name
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ old('last_name', $items->last_name) }}" placeholder="Enter lastname" />
                                        @error('last_name')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" id="contact"><b>Mobile No</label>
                                        </b><span style="color:red;">*</span>

                                        <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                                            placeholder="Mobile number" value="{{ $items->mobile_no }}" />
                                        <input type="hidden" name="iso2" id="phone_country_code" value="+91" />
                                        @error('mobile_number')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email"><b>Email-ID
                                            </b>&nbsp;<span style="color:red;">*</span></label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter email" value="{{ old('email', $items->email) }}">
                                        @error('email')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="gender"><b>Ethnicity
                                            </b>&nbsp;<span style="color:red;">*</span></label>
                                        <select name="ethnicity" id="ethnicity" class="form-control">
                                            <option value="" selected="selected" class="0">
                                                Select Ethnicity
                                                @isset($state)
                                                    @foreach ($state as $item)
                                                <option value="{{ $item->value }}"
                                                    @if (isset($items?->profile?->ethnicity) && $items?->profile?->ethnicity == $item->value) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                                @endforeach
                                            @endisset
                                            </option>
                                        </select>
                                        @error('ethnicity')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="gender"><b>Gender
                                            </b>&nbsp;<span style="color:red;">*</span></label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="" selected="selected" class="0">
                                                Select Gender
                                            </option>
                                            <option value="Male" @if (isset($items?->profile?->gender) && $items?->profile?->gender == 'Male') selected @endif>
                                                Male</option>
                                            <option value="Female" @if (isset($items?->profile?->gender) && $items?->profile?->gender == 'Female') selected @endif>
                                                Female</option>
                                            <option value="prefernottosay"
                                                @if (isset($items?->profile?->gender) && $items?->profile?->gender == 'prefernottosay') selected @endif>
                                                Prefer not to say
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date_of_birth"><b>Date Of Birth</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="date" name="date_of_birth" class="form-control"
                                            id="date_of_birth"
                                            value="{{ old('date_of_birth', $items?->profile?->date_of_birth) }}">
                                        @error('date_of_birth')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="current_location"><b>Current
                                                Location</b>&nbsp;<span style="color:red;">*
                                            </span></label>
                                        <input type="text" name="current_location" class="form-control"
                                            id="current_location"
                                            value="{{ old('current_location', $items?->profile?->current_location) }}"
                                            placeholder="Enter current location">
                                        @error('current_location')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="height"><b>Height (CM)</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="text" name="height" class="form-control" id="height"
                                            value="{{ old('height', $items?->profile?->height) }}"
                                            placeholder="Enter height">
                                        @error('height')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="weight"><b>Weight (KG)</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="text" name="weight" class="form-control" id="weight"
                                            value="{{ old('weight', $items?->profile?->weight) }}"
                                            placeholder="Enter weight">
                                        @error('weight')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="images"><b>Image </b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="file" name="images[]"  multiple class="form-control" 
                                            >
                                            @error('images')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                           @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status"><b>Active</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="checkbox" name="status" value="1" id="status"
                                            @if ($items->status == 1) checked @endif />

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div>
                                        @isset($items?->images[0]?->image)
                                        <img src="{{$items?->images[0]?->image}}"  alt="no image" width="100" height="75">
                                        @endisset
                                      
                                    </div>
                                </div>
                            </div>
                            <center>
                                <input type="submit" class="btn btn-success" value="Update" />
                            </center>
                        </form>
                        <hr />
                        <div class="row">
                            <div class="col-lg-6">

                            </div>
                            <div class="col-lg-6">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/intl-telephone/js/intlTelInput.js') }}" type="text/javascript"></script>
    <script>
        var selectedFlag = 'in'
        $("#mobile_number").intlTelInput({
            //preferredCountries: ['in','ae', 'us'],
            preferredCountries: ['in', 'ae', 'us'],
            autoPlaceholder: true,
            // onlyCountries: ['in','ae', 'us'],
            initialCountry: selectedFlag,
            separateDialCode: true,
            utilsScript: '{{ asset('assets/intl-telephone/js/utils.js') }}'
        });{{ $items->countryCode }}
        $("#mobile_number").on("countrychange", function(e, countryData) {
            $("#phone_country_code").val(countryData.dialCode);
            // $("#mobile_number").val('{{ $item->mobile_no }}')
        });
    </script>
@endsection
