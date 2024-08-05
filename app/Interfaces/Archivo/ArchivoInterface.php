<?php

namespace App\Interfaces\Archivo;

interface ArchivoInterface
{
    public function getArchivo(string $filePath);
    public function getArchivoById($id);
    public function save($data, $contractId, $patientId, $patientName, $patientSurname);
    public function update($data, $id);
    public function delete($id);
}
