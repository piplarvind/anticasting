<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {
	// permissions
	Route::GET('permissions', 'Piplmodules\Permissions\Controllers\PermissionsController@index')
        ->name('admin.permissions');
	Route::GET('permissions/create', 'Piplmodules\Permissions\Controllers\PermissionsController@create')
        ->name('admin.permissions.create');
	Route::POST('permissions', 'Piplmodules\Permissions\Controllers\PermissionsController@store')
        ->name('admin.permissions.store');
	Route::GET('permissions/{id}/edit', 'Piplmodules\Permissions\Controllers\PermissionsController@edit')
        ->name('admin.permissions.edit');
	Route::PATCH('permissions/{id}', 'Piplmodules\Permissions\Controllers\PermissionsController@update')
        ->name('admin.permissions.update');
	Route::POST('permissions/bulk-operations', 'Piplmodules\Permissions\Controllers\PermissionsController@bulkOperations')
        ->name('admin.permissions.bulk-operations');

});