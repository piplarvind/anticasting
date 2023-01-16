<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('country/send', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@index')->name('admin.country.send');

    Route::GET('country/send/create', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@create')
        ->name('admin.country.send.create');
    Route::POST('country/send/store', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@store')
        ->name('admin.country.send.store');
    Route::GET('country/send/{id}/edit', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@edit')
        ->name('admin.country.send.edit');
    Route::PATCH('country/send/{id}', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@update')
        ->name('admin.country.send.update');
    Route::GET('country/send/{id}/delete', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@delete')
        ->name('admin.country.send.delete');
    Route::POST('country/send/bulk-operations', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@bulkOperations')
        ->name('admin.country.send.bulk-operations');
    Route::GET('country/send/change-status', 'Piplmodules\SendingCountry\Controllers\SendingCountryController@changeTopicStatus')
        ->name('admin.country.send.change-status');
});
