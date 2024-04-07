<?php
namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Services\Logs\LogService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserServices
{
    public Collection $usuarios; // Corregir la declaración de la propiedad $usuarios
    protected UserRepositoryInterface $userRepository;
    protected LogService $logService;
    protected string $originalPassword;
    protected bool $randomPassword = false;

    public function __construct(
        UserRepositoryInterface $userRepository,
        LogService $logService
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

    private function createUser($data){
        try {
            return $this->userRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error en UserService::createUser: ' . $e->getMessage(), 0);
        }
    }

    /**
     * @throws Exception
     */
    public function create(array $data): User|Collection|null
    {
        $this->manageProfileData($data);

        $user = $this->createUser($data);
        if (!$user) {
            throw new Exception('No se pudo crear el usuario.');
        }

        $this->sendEmailToUser($user);

        $this->logService->create(
            entrypoint: self::class,
            message: 'El Usuario Fue Creado Por : '
        );

        return $user;
    }

    /**
     * @throws Exception
     */
    public function update(User $usuario, array $data): User|Collection|null
    {
        try {
            return $this->userRepository->update($usuario, $data);
        } catch (Exception $e) {
            throw new Exception('Error en CrudService::update: ' . $e->getMessage(), 0);
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
        if(empty($data['password'])){
            $data['password'] = Str::random(8);
        }
        $this->originalPassword = $data['password'];
        if(isset($data['role'])) {
            $data['rol'] = $data['role'];
            unset($data['role']);
        }
        if(isset($data['hospital'])) {
            $data['hospital_id'] = $data['hospital'];
            unset($data['hospital']);
        }
    }


}
