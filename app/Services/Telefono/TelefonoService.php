<?php

namespace App\Services\Telefono;

use App\Interfaces\Telefono\TelefonoInterface;
use App\Models\Contrato;

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
    public function update(array $telefonos, int $patientId)
    {
        $contrato = Contrato::query()->with('telefonos')->where('paciente_id', $patientId)->get();
        $contrato = $contrato->last();
        $existingTelefonos = $contrato->telefonos()->pluck('numero', 'id')->toArray();
        $newNumbers = $telefonos;
        $numbersToDelete = array_diff($existingTelefonos, $newNumbers);
        $numbersToAdd = array_diff($newNumbers, $existingTelefonos);

        // Eliminar teléfonos que ya no están en el formulario
        if (!empty($numbersToDelete)) {
            foreach ($numbersToDelete as $id => $number) {
                $this->telefonoRepository->delete($id);
            }
        }
        $this->telefonoRepository->save($numbersToAdd, $contrato->id);


    }
}
