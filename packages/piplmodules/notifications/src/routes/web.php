<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {
    // Notifications
    Route::GET('notifications', 'Piplmodules\Notifications\Controllers\NotificationsController@index')
        ->name('admin.notifications');
    Route::GET('notifications/create', 'Piplmodules\Notifications\Controllers\NotificationsController@create')
        ->name('admin.notifications.create');
    Route::POST('notifications/store', 'Piplmodules\Notifications\Controllers\NotificationsController@store')
        ->name('admin.notifications.store');
    Route::GET('notifications/{id}/edit', 'Piplmodules\Notifications\Controllers\NotificationsController@edit')
        ->name('admin.notifications.edit');
    Route::PATCH('notifications/{id}', 'Piplmodules\Notifications\Controllers\NotificationsController@update')
        ->name('admin.notifications.update');
    Route::POST('notifications/bulk-operations', 'Piplmodules\Notifications\Controllers\NotificationsController@bulkOperations')
        ->name('admin.notifications.bulk-operations');

    Route::GET('notifications/change-status', 'Piplmodules\Notifications\Controllers\NotificationsController@changeStatus')->name('admin.notifications.change-status');
});
