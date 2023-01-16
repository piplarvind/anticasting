<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('/faq', 'Piplmodules\Faq\Controllers\FaqController@index')->name('admin.faq');

    Route::GET('faq/create', 'Piplmodules\Faq\Controllers\FaqController@create')
        ->name('admin.faq.create');
    Route::POST('faq/store', 'Piplmodules\Faq\Controllers\FaqController@store')
        ->name('admin.faq.store');
    Route::GET('faq/{id}/edit', 'Piplmodules\Faq\Controllers\FaqController@edit')
        ->name('admin.faq.edit');
    Route::PATCH('faq/{id}', 'Piplmodules\Faq\Controllers\FaqController@update')
        ->name('admin.faq.update');
    Route::GET('faq/{id}/delete', 'Piplmodules\Faq\Controllers\FaqController@delete')
        ->name('admin.faq.delete');
    Route::POST('faq/bulk-operations', 'Piplmodules\Faq\Controllers\FaqController@bulkOperations')
        ->name('admin.faq.bulk-operations');
    Route::GET('faq/change-status', 'Piplmodules\Faq\Controllers\FaqController@changeTopicStatus')
        ->name('admin.faq.change-status');
});
