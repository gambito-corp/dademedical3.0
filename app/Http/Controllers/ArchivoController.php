<?php

namespace App\Http\Controllers;

use App\Services\Archivo\ArchivoService;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    public function __construct(private ArchivoService $archivoService) {}

    public function getUrl($rutaArchivo)
    {
        // Decodificar la ruta si viene codificada
        $rutaArchivo = urldecode($rutaArchivo);

        // Obtener la URL pre-firmada
        $url = $this->archivoService->obtenerUrlImagen($rutaArchivo);

        if ($url) {
            // Redirigir directamente a la URL pre-firmada
            return redirect($url);
        } else {
            abort(404, 'El archivo no existe');
        }
    }
}
