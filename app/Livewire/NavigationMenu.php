<?php

namespace App\Livewire;

//use App\Services\Logs\LogService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationMenu extends Component
{
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

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
