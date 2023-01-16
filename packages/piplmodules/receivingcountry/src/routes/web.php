<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('country/receive', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@index')->name('admin.country.receive');

    Route::GET('country/receive/create', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@create')
        ->name('admin.country.receive.create');
    Route::POST('country/receive/store', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@store')
        ->name('admin.country.receive.store');
    Route::GET('country/receive/{id}/edit', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@edit')
        ->name('admin.country.receive.edit');
    Route::PATCH('country/receive/{id}', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@update')
        ->name('admin.country.receive.update');
    Route::GET('country/receive/{id}/delete', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@delete')
        ->name('admin.country.receive.delete');
    Route::POST('country/receive/bulk-operations', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@bulkOperations')
        ->name('admin.country.receive.bulk-operations');
    Route::GET('country/receive/change-status', 'Piplmodules\ReceivingCountry\Controllers\ReceivingCountryController@changeTopicStatus')
        ->name('admin.country.receive.change-status');
});
