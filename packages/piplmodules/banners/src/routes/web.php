<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {
	//Banners
	Route::GET('banners', 'Piplmodules\Banners\Controllers\BannersController@index')
        ->name('admin.banners');
	Route::GET('banners/create', 'Piplmodules\Banners\Controllers\BannersController@create')
        ->name('admin.banners.create');
	Route::POST('banners', 'Piplmodules\Banners\Controllers\BannersController@store')
        ->name('admin.banners.store');
	Route::GET('banners/{id}/edit', 'Piplmodules\Banners\Controllers\BannersController@edit')
        ->name('admin.banners.edit');
	Route::PATCH('banners/{id}', 'Piplmodules\Banners\Controllers\BannersController@update')
        ->name('admin.banners.update');
    Route::GET('banners/{id}/delete', 'Piplmodules\Banners\Controllers\BannersController@deleteBanner')
        ->name('admin.banners.delete');
	Route::POST('banners/bulk-operations', 'Piplmodules\Banners\Controllers\BannersController@bulkOperations')
        ->name('admin.banners.bulk-operations');
});

Route::GET('banners/change-status', 'Piplmodules\Banners\Controllers\BannersController@changeBannerStatus')
    ->name('admin.banners.change-status');
