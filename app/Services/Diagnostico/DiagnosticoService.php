<?php

namespace App\Services\Diagnostico;

use App\Interfaces\Diagnostico\DiagnosticoInterface;

class DiagnosticoService
{
    public function __construct(private DiagnosticoInterface $diagnosticoRepository)
    {
    }

    public function guardarDiagnostico($diagnostico)
    {
        // Guardar diagnostico
    }

    public function eliminarDiagnostico($diagnostico)
    {
        // Eliminar diagnostico
    }

    public function obtenerDiagnostico($diagnostico)
    {
        // Obtener diagnostico
    }

    public function save(array $diagnostico)
    {
        return $this->diagnosticoRepository->save(data: $diagnostico);
    }

}
