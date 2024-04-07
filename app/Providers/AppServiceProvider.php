<?php

namespace App\Providers;

use App\Interfaces\Logs\LogInterface;
use App\Interfaces\Paciente\PacienteInterface;
use App\Interfaces\User\UserInterface;
use App\Repositories\Logs\LogsRepository;
use App\Repositories\Paciente\PacienteRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(LogInterface::class, LogsRepository::class);
        $this->app->bind(PacienteInterface::class, PacienteRepository::class);
    }

    public function boot(): void
    {
        Fortify::verifyEmailView(function (){
            return view('auth.verify-email');
        });
    }
}
