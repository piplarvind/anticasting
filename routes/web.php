<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'XssSanitization'],function(){

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Auth::routes();
    Auth::routes(['register' => false]);

    // Facebook Login URL
    Route::prefix('facebook')->name('facebook.')->group( function(){
        Route::get('auth', [App\Http\Controllers\FaceBookController::class, 'loginUsingFacebook'])->name('login');
        Route::get('callback', [App\Http\Controllers\FaceBookController::class, 'callbackFromFacebook'])->name('callback');
    });

    // Google Login URL
    Route::prefix('google')->name('google.')->group( function(){
        Route::get('auth', [App\Http\Controllers\FaceBookController::class, 'loginUsingGoogle'])->name('login');
        Route::get('callback', [App\Http\Controllers\FaceBookController::class, 'callbackFromGoogle'])->name('callback');
    });


    Route::get('verify-user-email/{activation_code}', [App\Http\Controllers\Auth\RegisterController::class, 'verifyUserEmail'])->name('verify-user-email');

    //Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
    //Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

    //FAQ
    Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');

    //Contact US
    Route::get('/contact-us', [App\Http\Controllers\ContactUsController::class, 'index'])->name('contact-us');


        Route::post('/contact-us', [App\Http\Controllers\ContactUsController::class, 'submitContact'])->name('submit-contact');

    Route::get('about/{page}', [App\Http\Controllers\CMSController::class, 'page'])->name('about');


    Route::get('pages/{page}', [App\Http\Controllers\CMSController::class, 'page'])->name('pages');
    Route::get('reviews', [App\Http\Controllers\HomeController::class, 'reviews'])->name('reviews');
    Route::get('share', [App\Http\Controllers\ShareController::class, 'index'])->name('share');
    Route::post('email-share', [App\Http\Controllers\ShareController::class, 'emailShare'])->name('email-share');
    Route::post('mobile-share', [App\Http\Controllers\ShareController::class, 'mobileShare'])->name('mobile-share');

    Route::get('currency-converter', [App\Http\Controllers\CronJobController::class, 'currencyConverter'])->name('currency-converter');

    Route::post('transaction-report-export', [App\Http\Controllers\ImportExportController::class,'transactionReportExport'])->name('transaction-report-export');

    Route::group(['middleware' => ['auth','frontAuthUserOnly']],function(){

        Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('edit-profile', [App\Http\Controllers\DashboardController::class, 'editProfile'])->name('edit-profile');
        Route::post('update-profile', [App\Http\Controllers\DashboardController::class, 'updateProfile'])->name('update-profile');
        Route::post('update-profile-picture', [App\Http\Controllers\DashboardController::class, 'updateProfilePicture'])->name('update-profile-picture');
        Route::post('update-password', [App\Http\Controllers\DashboardController::class, 'updatePassword'])->name('update-password');
        Route::post('update-address', [App\Http\Controllers\DashboardController::class, 'updateAddress'])->name('update-address');
        Route::post('update-phone-number', [App\Http\Controllers\DashboardController::class, 'updatePhoneNumber'])->name('update-phone-number');
        Route::post('update-user-email', [App\Http\Controllers\DashboardController::class, 'updateUserEmail'])->name('update-user-email');
        Route::post('update-send-money', [App\Http\Controllers\DashboardController::class, 'updateSendMoney'])->name('update-send-money');


        Route::get('submit-profile', [App\Http\Controllers\DashboardController::class, 'submitProfile'])->name('submit-profile');

        Route::get('notifications', [App\Http\Controllers\DashboardController::class, 'notification'])->name('notifications');
        Route::post('update-notification', [App\Http\Controllers\DashboardController::class, 'updateNotification'])->name('update-notification');
        Route::post('mark-as-read', [App\Http\Controllers\DashboardController::class, 'markNotification'])->name('markNotification');

        Route::get('send-receive-details', [App\Http\Controllers\PaymentController::class, 'sendReceiveDetails'])->name('send-receive-details');
        Route::post('save-send-receive-details', [App\Http\Controllers\PaymentController::class, 'saveSendReceiveDetails'])->name('save-send-receive-details');

        Route::get('recipient-details', [App\Http\Controllers\PaymentController::class, 'recipientDetails'])->name('recipient-details');
        Route::post('save-recipient-details', [App\Http\Controllers\PaymentController::class, 'saveRecipientDetails'])->name('save-recipient-details');
        Route::post('select-recipient', [App\Http\Controllers\PaymentController::class, 'selectRecipient'])->name('select-recipient');

        Route::get('sender-details', [App\Http\Controllers\PaymentController::class, 'senderDetails'])->name('sender-details');
        Route::post('save-sender-details', [App\Http\Controllers\PaymentController::class, 'saveSenderDetails'])->name('save-sender-details');

        Route::get('payment-page', [App\Http\Controllers\PaymentController::class, 'paymentPage'])->name('payment-page');
        Route::post('save-payment-page', [App\Http\Controllers\PaymentController::class, 'savePaymentPage'])->name('save-payment-page');

        Route::get('payment-confirmation', [App\Http\Controllers\PaymentController::class, 'paymentConfirmation'])->name('payment-confirmation');
        Route::get('payment-resend-otp', [App\Http\Controllers\PaymentController::class, 'paymentResendOTP'])->name('payment-resend-otp');
        Route::post('save-payment-confirmation', [App\Http\Controllers\PaymentController::class, 'savePaymentConfirmation'])->name('save-payment-confirmation');

        Route::get('payment-success', [App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('payment-success');

        Route::get('start-over', [App\Http\Controllers\PaymentController::class, 'startOver'])->name('start-over');
        Route::post('save-start-over', [App\Http\Controllers\PaymentController::class, 'saveStartOver'])->name('save-start-over');

        Route::get('transfer-history', [App\Http\Controllers\PaymentController::class, 'transferHistory'])->name('transfer-history');
        Route::get('receipt-details/{transaction_id}', [App\Http\Controllers\PaymentController::class, 'receiptDetails'])->name('receipt-details');
        Route::get('generate-receipt-pdf/{transaction_id}', [App\Http\Controllers\PaymentController::class, 'generateReceiptPdf'])->name('generate-receipt-pdf');

        Route::get('sending-limits', [App\Http\Controllers\PaymentController::class, 'sendingLimits'])->name('sending-limits');

        Route::get('recipients', [App\Http\Controllers\DashboardController::class, 'getRecipients'])->name('recipients');
        Route::get('recipients/add', [App\Http\Controllers\DashboardController::class, 'addRecipient'])->name('add-recipient');
        Route::post('recipients/save', [App\Http\Controllers\DashboardController::class, 'saveRecipient'])->name('save-recipient');
        Route::get('recipients/edit/{recipient_id}', [App\Http\Controllers\DashboardController::class, 'editRecipient'])->name('edit-recipient');
        Route::delete('delete-recipient', [App\Http\Controllers\DashboardController::class, 'deleteRecipient'])->name('delete-recipient');

        Route::post('change-send-to-country', [App\Http\Controllers\DashboardController::class, 'changeSendToCountry'])->name('change-send-to-country');
        Route::get('payers-api', [App\Http\Controllers\DashboardController::class, 'getPayersAPI'])->name('payers-api');
    });

    Route::group(['middleware' => 'web'],function(){
        Route::get('thunes/get-payers', [App\Http\Controllers\ThunesController::class, 'getPayers'])->name('get-payers');
        Route::get('thunes/create-payer', [App\Http\Controllers\ThunesController::class, 'createPayer'])->name('create-payer');
        Route::get('thunes/get-balance', [App\Http\Controllers\ThunesController::class, 'getBalance'])->name('get-balance');
        Route::get('thunes/get-rate', [App\Http\Controllers\ThunesController::class, 'getRate'])->name('get-rate');
        Route::get('thunes/create-quotation', [App\Http\Controllers\ThunesController::class, 'createQuotation'])->name('create-quotation');
        Route::get('thunes/create-transaction', [App\Http\Controllers\ThunesController::class, 'createTransaction'])->name('create-transaction');
        Route::get('thunes/confirm-transaction', [App\Http\Controllers\ThunesController::class, 'confirmTransaction'])->name('confirm-transaction');
        Route::get('thunes/get-transaction', [App\Http\Controllers\ThunesController::class, 'getTransaction'])->name('get-transaction');

        Route::get('plaid', [App\Http\Controllers\PlaidController::class, 'plaid'])->name('plaid');
        Route::get('plaid/balance', [App\Http\Controllers\PlaidController::class, 'getBalance'])->name('balance');

        Route::get('plaid/institutions', [App\Http\Controllers\PlaidController::class, 'getInstitutions'])->name('institutions');
        Route::get('plaid/institutions-api', [App\Http\Controllers\PlaidController::class, 'getInstitutionsAPI'])->name('institutions-api');

        Route::get('sila/link-account', [App\Http\Controllers\SilaController::class, 'linkAccount'])->name('link-account');
    });
});
