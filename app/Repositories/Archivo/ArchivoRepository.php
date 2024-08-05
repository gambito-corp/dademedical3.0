<?php

namespace App\Repositories\Archivo;

use App\Interfaces\Archivo\ArchivoInterface;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoRepository implements ArchivoInterface
{

    public function __construct(private Archivo $archivo){}

    public function getArchivo(string $filePath)
    {}

    public function getArchivoById($id)
    {}

    public function save($data, $contractId, $patientId, $patientName, $patientSurname)
    {

        foreach ($data as $key => $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $tipo = $this->getFileType($key);
                $directory = Str::slug(strtolower($patientName . ' ' . $patientSurname . ' ' . $patientId)) . '/' . Str::slug(strtolower($tipo));
                $path = $file->store($directory, 'archivos');

                $this->archivo->create([
                    'contrato_id' => $contractId,
                    'paciente_id' => $patientId,
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $path,
                    'tipo' => $tipo,
                ]);
            }
        }
    }
    private function getFileType(string $key): string
    {
        return match ($key) {
            'solicitud_oxigenoterapia' => Archivo::TIPO_SOLICITUD_OXIGENOTERAPIA,
            'declaracion_jurada' => Archivo::TIPO_DECLARACION_DOMICILIO,
            'documento_identidad' => Archivo::TIPO_DNI_PACIENTE,
            'documento_identidad_cuidador' => Archivo::TIPO_DNI_CUIDADOR,
            'croquis' => Archivo::TIPO_CROQUIS_DIRECCION,
            'otros' => Archivo::TIPO_OTROS,
            default => 'desconocido',
        };
    }

    public function update($data, $id)
    {}

    public function delete($id)
    {}
}
