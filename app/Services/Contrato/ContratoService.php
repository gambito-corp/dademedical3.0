<?php

namespace App\Services\Contrato;

use App\Interfaces\Contrato\ContratoInterface;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Collection;

class ContratoService
{
    public function __construct(private ContratoInterface $contratoRepository)
    {
    }

    public function guardarContrato($contrato)
    {
        // Guardar contrato
    }

    public function eliminarContrato($contrato)
    {
        // Eliminar contrato
    }

    public function obtenerContrato($contrato)
    {
        // Obtener contrato
    }

    public function save(array $contrato): Contrato|Collection|null
    {
        return $this->contratoRepository->save(data: $contrato);

    }
}
