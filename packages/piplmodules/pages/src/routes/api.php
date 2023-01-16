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
	# Pages 
	Route::GET('pages', 'Piplmodules\Pages\Controllers\PagesApiController@list');
	Route::POST('pages', 'Piplmodules\Pages\Controllers\PagesApiController@storePage');
	Route::POST('pages/{id}/update', 'Piplmodules\Pages\Controllers\PagesApiController@updatePage');
});