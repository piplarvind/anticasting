<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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





/*
User Register And Login Routing
*/
Route::get('/register', [RegisterController::class, 'register'])
->name('users.register');
Route::post('/register-post', [RegisterController::class, 'submitRegister'])
->name('users.registerpost');
Route::get('/login', [LoginController::class, 'login'])
    ->name('users.login');
Route::post('/login-post', [LoginController::class, 'submitLogin'])
    ->name('users.loginpost');

    Route::get('/', [HomeController::class, 'index'])
    ->name('users.home');

/*User Forgot Password */
Route::get('/forgotpassword', [ForgotPasswordController::class, 'showForgotPassword'])
    ->name('users.forgot-password');

  Route::post('/forgotpassword-post', [ForgotPasswordController::class, 'submitForgotPassword'])
    ->name('users.forgotpassword-post');
/**
 *  User Reset Password
 */
Route::get('/resetpassword/{token}/{email}', [ForgotPasswordController::class, 'ResetPassword'])
    ->name('users.reset-password');

  Route::post('/resetpassword-post', [ForgotPasswordController::class, 'submitResetPassword'])
    ->name('users.resetpasswordpost');

Route::group(['prefix' => 'users'], function () {

   Route::get('/logout', [LoginController::class, 'logout'])
        ->name('users.logout');

    /* Change Password  */
    Route::get('/changepassword', [ChangePasswordController::class, 'changePassword'])
        ->name('users.change-password');

    Route::post('/changepassword-post', [ChangePasswordController::class, 'changePasswordPost'])
        ->name('users.changepassword-post');

});
