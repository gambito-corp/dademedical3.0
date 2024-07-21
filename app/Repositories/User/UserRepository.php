<?php
namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Spatie\Permission\Models\Role;
use App\Interfaces\User\UserInterface;
use \Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    public function __construct(protected User $user){}
    public function query($orderColumn = 'id', $orderDirection = 'desc')
    {
        $query = $this->user->newQuery();

        if ($orderColumn === 'roles') {
            $query->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->orderBy('roles.name', $orderDirection)
                ->select('users.*');
        } else {
            $query->orderBy($orderColumn, $orderDirection);
        }

        return $query;
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

    /**
     * @throws Exception
     */
    public function forceDelete($id): void
    {
        try {
            $user = User::query()
                ->withTrashed()
                ->with([
                    'Logs',
                    'paciente',
                    'contratosSolicitados',
                    'contratosAprobados',
                    'contratosBajados',
                    'contratosFinalizados'
                ])
                ->where('id', $id)
                ->firstOrFail();
            $user->logs()->forceDelete();
            $user->paciente()->forceDelete();
            $user->contratosSolicitados()->forceDelete();
            $user->contratosAprobados()->forceDelete();
            $user->contratosBajados()->forceDelete();
            $user->contratosFinalizados()->forceDelete();

            $user->forceDelete();
        } catch (Exception $e) {
            throw new Exception('Error en UserRepository::forceDelete: ' . $e->getMessage(), 0, $e);
        } catch (\Error $e) {
            throw new \Error('Error en UserRepository::forceDelete: ' . $e->getMessage(), 0, $e);
        }
    }
}
