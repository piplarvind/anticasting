<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('paymentmethod/list', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@index')->name('admin.paymentmethod.list');

    Route::GET('paymentmethod/create', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@create')
        ->name('admin.paymentmethod.create');
    Route::POST('paymentmethod/store', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@store')
        ->name('admin.paymentmethod.store');
    Route::GET('paymentmethod/{id}/edit', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@edit')
        ->name('admin.paymentmethod.edit');
    Route::PATCH('paymentmethod/{id}', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@update')
        ->name('admin.paymentmethod.update');
    Route::GET('paymentmethod/{id}/delete', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@delete')
        ->name('admin.paymentmethod.delete');
    Route::POST('paymentmethod/bulk-operations', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@bulkOperations')
        ->name('admin.paymentmethod.bulk-operations');
    Route::GET('paymentmethod/change-status', 'Piplmodules\PaymentMethod\Controllers\PaymentMethodController@changeTopicStatus')
        ->name('admin.paymentmethod.change-status');
});
