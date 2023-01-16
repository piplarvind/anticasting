<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {
    // Roles
    Route::GET('roles', 'Piplmodules\Roles\Controllers\RolesController@index')
        ->name('admin.roles');
    Route::GET('roles/create', 'Piplmodules\Roles\Controllers\RolesController@create')
        ->name('admin.roles.create');
    Route::POST('roles/store', 'Piplmodules\Roles\Controllers\RolesController@store')
        ->name('admin.roles.store');
    Route::GET('roles/{id}/edit', 'Piplmodules\Roles\Controllers\RolesController@edit')
        ->name('admin.roles.edit');
    Route::PATCH('roles/{id}', 'Piplmodules\Roles\Controllers\RolesController@update')
        ->name('admin.roles.update');
    Route::POST('roles/bulk-operations', 'Piplmodules\Roles\Controllers\RolesController@bulkOperations')
        ->name('admin.roles.bulk-operations');

});