<?php

namespace App\Interfaces\Archivo;

interface ArchivoInterface
{
    public function getArchivo(string $filePath);
    public function getArchivoById($id);
    public function save($fileData);
    public function update($data, $id);
    public function delete($id);

    public function detachedFile($contrato);
}
