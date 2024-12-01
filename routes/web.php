<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Contracts\Contract;
use App\Livewire\Contracts\ContractShow;
use App\Livewire\Incidences\Incidence;
use App\Livewire\Inventory\Inventory;
use App\Livewire\Patients\Patient;
use App\Livewire\Users\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;

// redireccion forzosa a la pagina de login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación.
Route::get('/reset-password/{token}', NewPasswordController::class)
    ->middleware('guest')
    ->name('password.reset');

// Rutas protegidas que requieren autenticación y verificación de correo electrónico.
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/users', User::class)->name('usuarios.index');
    Route::get('/patients', Patient::class)->name('patients.index');
    Route::get('/incidences', Incidence::class)->name('incidences.index');
    Route::get('/inventory', Inventory::class)->name('inventory.index');
    Route::get('/contracts', Contract::class)->name('contracts.index');
    Route::get('/contract/show/{contract}', ContractShow::class)->name('contracts.show');
});

// Rutas de verificación de correo electrónico.
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

Route::get('archives/{id}', [ArchivoController::class, 'getFile'])->name('archives.get');
