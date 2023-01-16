<?php

use Illuminate\Support\Facades\Route;
use Piplmodules\Sendinglimits\Controllers\SendinglimitsController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function () {
    Route::GET('sendlimits', [SendinglimitsController::class, 'index'])
        ->name('admin.sendlimits');

    Route::GET('sendlimits/create', [SendinglimitsController::class, 'create'])
        ->name('admin.sendlimits.create');
    Route::POST('sendlimits/store', [SendinglimitsController::class, 'store'])
        ->name('admin.sendlimits.store');
    Route::GET('sendlimits/{id}/edit', [SendinglimitsController::class, 'edit'])
        ->name('admin.sendlimits.edit');
    Route::PATCH('sendlimits/{id}', [SendinglimitsController::class, 'update'])
        ->name('admin.sendlimits.update');

    //attributes start
    Route::GET('sendlimits/{id}/attributes', [SendinglimitsController::class, 'attributeList'])
        ->name('admin.sendlimits.attributes');
    Route::GET('sendlimits/{id}/attributes/create', [SendinglimitsController::class, 'createAttribute'])
        ->name('admin.sendlimits.attributes.create');
    Route::POST('sendlimits/attributes/{id}/store', [SendinglimitsController::class, 'storeAttribute'])
        ->name('admin.sendlimits.attributes.store');
    Route::GET('sendlimits/{id}/attributes/{sId}/edit', [SendinglimitsController::class, 'editAttribute'])
        ->name('admin.sendlimits.attributes.edit');
    Route::PATCH('sendlimits/{id}/attributes/{sId}', [SendinglimitsController::class, 'updateAttribute'])
        ->name('admin.sendlimits.attributes.update');
        Route::GET('sendlimits/attributes/{id}/delete/{sId}', [SendinglimitsController::class, 'deleteAttribute'])
        ->name('admin.sendlimits.attributes.delete');
    //attributes end

    Route::GET('sendlimits/{id}/delete', [SendinglimitsController::class, 'delete'])
        ->name('admin.sendlimits.delete');
    Route::POST('sendlimits/bulk-operations', [SendinglimitsController::class, 'bulkOperations'])
        ->name('admin.sendlimits.bulk-operations');
    Route::GET('sendlimits/change-status', [SendinglimitsController::class, 'changeStatus'])
        ->name('admin.sendlimits.change-status');
});
