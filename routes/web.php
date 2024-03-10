<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login',[AuthController::class,'indexLogin'])->name('loginView');
Route::get('/register',[AuthController::class,'indexRegister'])->name('registerView');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/login/otp-verification', [AuthController::class, 'otpVerification'])->name('otp_verification');

Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');
// Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])->name('sendotp');
Route::post('/login/resend-otp', [AuthController::class, 'resendOtp'])->name('resend_otp')->middleware('hasOtp');
Route::post('/login/verify-otp',[AuthController::class,'verifyOtp'])->name('verifyOtp')->middleware('hasOtp');

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.index')->middleware('auth','hasOtp');