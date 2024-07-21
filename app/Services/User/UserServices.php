<?php
namespace App\Services\User;

use App\Interfaces\User\UserInterface;
use App\Models\User;
use App\Services\Logs\LogService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;


class UserServices
{
    public Collection $usuarios; // Corregir la declaración de la propiedad $usuarios
    protected string $originalPassword;
    protected bool $randomPassword = false;

    public function __construct(protected UserInterface $userRepository, protected LogService $logService){}

    public function getUsers(string $search, string $filter, string $orderColumn, string $orderDirection, int $paginate): LengthAwarePaginator
    {
        $query = $this->userRepository->query($orderColumn, $orderDirection);

        $query = match ($filter) {
            'active' => $query->whereNull('users.deleted_at'),
            'inactive' => $query->onlyTrashed(),
            'deleted' => $query->onlyTrashed(),
        };

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('CONCAT(users.name, " ", users.surname) like ?', ["%{$search}%"])
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('users.username', 'like', "%{$search}%")
                    ->orWhereHas('roles', function($q) use ($search) {
                        $q->where('roles.name', 'like', "%{$search}%");
                    });
            });
        }

        return $query->paginate($paginate);
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
        $this->manageRelatedData($data);
        $this->manageProfileData($data);
        $this->managePasswordData($data);

        $user = $this->createUser($data);
        if (!$user) {
            throw new Exception('No se pudo crear el usuario.');
        }

        $this->sendEmailToUser($user);

        $authUser = $this->find(Auth::id());
        if (session()->has('originalUser')) {
            $authUser = $this->find(session('originalUser'));
        }

        $this->logService->create(
             entrypoint: self::class,
            message: "El Usuario Fue Creado Por: $authUser->name $authUser->surname, el cual tiene el Nickname de $authUser->username"
        );

        return $user;
    }

    public function delete(int $userId): bool
    {
        $authUser = $this->find(Auth::id());
        if (session()->has('originalUser')) {
            $authUser = $this->find(session('originalUser'));
        }
        try {
            $this->userRepository->delete($userId);
            $this->logService->create(
                entrypoint: self::class,
                message: "El Usuario Fue Eliminado Por: $authUser->name $authUser->surname, el cual tiene el Nickname de $authUser->username"
            );
            return true;
        } catch (Exception $e) {
            throw new Exception('Error en UserService::delete: ' . $e->getMessage(), 0);
        }
    }

    public function findWithTrashed(mixed $userId): ?User
    {
        return $this->userRepository->findWithTrashed($userId);
    }

    public function update(User $usuario, array $data): User|Collection|null
    {
        try {
            $this->manageRelatedData($data);
            return $this->userRepository->update($usuario, $data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::update: ' . $e->getMessage(), 0);
        }
    }

    private function createUser(array $data): ?User
    {
        try {
            return $this->userRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::createUser: ' . $e->getMessage(), 0);
        }
    }

    private function updatedUser(User $usuario, array $data): ?User
    {
        try {
            return $this->userRepository->update($usuario, $data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::updateUser: ' . $e->getMessage(), 0);
        }
    }

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function storeProfilePhoto($file): ?string
    {
        $filename = null;

        if ($file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('', $filename, 'profile_photos');
        }

        return $filename;
    }

    private function sendEmailToUser(User $user)
    {
        $user->sendEmailVerificationNotification($this->originalPassword);
    }

    private function manageProfileData(array &$data): void
    {
        if (isset($data['profile_photo_path'])) {
            $data['profile_photo_path'] = $this->storeProfilePhoto($data['profile_photo_path']);
        }
    }

    private function manageRelatedData(array &$data): void
    {
        if (isset($data['role'])) {
            $data['rol'] = $data['role'];
            unset($data['role']);
        }
        if (isset($data['hospital'])) {
            $data['hospital_id'] = $data['hospital'];
            unset($data['hospital']);
        }
    }

    private function managePasswordData(array &$data): void
    {
        if (empty($data['password'])) {
            $data['password'] = Str::random(8);
            $this->randomPassword = true;
        }
        $this->originalPassword = $data['password'];
    }

    public function restore(int $userId): bool
    {
        $authUser = $this->find(Auth::id());
        if (session()->has('originalUser')) {
            $authUser = $this->find(session('originalUser'));
        }
        try {
            $this->userRepository->restore($userId);
            $this->logService->create(
                entrypoint: self::class,
                message: "El Usuario Fue Restaurado Por: $authUser->name $authUser->surname, el cual tiene el Nickname de $authUser->username"
            );
            return true;
        } catch (Exception $e) {
            throw new Exception('Error en UserService::restore: ' . $e->getMessage(), 0);
        }
    }

    /**
     * @throws Exception
     */
    public function forceDelete(int $userId): bool
    {
        $authUser = $this->find(Auth::id());

        if (session()->has('originalUser')) {
            $authUser = $this->find(session('originalUser'));
        }

        try {
            DB::beginTransaction();

            $user = $this->findWithTrashed($userId);

            if ($user->hasRole('Medicos')) {
                $medicos = $this->userRepository->all()->filter(function ($medico) use ($user) {
                    return $medico->hasRole('Medicos') && $medico->hospital_id == $user->hospital_id && $medico->id != $user->id;
                });

                if ($medicos->count() == 1) {
                    $medico = $medicos->first();
                    $user->citas()->update(['medico_id' => $medico->id]);
                    $user->recetas()->update(['medico_id' => $medico->id]);
                    $user->historias()->update(['medico_id' => $medico->id]);
                }
            }

            $this->userRepository->forceDelete($userId);

            $this->logService->create(
                entrypoint: self::class,
                message: "El Usuario Fue Eliminado Definitivamente Por: {$authUser->name} {$authUser->surname}, el cual tiene el Nickname de {$authUser->username}"
            );

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error en UserService::forceDelete: ' . $e->getMessage(), 0, $e);
        }
    }
}
