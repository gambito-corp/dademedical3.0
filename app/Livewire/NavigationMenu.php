<?php

namespace App\Livewire;

//use App\Services\Logs\LogService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationMenu extends Component
{
//    protected LogService $logService;
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

//    public function boot(LogService $logService)
//    {
//        $this->logService = $logService;
//    }

    public function desimpersonacionParcial()
    {
////        dd(session('impersonate'));
//        $this->logService->create('DesimpersonacionParcial');
//        $usuario = session('impersonate')[count(session('impersonate')) - 2];
//        session()->forget('impersonate.' . (count(session('impersonate')) - 1));
//        Auth::login($usuario);
//        return redirect()->route('dashboard');
    }

    public function desimpersonacionTotal()
    {
//        $this->logService->create('DesimpersonacionTotal');
//        $usuario = session('originalUser');
//        Auth::login($usuario);
//        session()->forget('impersonate');
//        session()->forget('originalUser');
//        return redirect()->route('dashboard');
    }

//$this->logService->create(
//entrypoint: 'Servicio Auth',
//message: "Error en la suplantación del usuario {$user->name} en el método Impersonate en el Servicio AuthService2Fake: {$th->getMessage()}",
//stackTrace: $th->getTrace(),
//                accion: 'Impersonate User',
//                level: 'ERROR',
//                comentario: 'Error en la suplantación del usuario'
//            );
//            throw $th;

    public function render()
    {
        return view('navigation-menu');
    }

    public function handlePreviousUserImpersonation()
    {
        dd(session('impersonate'));
        $impersonate = session('impersonate');
        $user = array_pop($impersonate);
        Auth::loginUsingId($user);
        session(['impersonate' => $impersonate]);
        return redirect()->route('dashboard');
    }

    public function handleOriginalUserImpersonation()
    {
        // Código para manejar la personificación del usuario original aquí
    }

}
