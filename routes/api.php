<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('email-registration', [App\Http\Controllers\AuthWebservicesController::class, 'emailRegistration']);
Route::post('mobile-registration', [App\Http\Controllers\AuthWebservicesController::class, 'mobileRegistration']);
Route::post('fb-registration', [App\Http\Controllers\AuthWebservicesController::class, 'fbRegistration']);
Route::post('email-login', [App\Http\Controllers\AuthWebservicesController::class, 'emailLogin']);
Route::post('mobile-login', [App\Http\Controllers\AuthWebservicesController::class, 'mobileLogin']);
Route::post('mobile-login-otp', [App\Http\Controllers\AuthWebservicesController::class, 'mobileLoginOTP']);
Route::post('forgot-password', [App\Http\Controllers\AuthWebservicesController::class, 'forgotpassword']);
Route::post('logout', [App\Http\Controllers\AuthWebservicesController::class, 'logout']);

Route::get('global-fee', [App\Http\Controllers\WebservicesController::class, 'globalFee']);
Route::get('receiving-countries', [App\Http\Controllers\WebservicesController::class, 'receivingCountries']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('user-list', [App\Http\Controllers\WebservicesController::class, 'userList']);
    Route::post('recipient-list', [App\Http\Controllers\WebservicesController::class, 'recipientList']);
    Route::post('add-edit-recipient', [App\Http\Controllers\WebservicesController::class, 'addEditRecipient']);
    Route::post('view-profile', [App\Http\Controllers\WebservicesController::class, 'viewProfile']);
    Route::post('edit-profile', [App\Http\Controllers\WebservicesController::class, 'editProfile']);

    Route::post('change-send-to-country', [App\Http\Controllers\WebservicesController::class, 'changeSendToCountry']);
    Route::post('current-rate', [App\Http\Controllers\WebservicesController::class, 'currentRate']);
    Route::post('get-payers', [App\Http\Controllers\WebservicesController::class, 'getPayers']);

    Route::post('get-delivery-location', [App\Http\Controllers\WebservicesController::class, 'getDeliveryLocation']);
    
    Route::post('get-send-money', [App\Http\Controllers\WebservicesController::class, 'getSendMoneyDetail']);
    Route::post('save-send-money-one', [App\Http\Controllers\WebservicesController::class, 'saveSendMoneyStepOne']);
    Route::post('save-send-money-two', [App\Http\Controllers\WebservicesController::class, 'saveSendMoneyStepTwo']);

    Route::post('get-recipient', [App\Http\Controllers\WebservicesController::class, 'getRecipientDetail']);
    Route::post('save-recipient-one', [App\Http\Controllers\WebservicesController::class, 'saveRecipientStepOne']);
    Route::post('save-recipient-two', [App\Http\Controllers\WebservicesController::class, 'saveRecipientStepTwo']);

    Route::post('get-sender', [App\Http\Controllers\WebservicesController::class, 'getSenderDetail']);
    Route::post('save-sender-one', [App\Http\Controllers\WebservicesController::class, 'saveSenderStepOne']);
    Route::post('save-sender-two', [App\Http\Controllers\WebservicesController::class, 'saveSenderStepTwo']);
    Route::post('save-sender-three', [App\Http\Controllers\WebservicesController::class, 'saveSenderStepThree']);

    Route::post('get-payment-page-detail', [App\Http\Controllers\WebservicesController::class, 'getPaymentPageDetail']);
    Route::post('save-payment-page-detail', [App\Http\Controllers\WebservicesController::class, 'savePaymentPageDetail']);

    Route::post('get-payment-confirmation-step-one', [App\Http\Controllers\WebservicesController::class, 'getPaymentConfirmationStepOne']);
    Route::post('get-payment-confirmation-step-two', [App\Http\Controllers\WebservicesController::class, 'getPaymentConfirmationStepTwo']);

    Route::post('payment-resend-otp', [App\Http\Controllers\WebservicesController::class, 'paymentResendOTP']);
    Route::post('save-payment-confirmation', [App\Http\Controllers\WebservicesController::class, 'savePaymentConfirmation']);
    
});

