<?php

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    
    Route::get('settings', 'SettingsController@index')->name('admin.settings');
    Route::get('setting/edit/{id}', 'SettingsController@create')->name('admin.settings.edit');
   

});
