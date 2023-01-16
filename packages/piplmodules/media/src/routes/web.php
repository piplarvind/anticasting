<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'web'], function() {

    Route::GET('media', 'Piplmodules\Media\Controllers\MediaController@index')
        ->name('admin.media');
    Route::GET('media/upload', 'Piplmodules\Media\Controllers\MediaController@upload')
        ->name('admin.media.add');
    Route::POST('media/upload', 'Piplmodules\Media\Controllers\MediaController@storeFile')
        ->name('admin.media.upload');
    Route::GET('media/{id}/edit', 'Piplmodules\Media\Controllers\MediaController@edit')
        ->name('admin.media.edit');
    Route::PATCH('media/{id}', 'Piplmodules\Media\Controllers\MediaController@update')
        ->name('admin.media.update');
    /*Route::GET('media/{id}/confirm-delete', 'Piplmodules\Media\Controllers\MediaController@confirmDelete')
        ->name('admin.media.confirmDelete');
    Route::DELETE('media/{id}', 'Piplmodules\Media\Controllers\MediaController@delete')
        ->name('admin.media.delete');*/
    Route::GET('media/{id}/delete', 'Piplmodules\Media\Controllers\MediaController@delete')
        ->name('admin.media.delete');

    Route::POST('upload-media-file', 'Piplmodules\Media\Controllers\MediaController@storeFile');
    Route::POST('fetch-image-url', 'Piplmodules\Media\Controllers\MediaController@fetchImageUrlToGallery');
});