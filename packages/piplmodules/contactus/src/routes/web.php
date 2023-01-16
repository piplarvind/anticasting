<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {
    //Banners
    Route::GET('contact-us', 'Piplmodules\Contactus\Controllers\ContactUsController@index')
        ->name('admin.contact-us');
    Route::GET('contact-us/view-msg/{id}', 'Piplmodules\Contactus\Controllers\ContactUsController@viewMsg')
        ->name('admin.contact-us.view-msg');
    Route::POST('save-reply/{id}', 'Piplmodules\Contactus\Controllers\ContactUsController@store')
        ->name('admin.contact-us.save-reply');
});