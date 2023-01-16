<style>
.cke_dialog_ui_input_file{
    height: 310px;
}
#cke_129_uiElement{
    position: absolute;
    left: 10px;
    bottom: 50PX;
}
</style>
<script src="{{ asset('assets/backend/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'body_ar',
    {
        customConfig : 'config.js',
        toolbar : 'simple',
        filebrowserBrowseUrl : "{{ action('MediaController@ckeditor_browse_images',['_token' => csrf_token() ])}}",
    });
    CKEDITOR.replace( 'body_en',
    {
        customConfig : 'config.js',
        toolbar : 'simple',
        filebrowserBrowseUrl : "{{ action('MediaController@ckeditor_browse_images',['_token' => csrf_token() ])}}",
    });
</script> 