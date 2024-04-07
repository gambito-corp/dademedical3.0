<?php

namespace App\Livewire\Users;

//use App\Services\Auth\AuthService2Fake;
use App\Services\Logs\LogService;
use App\Services\User\UserServices;
use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Mockery\Exception;

class User extends Component
{
    use WithPagination;

    protected UserServices $userService;
    protected LogService $logService;
//    protected AuthService2Fake $authService;

    //objetos y colecciones
    public $usuarios;
    public $user;

    //primitivas
    public string $currentFilter = 'active';
    public bool $modalCreate = false;
    public bool $modalEdit = false;
    public bool $modalImpersonate;

    public bool $modalDelete = false;
    public bool $modalRestore = false;
    public bool $showDropdown = false;
    public bool $showDropdownTypeSearch = false;
    public string $search = '';
    public int $paginate = 10;
    public array $paginacion = [10,15,20,25,30,35,40,45,50,60,70,80,90,100,200,300,400,500,1000];
    public array $typeSearch = ['name' => 'Nombre', 'email' => 'Correo', 'username' => 'Usuario', 'role' => 'Rol', 'hospital' => 'Hospital'];
    public string $selectedTypeSearch = 'Nombre';
    public $orderColumn = 'id';
    public $orderDirection = 'desc';

    public function boot(
        UserServices $userService,
//        LogService $logService,
//        AuthService2Fake $authService
    )
    {
        $this->userService = $userService;
//        $this->logService = $logService;
//        $this->authService = $authService;
    }

    public function mount()
    {
        $this->changeUsers('active');
    }

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

    public function openModal(string $type, $userId = null)
    {
        if ($userId !== null) {
            $this->user = $this->userService->find($userId);
        }

        $this->resetModals();

        match ($type) {
            'create' => $this->modalCreate = true,
            'edit' => $this->modalEdit = true,
            'impersonate' => $this->modalImpersonate = true,
            'delete' => $this->modalDelete = true,
            'restore' => $this->modalRestore = true,
            default => null,
        };
    }

    private function resetModals()
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->modalImpersonate = false;
        $this->modalDelete = false;
        $this->modalRestore = false;
    }

    #[On('closeModal')]
    public function closeModal(string $type, $userId = null)
    {
        if ($userId !== null) {
            $this->user = null;
        }

        match ($type) {
            'create' => $this->closeCreate(),
            'edit' => $this->modalEdit = false,
            'impersonate' => $this->modalImpersonate = false,
            'delete' => $this->modalDelete = false,
            'restore' => $this->modalRestore = false,
        };
    }

    public function closeCreate()
    {
        $this->modalCreate = false;
    }

    public function impersonateUser()
    {

        try {

        } catch (\Exception $e) {
            return throw new \Exception('Error en el Controlador de Usuarios de Livewire en el Metodo impersonateUser de Logs... URGENTE REVISION: '. $e->getMessage());
        }

        $originalUser = session()->has('impersonate') ? session('originalUser') : Auth::id();
        session()->has('impersonate') ? session()->push('impersonate', Auth::id()) : session(['impersonate' => [$originalUser]]);
        session()->has('originalUser') ?: session(['originalUser' => $originalUser]);
        Auth::login($this->user);
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $usuariosFiltrados = $this->filterSearch($this->usuarios);
        $data = $this->paginateData($usuariosFiltrados);
        return view('livewire.users.user', compact('data'));
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
}
