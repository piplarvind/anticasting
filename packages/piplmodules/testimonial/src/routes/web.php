<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::GET('/testimonials', 'Piplmodules\Testimonial\Controllers\TestimonialController@index')->name('admin.testimonials');

    Route::GET('testimonials/create', 'Piplmodules\Testimonial\Controllers\TestimonialController@create')
        ->name('admin.testimonials.create');
    Route::POST('testimonials/store', 'Piplmodules\Testimonial\Controllers\TestimonialController@store')
        ->name('admin.testimonials.store');
    Route::GET('testimonials/{id}/edit', 'Piplmodules\Testimonial\Controllers\TestimonialController@edit')
        ->name('admin.testimonials.edit');
    Route::PATCH('testimonials/{id}', 'Piplmodules\Testimonial\Controllers\TestimonialController@update')
        ->name('admin.testimonials.update');
    Route::GET('testimonials/{id}/delete', 'Piplmodules\Testimonial\Controllers\TestimonialController@delete')
        ->name('admin.testimonials.delete');
    Route::POST('testimonials/bulk-operations', 'Piplmodules\Testimonial\Controllers\TestimonialController@bulkOperations')
        ->name('admin.testimonials.bulk-operations');
    Route::GET('testimonials/change-status', 'Piplmodules\Testimonial\Controllers\TestimonialController@changeStatus')
        ->name('admin.testimonials.change-status');
});
