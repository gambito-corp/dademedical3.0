<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\Logs\LogInterface;
use App\Interfaces\Paciente\PacienteInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Logs\LogsRepository;
use App\Repositories\Paciente\PacienteRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LogInterface::class, LogsRepository::class);
        $this->app->bind(PacienteInterface::class, PacienteRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
