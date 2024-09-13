<?php

namespace App\Services\Direccion;

use App\Interfaces\Direccion\DireccionInterface;
use App\Models\Contrato;

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

    }

    public function save(array $direccion)
    {
        return $this->direccionRepository->save(data: $direccion);
    }

    public function update(array $direccion)
    {
//        $contrato = $this->contratoService->getContrato($direccion['patientId']);
        $contrato = Contrato::query()->with('direccion')->where('paciente_id', $direccion['patientId'])->get();
        $contrato = $contrato->last();
        $contrato->direccion->responsable = $direccion['responsable'];
        return $this->direccionRepository->update(data: $contrato->direccion);

    }
}
