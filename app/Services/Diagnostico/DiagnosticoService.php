<?php

namespace App\Services\Diagnostico;

use App\Interfaces\Diagnostico\DiagnosticoInterface;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Services\Archivo\ArchivoService;
use App\Services\Paciente\PacienteService;
use Illuminate\Support\Facades\DB;

class DiagnosticoService
{
    public function __construct(private DiagnosticoInterface $diagnosticoRepository, protected ArchivoService $archivoService)
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

    public function newDiagnostico($patient, $file)
    {
        DB::beginTransaction();
        $diagnostico = [
            "contrato_id"       => $patient['contrato_id'],
            "historia_clinica"  => $patient['historia_clinica'],
            "diagnostico"       => $patient['diagnostico'],
            "dosis"             => $patient['dosis'],
            "frecuencia"        => $patient['frecuencia'],
            "comentarios"       => $patient['comentarios'],
            "active"            => 0,
            "fecha_cambio"      => now(),
        ];

        //borrar diagnostico pendientes no Aprobados

        $deleted = $this->diagnosticoRepository->deletePending($patient['contrato_id']);
        $this->diagnosticoRepository->save($diagnostico);
        $this->archivoService->save(['documento_de_cambio_de_dosis' => $file], $diagnostico["contrato_id"], $patient['paciente_id'], $patient['nombre'], $patient['apellido']);

        DB::commit();
    }

}
