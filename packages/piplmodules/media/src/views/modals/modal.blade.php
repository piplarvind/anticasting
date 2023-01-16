<input type="hidden" id="max_file_size_validation" value="{{trans('Media::media.max_file_size_validation')}}"/>
<div class="modal media-modal fade in" id="pipl_media_modal" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div id="drop-area"></div>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="livicon" data-name="image" data-size="18" data-c="#F89A14" data-hc="#5CB85C" data-loop="true"></i> Gallery Manager</h4>

            </div>
            <div class="modal-body" style="padding: 0;">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#" id="pipl_media_library_tab">{{trans('Media::media.media_library')}}</a></li>
                    <li><a href="#" id="pipl_upload_files_tab">{{trans('Media::media.upload_files')}}</a></li>
                </ul>

                <div class="pipl-container" id="pipl_media_library">
                    <div class="row">
                        <div class="col-md-3 file-info">
                            <div class="media-sidebar">

                                <div class="file-info">
                                    <h2>{{trans('Media::media.file_information')}}</h2>
                                    <div class="thumbnail thumbnail-image">
                                        <img src="" draggable="false" alt="">
                                    </div>
                                    <div class="details">
                                        <div class="filename"><b></b></div>
                                        <div class="uploaded"></div>
                                        <div class="file-size"></div>
                                        <div class="dimensions"></div>
                                        {{-- <a class="edit" href="">Edit</a> --}}
                                        {{--<a id="delete_file" href="javascript:void(0);" data-file-id="">{{trans('Media::media.delete')}}</a>--}}
                                        <div class="compat-meta"></div>
                                    </div>
                                    <div style="clear: both;"></div>
                                    <div>
                                        {{--<div class="form-group">
                                            <label for="url">{{trans('Media::media.link')}}</label>
                                            <input type="text" class="form-control" id="media_item_url" readonly>
                                        </div>--}}

                                        <div class="form-group">
                                            <label for="title">{{trans('Media::media.title')}}</label>
                                            <input type="text" class="form-control" id="media_item_title" value="">
                                        </div>

                                        {{--<div class="form-group">
                                            <label for="caption">{{trans('Media::media.comment')}}</label>
                                            <textarea class="form-control" id="media_item_caption" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="alt">{{trans('Media::media.alt_text')}}</label>
                                            <input type="text" class="form-control" id="media_item_alt">
                                        </div>--}}

                                        <div class="form-group">
                                            <label for="description">{{trans('Media::media.description')}}</label>
                                            <textarea class="form-control" id="media_item_description" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 media-img-content">
                            <div class="media-content">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="pipl_media_search" placeholder="Search...">
                                </div>
                                <div class="pipl-media-list">
                                    <ul></ul>
                                    <div id="pipl-no-more-files">{{trans('Media::media.no_other_files')}}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="pipl-container" id="pipl_upload_files">
                    <div id="pipl_upload_files_area">
                        <div class="pipl-browse-form">
                            <form action="" method="POST" role="form" enctype="multipart/form-data">
                                <input style="display: none;" type="file" id="files" name="files" multiple>
                            </form>
                            <p>{{trans('Media::media.drag_the_files')}}</p>
                            <p>{{trans('Media::media.or')}}</p>
                            <a href="javascript:;" id="pipl_browse_button" class="btn-sm btn-primary">{{trans('Media::media.select_files')}}</a>
                            <p>{{trans('Media::media.maximum_file_size')}}</p>
                            {{--<p>{{trans('Media::media.or')}}</p>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-2">
                                    <div class="input-group">
                                        <input  type="text" name="urlFile" id="urlFile" placeholder="Enter image url" class="form-control"  /> <span class="input-group-addon"><button type="button" class="btn-sm btn-danger" id="hide_spin" onclick="fetchImageUrlToGallery()">{{trans('Media::media.go')}}</button></span>
                                        <i class="fa fa-spinner fa-spin" id="go_spin" style="display:none;"></i>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <p class="pipl-drag-info">{{trans('Media::media.drop_file_to_upload')}}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn-sm btn-success" id="set-choosed-file">{{ trans('Media::media.select_files') }}</button>
            </div>--}}
        </div>
    </div>
</div>