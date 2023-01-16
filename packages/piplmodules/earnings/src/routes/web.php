<?php

use Illuminate\Support\Facades\Route;
use Piplmodules\Earnings\Controllers\EarningController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function() {

    Route::ANY('/earnings/list', [EarningController::class, 'index'])
        ->name('admin.earnings.list');
    Route::GET('/earnings/detail/{id}', [EarningController::class, 'earningDetails'])
        ->name('admin.earnings.detail');

});
