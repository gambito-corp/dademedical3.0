<?php
namespace App\Interfaces\User;
use App\Models\User;
use \Illuminate\Database\Eloquent\Collection;
interface UserInterface
{
    public function query($orderColumn = 'id', $orderDirection = 'desc');
    public function find($id): Collection|User|null;
    public function findWithTrashed($id): Collection|User|null;
    public function all(): Collection;
    public function usuariosActivos(): Collection;
    public function usuariosInactivos(): Collection;
    public function allWithTrashed(): Collection;
    public function allOnlyTrashed(): Collection;
    public function create(array $data): Collection|User|null;
    public function update(User $usuario, array $data): Collection|User|null;
    public function restore($id): Collection|User|null;
    public function delete($id): void;
    public function forceDelete($id): void;
}
