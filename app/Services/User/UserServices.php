<?php
namespace App\Services\User;

use App\Interfaces\User\UserInterface;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Logs\LogService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserServices
{
    public Collection $usuarios; // Corregir la declaración de la propiedad $usuarios
    protected UserInterface $userRepository;
    protected LogService $logService;
    protected string $originalPassword;
    protected bool $randomPassword = false;

    public function __construct(
        UserInterface $userRepository,
        LogService    $logService,
    )
    {
        $this->userRepository = $userRepository;
        $this->logService = $logService;
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

    /**
     * @throws Exception
     */
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


        $authUser = $this->find(id: Auth::id());
        if(session()->has('originalUser'))
        {
            $authUser = $this->find(id: session('originalUser'));
        }


        $this->logService->create(
            entrypoint: self::class,
            message: "El Usuario Fue Eliminado Por : $user->name $user->surname, el cual tiene el Nickname  de $user->username"
        );

        return $user;
    }

    public function delete(int $userId)
    {
        $authUser = $this->find(id: Auth::id());
        if(session()->has('originalUser'))
        {
            $authUser = $this->find(id: session('originalUser'));
        }
        try {
            $this->userRepository->delete(id: $userId);
            $this->logService->create(
                entrypoint: self::class,
                message: "El Usuario Fue Eliminado Por : $authUser->name $authUser->surname, el cual tiene el Nickname  de $authUser->username"
            );
            return true;
        }catch (\Exception $e){
            throw new Exception('Error en UserService::delete: ' . $e->getMessage(), 0);
        }

    }

    public function findWithTrashed(mixed $userId)
    {
        return $this->userRepository->findWithTrashed($userId);
    }

    /**
     * @throws Exception
     */
    public function update(User $usuario, array $data): User|Collection|null
    {
        try {
            $this->manageRelatedData($data);
            return $this->userRepository->update($usuario, $data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::update: ' . $e->getMessage(), 0);
        }
    }

    private function createUser($data){
        try {
            return $this->userRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::createUser: ' . $e->getMessage(), 0);
        }
    }
    private function updatedUser(User $usuario, array $data)
    {
        try {
            return $this->userRepository->update($usuario, $data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::createUser: ' . $e->getMessage(), 0);
        }
    }

    public function find($id): User|Collection|null
    {
        return $this->userRepository->find($id);
    }

    public function storeProfilePhoto($file): ?string
    {
        $filename = null;

        if ($file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('',$filename, 'profile_photos');
        }

        return $filename;
    }


    private function sendEmailToUser(User $user)
    {
        $user->sendEmailVerificationNotification($this->originalPassword);
    }

    private function manageProfileData(&$data): void
    {
        if($data['profile_photo_path']){
            $data['profile_photo_path'] = $this->storeProfilePhoto($data['profile_photo_path']);
        }
    }
    private function manageRelatedData(array &$data)
    {
        if(isset($data['role'])) {
            $data['rol'] = $data['role'];
            unset($data['role']);
        }
        if(isset($data['hospital'])) {
            $data['hospital_id'] = $data['hospital'];
            unset($data['hospital']);
        }
    }

    private function managePasswordData(array &$data)
    {
        if(empty($data['password'])){
            $data['password'] = Str::random(8);
        }
        $this->originalPassword = $data['password'];
    }

    public function restore(int $userId)
    {
        $authUser = $this->find(id: Auth::id());
        if(session()->has('originalUser'))
        {
            $authUser = $this->find(id: session('originalUser'));
        }
        try {
            $this->userRepository->restore(id: $userId);
            $this->logService->create(
                entrypoint: self::class,
                message: "El Usuario Fue Restaurado Por : $authUser->name $authUser->surname, el cual tiene el Nickname  de $authUser->username"
            );
            return true;
        }catch (\Exception $e){
            throw new Exception('Error en UserService::delete: ' . $e->getMessage(), 0);
        }

    }


    public function forceDelete(int $userId)
    {
        $authUser = $this->find(id: Auth::id());
        if(session()->has('originalUser'))
        {
            $authUser = $this->find(id: session('originalUser'));
        }
        try {
            $this->userRepository->forceDelete(id: $userId);
            $this->logService->create(
                entrypoint: self::class,
                message: "El Usuario Fue Eliminado Definitivamente Por : $authUser->name $authUser->surname, el cual tiene el Nickname  de $authUser->username"
            );
            return true;
        }catch (\Exception $e){
            throw new Exception('Error en UserService::delete: ' . $e->getMessage(), 0);
        }

    }

}
