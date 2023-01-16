@foreach ($payers as $payer)
    <div class="form-group cust-radio">
        <div class="form-control">
            <label class="radio-container">
                {{ $payer->payer_name }}
                <input class="bank_name" type="radio" name="bank_name" @if (session('bank_id') == $payer->payer_id) checked="checked" @endif
                    value="{{ $payer->payer_name . '###' . $payer->payer_id }}">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
@endforeach
