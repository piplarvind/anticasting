<form method="get">
    <div class="row">
     <div class="col-md-2">
        <label  for="staticName" class="col-form-label">
            <b>Gender</b>
        </label>
                {{-- 
                 <input type="text" name="q" class="form-control" id="staticName"
                value="{{ old('q', request()->q) }}" />
             --}}
             <select name="gender" class="form-control" id="">
                <option value="">--select--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>

        </div>
        <div class="col-md-3">
         <label for="status" class="col-form-label"><b>Ethnicity</b></label>
            {{-- 
             <select name="status" class="form-control" id="">
                <option value="">--select--</option>
                <option value="1"
                    {{ old('status', request()->status) == '1' ? 'selected="selected"' : '' }}>
                    Active</option>
                <option value="2"
                    {{ old('status', request()->status) == '2' ? 'selected="selected"' : '' }}>
                    Inactive</option>
             </select>
             --}}
            <select name="ethnicity" class="form-control w-75" id="">
                <option value="">--select--</option>
                @if (isset($state))
                    @foreach ($state as $item)
                        <option value="{{$item->value}}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-3">
            <br />
            <label for="status" class="col-form-label"><br /></label>
                <input type="submit" value="Filter" class="btn btn-primary" id="filter">
                <a href="{{ route('admin.submitprofile') }}" class="btn btn-danger">Reset</a>
        </div>
    </div>
</form>