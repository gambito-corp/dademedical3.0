<?php

namespace App\Livewire\Components\Layout;

//use App\Services\Logs\LogService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavBar extends Component
{

//    protected LogService $logService;
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

//    public function boot(LogService $logService)
//    {
//        $this->logService = $logService;
//    }

//$this->logService->create(
//entrypoint: 'Servicio Auth',
//message: "Error en la suplantación del usuario {$user->name} en el método Impersonate en el Servicio AuthService2Fake: {$th->getMessage()}",
//stackTrace: $th->getTrace(),
//                accion: 'Impersonate User',
//                level: 'ERROR',
//                comentario: 'Error en la suplantación del usuario'
//            );
//            throw $th;


    public function handlePreviousUserImpersonation()
    {
        $impersonate = session('impersonate');
        $user = array_pop($impersonate);
        Auth::loginUsingId($user);
        session(['impersonate' => $impersonate]);
        return redirect()->route('usuarios.index');
    }

    public function handleOriginalUserImpersonation()
    {
        $originalUser = session('originalUser');
        Auth::loginUsingId($originalUser);
        session()->forget('impersonate');
        session()->forget('originalUser');
        return redirect()->route('usuarios.index');
    }

    public function render()
    {
        return view('livewire.components.layout.nav-bar');
    }

}
