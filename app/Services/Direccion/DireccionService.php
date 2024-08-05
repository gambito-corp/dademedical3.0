<?php

namespace App\Services\Direccion;

use App\Interfaces\Direccion\DireccionInterface;

class DireccionService
{
    public function __construct(private DireccionInterface $direccionRepository)
    {
    }

    public function guardarDireccion($direccion)
    {
        // Guardar direccion
    }

    public function eliminarDireccion($direccion)
    {
        // Eliminar direccion
    }

    public function obtenerDireccion($direccion)
    {
        // Obtener direccion
    }

    public function save(array $direccion)
    {
        return $this->direccionRepository->save(data: $direccion);
    }
}
