<?php

use Illuminate\Support\Facades\Route;

//control language start here
Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('/settings/info', 'Piplmodules\Settings\Controllers\SettingsController@editInformation')
        ->name('admin.settings');
    Route::POST('/settings/info', 'Piplmodules\Settings\Controllers\SettingsController@updateMainInfo')
        ->name('admin.settings.save-info');
});
