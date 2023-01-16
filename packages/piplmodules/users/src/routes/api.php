<?php

use Illuminate\Http\Request;

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

$locale = \Request::segment(1);

Route::group(['middleware' => ['api'], 'prefix' => $locale.'/api/{key}'], function() {
    
    // Users
    Route::GET('users', 'App\Http\Controllers\WebservicesController@listUsers');
    Route::POST('users', 'Piplmodules\Users\Controllers\UsersApiController@storeUser');
    Route::POST('users/{id}/update', 'Piplmodules\Users\Controllers\UsersApiController@updateUser');
});
