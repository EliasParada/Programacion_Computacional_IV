<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::view('/', 'welcome');
Route::view('login', 'login')->name('login')->middleware('guest');
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified']);
Route::view('register', 'register')->name('register')->middleware('guest');
Auth::routes(['verify' => true]);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);
// Por hacer, forgot password, reset password, etc.
// Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::post('/password/reset', [ResetPasswordController::class, 'reset']);
// For now, login with google


Route::get('/storage', function ($path) {
    return $path;
});

Route::get('/', function () {
    if (Auth::check()) {
        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect('/email/verify');
        }
    }
    return view('welcome');
});
Route::get('/email/verify', function () {
    if (Auth::user()->hasVerifiedEmail()) {
        return redirect('/dashboard');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/auth/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');