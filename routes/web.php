<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\Users\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}', NewPasswordController::class)
    ->middleware('guest')
    ->name('password.reset');

Route::middleware([
    'auth',
    'verified',
    'web'
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/users', User::class)->name('usuarios.index');

});



Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


