<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('submit-profile', 'SubmitProfileController@index')->name('admin.submitprofile');

    Route::get('submit-profile/edit/{id}', 'SubmitProfileController@edit')->name('admin.submitprofile.edit');
    Route::put('submit-profile/update/post/{id}', 'SubmitProfileController@Update')->name('admin.submitprofile.store');
    Route::get('manage-userprofile/{id}', 'SubmitProfileController@manageUserProfile')->name('admin.manageuserprofile');
    Route::post('manage-user/post/{id}', 'SubmitProfileController@manageUserProfileStore')->name('admin.manageuserprofile.post');
});
