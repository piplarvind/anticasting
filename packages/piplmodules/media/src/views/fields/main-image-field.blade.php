{{-- <div class="form-group {{ $errors->has('main_image_id') ? 'has-error': '' }}" style="text-align: center;">
    <label for="main_image_id" style="display: block;">{{ trans('admin.main_image') }}</label>
    <input type="hidden" class="form-control" name="main_image_id" id="main-image" value="@if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->id)){{ $item->media->main_image->id }}@else{{ old('main_image_id') }}@endif">
    <input type="hidden" class="form-control" name="default_image" id="default_image" value="{{ asset('public/images/select_main_img.png') }}">
    @if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']) || !empty(old('main_image_id')))
        <a href='#main' style="position:absolute;left:222px;" class='main-img-delete'>X</a>
    @else
        <a href='#main' style="position:absolute;left:222px;display:none;" class='main-img-delete'>X</a>
    @endif
    <a class="" data-toggle="modal" data-href="#full-width" href="#pipl_media_modal" style="max-width: 100%;">
    	@if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']))
            <img id="main-image-thumbnail" src="{{url('/')}}/{{ $item->media->main_image->styles['thumbnail'] }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
    	@else
            <img id="main-image-thumbnail" src="{{ asset('public/images/select_main_img.png') }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
        @endif
    </a>
</div> --}}
<div class="form-group {{ $errors->has('main_image_id') ? 'has-error': '' }}" style="text-align: center;">
    <label style="display: block;">{{ trans('admin.main_image') }}</label>
    
    <a data-toggle="modal" data-target="#pipl_media_modal" href="javascript:void(0)" media-data-button-name="اختر الصورة الرئيسية" media-data-field-name="main_image_id" media-data-required>
        <div class="media-item">
            @if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']))
                <img src="{{url('/')}}/{{ $item->media->main_image->styles['thumbnail'] }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
                <input type="hidden" name="main_image"  value="{{$item->media->main_image->id}}">
            @else
                <img src="{{ asset('public/images/select_main_img.png') }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
            @endif
        </div>
    </a>
{{-- 
    <label for="main_image_id" style="display: block;">الصورة المميزة</label>
    <a data-toggle="modal" data-target="#pipl_media_modal" href="javascript:void(0)" media-data-button-name="اختر الصورة المميزة" media-data-field-name="featured_image">
        <div class="media-item">
            @if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']))
                <img id="main-image-thumbnail" src="/{{ $item->media->main_image->styles['thumbnail'] }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
            @else
                <img id="main-image-thumbnail" src="{{ asset('public/images/select_main_img.png') }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
            @endif
        </div>
    </a>

    <label for="main_image_id" style="display: block;">ملف ورد</label>
    <a data-toggle="modal" data-target="#pipl_media_modal" href="javascript:void(0)" media-data-button-name="اختر ملف الورد" media-data-field-name="word_fiels">
        <div class="media-item">
            @if(isset($item->media) && isset($item->media->main_image) && isset($item->media->main_image->styles['thumbnail']))
                <img id="main-image-thumbnail" src="/{{ $item->media->main_image->styles['thumbnail'] }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
            @else
                <img id="main-image-thumbnail" src="{{ asset('public/images/select_main_img.png') }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
            @endif
        </div>
    </a> --}}
</div>