<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\AuthInterface;
use App\Models\User;
use App\Services\Logs\LogService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AuthService2Fake
{
    protected AuthInterface $authService;
    protected LogService $logService;
    public function __construct(AuthInterface $authService, LogService $logService)
    {
        $this->authService = $authService;
        $this->logService = $logService;
    }

    public function login($request)
    {
        return $this->authService->login($request);
    }

    public function register($request)
    {
        return $this->authService->register($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function forgotPassword($request)
    {
        return $this->authService->forgotPassword($request);
    }

    public function resetPassword($request)
    {
        return $this->authService->resetPassword($request);
    }

    public function verifyEmail($request)
    {
        return $this->authService->verifyEmail($request);
    }

    public function resendEmailVerification($request)
    {
        return $this->authService->resendEmailVerification($request);
    }

    public function user()
    {
        return $this->authService->user();
    }

    public function id()
    {
        return $this->authService->id();
    }

    public function updateProfile($request)
    {
        return $this->authService->updateProfile($request);
    }

    public function updatePassword($request)
    {
        return $this->authService->updatePassword($request);
    }

    public function updateEmail($request)
    {
        return $this->authService->updateEmail($request);
    }

    public function updateProfilePicture($request)
    {
        return $this->authService->updateProfilePicture($request);
    }

    public function impersonate(User $user)
    {
        try {
            $originalUser = session()->has('impersonate') ? session('originalUser') : Auth::id();
            session()->has('impersonate') ? session()->push('impersonate', $user->id) : session(['originalUser' => $originalUser]);
            return $this->authService->impersonate($user);
        } catch (\Throwable $th) {
            Log::channel('clear')->error(
                "Error en la suplantación del usuario {$user->name} en el método Impersonate en el Servicio AuthService2Fake: {$th->getMessage()}"
            );
            $this->logService->create(
                entrypoint: 'Servicio Auth',
                message: "Error en la suplantación del usuario {$user->name} en el método Impersonate en el Servicio AuthService2Fake: {$th->getMessage()}",
                stackTrace: $th->getTrace(),
                accion: 'Impersonate User',
                level: 'ERROR',
                comentario: 'Error en la suplantación del usuario'
            );
            throw $th;
        }
    }

    public function backPreviousUser()
    {
        return $this->authService->backPreviousUser();
    }

    public function stopImpersonate()
    {
        return $this->authService->stopImpersonate();
    }



}
