@php
    $languageCode = '';
    $fieldName = $field_name;
    $name = $name;
    $placeholder = $placeholder;

    //$fields = end($fields);

    if(isset($type)){
        $type = $type;
    }else{
        $type = "text";
    }

    if(old($fieldName)){
        $value = old($fieldName);
    }elseif(isset($item) && isset($item->$fieldName) && $type !== 'password'){
        $value = $item->$fieldName;
    }elseif(!isset($value)){
        $value = '';
    }

    if(isset($lang["code"])){
        $languageCode = $lang["code"];
        $fieldName = $field_name.'_'.$lang["code"];

        if(old($fieldName)){
            $value = old($fieldName);
        }

        if(count($languages) > 1){
            $name = $name.' ('.$lang["name"].')';
            $placeholder = $placeholder.' ('.$lang["name"].')';
        }

        if(isset($trans) && isset($trans[$languageCode]) && isset($trans[$languageCode][$field_name])){
            $value = $trans[$languageCode][$field_name];
        }

        if(isset($required)){
            $required = ($required)?'*':'';
        }else{
            $required = "";
        }
    }
@endphp

<div class="form-group row {{ $errors->has($fieldName) ? 'has-error': '' }}">
    <div class="col-xs-12">
        <div class="sin-inp relative">
            <label for="{{$fieldName}}">{{ $name }} {{@$required}}</label>
            <input type="{{$type}}" class="form-control" id="{{$fieldName}}" name="{{$fieldName}}" value="{{ $value }}" placeholder="{{$placeholder}}">
            <i class="{!! isset($fields['input_icon']) ? $fields['input_icon']['class'] : "" !!}"></i>
        </div>
    </div>
</div>
