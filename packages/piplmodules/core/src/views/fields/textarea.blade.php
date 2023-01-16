@php
	$languageCode = '';
	$fieldName = $field_name;
	$name = $name;
	$placeholder = $placeholder;
	
	// rows
	if(isset($rows)){
		$rows = $rows;
	}else{
		$rows = 10;
	}

	// Class
	if(isset($class)){
		$class = $class;
	}else{
		$class = '';
	}

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
		if(isset($required)){
            $required = ($required)?'*':'';
        }else{
            $required = "";
        }
	}
@endphp

<div class="form-group {{ $errors->has($fieldName) ? 'has-error': '' }}">
    <label for="{{$fieldName}}">{{ $name }} {{@$required}}</label>
    <textarea id="{{$fieldName}}" name="{{$fieldName}}" class="form-control {{ $class }}" placeholder="{{$placeholder}}" rows="{{$rows}}">{{ $value }}</textarea>
</div>