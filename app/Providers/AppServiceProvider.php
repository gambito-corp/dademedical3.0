<?php

namespace App\Providers;

use App\Interfaces\Archivo\ArchivoInterface;
use App\Interfaces\Contrato\ContratoInterface;
use App\Interfaces\Diagnostico\DiagnosticoInterface;
use App\Interfaces\Direccion\DireccionInterface;
use App\Interfaces\Incidencia\IncidenciaInterface;
use App\Interfaces\Logs\LogInterface;
use App\Interfaces\Paciente\PacienteInterface;
use App\Interfaces\Telefono\TelefonoInterface;
use App\Interfaces\User\UserInterface;
use App\Repositories\Archivo\ArchivoRepository;
use App\Repositories\Contrato\ContratoRepository;
use App\Repositories\Diagnostico\DiagnosticoRepository;
use App\Repositories\Direccion\DireccionRepository;
use App\Repositories\Incidencia\IncidenciaRepository;
use App\Repositories\Logs\LogsRepository;
use App\Repositories\Paciente\PacienteRepository;
use App\Repositories\Telefono\TelefonoRepository;
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
        $this->app->bind(ArchivoInterface::class, ArchivoRepository::class);
        $this->app->bind(ContratoInterface::class, ContratoRepository::class);
        $this->app->bind(DiagnosticoInterface::class, DiagnosticoRepository::class);
        $this->app->bind(DireccionInterface::class, DireccionRepository::class);
        $this->app->bind(IncidenciaInterface::class, IncidenciaRepository::class);
        $this->app->bind(TelefonoInterface::class, TelefonoRepository::class);
    }

    public function boot(): void
    {
        Fortify::verifyEmailView(function (){
            return view('auth.verify-email');
        });
    }
}
