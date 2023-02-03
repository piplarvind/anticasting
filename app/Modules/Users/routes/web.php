<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('users', 'UsersController@welcome');
    Route::get('manageuser', 'UsersController@manageUser')->name('admin.manageuser');
    Route::get('manageuser/edit/{id}', 'UsersController@editUser')->name('admin.manageuser.edit');
    Route::put('manageuser/post/{id}', 'UsersController@UpdateUserStore')->name('admin.manageuser.post');
});
