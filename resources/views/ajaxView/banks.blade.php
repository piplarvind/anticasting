@foreach ($banks as $bank)
    <div class="form-group cust-radio">
        <div class="form-control">
            <label class="radio-container">
                {{ $bank->name }}
                <input class="bank_name" type="radio" name="bank_name" @if (session('bank_id') == $bank->institution_id) checked="checked" @endif
                    value="{{ $bank->name . '###' . $bank->institution_id }}">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
@endforeach
