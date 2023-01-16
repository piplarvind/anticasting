@if(count($languages))
    @foreach($languages as $lang)
    <div id="group-{{$lang["code"]}}">
        @foreach($fields as $field)
            @include('Core::fields.'.$field['type'].'', $field['properties'])
        @endforeach
    </div>
    @endforeach
@endif