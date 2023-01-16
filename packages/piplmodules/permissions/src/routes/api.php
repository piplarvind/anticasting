<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api'], 'prefix' => '/api/{key}'], function() {
	# Permissions 
	Route::GET('permissions', 'Piplmodules\Permissions\Controllers\PermissionsApiController@list');
	Route::POST('permissions', 'Piplmodules\Permissions\Controllers\PermissionsApiController@storeActivity');
	Route::POST('permissions/{id}/update', 'Piplmodules\Permissions\Controllers\PermissionsApiController@updateActivity');

});
