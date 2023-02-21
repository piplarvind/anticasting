<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin','middleware'=>['web','admin']],function(){
 
    Route::get('/message', 'MessageController@index')->name('admin.message');
    Route::get('message/create', 'MessageController@create')->name('admin.message.create');
    Route::post('message-post', 'MessageController@store')->name('admin.message.store');
});

