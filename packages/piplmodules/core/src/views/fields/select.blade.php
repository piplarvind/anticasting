@php
	$languageCode = '';
	$fieldName = $field_name;
	$fieldNameUnderscoreId = $fieldName.'_id';
	$name = $name;
	$options = $options;
    
	if(old($fieldName)){
		$value = old($fieldName);
	}elseif(isset($item) && isset($item->$fieldNameUnderscoreId)){
		$value = $item->$fieldNameUnderscoreId;
	}elseif(isset($item) && isset($item->$fieldName) && is_int($item->$fieldName)){
		$value = $item->$fieldName;
	}elseif(!isset($value)){
		$value = '';
	}

	$isMultiple = false;
	if(isset($multiple)){
		$isMultiple = true;
	}
	
	if(isset($lang["code"])){
		$languageCode = $lang["code"];
		$fieldName = $field_name.'_'.$lang["code"];

		if(old($fieldName)){
			$value = old($fieldName);
		}
		
		if(count($languages) > 1){
			$name = $name.' ('.$lang["name"].')';
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
	<select id="{{$fieldName}}" name="{{$fieldName}}" class="form-control" @if(isset($dependOn)) depend-on="{{ $dependOn }}" @endif @if($isMultiple) multiple @endif>
		 @if(count($options))
		    @foreach($options as $option)
		        <option @if($value == $option['value']) selected @endif value="{{ $option['value'] }}" @if(isset($option['dependencyValue'])) dependency-value="{{ $option['dependencyValue'] }}" @endif>{{ $option['name'] }}</option>
		    @endforeach
		@endif
	</select>
</div>