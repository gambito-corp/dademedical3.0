<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\Users\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth',
    'verified',
    'web'
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/users', User::class)->name('usuarios.index');

});




