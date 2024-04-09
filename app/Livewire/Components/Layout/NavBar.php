<?php

namespace App\Livewire\Components\Layout;

//use App\Services\Logs\LogService;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavBar extends Component
{

    protected AuthService $authService;

    public function boot(
        AuthService $authService
    )
    {
        $this->authService = $authService;
    }
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    public function handlePreviousUserImpersonation()
    {
        try {
            $this->authService->previousUserImpersonation();
        }catch (\Exception $e){
            return throw new \Exception('Error en el Controlador de NavBar de Livewire en el Metodo handlePreviousUserImpersonation: '. $e->getMessage());
        }
        return redirect()->route('usuarios.index');
    }

    public function handleOriginalUserImpersonation()
    {
        try {
            $this->authService->originalUserImpersonation();
        }catch (\Exception $e)
        {
            return throw new \Exception('Error en el Controlador de NavBar de Livewire en el Metodo handleOriginalUserImpersonation: '. $e->getMessage());
        }
        return redirect()->route('usuarios.index');
    }

    public function render()
    {
        return view('livewire.components.layout.nav-bar');
    }

}
