<?php
namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserServices
{
    public Collection $usuarios; // Corregir la declaración de la propiedad $usuarios
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function usuariosActivos(): Collection
    {
        return $this->userRepository->usuariosActivos();
    }

    public function usuariosInactivos(): Collection
    {
        return $this->userRepository->usuariosInactivos();
    }

    public function allOnlyTrashed(): Collection
    {
        return $this->userRepository->allOnlyTrashed();
    }

    public function create(array $data): User|Collection|null
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception('Error en CrudService::create: ' . $e->getMessage(), 0);
        }
    }

    public function update(User $usuario, array $data): User|Collection|null
    {
        try {
            return $this->userRepository->update($usuario, $data);
        } catch (\Exception $e) {
            throw new \Exception('Error en CrudService::update: ' . $e->getMessage(), 0);
        }
    }

    public function find($id): User|Collection|null
    {
        return $this->userRepository->find($id);
    }

}
