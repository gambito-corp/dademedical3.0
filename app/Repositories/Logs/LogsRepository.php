<?php

namespace App\Repositories\Logs;

use App\Interfaces\Logs\LogInterface;
use App\Models\Logs;

class LogsRepository implements LogInterface
{

    protected $logModel;

    public function __construct(Logs $logModel)
    {
        $this->logModel = $logModel;
    }

    /**
     * @throws \Exception
     */
    public function create(array $log)
    {
        try {
            return $this->logModel::query()->create($log);
        } catch (\Exception $e) {
            return throw new \Exception('Error en el Repositorio/Interface de Logs... URGENTE REVISION: '. $e->getMessage());
        }
    }
}
