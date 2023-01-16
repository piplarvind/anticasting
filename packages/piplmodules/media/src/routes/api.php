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
Route::group(['middleware' => 'web'], function() {
Route::GET('api/media', 'Piplmodules\Media\Controllers\MediaApiController@listAll');
Route::POST('api/media', 'Piplmodules\Media\Controllers\MediaApiController@uploadFile');
Route::PATCH('api/media/{id}', 'Piplmodules\Media\Controllers\MediaApiController@updateFile');

/*Route::POST('api/bulk-media', function(){
	return true;
});*/
//'Piplmodules\Media\Controllers\MediaApiController@uploadFiles');

Route::POST('api/bulk-media','Piplmodules\Media\Controllers\MediaApiController@uploadFiles');


/*Route::GET('api/bulk-media', function(){
	echo "HI";
});*/

Route::DELETE('api/media/{id}', 'Piplmodules\Media\Controllers\MediaApiController@deleteFile');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');
});