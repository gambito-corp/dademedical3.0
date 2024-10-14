<?php

namespace App\Repositories\Archivo;

use App\Interfaces\Archivo\ArchivoInterface;
use App\Models\Archivo;
use App\Services\Contrato\ContratoService;

class ArchivoRepository implements ArchivoInterface
{
    public function __construct(private Archivo $archivo, private ContratoService $contratoService) {}

    // Función para crear un archivo en la base de datos
    public function save($fileData): Archivo
    {
        $archivo =  $this->archivo->create($fileData);
        $this->associateWithContract($archivo->id, $archivo->contrato_id);
        return $archivo;
    }

    public function getArchivoById($id): ?Archivo
    {
        return $this->archivo->find($id);
    }

    public function deleteArchivoById($id)
    {
        return $this->archivo->destroy($id);
    }

    public function getArchivo(string $filePath)
    {
        // TODO: Implement getArchivo() method.
    }

    public function update($data, $id)
    {
        // TODO: Implement update() method.
    }

    private function associateWithContract(int $archivoId, int $contractId)
    {
        $contrato = $this->contratoService->obtenerContrato($contractId);
        $contrato->archivos()->attach($archivoId);  // Asociar el archivo con el contrato
    }

    public function detachedFile($contrato)
    {
        return $contrato->detach();
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
