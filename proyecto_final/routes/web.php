<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FriendRequestsController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::view('/', 'welcome');
Route::view('login', 'login')->name('login')->middleware('guest');
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified']);
Route::view('register', 'register')->name('register')->middleware('guest');
Route::view('google-register', 'google-register')->middleware('guest');
Route::view('reset', 'auth.passwords.email');
Auth::routes(['verify' => true]);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);
// Por hacer, forgot password, reset password, etc.
// Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('/password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/register/google', [GoogleController::class, 'register']);


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
// Route::post('/password/reset', function (Request $request) {
//     $request->user()->sendPasswordResetNotification($request->password);
 
//     return back()->with('message', 'Password reset link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('password.send');

Route::get('/auth/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');
Route::resource('/notes', NotesController::class)->middleware(['auth', 'verified']);
Route::resource('/users', UsersController::class)->middleware(['auth', 'verified']);
Route::resource('/requests', FriendRequestsController::class)->middleware(['auth', 'verified']);
Route::resource('/friends', FriendsController::class)->middleware(['auth', 'verified']);
Route::delete('/friends/{id}', [FriendsController::class, 'destroy'])->middleware(['auth', 'verified']);
Route::delete('/requests/cancel/', [FriendRequestsController::class, 'destroy'])->middleware(['auth', 'verified']);
Route::delete('/requests/reject/', [FriendRequestsController::class, 'test'])->middleware(['auth', 'verified']);