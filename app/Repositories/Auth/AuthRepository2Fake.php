<?php
//
//namespace App\Repositories\Auth;
//
//use App\Interfaces\Auth\AuthInterface;
//use App\Services\Logs\LogService;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
//
//class AuthRepository implements AuthInterface
//{
//    protected LogService $logService;
//    public function __construct(LogService $logService)
//    {
//        $this->logService = $logService;
//    }
//
//    public function login($request)
//    {
//        // TODO: Implement login() method.
//    }
//
//    public function register($request)
//    {
//        // TODO: Implement register() method.
//    }
//
//    public function logout()
//    {
//        // TODO: Implement logout() method.
//    }
//
//    public function forgotPassword($request)
//    {
//        // TODO: Implement forgotPassword() method.
//    }
//
//    public function resetPassword($request)
//    {
//        // TODO: Implement resetPassword() method.
//    }
//
//    public function verifyEmail($request)
//    {
//        // TODO: Implement verifyEmail() method.
//    }
//
//    public function resendEmailVerification($request)
//    {
//        // TODO: Implement resendEmailVerification() method.
//    }
//
//    public function user()
//    {
//        return Auth::user();
//    }
//    public function id()
//    {
//        return Auth::id();
//    }
//
//    public function updateProfile($request)
//    {
//        // TODO: Implement updateProfile() method.
//    }
//
//    public function updatePassword($request)
//    {
//        // TODO: Implement updatePassword() method.
//    }
//
//    public function updateEmail($request)
//    {
//        // TODO: Implement updateEmail() method.
//    }
//
//    public function updateProfilePicture($request)
//    {
//        // TODO: Implement updateProfilePicture() method.
//    }
//
//    public function impersonate($user)
//    {
//        try {
//            Auth::login($user);
//            return true;
//        }catch (\Throwable $th) {
//            Log::channel('clear')->error(
//                "Error en la suplantación del usuario {$user->name} en el método Impersonate en el Repositorio AuthRepository: {$th->getMessage()}"
//            );$this->logService->create(
//                entrypoint: 'Servicio Auth',
//                message: "Error en la suplantación del usuario {$user->name} en el método Impersonate en el Servicio AuthService2Fake: {$th->getMessage()}",
//                stackTrace: $th->getTrace(),
//                accion: 'Impersonate User',
//                level: 'ERROR',
//                comentario: 'Error en la suplantación del usuario'
//            );
//            throw $th;
//        }
//    }
//
//    public function backPreviousUser()
//    {
//        // TODO: Implement backPreviousUser() method.
//    }
//
//    public function stopImpersonate()
//    {
//        // TODO: Implement stopImpersonate() method.
//    }
//}
