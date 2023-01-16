@php
    $languageCode = '';
    $fieldName = $field_name;
    $name = $name;
    $placeholder = $placeholder;

    if(old($fieldName)){
        $value = old($fieldName);
    }elseif(isset($item) && isset($item->$fieldName)){
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
    }
@endphp

<div class="checkbox">
    <label>
        <input name="{{$fieldName}}" id="{{$fieldName}}" type="checkbox" value="1" class="minimal-blue"  checked >
        {{ $name }}
    </label>
</div>