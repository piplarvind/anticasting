<?php

Route::group(array('module' => 'EmailTemplate', 'namespace' => 'App\PiplModules\emailtemplate\Controllers', 'middleware' => ['web','auth']), function() {
    //Your routes belong to this module.
    Route::get("/admin/email-templates/list", "EmailTemplateController@index")->middleware('permission:view.email-templates');
    Route::get("/admin/email-templates-data", "EmailTemplateController@getEmailTemplateData")->middleware('permission:view.email-templates');
    Route::get("/admin/email-templates/update/{template_id}", "EmailTemplateController@showUpdateEmailTemplateForm")->middleware('permission:update.email-templates');
    Route::post("/admin/email-templates/update/{template_id}", "EmailTemplateController@showUpdateEmailTemplateForm")->middleware('permission:update.email-templates');
    Route::get("/admin/email-template/update-language/{page_id}/{locale}", "EmailTemplateController@showUpdateEmailTemplateLanguageForm")->middleware('permission:update.email-templates');
    Route::post("/admin/email-template/update-language/{page_id}/{locale}", "EmailTemplateController@showUpdateEmailTemplateLanguageForm")->middleware('permission:update.email-templates');
    Route::get("/admin/email-templates/get-template-view/{template_id}/{lang}", "EmailTemplateController@getTemplateView");
});