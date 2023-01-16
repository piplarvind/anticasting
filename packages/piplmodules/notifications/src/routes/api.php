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
	# Notifications
	Route::GET('notifications', 'Piplmodules\Notifications\Controllers\NotificationsApiController@list');
	Route::POST('notifications', 'Piplmodules\Notifications\Controllers\NotificationsApiController@storeActivity');
	Route::POST('notifications/{id}/update', 'Piplmodules\Notifications\Controllers\NotificationsApiController@updateActivity');

});
