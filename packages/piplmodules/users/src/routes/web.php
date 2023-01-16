<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('dashboard', 'Piplmodules\Users\Controllers\AdminController@dashboard')->name('admin.dashboard');

    //Members
    Route::GET('admin-users', 'Piplmodules\Users\Controllers\AdminController@index')->name('admin.users');
    Route::GET('admin-users/create', 'Piplmodules\Users\Controllers\AdminController@create')->name('admin.users.create');
    Route::POST('admin-users', 'Piplmodules\Users\Controllers\AdminController@store')->name('admin.users.store');
    Route::GET('admin-users/{id}/edit', 'Piplmodules\Users\Controllers\AdminController@edit')->name('admin.users.edit');
    Route::PATCH('admin-users/{id}', 'Piplmodules\Users\Controllers\AdminController@update')->name('admin.users.update');
    //delete admin user
    Route::GET('admin-users/{id}/delete', 'Piplmodules\Users\Controllers\AdminController@delete')->name('admin.users.delete');
    Route::POST('admin-users/bulk-operations', 'Piplmodules\Users\Controllers\AdminController@bulkOperations')->name('admin.users.bulk-operations');

    //Members
    Route::GET('users/give-permission/{user_id}', 'Piplmodules\Users\Controllers\UsersController@givePermission');
    Route::POST('users/give-permission/{user_id}', 'Piplmodules\Users\Controllers\UsersController@givePermission');

    Route::GET('users/', 'Piplmodules\Users\Controllers\UsersController@index')->name('admin.customers');
    Route::GET('users/create', 'Piplmodules\Users\Controllers\UsersController@create')->name('admin.customers.create');
    Route::POST('users', 'Piplmodules\Users\Controllers\UsersController@store')->name('admin.customers.store');
    Route::GET('users/{id}/edit', 'Piplmodules\Users\Controllers\UsersController@edit')->name('admin.customers.edit');
    Route::PATCH('users/{id}', 'Piplmodules\Users\Controllers\UsersController@update')->name('admin.customers.update');
    Route::PATCH('users/{id}/edit-address', 'Piplmodules\Users\Controllers\UsersController@editAddress')->name('admin.customers.edit_address');
    Route::PATCH('users/{id}/edit-send-country', 'Piplmodules\Users\Controllers\UsersController@editSendCountry')->name('admin.customers.edit_send_country');
    Route::GET('users/{id}/recipients', 'Piplmodules\Users\Controllers\UsersController@recipients')->name('admin.customers.recipients');
    Route::GET('users/{user_id}/recipients/{id}/view', 'Piplmodules\Users\Controllers\UsersController@viewRecipient')->name('admin.customers.recipients.view');
    Route::GET('users/{user_id}/recipients/{id}/edit', 'Piplmodules\Users\Controllers\UsersController@editRecipient')->name('admin.customers.recipients.edit');
    Route::PATCH('users/{user_id}/recipients/{id}', 'Piplmodules\Users\Controllers\UsersController@updateRecipient')->name('admin.customers.recipients.update');
    Route::GET('users/{user_id}/recipients/{id}/delete', 'Piplmodules\Users\Controllers\UsersController@deleteRecipient')->name('admin.customers.recipients.delete');
    
    //delete user
    Route::GET('users/{id}/delete', 'Piplmodules\Users\Controllers\UsersController@deleteUser')->name('admin.customers.delete');
    Route::GET('users/{id}/view', 'Piplmodules\Users\Controllers\UsersController@viewUser')->name('admin.customers.view');

    Route::POST('users/bulk-operations', 'Piplmodules\Users\Controllers\UsersController@bulkOperations')->name('admin.customers.bulk-operations');

    Route::any('notifications/send-notification', 'Piplmodules\Users\Controllers\AdminController@sendNotification')->name('admin.send-notification');
    Route::get('notifications', 'Piplmodules\Users\Controllers\AdminController@listNotifications')->name('admin.notifications');
});
Route::GET('users/change-status', 'Piplmodules\Users\Controllers\UsersController@changeStatus')->name('admin.user.change-status');

Route::get('user-country-states/{countryId}', 'Piplmodules\Users\Controllers\AdminController@getCountryStates');
Route::get('user-state-cities/{stateId}', 'Piplmodules\Users\Controllers\AdminController@getStateCities');
