<?php

use Illuminate\Support\Facades\Route;

//control language start here
//$locale = request()->segment(1);
//$locale = app()->getLocale();
$locale = '';
//control language start here

Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function() {
    Route::get('login', 'Piplmodules\Core\Controllers\AdminLoginController@getAdmin')->name('admin.login');
    Route::post('login', 'Piplmodules\Core\Controllers\AdminLoginController@postAdmin')->name('admin.submit-login');
    Route::get('logout', 'Piplmodules\Core\Controllers\DashboardController@getAdminLogout')->name('admin.logout');
});

Route::group(['middleware' => ['web'], 'prefix' => $locale.'/admin'], function() {
    Route::get('login', 'Piplmodules\Core\Controllers\AdminLoginController@getAdmin')->name('admin.login');
    Route::post('login', 'Piplmodules\Core\Controllers\AdminLoginController@postAdmin')->name('admin.submit-login');
    Route::get('logout', 'Piplmodules\Core\Controllers\DashboardController@getAdminLogout')->name('admin.logout');
});

$action = 'Piplmodules\Core\Controllers\DashboardController@index';
if(Config::has('piplmodules.dashboard_function') && !empty(config('piplmodules.dashboard_function'))){
    $action = config('piplmodules.dashboard_function');
}

Route::group(['middleware' => ['web' ,'admin'], 'prefix' => $locale], function() use($action) {
//Route::group(['middleware' => ['web' ,'admin']], function() use($action) {
    Route::get('admin', $action);
});

Route::group(['middleware' => ['web' ,'admin']], function() use($action) {
    Route::get('admin', $action);
});


Route::group(['middleware' => ['web' ,'admin'], 'prefix' => $locale.'/admin'], function() {
    Route::post('delete-item', 'Piplmodules\Core\Controllers\OperationsController@delete');
    Route::post('bulk-delete-items', 'Piplmodules\Core\Controllers\OperationsController@bulkDelete');
});