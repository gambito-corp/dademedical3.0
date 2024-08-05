<?php

namespace App\Services\Telefono;

use App\Interfaces\Telefono\TelefonoInterface;

class TelefonoService
{
    public function __construct(private TelefonoInterface $telefonoRepository)
    {
    }

    public function guardarTelefono($telefono)
    {
        // Guardar telefono
    }

    public function eliminarTelefono($telefono)
    {
        // Eliminar telefono
    }

    public function obtenerTelefono($telefono)
    {
        // Obtener telefono
    }

    public function save(array $telefonos, int $contractId)
    {
        return $this->telefonoRepository->save(data: $telefonos, id: $contractId);
    }
}
