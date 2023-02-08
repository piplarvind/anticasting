<?php

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\{
    HomeController,
    AboutUsController, 
    ContactUsController,
    MessageController
 };
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;

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
    ->middleware(['guest'])
    ->name('users.register');
Route::get('/validate-email', [RegisterController::class, 'validateUserEmail']);
Route::get('/validate-mobile', [RegisterController::class, 'validateUserMobileNumber']);
Route::post('/register-post', [RegisterController::class, 'submitRegister'])->name('users.registerpost');
Route::get('/login', [LoginController::class, 'login'])
    ->middleware(['guest'])
    ->name('users.login');
Route::post('/login-post', [LoginController::class, 'submitLogin'])->name('users.loginpost');

/*User Forgot Password */
Route::get('/forgotpassword', [ForgotPasswordController::class, 'showForgotPassword'])
    ->middleware(['guest'])
    ->name('users.forgot-password');

Route::post('/forgotpassword-post', [ForgotPasswordController::class, 'submitForgotPassword'])->name('users.forgotpassword-post');
/**
 *  User Reset Password
 */
Route::get('/resetpassword/{token}/{email}', [ForgotPasswordController::class, 'ResetPassword'])->name('users.reset-password');

Route::post('/resetpassword-post', [ForgotPasswordController::class, 'submitResetPassword'])->name('users.resetpasswordpost');

Route::group(['prefix' => 'users', 'middleware' => ['web', 'user']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('users.dashboard');

    /* Change Password  */
    Route::get('/changepassword', [ChangePasswordController::class, 'changePassword'])->name('users.change-password');

    Route::post('/changepassword-post', [ChangePasswordController::class, 'changePasswordPost'])->name('users.changepassword-post');

    /* Submit Profile */
    Route::get('/submitProfile', [\App\Http\Controllers\ProfileController::class, 'submitProfile'])->name('users.submitProfile');
    Route::post('submitProfile-store', [\App\Http\Controllers\ProfileController::class, 'submitProfileStore'])->name('users.submitProfile.store');

    Route::get('/submitProfile/edit/{id}', [\App\Http\Controllers\ProfileController::class, 'editProfile'])->name('users.submitProfile.edit');
    Route::put('submitProfile-update/{id}', [\App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('users.submitProfile.update');
    /*Logout User */
    Route::get('/logout', [LoginController::class, 'logout'])->name('users.logout');
    /* Message*/
    Route::post('message-post',[MessageController::class, 'storeMessage'])->name('users.message');
   // Route::get('/message-show',[MessageController::class, 'showMessage'])->name('users.message.show');
    Route::post('/userimage', [\App\Http\Controllers\ProfileController::class,'uploadUserImage'])->name('users.uploadimage');
});

/*
   Otp
*/
Route::get('/showotp/', [RegisterController::class, 'showOtp'])->middleware(['guest']);

Route::post('/verifyOtp', [RegisterController::class, 'VerifyOtp'])->name('verify.otp');

/*
   Admin Login
*/
Route::get('/admin', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])
    ->middleware(['guest'])
    ->name('admin.login');

Route::post('/admin-post', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'loginSubmit'])->name('admin.loginPost');

/*Admin Forgot Password */
Route::get('/admin/forgotpassword', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showForgotPassword'])
    ->middleware(['guest'])
    ->name('admin.forgot-password');

Route::post('/admin/forgotpassword-post', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'submitForgotPassword'])->name('admin.forgotpassword-post');

/**
 *  Admin Reset Password
 */
Route::get('/admin/resetpassword/{token}/{email}', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'ResetPassword'])->name('admin.reset-password');

Route::post('/admin/resetpassword-post', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'submitResetPassword'])->name('admin.resetpasswordpost');

/* Working on Admin Backend */
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {

    Route::get('/changepassword', [\App\Http\Controllers\Admin\Auth\ChangePasswordController::class, 'changePassword'])->name('admin.changePassword');
    Route::post('/changepassword-post', [\App\Http\Controllers\Admin\Auth\ChangePasswordController::class, 'changePasswordPost'])->name('admin.changePasswordPost');
    Route::get('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logoutAdmin'])->name('admin.logout');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');
});
/* About us */
Route::get('/about', [AboutUsController::class, 'about']);
/* Contact us */
Route::get('/contact', [ContactUsController::class, 'contact']);
/* Home */
Route::get('/', [HomeController::class, 'index'])->name('users.home');
