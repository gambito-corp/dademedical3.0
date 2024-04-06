<?php

namespace App\Services\Logs;

use App\Interfaces\Logs\LogInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LogService
{

    protected LogInterface $logRepository;

    public function __construct(LogInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $entrypoint, string $message = '', array $stackTrace = [], string $accion = '', string $level = 'INFO', string $comentario = '')
    {
        try {
            $request = request();
            $userId = Auth::id();
            $originalUserId = session()->has('impersonate') ? session()->get('impersonate') : $userId;
            $log = [
                'user_id' => $userId,
                'original_user_id' => $originalUserId,
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'function' => $entrypoint,
                'accion' => $accion,
                'method' => $request->method(),
                'message' => $message,
                'level' => $level,
                'context' => json_encode($request->all()),
                'comentario' => $comentario,
                'strackTrace' => json_encode($stackTrace),
            ];
            return $this->logRepository->create(log: $log);
        } catch (\Exception $e) {
            Log::channel('clear')->error('Error en el Servicio de Logs... URGENTE REVISION: '. $e->getMessage());
            throw new \Exception('Error en el Servicio de Logs... URGENTE REVISION: '. $e->getMessage());
        }
    }
}
