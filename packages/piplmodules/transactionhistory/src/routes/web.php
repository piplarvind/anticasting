<?php

use Illuminate\Support\Facades\Route;
use Piplmodules\Transactionhistory\Controllers\TransactionhistoryController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => '/admin'], function () {

    Route::ANY('/transactions/history', [TransactionhistoryController::class, 'index'])
        ->name('admin.transactions.history');
    Route::GET('/transactions/history/detail/{id}', [TransactionhistoryController::class, 'trasnactionDetails'])
        ->name('admin.transactions.history.detail');

    Route::GET('/transactions/history/generate-receipt-pdf/{transaction_id}', [TransactionhistoryController::class, 'generateReceiptPdf'])->name('admin.generate-receipt-pdf');
});
