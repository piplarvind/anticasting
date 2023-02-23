<?php

use App\Modules\Actors\Http\Controllers\ActorsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    Route::get('actors', [ActorsController::class, 'listActors'])
        ->name('admin.list-actors');
});
