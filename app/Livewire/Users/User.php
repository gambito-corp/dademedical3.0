<?php

namespace App\Livewire\Users;

use App\Services\Auth\AuthService;
use App\Services\User\UserServices;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    // Inyección de dependencias y propiedades protegidas
    protected UserServices $userService;
    protected AuthService $authService;
    // Propiedades públicas: objetos, colecciones, y primitivas
    public $usuarios, $user;
    public string $currentFilter = 'active', $search = '', $selectedTypeSearch = 'Nombre', $orderColumn = 'id', $orderDirection = 'desc';
    public bool $modalCreate = false, $modalEdit = false, $modalShow = false, $modalImpersonate = false, $modalDelete = false, $modalRestore = false, $modalForceDelete = false, $showDropdown = false, $showDropdownTypeSearch = false;
    public int $paginate = 10;
    public array $paginacion = [10,15,20,25,30,35,40,45,50,60,70,80,90,100,200,300,400,500,1000], $typeSearch = ['name' => 'Nombre', 'email' => 'Correo', 'username' => 'Usuario', 'role' => 'Rol', 'hospital' => 'Hospital'];
    // Métodos del ciclo de vida del componente
    public function boot(UserServices $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }
    public function mount()
    {
        $this->changeUsers('active');
    }
    // Métodos para la gestión de usuarios
    public function changeUsers(string $title)
    {
        $this->currentFilter = $title;
        $this->usuarios = match ($title) {
            'active' => $this->userService->usuariosActivos(),
            'inactive' => $this->userService->usuariosInactivos(),
            'deleted' => $this->userService->allOnlyTrashed(),
        };
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
            return throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo impersonateUser: '. $e->getMessage());
        }
        return redirect()->route('dashboard');
    }
    public function delete(): void
    {
        try {
            $this->userService->delete(userId: $this->user->id);
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo delete: '. $e->getMessage());
        }
        $this->dispatch('closeModal', 'delete', $this->user->id);
    }
    public function restore(): void
    {
        try {
            $this->userService->restore($this->user->id);
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo restore: '. $e->getMessage());
        }
        $this->dispatch('closeModal', 'restore', $this->user->id);
    }
    public function forceDelete(): void
    {
        try {
            $this->userService->forceDelete($this->user->id);
        } catch (\Exception $e) {
            throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo forceDelete: '. $e->getMessage());
        }
        $this->modalForceDelete = false;
    }
    // Métodos auxiliares privados
    private function standarTypeSearch(): string
    {
        return match ($this->selectedTypeSearch) {
            'Correo' => 'email',
            'Usuario' => 'username',
            'Rol' => 'role',
            'Hospital' => 'hospital',
            default => 'name',
        };
    }
    private function filterSearch($usuarios)
    {
        return $usuarios->filter(function ($user) {
            $result = '';
            if($this->selectedTypeSearch == 'Rol')
            {
                foreach ($user->roles as $role)
                {
                    $result .= $role->name;
                }
                return str_contains(strtolower($result), strtolower($this->search));
            }

            if($this->selectedTypeSearch == 'Hospital')
            {
                return str_contains(strtolower($user->hospital->name), strtolower($this->search)) ||
                    str_contains(strtolower($user->hospital->acronimo), strtolower($this->search));
            }
            return str_contains(strtolower($user->{$this->standarTypeSearch()}), strtolower($this->search));
        });
    }
    private function paginateData($usuarios)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $this->paginate;
        $total = $usuarios->count();
        $results = $this->sliceDataForPage($usuarios, $page, $perPage);

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
    }
    private function sliceDataForPage($data, $page, $perPage)
    {
        return $data->slice(($page - 1) * $perPage, $perPage)->all();
    }
    // Métodos para la gestión de modales
    public function openModal(string $type, $userId = null)
    {
        if ($userId !== null) {
            $this->user = $this->userService->findWithTrashed($userId);
        }
//        dd('user: ', $this->user, $type);

        $this->resetModals();

        match ($type) {
            'create' => $this->modalCreate = true,
            'edit' => $this->modalEdit = true,
            'show' => $this->modalShow = true,
            'impersonate' => $this->modalImpersonate = true,
            'delete' => $this->modalDelete = true,
            'restore' => $this->modalRestore = true,
            'forceDelete' => $this->modalForceDelete = true,
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
            'forceDelete' => $this->modalForceDelete = false,
            default => null,
        };
        return redirect()->route('usuarios.index');
    }
    private function resetModals()
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->modalShow = false;
        $this->modalImpersonate = false;
        $this->modalDelete = false;
        $this->modalRestore = false;
        $this->modalForceDelete = false;
    }
    // Métodos para mostrar y ocultar dropdowns
    public function showPagination()
    {
        $this->showDropdown = !$this->showDropdown;
    }
    public function showTypeSearch()
    {
        $this->showDropdownTypeSearch = !$this->showDropdownTypeSearch;
    }
    public function selectedPaginate($paginate)
    {
        $this->paginate = $paginate;
        $this->showDropdown = false;
    }
    public function selectedTypeSearchComponent($type)
    {
        $this->selectedTypeSearch = $type;
        $this->showDropdownTypeSearch = false;
    }
    // Método de renderizado
    public function render()
    {
        $usuariosFiltrados = $this->filterSearch($this->usuarios);
        $data = $this->paginateData($usuariosFiltrados);
        return view('livewire.users.user', compact('data'));
    }
}
