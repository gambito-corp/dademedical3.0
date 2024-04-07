<?php
//
//namespace App\Services\Logs;
//
//use App\Interfaces\Logs\LogInterface;
//use App\Models\User;
//use App\Services\Auth\AuthService2Fake;
//use Illuminate\Support\Facades\Auth;
//
//class LogService2Fake
//{
//    protected $userRepository;
//    protected AuthService2Fake $authService;
//    public function __construct(LogInterface $userRepository, AuthService2Fake $authService)
//    {
//        $this->userRepository = $userRepository;
//        $this->authService = $authService;
//    }
//
//    public function create(string $entrypoint, string $message = '', array $stackTrace = [], string $accion = '', string $level = 'INFO', string $comentario = '')
//    {
//        try {
//            $request = request();
//            $userId = $this->authService->id();
//            $originalUserId = session()->has('impersonate') ? session()->get('impersonate') : $userId;
//            $log = [
//                'user_id' => $userId,
//                'original_user_id' => $originalUserId,
//                'ip_address' => $request->ip(),
//                'url' => $request->fullUrl(),
//                'function' => $entrypoint,
//                'accion' => $accion,
//                'method' => $request->method(),
//                'message' => $message,
//                'level' => $level,
//                'context' => json_encode($request->all()),
//                'comentario' => $comentario,
//                'strackTrace' => json_encode($stackTrace),
//            ];
//            return $this->userRepository->create($log);
//        } catch (\Exception $e) {
//            return $e->getMessage();
//        }
//    }
//
//    private function getLogs($entrypoint): string
//    {
//        switch ($entrypoint){
//            case 'Creacion Usuarios':
//                return 'Creacion Usuario';
//                break;
//            case 'Actualizacion Usuarios':
//                return 'Actualizacion Usuario';
//                break;
//            default:
//                return 'Accion Desconocida';
//                break;
//        }
//    }
//
//    private function getComments($entrypoint): string
//    {
//        $user = auth()->user();
//        switch ($entrypoint){
//            case 'Creacion Usuarios':
//                return "El Usuario {$user->name} en la Funcion store del controlador user UserController::store Creo a un Usuario";
//                break;
//            case 'Actualizacion Usuarios':
//                return "El Usuario {$user->name} en la Funcion update del controlador user UserController::update Actualizo a un Usuario";
//                break;
//            default:
//                return "ERROR!!! El Usuario {$user->name} en la Funcion {$entrypoint} del controlador user UserController::{$entrypoint} Hizo una Accion Desconocida";
//                break;
//        }
//    }
//}
