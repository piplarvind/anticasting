<div class="form-group">
	<a class="btn btn-block btn-success gallery-images-browse" data-toggle="modal" data-target="#pipl_media_modal" href="#" media-data-button-name="{{ trans('Media::media.select_files') }}" media-data-field-name="gallery_images[]" media-data-multiple>{{ trans('Media::media.select_files') }}</a>
	<div class="pipl-media-gallery">
		@if(isset($item->media) && isset($item->media->gallery))
			@foreach($item->media->gallery as $image)
				<div class='media-item'>
					<img src='{{url('/')}}/{{ $image['styles']['thumbnail'] }}' />
					<input type='file' name='gallery_images[]' value='{{ $image['id'] }}'>
				</div>
			@endforeach
		@endif

        <?php
        if (isset($gallery_images) && count($gallery_images) > 0) {

        foreach ($gallery_images as $images) {
        ?>
		<div class="media-item">
			<a href="#"><img id="deleteImage_<?php echo $images['media_id']; ?>"  src="<?php echo url('/'); ?>/{{  $images['file']  }}"  class="sli-imageiner" alt="slide"></a>
			<div class="sli-delete"  id="deleteImageB_<?php echo $images['media_id']; ?>"  onclick="deleteMyImages('<?php echo $images['media_id']; ?>')">
				<i class="fa fa-times" aria-hidden="true"></i>
			</div>
		</div>

        <?php }
        }
        ?>
	</div>
</div>