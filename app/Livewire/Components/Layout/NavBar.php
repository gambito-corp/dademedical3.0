<?php

namespace App\Livewire\Components\Layout;

use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavBar extends Component
{
    protected AuthService $authService;

    public $nav_links = [];

    public function boot(AuthService $authService)
    {
        $this->authService = $authService;
    }

    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    public function mount()
    {
        $this->nav_links = [
            [
                'name' => __('dashboard.dashboard'),
                'route' => 'dashboard',
                'active' => request()->routeIs('dashboard'),
                'roles' => ['*'] // Todos los roles pueden ver esto
            ],
            [
                'name' => __('dashboard.users'),
                'route' => 'usuarios.index',
                'active' => request()->routeIs('usuarios.*'),
                'roles' => ['SuperAdmin', 'Dueño', 'Administrador', 'Gerencia'] // Solo estos roles pueden ver esto
            ],
            [
                'name' => __('dashboard.patients'),
                'route' => 'patients.index',
                'active' => request()->routeIs('patients.*'),
                'roles' => ['*'] // Todos los roles pueden ver esto
            ]
        ];

        // Filtrar los enlaces según los roles del usuario
        $this->nav_links = array_filter($this->nav_links, function ($link) {
            if (in_array('*', $link['roles'])) {
                return true;
            }
            return Auth::user()->hasAnyRole($link['roles']);
        });
    }

    public function handlePreviousUserImpersonation()
    {
        try {
            $this->authService->previousUserImpersonation();
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de NavBar de Livewire en el Metodo handlePreviousUserImpersonation: ' . $e->getMessage());
        }
        return redirect()->route('usuarios.index');
    }

    public function handleOriginalUserImpersonation()
    {
        try {
            $this->authService->originalUserImpersonation();
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de NavBar de Livewire en el Metodo handleOriginalUserImpersonation: ' . $e->getMessage());
        }
        return redirect()->route('usuarios.index');
    }

    public function render()
    {
        return view('livewire.components.layout.nav-bar', [
            'nav_links' => $this->nav_links
        ]);
    }
}
