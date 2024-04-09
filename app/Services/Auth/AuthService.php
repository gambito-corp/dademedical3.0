<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Logs\LogService;
use App\Services\User\UserServices;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected LogService $logService;
    protected UserServices $userServices;

    public function __construct(
        LogService      $logService,
        UserServices    $userServices
    )
    {
        $this->logService = $logService;
        $this->userServices = $userServices;
    }

    private function logImpersonatingUser($impersonatedUser)
    {
        $this->logService->create(
            entrypoint: 'AuthService',
            message: sprintf('Impersonando al Usuario %s', $impersonatedUser),
        );
    }
    private function logDesimpersonation($functionName)
    {
        $this->logService->create(
            entrypoint: 'AuthService',
            message: sprintf('Desimpersonando Usuario en la Funcion %s de la Clase AuthService', $functionName),
        );
    }

    public function ImpersonateUser(User $usuario)
    {
        $this->manageSession(Auth::id());
        $this->logImpersonatingUser($usuario->name);
        Auth::login($usuario);
    }

    private function manageSession($userID)
    {
        $originalUser = session()->has('impersonate') ? session('originalUser') : $userID;
        session()->has('impersonate') ? session()->push('impersonate', $userID) : session(['impersonate' => [$originalUser]]);
        session()->has('originalUser') ?: session(['originalUser' => $originalUser]);
    }

    public function previousUserImpersonation()
    {
        $impersonateArray = session('impersonate');
        $user = array_pop($impersonateArray);
        $this->logDesimpersonation(__FUNCTION__);

        if (empty($impersonateArray)) {
            $this->executeUserAndClearSession($user);
            return;
        }

        session(['impersonate' => $impersonateArray]);
        Auth::loginUsingId($user);
    }

    public function originalUserImpersonation()
    {
        $originalUser = session('originalUser');
        $this->logDesimpersonation(__FUNCTION__);
        $this->executeUserAndClearSession($originalUser);
    }

    private function executeUserAndClearSession($userId)
    {
        Auth::loginUsingId($userId);
        session()->forget('impersonate');
        session()->forget('originalUser');
    }
}
