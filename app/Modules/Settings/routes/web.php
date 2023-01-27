<?php

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    
    Route::get('settings', 'SettingsController@SettingMainInfo')->name('admin.settings');
    Route::put('setting-updateInfo', 'SettingsController@UpdateSettingMainInfo')->name('admin.UpdateSettingMainInfo');
   

});
