<?php

use Illuminate\Support\Facades\Route;

//control language start here
Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {
    Route::GET('emailtemplates', 'Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@index')
        ->name('admin.emailtemplates');
    Route::GET('emailtemplates/create', 'Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@create')
        ->name('admin.emailtemplates.create');
    Route::POST('emailtemplates', 'Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@store')
        ->name('admin.emailtemplates.store');
    Route::GET('emailtemplates/{id}/edit', 'Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@edit')
        ->name('admin.emailtemplates.edit');
    Route::PATCH('emailtemplates/{id}', 'Piplmodules\Emailtemplates\Controllers\EmailTemplatesController@update')
        ->name('admin.emailtemplates.update');
});