@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Update Email Template</title>

@endsection

@section('content')
<section class="tabcontent_area">
    <div class="container-fluid">
        <div class="tab_headings clearfix">
            <h3 class="float-left">Update Email Template</h3>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/email-templates/list')}}">Manage Email Templates</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Email Template</li>
            </ol>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="tabcontent_inner">
            <div class="tabcontent_part">
                <div class="tcpart_inner">
                    <div class="update_forms">
                        <form name="frm_emailtemplate_update" id="frm_emailtemplate_update"  class="form-horizontal" role="form"  method="post" >
                            {!! csrf_field() !!}
                            <div class="form-group row @if ($errors->has('subject')) has-error @endif">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Subject<sup>*</sup></label>

                                <div class="col-md-9">     
                                    <input class="form-control-plaintext custom_input" name="subject" value="{{old('subject',$template_info->subject)}}" />
                                    @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('subject') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group row @if ($errors->has('html_content')) has-error @endif">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Content <sup>*</sup></label>
                                <div class="col-md-9">     
                                    <textarea class="custom_textarea" id="html_content" name="html_content">{{old('html_content',$template_info->html_content)}}</textarea>
                                    @if ($errors->has('html_content'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('html_content') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row  @if ($errors->has('subject')) has-error @endif">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Keywords</label>
                                <div class="col-md-9">
                                    <div class="custom_select">
                                        <select onchange="jQuery('#keyword-preview').text(jQuery(this).val())">
                                            <?php $keyword_list = explode(",", $template_info->template_keywords) ?>
                                            <option value="">Select Keyword</option>
                                            @foreach($keyword_list as $keyword)
                                            <option>{!! $keyword !!}</option>
                                            @endforeach
                                        </select>
                                        <br />
                                        <div id="keyword-preview"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" id="btnSubmit" class="btn btn-theme">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script> 
<script type="text/javascript">
    CKEDITOR.editorConfig = function( config ) {
            // Define changes to default configuration here.
            // For complete reference see:
            // http://docs.ckeditor.com/#!/api/CKEDITOR.config

            // The toolbar groups arrangement, optimized for two toolbar rows.
            config.toolbarGroups = [
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                    { name: 'links' },
                    { name: 'insert' },
                    { name: 'forms' },
                    { name: 'tools' },
                    { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'others' },
                    '/',
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                    { name: 'styles' },
                    { name: 'colors' },
                    { name: 'about' }
            ];

            // Remove some buttons provided by the standard plugins, which are
            // not needed in the Standard(s) toolbar.
            config.removeButtons = 'Underline,Subscript,Superscript';

            // Set the most common block elements.
            config.format_tags = 'p;h1;h2;h3;pre';

            // Simplify the dialog windows.
            config.removeDialogTabs = 'image:advanced;link:advanced';

            config.colorButton_foreStyle = {
                element: 'font',
                attributes: { 'color': '#(color)' }
            };

            config.colorButton_backStyle = {
                element: 'font',
                styles: { 'background-color': '#(color)' }
            };
            config.allowedContent=true;
    };
    CKEDITOR.replace('html_content');
</script>  
@endsection