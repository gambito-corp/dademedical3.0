<?php
namespace App\Repositories\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Interfaces\User\UserInterface;
use \Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    protected User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function find($id): Collection|User|null
    {
        return $this->user->find($id);
    }
    public function findWithTrashed($id): Collection|User|null
    {
        return $this->user->withTrashed()->find($id);
    }
    public function all(): Collection
    {
        return $this->user->all();
    }
    public function usuariosActivos(): Collection
    {
        return $this->user->whereNotNull('email_verified_at')->get();
    }
    public function usuariosInactivos(): Collection
    {
        return $this->user->whereNull('email_verified_at')->get();
    }
    public function allWithTrashed(): Collection
    {
        return $this->user->withTrashed()->get();
    }
    public function allOnlyTrashed(): Collection
    {
        return $this->user->onlyTrashed()->get();
    }
    public function create($data): Collection|User|null
    {
        try {
            $usuario = [
                'hospital_id' => $data['hospital_id'],
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'profile_photo_path' => $data['profile_photo_path'],
                'activo' => '1',
            ];
            $user = $this->user->create($usuario);
            $role = Role::query()->find($data['rol']);
            $user->assignRole($role);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception('Error en UserRepository::create: ' . $e->getMessage(), $e->getCode());
        } catch (\Error $e) {
            throw new \Error('Error en UserRepository::create: ' . $e->getMessage(), $e->getCode());
        }
    }
    public function update( $usuario, $data): User
    {
        $usuario->update(array_filter($data));
        return $usuario;
    }
    public function restore($id): Collection|User|null
    {
        $user = $this->findWithTrashed($id);
        $user->restore();
        return $user;
    }
    public function delete($id): void
    {
        $user = $this->find($id);
        $user->delete();
    }
    public function forceDelete($id): void
    {
        $user = $this->findWithTrashed($id);
        $user->forceDelete();
    }
}
