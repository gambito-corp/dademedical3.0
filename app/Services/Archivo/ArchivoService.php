<?php

namespace App\Services\Archivo;

use App\Interfaces\Archivo\ArchivoInterface;
use App\Models\Archivo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ArchivoService
{
    public function __construct(private ArchivoInterface $archivoRepository)
    {
    }

    // Función principal para guardar archivos en el sistema y en la base de datos
    public function save(array $archivos, int $contractId, int $patientId, string $name, string $surname)
    {
        DB::beginTransaction();
        $uploadedFiles = [];
        try {
            foreach ($archivos as $key => $file) {
                if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    $tipo = $this->getFileType($key);
                    $directory = $this->generateDirectoryStructure($name, $surname, $patientId, $contractId, $tipo);

                    $extension = $file->getClientOriginalExtension();
                    $fileName = $this->generateFileName($tipo, $directory, $extension);
                    $path = $file->storeAs($directory, $fileName, 'archivos');
                    $uploadedFiles[] = $path;
                    $this->archivoRepository->save([
                        'contrato_id' => $contractId,
                        'paciente_id' => $patientId,
                        'nombre' => $fileName,
                        'ruta' => $path,
                        'tipo' => $tipo,
                    ]);
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            // Eliminar los archivos subidos si ocurre un error
            foreach ($uploadedFiles as $filePath) {
                if (Storage::disk('archivos')->exists($filePath)) {
                    Storage::disk('archivos')->delete($filePath);
                }
            }
            throw new \Exception("Error al guardar archivos o en la base de datos: " . $e->getMessage(), 0, $e);
        }
    }

    // Generar la estructura de directorios
    private function generateDirectoryStructure(string $patientName, string $patientSurname, int $patientId, int $contractId, string $tipo): string
    {
        $directory = Str::slug(strtolower($patientName . '-' . $patientSurname . '-' . $patientId));
        $contractDirectory = $directory . '/contrato-id-' . $contractId;
        return $contractDirectory . '/' . Str::slug(strtolower($tipo));
    }

    // Generar un nombre de archivo único dentro del directorio
    private function generateFileName(string $tipo, string $directorio, string $extension)
    {
        $files = Storage::disk('archivos')->files($directorio);
        $pattern = "/^" . preg_quote($tipo) . "(-[0-9]+)?\.[a-zA-Z0-9]+$/";
        $i = 1;
        foreach ($files as $file) {
            $baseName = pathinfo($file, PATHINFO_FILENAME);
            if (preg_match($pattern, $baseName)) {
                $i++;
            }
        }
        return $tipo . '-' . $i . '.' . $extension;
    }

    // Obtener el tipo de archivo
    private function getFileType(string $key): string
    {
        return match ($key) {
            'solicitud_oxigenoterapia' => Archivo::TIPO_SOLICITUD_OXIGENOTERAPIA,
            'declaracion_jurada' => Archivo::TIPO_DECLARACION_DOMICILIO,
            'documento_identidad' => Archivo::TIPO_DNI_PACIENTE,
            'documento_identidad_cuidador' => Archivo::TIPO_DNI_CUIDADOR,
            'croquis' => Archivo::TIPO_CROQUIS_DIRECCION,
            'otros' => Archivo::TIPO_OTROS,
            'documento_de_cambio_de_dosis' => Archivo::TIPO_CAMBIO_DOSIS,
            'ficha_instalacion' => Archivo::TIPO_ENTREGA_DISPOSITIVOS,
            'guia_remision' => Archivo::TIPO_GUIA_REMISION,
            'ficha_recogida' => Archivo::TIPO_RECOJO_DISPOSITIVOS,
            'documento_de_cambio_de_direccion' => Archivo::TIPO_CAMBIO_DIRECCION,
            default => 'desconocido',
        };
    }

    // Función para recuperar un documento desde S3 y mostrarlo en una Response
    public function showDocument($fileName)
    {
        return Storage::disk('archivos')->temporaryUrl($fileName, now()->addMinutes(60));
    }

    public function getFile($ruta)
    {
        if (Auth::user()){
            $file = Storage::disk('archivos')->get($ruta);
            $code = 200;
        }else{
            $file = Storage::disk('s3')->get('avatar/ejemplo.jpg');
            $code = 401;
        }
        return ['file' => $file, 'status' => $code];
    }

//    public function getDownload($id, $file){
//        $data = DocumentosVehiculo::with('Empresa', 'Lote', 'Producto')->where('id', $id)->first();
//        $ruta = 'documentos/vehiculos/'.
//            Str::slug($data->Empresa->nombre, "-").
//            '/'.
//            Str::slug($data->Lote->nombre, "-").
//            '/' .
//            Str::slug($data->Producto->nombre, "-").
//            '/';
//        $header = [
//            'Content-Disposition: attachment',
//            'Cache-Control: no-cache',
//            'Content-Type: application/pdf',
//        ];
//
//        return Storage::disk('s3')->download($ruta.$file, $file, $header);
//    }

    public function detachedFiles($archivoCambioDireccion)
    {
        try {
            DB::beginTransaction();
            foreach ($archivoCambioDireccion as $archivo) {
                $this->deleteDocument($archivo->id);
                $this->archivoRepository->detachedFile($archivo->contratos());
                $this->archivoRepository->deleteArchivoById($archivo->id);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al eliminar archivos: " . $e->getMessage(), 0, $e);
        }
    }

    public function obtenerUrlImagen($fileName)
    {
        $disk = Storage::disk('s3');
        $ruta = 'Documentos/Archivos/' . $fileName;

        if ($disk->exists($ruta)) {
            // Genera una URL pre-firmada válida por 5 minutos
            $url = $disk->temporaryUrl($ruta, now()->addMinutes(5));
            return $url;
        } else {
            // Manejar el caso en que el archivo no exista
            Log::error("El archivo no existe en S3: $ruta");
            return null;
        }
    }

    public function deleteDocument($id)
    {
        $archivo = Archivo::query()->find($id);
        if ($archivo) {
            if (Storage::disk('archivos')->exists(urlencode($archivo->ruta))) {
                Storage::disk('archivos')->delete(urlencode($archivo->ruta));
            }
            $archivo->delete();
        }
    }
}
