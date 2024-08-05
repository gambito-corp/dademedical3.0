<?php

namespace App\Services\Archivo;

use App\Interfaces\Archivo\ArchivoInterface;

class ArchivoService
{
    public function __construct(private ArchivoInterface $archivoRepository)
    {
    }

    public function guardarArchivo($archivo)
    {
        // Guardar archivo
    }

    public function eliminarArchivo($archivo)
    {
        // Eliminar archivo
    }

    public function obtenerArchivo($archivo)
    {
        // Obtener archivo
    }

    public function save(array $archivos, int $contractId, int $patientId, string $name, string $surname)
    {
        return $this->archivoRepository->save(data: $archivos, contractId: $contractId, patientId: $patientId, patientName: $name, patientSurname: $surname);
    }

}
