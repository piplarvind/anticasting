<?php

//control language start here
$locale = \Request::segment(1);
//control language start here
Route::group(['middleware' => ['web', 'admin'], 'prefix' => $locale . '/admin'], function() {
    //Pages
    Route::GET('pages', 'Piplmodules\Pages\Controllers\PagesController@index')->name('admin.pages');
    Route::GET('pages/dynamic', 'Piplmodules\Pages\Controllers\PagesController@dynamic');
    Route::GET('pages/create', 'Piplmodules\Pages\Controllers\PagesController@create')->name('admin.pages.create');;
    Route::POST('pages', 'Piplmodules\Pages\Controllers\PagesController@store')->name('admin.pages.store');
    Route::GET('pages/{id}/edit', 'Piplmodules\Pages\Controllers\PagesController@edit')->name('admin.pages.edit');
    Route::PATCH('pages/{id}', 'Piplmodules\Pages\Controllers\PagesController@update')->name('admin.pages.update');
    Route::POST('pages/bulk-operations', 'Piplmodules\Pages\Controllers\PagesController@bulkOperations');
    Route::GET('pages/remove-cms-page-image/{id}', 'Piplmodules\Pages\Controllers\PagesController@removeCmsPageImage')->name('admin.pages.remove-cms-page-image');
});