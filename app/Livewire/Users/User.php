<?php

namespace App\Livewire\Users;

use App\Livewire\BaseComponent as Component;
use App\Services\Auth\AuthService;
use App\Services\User\UserServices;
use Livewire\Attributes\On;

class User extends Component
{
    protected UserServices $userService;
    protected AuthService $authService;
    public $usuarios, $user;
    public bool $modalCreate = false, $modalEdit = false, $modalShow = false, $modalDelete = false, $modalImpersonate = false, $modalRestore = false;
    public function boot(UserServices $userService, AuthService $authService) : void
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }
    public function mount() : void
    {
        $this->filter = 'active';
    }
    public function render()
    {
        $data = $this->loadUser();
        return view('livewire.users.user', compact('data'));
    }
    public function changeUsers(string $title)
    {
        $this->currentFilter = $title;
        $this->filter = $title;
        $this->resetPage();
    }
    public function loadUser()
    {
        return $this->userService->getUsers(
            $this->search, $this->filter, $this->orderColumn, $this->orderDirection, $this->paginate
        );
    }
    public function canImpersonate($targetUser)
    {
        $currentUser = auth()->user();
        if ($currentUser->id === $targetUser->id) {
            return false;
        }
        $nonImpersonatableRoles = [
            'SuperAdmin' => [],
            'Dueño' => ['SuperAdmin'],
            'Administrador' => ['SuperAdmin', 'Dueño'],
            'Gerencia' => ['SuperAdmin', 'Dueño', 'Administrador', 'Gerencia'],
            'Hospitales' => ['SuperAdmin', 'Dueño', 'Administrador', 'Gerencia', 'Hospitales'],
            'Medicos' => ['SuperAdmin', 'Dueño', 'Administrador', 'Gerencia', 'Hospitales', 'Medicos'],
            'Pacientes' => ['SuperAdmin', 'Dueño', 'Administrador', 'Gerencia', 'Hospitales', 'Medicos', 'Pacientes'],
        ];
        foreach ($nonImpersonatableRoles as $role => $prohibitedRoles) {
            if ($currentUser->hasRole($role)) {
                if (in_array($role, ['Gerencia', 'Hospitales', 'Medicos', 'Pacientes']) && $currentUser->hospital_id !== $targetUser->hospital_id) {
                    return false;
                }

                foreach ($prohibitedRoles as $prohibitedRole) {
                    if ($targetUser->hasRole($prohibitedRole)) {
                        return false;
                    }
                }
                return true;
            }
        }
        return false;
    }
    public function impersonateUser()
    {
        try {
            $this->authService->ImpersonateUser(usuario: $this->user);
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo impersonateUser: ' . $e->getMessage());
        }
        return redirect()->route('dashboard');
    }
    public function delete(): void
    {
        try {
            $this->userService->delete(userId: $this->user->id);
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo delete: ' . $e->getMessage());
        }
        $this->dispatch('closeModal', 'delete', $this->user->id);
    }
    public function restore(): void
    {
        try {
            $this->userService->restore($this->user->id);
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo restore: ' . $e->getMessage());
        }
        $this->dispatch('closeModal', 'restore', $this->user->id);
    }
    public function openModal(string $type, $userId = null):void
    {
        if ($userId !== null) {
            $this->user = $this->userService->findWithTrashed($userId);
        }

        $this->resetModals();

        match ($type) {
            'create' => $this->modalCreate = true,
            'edit' => $this->modalEdit = true,
            'show' => $this->modalShow = true,
            'impersonate' => $this->modalImpersonate = true,
            'delete' => $this->modalDelete = true,
            'restore' => $this->modalRestore = true,
            default => null,
        };
    }
    #[On('closeModal')]
    public function closeModal(string $type, $userId = null)
    {
        if ($userId !== null) {
            $this->user = null;
        }

        match ($type) {
            'create' => $this->modalCreate = false,
            'edit' => $this->modalEdit = false,
            'show' => $this->modalShow = false,
            'impersonate' => $this->modalImpersonate = false,
            'delete' => $this->modalDelete = false,
            'restore' => $this->modalRestore = false,
            default => null,
        };
    }
    private function resetModals()
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->modalShow = false;
        $this->modalImpersonate = false;
        $this->modalDelete = false;
        $this->modalRestore = false;
    }
}
