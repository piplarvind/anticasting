@if(count($languages) && count($languages) > 1)
    <div class="form-group">
        <label  style="text-align: center; width:100%;">{{ trans('admin.languages') }}</label>
        @foreach($languages as $lang)
            <div class="checkbox">
                <label for="lang-{{$lang["code"]}}">
                  <input type="checkbox" name="language[{{$lang["code"]}}]" id="lang-{{$lang["code"]}}" value="{{$lang["code"]}}"
                    @if($lang["content_default"] === true && empty(old('language.'.$lang["code"])) || old('language.'.$lang["code"].'') == $lang["code"]) checked @endif


                    > {{$lang["name"]}}
                </label>
            </div>
        @endforeach
    </div>
    <hr>
@elseif(count($languages) == 1)
    @foreach($languages as $lang)
        <input type="checkbox" name="language[{{$lang["code"]}}]" id="lang-{{$lang["code"]}}" value="{{$lang["code"]}}" checked style="display: none;">
    @endforeach
@endif