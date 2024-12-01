<?php

namespace App\Services\Direccion;

use App\Interfaces\Direccion\DireccionInterface;
use App\Models\Contrato;
use App\Models\Paciente;
use App\Services\Archivo\ArchivoService;
use Illuminate\Support\Facades\DB;

class DireccionService
{
    public function __construct(private DireccionInterface $direccionRepository, protected ArchivoService $archivoService)
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

    public function newDireccion(array $data, $file)
    {
        DB::beginTransaction();
        $direccion = [
            'contrato_id'   => $data['paciente_id'],
            'distrito'      => $data['contrato_id'],
            'distrito'      => $data['distrito'],
            'calle'     => $data['direccion'],
            'referencia'    => $data['referencia'],
            'responsable'   => $data['responsable'],
            "active"        => 0,
            "fecha_cambio"  => now(),
        ];

        $deleted = $this->direccionRepository->deletePending($data['contrato_id']);
        $this->direccionRepository->save($direccion);

        $paciente = Paciente::query()->where('id', $data['paciente_id'])->first();
        $this->archivoService->save(
            ['documento_de_cambio_de_direccion' => $file],
            $data["contrato_id"],
            $data['paciente_id'],
            $paciente->name,
            $paciente->surname
        );

        DB::commit();
    }
}
